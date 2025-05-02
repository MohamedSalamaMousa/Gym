@extends('AdminPanel.layouts.master')

@section('content')
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <!-- Add New Button -->
                    <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#add-new-supply"
                        aria-controls="add-new-supply">
                        <i class="bx bx-plus-circle"></i> {{ __('common.Add New Gym Supply') }}
                    </button>
                </div>

                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>{{ trans('common.item_name') }}</th>
                                <th>{{ trans('common.quantity') }}</th>
                                <th>{{ trans('common.unit_price') }}</th>
                                <th>{{ trans('common.total_price') }}</th>
                                <th>{{ trans('common.purchase_date') }}</th>
                                <th>{{ trans('common.created_by') }}</th>
                                <th>{{ trans('common.updated_by') }}</th>
                                <th>{{ trans('common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gymSupplies as $supply)
                                <tr>
                                    <td><strong>{{ $supply->item_name }}</strong></td>
                                    <td>{{ $supply->quantity }}</td>
                                    <td>{{ $supply->unit_price }}</td>
                                    <td>{{ $supply->total_price }}</td>
                                    <td>{{ \Carbon\Carbon::parse($supply->purchase_date)->format('d-m-Y') }}</td>

                                    <td>
                                        @if ($supply->created_by)
                                            {{ $supply->created_by }}
                                        @else
                                            {{ __('common.not available') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($supply->updated_by)
                                            {{ $supply->updated_by }}
                                        @else
                                            {{ __('common.not updated') }}
                                        @endif
                                    <td>
                                        <a href="{{ route('admin.gymSupply.edit', $supply->id) }}"
                                            class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="{{ trans('common.edit') }}">
                                            <i class="bx bx-edit"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        <?php $delete = route('admin.gymSupply.destroy', ['id' => $supply->id]); ?>
                                        <button type="button" class="btn btn-icon btn-danger"
                                            onclick="confirmDelete('{{ $delete }}','{{ $supply->id }}')"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="{{ trans('common.delete') }}">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('AdminPanel.gym_supplies.create') <!-- For Add Gym Supply Modal -->
@endsection
