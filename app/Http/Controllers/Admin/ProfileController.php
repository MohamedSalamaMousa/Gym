<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Traits\Media;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $admin = auth()->user();
        return view('AdminPanel.profile.index',[
            'active' => 'my-profile',
            'admin' =>$admin,
            'title' => trans('common.Admin Panel'),
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.Account')
                ]
            ]
        ]);
    }

    public function update(Request $request,$id){
        $admin = Admin::find($id);
        $data = $request->except('_token','image');

        if ($request->hasFile('image')) {
            $newPhotoName = Media::upload($request->file('image'), 'profiles');
            if ($admin->image != null) {
                Media::delete("images/profiles/$admin->image");
            }
            $data['image'] = $newPhotoName;
        }
        $admin->update($data);
        if($admin)
        {
            return redirect()->route('admin.profile')
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
    }
}