@extends('AdminPanel.layouts.master')

@section('css')
    <!-- DataTables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/datatables.net-responsive-bs5@2.3.0/css/responsive.bootstrap5.min.css"
        rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <!-- Add New Button -->
            @role('manger')
                <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#add-new-service"
                    aria-controls="add-new-service">
                    <i class="bx bx-plus-circle"></i> {{ __('common.Add New Service') }}
                </button>
            @endrole
        </div>
        <div class="card-body">
            <!-- DataTable Section -->
            <div class="card-datatable">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead class="table-light">

                            <tr>
                                <th>{{ __('common.name of service') }}</th>
                                <th>{{ trans('common.price') }}</th>
                                <th>{{ __('common.Number of Invitions') }}</th>
                                <th>{{ __('common.Number of sessions') }}</th>
                                <th>{{ __('common.freeze_days') }}</th>
                                <th>{{ __('common.created_by') }}</th>
                                <td>{{ __('common.updated_by') }}</td>
                                @role('manger')
                                    <th>{{ __('common.status') }}</th>
                                @endrole
                                @role('manger')
                                    <th>{{ __('common.action') }}</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr id="row_{{ $service->id }}">
                                    <td>{{ $service->name }}</td>
                                    <td>{{ $service->price }}</td>
                                    <td>{{ $service->num_invitions }}</td>
                                    <td>{{ $service->session_count }}</td>
                                    <td>{{ $service->freeze_days }}</td>

                                    <td>
                                        @if ($service->created_by)
                                            {{ $service->created_by }}
                                        @else
                                            {{ __('common.not available') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($service->updated_by)
                                            {{ $service->updated_by }}
                                        @else
                                            {{ __('common.not updated') }}
                                        @endif
                                    </td>
                                    @role('manger')
                                        <td>
                                            <button type="button"
                                                class="btn btn-sm
                                            {{ $service->status == 'active' ? 'btn-success' : 'btn-secondary' }} toggle-status-btn"
                                                data-id="{{ $service->id }}" data-status="{{ $service->status }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-original-title="{{ $service->status == 'active' ? __('common.deactivate') : __('common.activate') }}">
                                                <i class="bx bx-power-off"></i>
                                                {{ $service->status == 'active' ? __('common.active') : __('common.inactive') }}
                                            </button>
                                        </td>
                                        <td>
                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-sm btn-warning edit-service-btn"
                                                data-id="{{ $service->id }}" data-name="{{ $service->name }}"
                                                data-price="{{ $service->price }}"
                                                data-invitions="{{ $service->num_invitions }}"
                                                data-session_count="{{ $service->session_count }}"
                                                data-description="{{ $service->description }}"
                                                data-freeze_days="{{ $service->freeze_days }}" data-bs-toggle="offcanvas"
                                                data-bs-target="#edit-service-modal" data-bs-placement="top"
                                                title="{{ __('common.edit') }}">
                                                <i class="bx bx-edit"></i> {{ __('common.edit') }}
                                            </button>

                                            <!-- Spacer between buttons -->
                                            <div class="d-inline-block mx-2"></div>

                                            <!-- Delete Button -->
                                            <?php $delete = route('admin.service.destroy', ['id' => $service->id]); ?>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="confirmDelete('{{ $delete }}','{{ $service->id }}')"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-original-title="{{ trans('common.delete') }}">
                                                <i class="bx bx-trash"></i> {{ __('common.delete') }}
                                            </button>
                                        </td>
                                    @endrole

                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    {{ $services->links('vendor.pagination.default') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal to add new service -->

    @include('AdminPanel.services.create')

    <!-- Modal to edit existing service -->
    @include('AdminPanel.services.edit')
@endsection

@section('js')
    <!-- DataTables and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net-responsive-bs5@2.3.0/js/responsive.bootstrap5.min.js"></script>

    <!-- JS for Modal Populating Data -->
    <script>
        document.querySelectorAll('.toggle-status-btn').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const currentStatus = button.getAttribute('data-status');
                const newStatus = currentStatus === 'active' ? 'inactive' : 'active'; // Toggle status

                // AJAX request to update status
                fetch(`/AdminPanel/services/${id}/status`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure CSRF token is sent
                        },
                        body: JSON.stringify({
                            status: newStatus
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update button UI based on new status
                            button.classList.toggle('btn-success');
                            button.classList.toggle('btn-secondary');
                            button.setAttribute('data-status', newStatus);
                            button.innerHTML =
                                `<i class="bx bx-power-off"></i> ${newStatus == 'active' ? '{{ __('common.active') }}' : '{{ __('common.inactive') }}'}`;
                        } else {
                            alert('{{ __('common.error') }}');
                        }
                    });
            });
        });
    </script>

    <script>
        document.querySelectorAll('.edit-service-btn').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const price = button.getAttribute('data-price');
                const invitions = button.getAttribute('data-invitions');
                const sessionCount = button.getAttribute('data-session_count');
                const description = button.getAttribute('data-description');
                const freezeDays = button.getAttribute('data-freeze_days'); // الجديد

                // Set the form action URL with the service ID


                // Populate the fields in the edit modal
                document.getElementById('edit-service-id').value = id;
                document.getElementById('edit-serviceName').value = name;
                document.getElementById('edit-servicePrice').value = price;
                document.getElementById('edit-serviceInvitions').value = invitions;
                document.getElementById('edit-sessionCount').value = sessionCount;
                document.getElementById('edit-serviceDescription').value = description;
                document.getElementById('edit-freezeDays').value = freezeDays; // تعبئة حقل freeze_days
            });
        });
    </script>
@endsection
