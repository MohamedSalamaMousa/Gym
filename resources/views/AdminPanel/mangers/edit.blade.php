@extends('AdminPanel.layouts.master')
@section('content')
    @include('AdminPanel.layouts.common.response-messages')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.manger.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="divider">
                            <div class="divider-text">{{ trans('common.MainProfileData') }}</div>
                        </div>

                        <div class="row pt-3">
                            <div class="col-12 col-sm-3 mb-1">
                                <label for="name" class="form-label">{{ trans('common.name') }}</label>
                                <input type="name" class="form-control" name="name" id="name"
                                    placeholder="{{ trans('common.name') }}" value="{{ $admin->name }}" required />
                                @error('name')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-12 col-sm-3 mb-1">
                                <label for="phone" class="form-label">{{ trans('common.phone') }}</label>
                                <input type="phone" class="form-control" name="phone" id="phone"
                                    value="{{ $admin->phone }}" required />
                                @error('phone')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>

                            @if ($admin->getRoleNames()[0] != 'manger')
                                <div class="col-12 col-sm-3 mb-1">
                                    <label for="role" class="form-label">{{ trans('common.role') }}</label>
                                    <select class="form-select" id="role" aria-label="Default select example"
                                        name="role" id="role" required>
                                        <option disabled selected>{{ trans('common.Roles') }}</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ trans("common.$role->name") }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <p class="text-danger"> {{ $message }} </p>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        <div class="divider">
                            <div class="divider-text">{{ trans('common.loginData') }}</div>
                        </div>

                        <div class="row pt-3">
                            <div class="col-12 col-sm-3 mb-1">
                                <label for="email" class="form-label">{{ trans('common.email') }} </label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="{{ $admin->email }}" required />
                                @error('email')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>


                            <div class="col-12 col-sm-3 mb-1">
                                <label for="password" class="form-label">{{ trans('common.password') }}</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="password" required />
                                @error('password')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-12 col-sm-3 mb-1">
                                <label for="password_confirmation"
                                    class="form-label">{{ trans('common.password_confirmation') }}</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placepassword_confirmationholder="password_confirmation"
                                    required />
                                @error('password_confirmation')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>
                        </div>
                        <div class="row pt-3">
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
