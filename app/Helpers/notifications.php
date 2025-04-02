<?php

use Spatie\Permission\Models\Role;
function notificationTextTranslate($parameters = [],$lang)
{
    $result = '';
    if (count($parameters) > 0) {
        if ($parameters['type'] == 'newMessage') {
            $result = [
                'ar' => 'لقد قام '.$parameters['name'].' بإرسال رسالة جديدة.',
                'en' => '‘User with the name '.$parameters['name'].'Send a new message for you'
            ];
        }
        if ($parameters['type'] == 'newComment') {
            $result = [
                'ar' => 'لقد قام '.$parameters['name'].' بكتابة تعليق جديد. ',
                'en' => '‘User with the name '.$parameters['name'].'write a new comment for you'
            ];
        }

    }
    return $result[$lang];
}

function notifyManagers($notificationType,$notificationData)
{
    if (in_array($notificationType, ['newMessage','newComment'])) {
        $PrimeManagers =  App\Models\Admin::role('manger')->get();
        foreach ($PrimeManagers as $key => $value) {
            $value->notify(new \App\Notifications\AdminNotifications($notificationData));
        }
    }
}

function notifyEmployee($notificationType,$notificationData,$role)
{
    if (in_array($notificationType, ['newMessage','newAppointment','cancelAppointment','newAffiliator','withdraw'])) {
        $PrimeEmployee =  App\Models\User::where('role',$role)->where('status','Active')->get();
        foreach ($PrimeEmployee as $key => $value) {
            $value->notify(new \App\Notifications\AdminNotifications($notificationData));
        }
    }
}

function notificationImageLink($type,$linked_id = '')
{
    $link = asset('assets/img/avatars/1.png');
    if ($type == 'newMessage') {
        
        $thePublisher =  App\Models\User::find($linked_id);
        if ($thePublisher != '') {
            $link = $thePublisher->image;
        }
    }
    if ($type == 'newAppointment') {
        $thePublisher =  App\Models\User::find($linked_id);
        if ($thePublisher != '') {
            $link = $thePublisher->photoLink();
        }
    }
    if ($type == 'cancelAppointment') {
        $thePublisher =  App\Models\User::find($linked_id);
        if ($thePublisher != '') {
            $link = $thePublisher->photoLink();
        }
    }
    if ($type == 'newAffiliator') {
        $thePublisher =  App\Models\User::find($linked_id);
        if ($thePublisher != '') {
            $link = $thePublisher->photoLink();
        }
    }
    return $link;
}

function notifyPublisher($notificationData,$publisherId)
{
    $publisher =  App\Models\User::find($publisherId);
    if ($publisher != '') {
        $publisher->notify(new \App\Notifications\PublisherNotifications($notificationData));
    }
}

function pushNotify($name,$userId,$type)
{
    $notificationText = notificationTextTranslate([
        'name' => $name,
        'type' => $type
    ],'ar');
    $notificationData = [
        'type' => $type,
        'linked_id' => $userId,
        'text' => $notificationText,
        'date' => date('Y-m-d'),
        'time' => date('H:i')
    ];
    notifyManagers($type, $notificationData);
}



function clientDuration($name,$position,$cellphone,$lang)
{
    $result = [
        'ar' => "لقد تخطى $name المدة المسموحة في هذا القسم $position طريقه التواصل $cellphone",
        'en' =>  "$name exceeded the period allowed in this $position contact way $cellphone",
    ];
    return $result[$lang];
}
