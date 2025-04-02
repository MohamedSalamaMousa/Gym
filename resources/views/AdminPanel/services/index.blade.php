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
            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#add-new-service"
                aria-controls="add-new-service">
                <i class="bx bx-plus-circle"></i> {{ __('common.Add New Service') }}
            </button>
        </div>
        <div class="card-body">
            <!-- DataTable Section -->
            <div class="card-datatable">
                <div class="table-responsive">
                    <table class="datatables-basic table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('common.name of service') }}</th>
                                <th>{{ trans('common.price') }}</th>
                                <th>{{ __('common.Number of sessions') }}</th>
                                <th>{{ __('common.description') }}</th>
                                <th>{{ __('common.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td>{{ $service->name }}</td>
                                    <td>{{ $service->price }}</td>
                                    <td>{{ $service->session_count }}</td>
                                    <td>{{ $service->description }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-sm btn-warning edit-service-btn"
                                            data-id="{{ $service->id }}" data-name="{{ $service->name }}"
                                            data-price="{{ $service->price }}"
                                            data-session_count="{{ $service->session_count }}"
                                            data-description="{{ $service->description }}" data-bs-toggle="offcanvas"
                                            data-bs-target="#edit-service-modal">
                                            <i class="bx bx-edit"></i> {{ __('common.edit') }}
                                        </button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.service.destroy', $service->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this service?')">
                                                <i class="bx bx-trash"></i> {{ __('common.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal to add new service -->
    <div class="offcanvas offcanvas-end" id="add-new-service">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title">New Service</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <form id="form-add-new-service" method="POST" action="{{ route('admin.service.store') }}">
                @csrf <!-- Include CSRF Token -->
                <div class="col-sm-12 form-control-validation">
                    <label class="form-label" for="serviceName">{{ __('common.name of service') }}</label>
                    <div class="input-group input-group-merge">
                        <span id="serviceName2" class="input-group-text"><i class="icon-base bx bx-cog"></i></span>
                        <input type="text" id="serviceName" class="form-control" name="name"
                            placeholder="{{ __('common.name of service') }}" aria-label="اسم الخدمة"
                            aria-describedby="serviceName2" required>
                    </div>
                </div>

                <div class="col-sm-12 form-control-validation">
                    <label class="form-label" for="servicePrice">{{ trans('common.price') }} </label>
                    <div class="input-group input-group-merge">
                        <span id="servicePrice2" class="input-group-text"><i class="icon-base bx bx-dollar"></i></span>
                        <input type="number" id="servicePrice" name="price" class="form-control"
                            placeholder="{{ trans('common.price') }}" aria-label="سعر الخدمة"
                            aria-describedby="servicePrice2" required step="0.01">
                    </div>
                </div>

                <div class="col-sm-12 form-control-validation">
                    <label class="form-label" for="sessionCount"> {{ __('common.Number of sessions') }}</label>
                    <div class="input-group input-group-merge">
                        <span id="sessionCount2" class="input-group-text"><i
                                class="icon-base bx bx-calendar-check"></i></span>
                        <input type="number" id="sessionCount" name="session_count" class="form-control"
                            placeholder="{{ __('common.Number of sessions') }}" aria-label="عدد الجلسات المتاحة"
                            aria-describedby="sessionCount2" required min="0" value="0">
                    </div>
                </div>

                <div class="col-sm-12 form-control-validation">
                    <label class="form-label" for="serviceDescription">{{ __('common.description') }} </label>
                    <div class="input-group input-group-merge">
                        <span id="serviceDescription2" class="input-group-text"><i class="icon-base bx bx-edit"></i></span>
                        <textarea id="serviceDescription" name="description" class="form-control" placeholder=""
                            aria-label="{{ __('common.description') }}" aria-describedby="serviceDescription2" rows="4"></textarea>
                    </div>
                </div>

                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary data-submit me-sm-4 me-1">Submit</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal to edit existing service -->
    <div class="offcanvas offcanvas-end" id="edit-service-modal">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title">Edit Service</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <form id="form-edit-service" method="POST" action="{{ route('admin.service.update') }}">
                @csrf
                @method('Post') <!-- Ensure PUT method for update -->

                <input type="hidden" name="id" id="edit-service-id">

                <div class="col-sm-12 form-control-validation">
                    <label class="form-label" for="edit-serviceName">{{ __('common.name of service') }}</label>
                    <div class="input-group input-group-merge">
                        <span id="edit-serviceName2" class="input-group-text"><i class="icon-base bx bx-cog"></i></span>
                        <input type="text" id="edit-serviceName" class="form-control" name="name"
                            placeholder="{{ __('common.name of service') }}" aria-label="اسم الخدمة"
                            aria-describedby="edit-serviceName2" required>
                    </div>
                </div>

                <div class="col-sm-12 form-control-validation">
                    <label class="form-label" for="edit-servicePrice">{{ trans('common.price') }} </label>
                    <div class="input-group input-group-merge">
                        <span id="edit-servicePrice2" class="input-group-text"><i
                                class="icon-base bx bx-dollar"></i></span>
                        <input type="number" id="edit-servicePrice" name="price" class="form-control"
                            placeholder="{{ trans('common.price') }}" aria-label="سعر الخدمة"
                            aria-describedby="edit-servicePrice2" required step="0.01">
                    </div>
                </div>

                <div class="col-sm-12 form-control-validation">
                    <label class="form-label" for="edit-sessionCount"> {{ __('common.Number of sessions') }}</label>
                    <div class="input-group input-group-merge">
                        <span id="edit-sessionCount2" class="input-group-text"><i
                                class="icon-base bx bx-calendar-check"></i></span>
                        <input type="number" id="edit-sessionCount" name="session_count" class="form-control"
                            placeholder="{{ __('common.Number of sessions') }}" aria-label="عدد الجلسات المتاحة"
                            aria-describedby="edit-sessionCount2" required min="0">
                    </div>
                </div>

                <div class="col-sm-12 form-control-validation">
                    <label class="form-label" for="edit-serviceDescription">{{ __('common.description') }} </label>
                    <div class="input-group input-group-merge">
                        <span id="edit-serviceDescription2" class="input-group-text"><i
                                class="icon-base bx bx-edit"></i></span>
                        <textarea id="edit-serviceDescription" name="description" class="form-control" placeholder=""
                            aria-label="{{ __('common.description') }}" aria-describedby="edit-serviceDescription2" rows="4"></textarea>
                    </div>
                </div>

                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary data-submit me-sm-4 me-1">Submit</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <!-- DataTables and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net-responsive-bs5@2.3.0/js/responsive.bootstrap5.min.js"></script>

    <!-- JS for Modal Populating Data -->
    <script>
        document.querySelectorAll('.edit-service-btn').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const price = button.getAttribute('data-price');
                const sessionCount = button.getAttribute('data-session_count');
                const description = button.getAttribute('data-description');

                // Set the form action URL with the service ID


                // Populate the fields in the edit modal
                document.getElementById('edit-service-id').value = id;
                document.getElementById('edit-serviceName').value = name;
                document.getElementById('edit-servicePrice').value = price;
                document.getElementById('edit-sessionCount').value = sessionCount;
                document.getElementById('edit-serviceDescription').value = description;
            });
        });
    </script>
@endsection
