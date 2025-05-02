<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Captain;
use App\Models\Member;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class AdminPanelController extends Controller
{
    public function index()
    {
        $activeSubscriptions = Subscription::where('status', 'active')->count();
        $inactiveSubscriptions = Subscription::where('status', '!=', 'active')->count(); // أو status = 'inactive' حسب نظامك
        $members = Member::All()->count();
        $coaches = Captain::All()->count(); // أو 'captain' لو بتسميهم كده

        return view('AdminPanel.index', [
            'active' => 'panelHome',
            'activeSubscriptions' => $activeSubscriptions,
            'coaches' => $coaches,
            'inactiveSubscriptions' => $inactiveSubscriptions,
            'members' => $members,
            'title' => trans('common.Admin Panel')
        ]);
    }

    public function notificationDetails($id)
    {
        $Notification = DatabaseNotification::find($id);
        $Notification->markAsRead();

        if (in_array($Notification['data']['type'], ['newPublisher'])) {
            return redirect()->route('admin.publisherUsers.edit', ['id' => $Notification['data']['linked_id']]);
        }
        if (in_array($Notification['data']['type'], ['newPublisherMessage'])) {
            return redirect()->route('admin.contactmessages.details', ['id' => $Notification['data']['linked_id']]);
        }

        return redirect()->back();
    }

    public function readAllNotifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }
}
