<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Member;
use App\Models\Service;
use App\Models\Subscription;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //
    public function index()
    {
        return view('AdminPanel.attendance.index', [

            'active' => 'Attendance',

            'title' => __('common.Attendance'),
            'parent_url' => '',
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.Attendance')
                ]
            ]
        ]);
    }
    public function showManualAttendanceForm()
    {
        $members = Member::all();
        $services = Service::all();
        return view('AdminPanel.attendance.manual', [

            'active' => 'Manual Attendance',
            'members' => $members,
            'services' => $services,

            'title' => __('common.Attendance_Manual'),
            'parent_url' => '',
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.Attendance_Manual')
                ]
            ]
        ]);
    }
    public function manualMarkAttendance(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'service_id' => 'required|exists:services,id',
        ]);
        $subscription = Subscription::with('member')
            ->where('member_id', $request->input('member_id'))
            ->where('service_id', $request->input('service_id'))
            ->first();
        if (!$subscription) {
            return response()->json(['status' => 'error', 'message' => 'Invalid subscription.'], 404);
        }
        // تسجيل الحضور
        Attendance::create([
            'subscription_id' => $subscription->id,
            'attended_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'تم تسجيل الحضور بنجاح.',
        ]);
    }

    public function markAttendance(Request $request)
    {
        $barcode = $request->input('barcode');

        // Example: "12-A3B6C7"
        [$subscriptionId, $uuidPart] = explode('-', $barcode);

        $subscription = Subscription::with('member')
            ->where('id', $subscriptionId)
            ->first();


        if (!$subscription || substr($subscription->member->uuid, 0, 6) !== $uuidPart) {
            return response()->json(['status' => 'error', 'message' => 'Invalid barcode.'], 404);
        }


        // سجل الحضور
        if ($subscription->remaining_sessions <= 0) {
            return response()->json(['status' => 'error', 'message' => 'No remaining sessions.'], 404);
        }
        Attendance::create([
            'subscription_id' => $subscription->id,
            'attended_at' => now(),
        ]);
        $subscription->update([
            'remaining_sessions' => $subscription->remaining_sessions - 1,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Attendance marked for ' . $subscription->member->name,
        ]);
    }
    public function searchForm()
    {
        return view('AdminPanel.attendance.search', [

            'active' => 'Attendance Search',

            'title' => __('common.Attendance Search'),
            'parent_url' => '',
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.Attendance Search')
                ]
            ]
        ]);
    }
    public function search(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $subscriptions = Subscription::with('member')
            ->whereHas('member', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->name . '%');
            })->get();

        return view('AdminPanel.attendance.search', [

            'active' => 'Attendance Search',
            'subscriptions' => $subscriptions,

            'title' => __('common.Attendance Search'),
            'parent_url' => '',
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.Attendance Search')
                ]
            ]
        ]);
    }
}