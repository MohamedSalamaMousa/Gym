<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Member;
use App\Models\Service;
use App\Services\BarcodeService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    //
    public function index()
    {
        $members = Member::latest()->paginate(10);
        $services = Service::all();
        return view('AdminPanel.members.index', [
            'members' => $members,
            'active' => 'Members',
            'services' => $services,
            'title' => __('common.Members'),
            'parent_url' => '',
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.Members')
                ]
            ]
        ]);
    }
    public function store(StoreMemberRequest $request, BarcodeService $barcodeService)
    {
        // The validated data is automatically available from the request.
        $validated = $request->validated();

        // Generate a UUID
        $uuid = Str::uuid();

        // Generate barcode using UUID
        $barcodePath = $barcodeService->generateBarcode($uuid);
        // Create the new service record
        $admin_id = auth()->user()->id;
        Member::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'whatsapp' => $validated['whatsapp'],
            'emergency_contact' => $validated['emergency_contact'],
            'admin_id' => $admin_id,
            'uuid' => $uuid,
            'barcode' => $barcodePath,

        ]);


        // Redirect back with success message
        return redirect()->route('admin.member.index')
            ->with('success', trans('common.successMessageText'));
    }
    public function edit($id)
    {
        $member = Member::find($id);

        return view('AdminPanel.members.edit', [
            'active' => 'Members',
            'member' => $member,

            'title' => trans('common.Admin Panel'),
            'breadcrumbs' => [
                [
                    'url' => route('admin.member.index'),
                    'text' => trans('common.Members')
                ],
                [
                    'url' => '',
                    'text' => trans('common.edit')
                ]
            ]
        ]);
    }
    public function update(UpdateMemberRequest $request, $id)
    {

        $member = Member::find($id);

        $data = $request->validated();
        $data['updated_by'] = auth()->user()->name; // Assuming you have a logged-in user
        $member->update($data);
        return redirect()->route('admin.member.index')->with('success', trans('common.successMessageText'));
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);

        if ($member->delete()) {
            return response()->json("true");
        }
        return response()->json("false");
    }
}
