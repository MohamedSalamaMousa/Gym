<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGymSupplyRequest;
use App\Models\GymSupply;
use Illuminate\Http\Request;

class GymSupplyController extends Controller
{
    //
    public function index()
    {
        $gymSupplies = GymSupply::all();

        return view('AdminPanel.gym_supplies.index', [
            'gymSupplies' => $gymSupplies,
            'active' => 'Gym supplies',

            'title' => __('common.Gym supplies'),
            'parent_url' => '',
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.Gym supplies')
                ]
            ]
        ]);
    }

    public function  store(StoreGymSupplyRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->user()->name; // Assuming you want to set the created_by field to the current admin's ID
        GymSupply::create($validated);
        return redirect()->route('admin.gymSupply.index')
            ->with('success', trans('common.successMessageText'));
    }
    public function edit($id)
    {
        $supply = GymSupply::find($id);

        return view('AdminPanel.gym_supplies.edit', [
            'active' => 'Gym supplies',
            'supply' => $supply,

            'title' => trans('common.Admin Panel'),
            'breadcrumbs' => [
                [
                    'url' => route('admin.gymSupply.index'),
                    'text' => trans('common.Gym supplies')
                ],
                [
                    'url' => '',
                    'text' => trans('common.edit')
                ]
            ]
        ]);
    }

    public function update(StoreGymSupplyRequest $request, $id)
    {

        $supply = GymSupply::find($id);

        $data = $request->validated();
        $data['updated_by'] = auth()->user()->name; // Assuming you want to set the updated_by field to the current admin's ID
        $supply->update($data);
        return redirect()->route('admin.gymSupply.index')->with('success', trans('common.successMessageText'));
    }
    public function destroy($id)
    {
        $gymSupply = GymSupply::findOrFail($id);

        if ($gymSupply->delete()) {
            return response()->json("true");
        }
        return response()->json("false");
    }
}
