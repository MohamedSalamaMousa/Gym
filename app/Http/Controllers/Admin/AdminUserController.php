<?php

namespace App\Http\Controllers\Admin;


use App\Models\Admin;
use App\Traits\Media;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Response;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = Admin::get();
        return view('AdminPanel.mangers.index', [
            'active' => 'Mangers',
            'admins' => $admins,
            'title' => trans('common.Admin Panel'),
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.Members')
                ]
            ]
        ]);
    }
    public function create()
    {
        $roles = Role::where('guard_name', 'web')->get();
        return view('AdminPanel.mangers.create', [
            'active' => 'Members',
            'roles' => $roles,
            'title' => trans('common.Admin Panel'),
            'breadcrumbs' => [
                [
                    'url' => route('admin.manger'),
                    'text' => trans('common.users')
                ],
                [
                    'url' => '',
                    'text' => trans('common.CreateNew')
                ]
            ]
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->phone);
        $data = $request->except(['_token', 'password', 'password_confirmation', 'role']);
        $data['password'] = Hash::make($request->password);
        $admin = Admin::create($data);
        if (isset($request->role)) $admin->assignRole($request->role);
        return redirect()->route('admin.manger')->with('success', trans('common.successMessageText'));
    }

    public function edit($id)
    {
        $admin = Admin::find($id);
        $roles = Role::where('guard_name', 'web')->get();
        return view('AdminPanel.mangers.edit', [
            'active' => 'Mangers',
            'admin' => $admin,
            'roles' => $roles,
            'title' => trans('common.Admin Panel'),
            'breadcrumbs' => [
                [
                    'url' => route('admin.manger'),
                    'text' => trans('common.users')
                ],
                [
                    'url' => '',
                    'text' => trans('common.edit')
                ]
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);
        $data = $request->except(['_token', 'password', 'password_confirmation', 'role']);
        $data['password'] = Hash::make($request->password);
        $admin->update($data);

        if ($request->role != null) {
            $admin->syncRoles($request->role);
            $admin->assignRole($request->role);
        }
        if ($admin) {
            return redirect()->route('admin.manger')->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()->with('faild', trans('common.faildMessageText'));
        }
    }


    public function delete($id)
    {
        $admin = Admin::find($id);
        if ($admin->image != null) {
            Media::delete("images/profiles/{$admin->image}");
        }
        $admin->syncRoles();
        if ($admin->delete()) {
            return response()->json("true");
        }
        return response()->json("false");
    }
}
