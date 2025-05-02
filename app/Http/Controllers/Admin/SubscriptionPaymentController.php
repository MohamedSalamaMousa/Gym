<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPayment;
use Illuminate\Http\Request;

class SubscriptionPaymentController extends Controller
{
    //
    public function store(Request $request)
    {

        // Validate the request


        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'paid_amount' => 'required|numeric|min:0.01',
        ]);


        SubscriptionPayment::create([
            'subscription_id' => $request->subscription_id,
            'paid_amount' => $request->paid_amount,
            'paid_at' => now(),
        ]);

        return redirect()->back()->with('success', 'تمت إضافة الدفعة بنجاح!');
    }
}
