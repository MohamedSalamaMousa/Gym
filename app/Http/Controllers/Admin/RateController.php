<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rate;
use App\Traits\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class RateController extends Controller
{
    public function index()
    {
        $rates = Rate::orderBy('created_at','desc')->paginate(20);
        return view('AdminPanel.contactMessage.rate',[
            'active' => 'oldRate',
            'rates' =>$rates,
            'title' => trans('common.oldRate'),
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.oldRate')
                ]
            ]
        ]);
    }


    public function store(Request $request)
    {
        if($request->hasFile('image'))
        {
            $newPhotoName = Media::upload($request->file('image'), 'rates');
            $rateImage = $newPhotoName;
        }
        $rate = Rate::create([
            'image' => $rateImage,
        ]);

        if ($rate) {
            return redirect()->back()->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()->with('faild', trans('common.faildMessageText'));
        }
    }

    public function update(Request $request,$id)
    {
        $rate = Rate::find($id);
        if($request->hasFile('image'))
        {
            Media::delete("images/rates/{$rate->image}");
            $newPhotoName = Media::upload($request->file('image'), 'rates');
            $rateImage = $newPhotoName;
        }
        $rate->update([
            'image' => $rateImage,
        ]);

        if ($rate) {
            return redirect()->back()->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()->with('faild', trans('common.faildMessageText'));
        }
    }

    public function delete($id){
        $rate = Rate::find($id);
        Media::delete("images/rates/{$rate->image}");
        if ($rate->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }
}