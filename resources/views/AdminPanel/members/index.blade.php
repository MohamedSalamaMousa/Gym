@extends('AdminPanel.layouts.master')
@section('content')
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <!-- Add New Button -->
                    <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#add-new-service"
                        aria-controls="add-new-service">
                        <i class="bx bx-plus-circle"></i> {{ __('common.Add New Member') }}
                    </button>

                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ trans('common.name') }}</th>
                                    <th>{{ trans('common.phone') }}</th>
                                    <th>{{ trans('common.created_by') }}</th>
                                    <th>{{ trans('common.updated_by') }}</th>
                                    <th>{{ trans('common.actions') }}</th>
                                </tr>
                            </thead>
                            @foreach ($members as $value)
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                            <strong>{{ $value->name }}</strong>
                                        </td>
                                        <td>{{ $value->phone }}</td>

                                        <td>{{ optional($value->admin)->name }} </td>
                                        <td>
                                            @if ($value->updated_by)
                                                {{ $value->updated_by }}
                                            @else
                                                {{ __('common.not updated') }}
                                            @endif
                                        <td>
                                            <a href="{{ route('admin.member.edit', $value->id) }}"
                                                class="btn btn-icon btn-info" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-bs-original-title="{{ trans('common.edit') }}">
                                                <i class="bx bx-edit"></i>
                                            </a>

                                            <!-- Delete Button -->
                                            @role('manger')
                                                <?php $delete = route('admin.member.destroy', ['id' => $value->id]); ?>
                                                <button type="button" class="btn btn-icon btn-danger"
                                                    onclick="confirmDelete('{{ $delete }}','{{ $value->id }}')"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-original-title="{{ trans('common.delete') }}">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            @endrole
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach

                        </table>
                        {{ $members->links('vendor.pagination.default') }}
                    </div>
                </div>
            </div>
        </div>
        @include('AdminPanel.members.create')

        <!-- Modal to edit existing service -->
    @endsection
