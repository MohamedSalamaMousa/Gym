<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreCaptainRequest;
use App\Http\Requests\UpdateCaptainRequest;
use App\Models\Captain;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class CaptainController extends Controller
{
    //

    public function index()
    {

        if (!Auth::user()->hasRole('manger')) {
            abort(403, 'Unauthorized action.');
        }


        $captains = Captain::all();

        return view('AdminPanel.captains.index', [
            'captains' => $captains,
            'active' => 'Captains',

            'title' => __('common.Captains'),
            'parent_url' => '',
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.Captains')
                ]
            ]
        ]);
    }
    public function store(StoreCaptainRequest $request)
    {

        $validated = $request->validated();
        $validated['created_by'] = auth()->user()->name; // Assuming you have a logged-in user
        $captain = Captain::create($validated);


        return redirect()->route('admin.captain.index')
            ->with('success', trans('common.successMessageText'));
    }

    public function adjustWallet(Request $request, Captain $captain)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:add,subtract',
            'note' => 'nullable|string|max:255'
        ]);
        $amount = $request->input('amount');
        $type = $request->input('type');
        $description = $request->input('note');
        if ($type === 'subtract') {
            $amount = -$amount; // Negate the amount for subtraction
        }
        $captainWallet = $captain->wallets()->create([
            'amount' => $amount,
            'type' => $type === 'add' ? 'in' : 'out',
            'description' => $description,
        ]);


        return redirect()->back()->with('success', 'تم تعديل رصيد الكابتن بنجاح');
    }
    public function edit($id)
    {
        $captain = Captain::find($id);

        return view('AdminPanel.captains.edit', [
            'active' => 'Captains',
            'captain' => $captain,

            'title' => trans('common.Admin Panel'),
            'breadcrumbs' => [
                [
                    'url' => route('admin.captain.index'),
                    'text' => trans('common.Captains')
                ],
                [
                    'url' => '',
                    'text' => trans('common.edit')
                ]
            ]
        ]);
    }
    public function update(UpdateCaptainRequest $request, $id)
    {

        $captain = Captain::find($id);

        $data = $request->validated();
        $data['updated_by'] = auth()->user()->name; // Assuming you have a logged-in user
        $captain->update($data);

        return redirect()->route('admin.captain.index')->with('success', trans('common.successMessageText'));
    }
    public function show($id)
    {
        $captain = Captain::with('subscriptions', 'wallets')->findOrFail($id);

        // If services or subscriptions are null, ensure they are defaulted to empty collections

        return view(
            'AdminPanel.captains.show',
            [
                'captain' => $captain,

                'active' => 'Captains',
                'title' => trans('common.captains_show'),
                'parent_url' => '',
                'breadcrumbs' => [
                    [
                        'url' => '',
                        'text' => trans('common.captains_show')
                    ]
                ]
            ]
        );
    }

    public function clearWallet($id)
    {
        $captain = Captain::findOrFail($id);

        // حذف كل العمليات المالية المرتبطة بالمحفظة
        $captain->wallets()->delete();
        $captain->update([
            'cleared_by' => auth()->user()->name, // Assuming you have a logged-in user
        ]);

        return redirect()->back()->with('success', 'تم تصفية المحفظة لبداية شهر جديد.');
    }

    public function destroy($id)
    {
        $captain = Captain::findOrFail($id);

        if ($captain->delete()) {
            return response()->json("true");
        }
        return response()->json("false");
    }
}
