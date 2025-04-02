@extends('AdminPanel.layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">{{ trans('common.Account') }}</h4>
                </div>
                <div class="card-body py-2 my-25">
                    <form action="{{ route('admin.profile.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row d-flex justify-content-center">
                            <div class="form-group col-md-3 text-center">
                                <img class="round" src="{{ asset("images/profiles/{$admin->image}") }}" width="200px" height="200px">
                                <div class="mb-3">
                                    <input class="form-control" type="file" id="formFile" name="image" />
                                </div>
                            </div>
                        </div>
                        <!-- form -->
                        <div class="row pt-3">
                            <div class="col-12 col-sm-6 mb-1">
                                <label for="name" class="form-label">{{ trans('common.name') }}</label>
                                <input type="name" value="{{ $admin->name }}" class="form-control" name="name"
                                    id="name" placeholder="{{ trans('common.name') }}" />
                            </div>

                            <div class="col-12 col-sm-6 mb-1">
                                <label for="title" class="form-label">{{ trans('common.position') }}</label>
                                <input type="text" value="{{ $admin->title ?? '' }}" class="form-control" name="title"
                                    id="title" placeholder="{{ trans('common.position') }}" />
                            </div>

                            <div class="col-12 col-sm-6 mb-1">
                                <label for="phone" class="form-label">{{ trans('common.phone') }}</label>
                                <input type="tel" value="{{ $admin->phone ?? '' }}" class="form-control" name="phone"
                                    id="phone" value="{{ old('phone') }}" />
                            </div>

                            <div class="col-12 col-sm-6 mb-1">
                                <label for="email" class="form-label">{{ trans('common.email') }} </label>
                                <input type="email" value="{{ $admin->email }}" class="form-control" name="email"
                                    id="email" />
                            </div>

                            <div class="col-12 col-sm-12 mb-1">
                                <label for="address" class="form-label">{{ trans('common.address') }}</label>
                                <input type="text" value="{{ $admin->address ?? '' }}" class="form-control"
                                    name="address" id="address" placeholder="{{ trans('common.address') }}" />
                            </div>

                            <div class="row pt-3  text-center">
                                <div class="col-12">
                                    <button type="submit"
                                        class="btn btn-primary mt-1 me-1">{{ trans('common.Save changes') }}</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
