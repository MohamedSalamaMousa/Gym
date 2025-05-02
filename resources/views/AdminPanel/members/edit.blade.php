@extends('AdminPanel.layouts.master')
@section('content')
    @include('AdminPanel.layouts.common.response-messages')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.member.update', $member->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="divider">
                            <div class="divider-text">{{ trans('common.MainMemeberData') }}</div>
                        </div>

                        <div class="row pt-3">
                            <div class="col-12 col-sm-3 mb-1">
                                <label for="name" class="form-label">{{ trans('common.name') }}</label>
                                <input type="name" class="form-control" name="name" id="name"
                                    placeholder="{{ trans('common.name') }}" value="{{ $member->name }}" required />
                                @error('name')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-12 col-sm-3 mb-1">
                                <label for="phone" class="form-label">{{ trans('common.phone') }}</label>
                                <input type="phone" class="form-control" name="phone" id="phone"
                                    value="{{ $member->phone }}" required />
                                @error('phone')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-12 col-sm-3 mb-1">
                                <label for="phone" class="form-label">{{ trans('common.whatsapp') }}</label>
                                <input type="phone" class="form-control" name="whatsapp" id="whatsapp"
                                    value="{{ $member->whatsapp }}" required />
                                @error('whatsapp')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label for="phone" class="form-label">{{ trans('common.emergency_contact') }}</label>
                                <input type="phone" class="form-control" name="emergency_contact" id="phone"
                                    value="{{ $member->emergency_contact }}" />
                                @error('emergency_contact')
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
