<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GymSupply;
use App\Models\SubscriptionPayment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Mpdf\Mpdf;

class FinancialReportController extends Controller
{
    //
    public function showFinancialReports(Request $request)
    {
        // تحديد التاريخ اليوم
        $today = Carbon::today();

        // إذا كان المستخدم قد حدد فترة معينة، نعرض الاشتراكات في هذه الفترة
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay(); // 00:00:00
            $endDate = Carbon::parse($request->end_date)->endOfDay(); // 23:59:59
            $subscriptions = SubscriptionPayment::whereBetween('paid_at', [$startDate, $endDate])
                ->paginate(10);
            $subscriptionsWithoutPagination = SubscriptionPayment::whereBetween('paid_at', [$startDate, $endDate])
                ->get();
            // حساب النفقات للفترة المحددة
            $suplies = GymSupply::whereBetween('purchase_date', [$startDate, $endDate])->get();
        } else {
            // إذا لم يحدد تاريخ، نعرض الاشتراكات اليوم فقط
            $subscriptions = SubscriptionPayment::whereDate('paid_at', $today)->paginate(10);
            $subscriptionsWithoutPagination = SubscriptionPayment::whereDate('paid_at', $today)->get();

            $suplies = GymSupply::whereDate('purchase_date', $today)->get();
        }

        // حساب إجمالي الدخل
        $totalIncome = $subscriptionsWithoutPagination->sum('paid_amount');
        // حساب إجمالي النفقات

        $totalOutcome = $suplies->sum('total_price');


        return view('AdminPanel.reports.financial.index', [
            'active' => 'Gym supplies',
            'subscriptions' => $subscriptions,
            'totalIncome' => $totalIncome,
            'totalOutcome' => $totalOutcome,
            'title' => __('common.Financial Report'),
            'parent_url' => '',
            'breadcrumbs' => [
                [
                    'url' => route('admin.reports.financial.index'),
                    'text' => trans('common.Financial Report')
                ],

            ]
        ]);
    }


    public function exportFinancialReportPDF(Request $request)
    {
        $today = Carbon::today();

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();

            $subscriptions = SubscriptionPayment::whereBetween('paid_at', [$startDate, $endDate])->get();
            $supplies = GymSupply::whereBetween('purchase_date', [$startDate, $endDate])->get();
        } else {
            $subscriptions = SubscriptionPayment::whereDate('paid_at', $today)->get();
            $supplies = GymSupply::whereDate('purchase_date', $today)->get();
        }

        $totalIncome = $subscriptions->sum('paid_amount');
        $totalOutcome = $supplies->sum('total_price');

        $html = view('AdminPanel.reports.financial.pdf', [
            'subscriptions' => $subscriptions,
            'totalIncome' => $totalIncome,
            'totalOutcome' => $totalOutcome,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ])->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'default_font' => 'dejavusans', // يدعم العربية
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output('', 'S'))->withHeaders([
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="financial_report_' . now()->format('Y_m_d_H_i') . '.pdf"',
        ]);
    }

}