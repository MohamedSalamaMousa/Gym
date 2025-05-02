@extends('AdminPanel.layouts.master')

@section('content')
    @include('AdminPanel.layouts.common.response-messages')

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ trans('common.MainCaptainData') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.captain.update', $captain->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf


                        <div class="row g-3 pt-2">

                            <div class="col-md-6 col-lg-4">
                                <label for="name" class="form-label">{{ trans('common.name') }}</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ $captain->name }}" required />
                                @error('name')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <label for="email" class="form-label">{{ trans('common.email') }}</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="{{ $captain->email }}" />
                                @error('email')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <label for="phone" class="form-label">{{ trans('common.phone') }}</label>
                                <input type="text" class="form-control" name="phone" id="phone"
                                    value="{{ $captain->phone }}" required />
                                @error('phone')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>



                            <div class="col-md-6 col-lg-4">
                                <label for="wallet" class="form-label">{{ trans('common.Wallet') }}</label>
                                <input type="number" step="0.01" class="form-control" name="price" id="wallet"
                                    value="{{ $captain->price }}" required />
                                @error('price')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="col-md-6 col-lg-4">
                                <label for="city" class="form-label">{{ trans('common.city') }}</label>
                                <input type="text" class="form-control" name="city" id="city"
                                    value="{{ $captain->city }}" />
                                @error('city')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <label for="status" class="form-label">{{ trans('common.status') }}</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="active" {{ $captain->status == 'active' ? 'selected' : '' }}>
                                        {{ trans('common.active') }}</option>
                                    <option value="inactive" {{ $captain->status == 'inactive' ? 'selected' : '' }}>
                                        {{ trans('common.inactive') }}</option>
                                </select>
                                @error('status')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label for="address" class="form-label">{{ trans('common.address') }}</label>
                            <textarea class="form-control" name="address" id="address" rows="2">{{ $captain->address }}</textarea>
                            @error('address')
                                <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="row pt-4">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> {{ trans('common.Save changes') }}
                                </button>
                                <a href="{{ route('admin.captain.index') }}" class="btn btn-secondary ms-2">
                                    <i class="fas fa-arrow-left me-1"></i> {{ trans('common.Back') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
