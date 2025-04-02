@extends('AdminPanel.layouts.master')
@section('content')
    <?php
    use Spatie\Permission\Models\Permission;
    ?>
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="table-responsive  text-nowrap">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">{{ trans('common.name') }}</th>
                                    {{-- <th>{{ trans('common.role') }}</th> --}}
                                    <th class="text-center">{{ trans('common.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @forelse ($roles as $value)
                                        <tr>
                                        <td class="text-center">{{ trans("common.$value->name") }}</td>
                                        <td class="text-center">
                                            
                                            <a href="#" class="btn btn-icon btn-success"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="{{ trans('common.shield') }}">
                                            <i class='bx bx-shield-quarter'></i> 
                                         </a>   
                                            {{-- <a href="javascript:;" data-bs-target="#editPlan{{ $value->id }}"
                                            data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                            <i class="bx bx-edit"></i>
                                            </a> --}}
                                            {{-- @if ($value->name != "manger")
                                            <?php //$delete = route('admin.role.delete',['id'=>$value->id]); ?>
                                            <button type="button" class="btn btn-icon btn-danger"
                                                onclick="confirmDelete('{{$delete}}','{{$value->id}}')" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-original-title="{{trans('common.delete')}}">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                            @endif --}}
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="5" class="p-3 text-center ">
                                        <h2>{{ trans('common.nothingToView') }}</h2>
                                    </td>
                                {{-- </tr> --}}
                                @endforelse 
                            </tbody>
                        </table>
                    </div>

                    @forelse($roles as $value)
                        <div class="modal fade text-md-start" id="editPlan{{ $value->id }}" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                                <div class="modal-content">
                                    <div class="modal-header bg-transparent">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body pb-5 px-sm-5 pt-50">
                                        <div class="text-center mb-2">
                                            <h1 class="mb-1">{{ trans('common.edit') }}</h1>
                                        </div>

                                        <form action="{{ route('admin.role.update',$value->id) }}" method="post"
                                            id="add_form" enctype="multipart/form-data">
                                            @csrf

                                            <div id="add_form_messages"></div>

                                            {{-- MODIFICATIONS FROM HERE --}}
                                            <div class="form-group col-md-10">
                                                <label class="form-label">{{ trans('common.name') }}</label>
                                                <input type="text" class="border form-control" value="{{ $value->name }}" name="name"
                                                    placeholder="{{ trans('common.name') }}">
                                            </div>
                                            <div class="form-group col-12 mt-2">
                                                <div class="row">
                                                    <?php $groups = Permission::where('guard_name', 'web')->get(); ?>
                                                    @if (count($groups) > 0)
                                                        @foreach ($groups as $permission)
                                                            <div class="col-md-6">
                                                                <div class="form-check form-check-primary mt-1">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="permissionArray[{{ $permission->name }}]"
                                                                        id="formCheckcolor{{ $permission->id }}" @checked($value->hasPermissionTo($permission->name))>
                                                                    <label class="form-check-label"
                                                                        for="formCheckcolor{{ $permission->id }}">{{ trans("role.$permission->name") }}</label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-12 text-center mt-2 pt-50">
                                                <button type="submit"
                                                    class="btn btn-primary me-1">{{ trans('common.Savechanges') }}</button>
                                                <button type="reset" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal"aria-label="Close">
                                                    {{ trans('common.Cancel') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    @endsection

    @section('page_buttons')
        {{-- <a href="javascript:;" data-bs-target="#createCity" data-bs-toggle="modal" class="btn btn-primary">
            {{ trans('common.CreateNew') }}
        </a> --}}

        <div class="modal fade text-md-start" id="createCity" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">{{ trans('common.CreateNew') }}</h1>
                        </div>

                        <form action="{{ route('admin.role.store') }}" method="post" id="add_form" enctype="multipart/form-data">
                        @csrf
                            <div id="add_form_messages"></div>

                            {{-- MODIFICATIONS FROM HERE --}}
                            <div class="row">

                                <div class="form-group col-md-10">
                                    <label class="form-label">{{ trans('common.name') }}</label>
                                    <input type="text" class="border form-control" name="name"
                                        placeholder="{{ trans('common.name') }}">
                                </div>
                                <div class="form-group col-md-2 mt-4">
                                    {{-- <label class="form-check-label text-primary mt-2">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                        {{ trans('common.Select All') }}
                                    </label> --}}
                                </div>
                                <div class="form-group col-12 mt-2">
                                    <div class="row">
                                        <?php $groups = Permission::where('guard_name', 'web')->get(); ?>
                                        @if (count($groups) > 0)
                                            @foreach ($groups as $permission)
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-primary mt-1">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="permissionArray[{{ $permission->name }}]"
                                                            id="formCheckcolor{{ $permission->id }}">
                                                        <label class="form-check-label"
                                                            for="formCheckcolor{{ $permission->id }}">{{ trans("role.$permission->name") }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="col-12 text-center mb-3 pt-50">
                                <button type="submit"
                                    class="btn btn-primary me-1">{{ trans('common.Save changes') }}</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    {{ trans('common.Cancel') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @stop
