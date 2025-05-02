@extends('AdminPanel.layouts.master')
@section('content')
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ trans('common.name') }}</th>
                                    <th>{{ trans('common.email') }}</th>
                                    <th>{{ trans('common.phone') }}</th>
                                    <th>{{ trans('common.role') }}</th>
                                    <th>{{ trans('common.status') }}</th>
                                    <th class="text-center">{{ trans('common.actions') }}</th>
                                </tr>
                            </thead>
                            @foreach ($admins as $value)
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                            <strong>{{ $value->name }}</strong>
                                        </td>
                                        <td>{{ $value->email }}</td>
                                        {{-- <td>
                                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                                class="avatar avatar-xs pull-up" title="Lilian Fuller">
                                                <img src="{{ asset('') }}/assets/img/avatars/5.png" alt="Avatar"
                                                    class="rounded-circle" />
                                            </li>
                                        </ul>
                                    </td> --}}
                                        <td>
                                            {{ $value->phone }}
                                        </td>
                                        <td>
                                            <span class="badge bg-label-primary me-1">
                                                <?php
                                                $role = $value->getRoleNames()[0] ?? '';
                                                ?>
                                                {{ trans("common.$role") }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($value->status == 1)
                                                <span
                                                    class="badge bg-label-success me-1">{{ trans('common.active') }}</span>
                                            @else
                                                <span
                                                    class="badge bg-label-warning me-1">{{ trans('common.inactive') }}</span>
                                            @endif

                                        </td>
                                        <td class="text-center">
                                            @if ($value->getRoleNames()[0] == 'manger')
                                                @if (auth()->user()->id == $value->id)
                                                    <a href="{{ route('admin.manger.edit', $value->id) }}"
                                                        class="btn btn-icon btn-info" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-original-title="{{ trans('common.edit') }}">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <i class='bx bx-shield-minus'></i>
                                                @else
                                                    <a href="#" class="btn btn-icon btn-success"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-original-title="{{ trans('common.shield') }}">
                                                        <i class='bx bx-shield-quarter'></i> </a>
                                                @endif
                                            @else
                                                <a href="{{ route('admin.manger.edit', $value->id) }}"
                                                    class="btn btn-icon btn-info" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    data-bs-original-title="{{ trans('common.edit') }}">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <?php $delete = route('admin.manger.delete', $value->id); ?>
                                                <button type="button" class="btn btn-icon btn-danger"
                                                    onclick="confirmDelete('{{ $delete }}','{{ $value->id }}')"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-original-title="{{ trans('common.delete') }}">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            @endif

                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('page_buttons')
        <a href="{{ route('admin.manger.create') }}" class="btn btn-primary"> {{ trans('common.CreateNew') }} </a>
    @endsection
