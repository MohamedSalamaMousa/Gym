<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscribtionRequest;
use App\Http\Requests\UpdateSubscribtionRequest;
use App\Models\Captain;
use App\Models\Member;
use App\Models\Service;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubscriptionController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Subscription::with('member', 'service');

        if ($request->filled('member_name')) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->member_name . '%');
            });
        }

        if ($request->filled('service_name')) {
            $query->whereHas('service', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->service_name . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        $subscriptions = $query->orderBy('created_at', 'desc')->paginate(10);

        // Update status (optional: move this to Observer or Scheduled Task)
        foreach ($subscriptions as $subscription) {
            $subscription->updateStatus();
        }
        $members = Member::all();
        $services = Service::where('status', 'active')->get();
        $captains = Captain::all();

        return view('AdminPanel.subscriptions.index', [
            'subscriptions' => $subscriptions,
            'members' => $members,
            'services' => $services,
            'captains' => $captains,
            'active' => 'subscriptions',
            'title' => trans('common.subscriptions'),
            'breadcrumbs' => [['url' => '', 'text' => trans('common.subscriptions')]]
        ]);
    }

    public function show($id)
    {
        $subscription = Subscription::with('member', 'service', 'captain')->findOrFail($id);

        // If services or subscriptions are null, ensure they are defaulted to empty collections

        return view(
            'AdminPanel.subscriptions.show',
            [
                'subscription' => $subscription,

                'active' => 'subscriptions',
                'title' => trans('common.subscriptions_show'),
                'parent_url' => '',
                'breadcrumbs' => [
                    [
                        'url' => '',
                        'text' => trans('common.subscriptions_show')
                    ]
                ]
            ]
        );
    }

    // حفظ اشتراك جديد
    public function store(StoreSubscribtionRequest $request)
    {

        $data = $request->validated();
        $service = Service::find($request->service_id);
        $data['remaining_sessions'] = $service->session_count; // احصل على عدد الجلسات من الخدمة
        $data['status'] = 'active'; // تعيين الحالة إلى نشط
        $data['renewed_from'] = null; // تعيين التجديد من إلى null
        $data['remaining_invitions'] = $service->num_invitions; // تعيين عدد الدعوات المتبقية

        $subscription = Subscription::create($data);
        if ($request->filled('paid_amount') && $request->paid_amount > 0) {
            $subscription->payments()->create([
                'paid_amount' => $request->paid_amount,
                'paid_at' => now(),
            ]);
        }
        if (isset($data['is_individual']) && $data['is_individual'] == 1) {
            $captain = Captain::find($data['captain_id']);
            $amount =  $data['captain_percentage'] / 100 * $service->price;
            $captain->wallets()->create([
                'amount' => $amount,
                'description' => 'نسبة الكابتن من اشتراك العضو: ' . $subscription->member->name,
                'captain_id' => $data['captain_id'],
                'subscription_id' => $subscription->id,
            ]);
        }

        return redirect()->route('admin.subscription.index')->with('success', 'تم إضافة الاشتراك بنجاح');
    }
    // عرض صفحة تعديل الاشتراك
    public function edit($id)
    {
        $subscription = Subscription::findOrFail($id);
        return view('AdminPanel.subscriptions.edit', [
            'active' => 'subscriptions',
            'subscription' => $subscription,
            'members' => Member::all(),
            'services' => Service::all(),
            'captains' => Captain::all(),
            'title' => trans('common.Admin Panel'),
            'breadcrumbs' => [
                [
                    'url' => route('admin.subscription.index'),
                    'text' => trans('common.subscriptions')
                ],
                [
                    'url' => '',
                    'text' => trans('common.edit')
                ]
            ]
        ]);
    }

    public function update(UpdateSubscribtionRequest $request, $id)
    {
        $data = $request->validated();
        $data['is_individual'] = $request->has('is_individual');

        if (!$data['is_individual']) {
            $data['captain_id'] = null;
        }

        $subscription = Subscription::findOrFail($id);

        // لو الكابتن اتغير
        if ($subscription->captain_id != $request->captain_id) {
            // حذف المحفظة الخاصة بالكابتن القديم
            $oldCaptain = Captain::find($subscription->captain_id);

            if ($oldCaptain) {
                $oldWallet = $oldCaptain->wallets()->where('subscription_id', $subscription->id)->first();

                if ($oldWallet) {
                    $oldWallet->delete();
                }
            }

            // إضافة محفظة للكابتن الجديد
            if ($request->captain_id) {
                $newCaptain = Captain::find($request->captain_id);
                $service = Service::find($request->service_id);
                $amount = ($data['captain_percentage'] / 100) * $service->price;

                $newCaptain->wallets()->create([
                    'amount' => $amount,
                    'description' => 'نسبة الكابتن من اشتراك العضو: ' . $subscription->member->name,
                    'captain_id' => $request->captain_id,
                    'subscription_id' => $subscription->id,
                ]);
            }
        }

        // لو اتغيرت الخدمة، حدث عدد الجلسات والدعوات والتجميد
        if ($subscription->service_id != $request->service_id) {
            $service = Service::find($request->service_id);
            $data['remaining_sessions'] = $service->session_count;
            $data['remaining_invitions'] = $service->num_invitions;
            $data['remaining_freeze_days'] = $service->freeze_days;

            // تحديث المحفظة بناءً على السعر الجديد
            if ($request->captain_id) {
                $captain = Captain::find($request->captain_id);
                if ($captain) {
                    $wallet = $captain->wallets()->where('subscription_id', $subscription->id)->first();
                    if ($wallet) {
                        $amount = ($data['captain_percentage'] / 100) * $service->price;
                        $wallet->update([
                            'amount' => $amount,
                            'description' => 'نسبة الكابتن من اشتراك العضو: ' . $subscription->member->name,
                        ]);
                    }
                }
            }
        }

        // لو اتغيرت النسبة فقط، حدث المحفظة
        if ($subscription->captain_percentage != $request->captain_percentage) {
            $captain = Captain::find($request->captain_id);
            if ($captain) {
                $wallet = $captain->wallets()->where('subscription_id', $subscription->id)->first();
                if ($wallet) {
                    $service = Service::find($request->service_id ?? $subscription->service_id);
                    $amount = ($data['captain_percentage'] / 100) * $service->price;

                    $wallet->update([
                        'amount' => $amount,
                        'description' => 'نسبة الكابتن من اشتراك العضو: ' . $subscription->member->name,
                    ]);
                }
            }
        }

        // تحديث بيانات الاشتراك
        $subscription->update($data);

        return redirect()->route('admin.subscription.index')->with('success', 'تم تحديث الاشتراك بنجاح');
    }


    public function invoice($id)
    {
        $subscription = Subscription::with(['member', 'service'])->findOrFail($id);
        return view('AdminPanel.subscriptions.invoice', compact('subscription'));
    }

    public function freeze(Request $request)
    {
        $subscription = Subscription::findOrFail($request->subscription_id);

        // تأكد أول مرة إذا المتبقي فاضي نبدأ بقيمة الخدمة
        if (is_null($subscription->remaining_freeze_days)) {
            $subscription->remaining_freeze_days = $subscription->service->freeze_days;
        }

        // تحقق من إذا كانت الأيام المجمّدة أكبر من صفر والمتبقي من الأيام أكبر من أو يساوي 1
        if ($request->freeze_days > 0 && $subscription->remaining_freeze_days >= 1) {
            // إضافة الأيام إلى تاريخ الانتهاء (end_date)
            $subscription->end_date = \Carbon\Carbon::parse($subscription->end_date)
                ->addDays($request->freeze_days)
                ->format('Y-m-d'); // تأكد من حفظ التاريخ بالتنسيق الصحيح

            // طرح الأيام المجمّدة من remaining_freeze_days
            $subscription->remaining_freeze_days -= $request->freeze_days;

            // تأكد أنه إذا المتبقي أقل من 0 لا يتم السماح بذلك
            if ($subscription->remaining_freeze_days < 0) {
                $subscription->remaining_freeze_days = 0;
            }
        }

        // حفظ التحديثات
        $subscription->save();

        return redirect()->route('admin.subscription.index')->with('success', 'تم تجميد الاشتراك بنجاح');
    }

    public function export(Request $request)
    {
        $query = Subscription::with('member')
            ->when($request->member_name, function ($q) use ($request) {
                $q->whereHas('member', function ($q2) use ($request) {
                    $q2->where('name', 'like', '%' . $request->member_name . '%');
                });
            })
            ->when($request->service_name, function ($q) use ($request) {
                $q->whereHas('service', function ($q2) use ($request) {
                    $q2->where('name', 'like', '%' . $request->service_name . '%');
                });
            })
            ->when($request->status, function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->start_date, function ($q) use ($request) {
                $q->whereDate('start_date', '>=', $request->start_date);
            })
            ->when($request->end_date, function ($q) use ($request) {
                $q->whereDate('end_date', '<=', $request->end_date);
            });

        $subscriptions = $query->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=subscriptions.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($subscriptions) {
            $file = fopen('php://output', 'w');

            // BOM لتفادي مشكلة اللغة
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // رؤوس الأعمدة
            fputcsv($file, ['Member Name', 'WhatsApp Number']);

            foreach ($subscriptions as $subscription) {
                $whatsappNumber = $subscription->member->whatsapp ?? '';

                // إزالة المسافات، وحذف الصفر الأول إذا كان موجودًا، ثم إضافة +20
                $whatsappNumber = '+20' . ltrim(str_replace(' ', '', $whatsappNumber), '0');

                // إضافة علامات اقتباس حول الرقم لضمان أنه سيتم اعتباره نصًا
                $whatsappNumber = '"' . $whatsappNumber . '"';

                fputcsv($file, [
                    $subscription->member->name ?? '',
                    $whatsappNumber
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function unpaid()
    {
        $subscriptions = Subscription::with(['member', 'payments', 'service'])
            ->get()
            ->filter(function ($subscription) {
                $totalPaid = $subscription->payments->sum('paid_amount');
                return $totalPaid < $subscription->service->price;
            });

        $totalUnpaid = $subscriptions->sum(function ($subscription) {
            $totalPaid = $subscription->payments->sum('paid_amount');
            return $subscription->service->price - $totalPaid;
        });

        return view('AdminPanel.subscriptions.unpaid', [
            'subscriptions' => $subscriptions,
            'active' => 'unpaid',
            'title' => 'الاشتراكات غير المسددة',
            'totalUnpaid' => $totalUnpaid,
            'breadcrumbs' => [['url' => '', 'text' => 'الاشتراكات غير المسددة']]
        ]);
    }


    // حذف الاشتراك
    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);
        // تحقق مما إذا كان الاشتراك موجودًا
        if (!$subscription) {
            return response()->json("false");
        }

        if ($subscription->delete()) {
            return response()->json("true");
        }
        return response()->json("false");
    }
}
