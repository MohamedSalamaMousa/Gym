<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;


class ServiceController extends Controller
{
    //
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('AdminPanel.services.index', [
            'active' => 'services',
            'services' => $services,
            'title' => trans('common.services'),
            'parent_url' => '',

            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.services')
                ]
            ]
        ]);
    }
    public function store(StoreServiceRequest $request)
    {
        // The validated data is automatically available from the request.
        $validated = $request->validated();

        // Create the new service record
        Service::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'session_count' => $validated['session_count'],
            'description' => $validated['description'],
            'num_invitions' => $validated['num_invitions'], // New field for number of invitations
            'freeze_days' => $validated['freeze_days'],
            'created_by' => auth()->user()->name, // Assuming you have a logged-in user
        ]);

        // Redirect back with success message
        return redirect()->route('admin.service')
            ->with('success', trans('common.successMessageText'));
    }
    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        if ($service->delete()) {
            return response()->json("true");
        }
        return response()->json("false");
    }
    public function update(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'id' => 'required|exists:services,id', // Make sure service exists
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'session_count' => 'required|integer|min:0',
            'description' => 'nullable|string|max:1000',
            'num_invitions' => 'required|integer|min:0', // New field for number of invitations
            'freeze_days' => 'required|integer|min:0',
        ]);

        // Find the service by ID and update it
        $service = Service::findOrFail($validatedData['id']);
        $service->name = $validatedData['name'];
        $service->price = $validatedData['price'];
        $service->session_count = $validatedData['session_count'];
        $service->description = $validatedData['description'] ?? $service->description;
        $service->num_invitions = $validatedData['num_invitions']; // Update the number of invitations
        $service->freeze_days = $validatedData['freeze_days'];
        $service->updated_by = auth()->user()->name; // Assuming you have a logged-in user

        // Save the updated service
        $service->save();
        return redirect()->route('admin.service')
            ->with('success', trans('Service updated successfully'));
    }
    public function toggleStatus($id, Request $request)
    {
        $service = Service::findOrFail($id);

        // Update the service status
        $service->status = $request->status;
        $service->save();

        return response()->json(['success' => true]);
    }
}
