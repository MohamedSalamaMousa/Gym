@extends('AdminPanel.layouts.master')
@section('content')
    @include('AdminPanel.layouts.common.response-messages')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.gymSupply.update', $supply->id) }}" method="POST">
                        @csrf
                      

                        <div class="divider">
                            <div class="divider-text">{{ trans('common.GymSupplyData') }}</div>
                        </div>

                        <div class="row pt-3">
                            <div class="col-12 col-sm-3 mb-1">
                                <label for="item_name" class="form-label">{{ trans('common.item_name') }}</label>
                                <input type="text" class="form-control" name="item_name" id="item_name"
                                    value="{{ $supply->item_name }}" required />
                                @error('item_name')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-12 col-sm-3 mb-1">
                                <label for="quantity" class="form-label">{{ trans('common.quantity') }}</label>
                                <input type="number" class="form-control" name="quantity" id="quantity"
                                    value="{{ $supply->quantity }}" required />
                                @error('quantity')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-12 col-sm-3 mb-1">
                                <label for="unit_price" class="form-label">{{ trans('common.unit_price') }}</label>
                                <input type="number" step="0.01" class="form-control" name="unit_price" id="unit_price"
                                    value="{{ $supply->unit_price }}" required />
                                @error('unit_price')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-12 col-sm-3 mb-1">
                                <label for="purchase_date" class="form-label">{{ trans('common.purchase_date') }}</label>
                                <input type="date" class="form-control" name="purchase_date" id="purchase_date"
                                    value="{{ \Carbon\Carbon::parse($supply->purchase_date)->format('Y-m-d') }}"
                                    required />
                                @error('purchase_date')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>
                        </div>

                        <div class="row pt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-1 me-1">
                                    {{ trans('common.Save changes') }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
