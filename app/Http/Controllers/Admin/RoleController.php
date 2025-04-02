<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Response;
class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('guard_name', 'web')->get();
        return view('AdminPanel.Role.index',[
            'active' => 'roles',
            'roles' =>$roles,
            'title' => trans('common.roles'),
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.roles')
                ]
            ]
        ]);
    }
    public function store(RoleRequest $request)
    {
        $data = $request->validated();
        $role = Role::create(['name' => $data['name'], 'guard_name' => 'web']);
        if (isset($data['permissionArray'])) {
            foreach ($data['permissionArray'] as $permission => $value) {
                $role->givePermissionTo($permission);
            }
        }
        if($role)
        {
            return redirect()->back()->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()->with('faild', trans('common.faildMessageText'));
        }
    }

    public function update(Request $request, $id)
    {
        $role = Role::findById($id);
        $role->update(['name' => $request['name']]);
        $role->syncPermissions();
        if (isset($request['permissionArray'])) {
            foreach ($request['permissionArray'] as $permission => $value) {
                $role->givePermissionTo($permission);
            }
        }
        if($role)
        {
            return redirect()->back()->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()->with('faild', trans('common.faildMessageText'));
        }
    }

    public function delete($id)
    {
        $role = Role::findById($id);
        $role->syncPermissions();
        if($role->delete())
        {
            return Response::json($id);
        }
        return Response::json("false");
    }
}