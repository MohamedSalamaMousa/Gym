@extends('AdminPanel.layouts.master')
@section('css')
    <style>
        @media print {

            .btn,
            .card-header,
            .navbar,
            .footer {
                display: none !important;
            }

            body {
                background: white !important;
            }
        }
    </style>
@endsection
@section('content')
    @include('AdminPanel.layouts.common.response-messages')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Member Data Section -->
                    <div class="divider">
                        <div class="divider-text">{{ trans('common.MainCaptainData') }}</div>
                    </div>

                    <div class="row pt-3">
                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.name') }}</label>
                            <p>{{ $captain->name }}</p>
                        </div>

                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.phone') }}</label>
                            <p>{{ $captain->phone }}</p>
                        </div>
                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.price') }}</label>
                            <p>{{ $captain->price }}</p>
                        </div>

                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.email') }}</label>
                            <p>{{ $captain->email }}</p>
                        </div>

                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.city') }}</label>
                            <p>{{ $captain->city }}</p>
                        </div>
                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.status') }}</label>
                            <p>{{ $captain->status }}</p>
                        </div>
                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.description') }}</label>
                            <p>{{ $captain->description }}</p>
                        </div>
                    </div>

                    <!-- Service Data Section -->
                    <div class="divider mt-3">
                        <div class="divider-text">{{ trans('common.Members') }}</div>
                    </div>
                    <div class="pt-3">
                        @foreach ($captain->subscriptions as $subscription)
                            <div class="row mb-2 border-bottom pb-2">
                                <div class="col-12 col-sm-4 mb-1">
                                    <label class="form-label">{{ trans('common.name') }}</label>
                                    <p>{{ $subscription->member->name }}</p>
                                </div>
                                <div class="col-12 col-sm-4 mb-1">
                                    <label class="form-label">{{ trans('common.serviceName') }}</label>
                                    <p>{{ $subscription->service->name }}</p>
                                </div>
                                <div class="col-12 col-sm-4 mb-1">
                                    <label class="form-label">{{ trans('common.priceOfService') }}</label>
                                    <p>{{ $subscription->service->price }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <!-- Subscription Data Section -->
                    <div class="divider mt-3">
                        <div class="divider-text">{{ trans('common.Wallet') }}</div>
                    </div>

                    <div class="pt-3">
                        @foreach ($captain->wallets as $wallet)
                            <div class="row mb-2 border-bottom pb-2">
                                <div class="col-12 col-sm-4 mb-1">
                                    <label class="form-label">{{ trans('common.amount') }}</label>
                                    <p>{{ $wallet->amount }}</p>
                                </div>
                                <div class="col-12 col-sm-4 mb-1">
                                    <label class="form-label">{{ trans('common.type') }}</label>
                                    <p>{{ $wallet->type }}</p>
                                </div>
                                <div class="col-12 col-sm-4 mb-1">
                                    <label class="form-label">{{ trans('common.description') }}</label>
                                    <p>{{ $wallet->description }}</p>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12 col-sm-4 mb-1">
                            <label class="form-label">{{ trans('common.total') }}</label>
                            <p>{{ $captain->totalWalletBalance() }}</p>
                        </div>
                    </div>

                    <div class="row pt-3">
                        <div class="col-3">
                            <a href="{{ route('admin.captain.index') }}"
                                class="btn btn-primary mt-1 me-1">{{ trans('common.Back to list') }}</a>
                        </div>
                        <div class="col-3">
                            <button onclick="printPage()" class="btn btn-success mt-1 me-1">
                                {{ trans('common.print') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function printPage() {
            window.print();
        }
    </script>
