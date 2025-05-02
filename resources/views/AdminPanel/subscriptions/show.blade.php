@extends('AdminPanel.layouts.master')

@section('content')
    @include('AdminPanel.layouts.common.response-messages')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Member Data Section -->
                    <div class="divider">
                        <div class="divider-text">{{ trans('common.MainMemeberData') }}</div>
                    </div>

                    <div class="row pt-3">
                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.name') }}</label>
                            <p>{{ $subscription->member->name }}</p>
                        </div>

                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.phone') }}</label>
                            <p>{{ $subscription->member->phone }}</p>
                        </div>

                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.whatsapp') }}</label>
                            <p>{{ $subscription->member->whatsapp }}</p>
                        </div>

                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.emergency_contact') }}</label>
                            <p>{{ $subscription->member->emergency_contact }}</p>
                        </div>
                    </div>

                    <!-- Service Data Section -->
                    <div class="divider mt-3">
                        <div class="divider-text">{{ trans('common.ServiceData') }}</div>
                    </div>
                    <div class="row pt-3">

                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.service') }}</label>
                            <p>{{ $subscription->service->name }}</p>
                        </div>
                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.Number of sessions') }}</label>
                            <p>{{ $subscription->service->session_count }}</p>
                        </div>
                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.price') }}</label>
                            <p>{{ $subscription->service->price }}</p>
                        </div>
                        @if ($subscription->is_individual == true)
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label">{{ trans('common.captain_name') }}</label>
                                <p> {{ optional($subscription->captain)->name ?? '-' }} </p>
                            </div>
                        @endif

                    </div>

                    <!-- Subscription Data Section -->
                    <div class="divider mt-3">
                        <div class="divider-text">{{ trans('common.SubscriptionData') }}</div>
                    </div>
                    <div class="row pt-3">
                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.remaining_sessions') }}</label>
                            <p>{{ $subscription->remaining_sessions }}</p>
                        </div>
                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.start_date') }}</label>
                            <p>{{ $subscription->start_date }}</p>
                        </div>

                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.end_date') }}</label>
                            <p>{{ $subscription->end_date }}</p>
                        </div>

                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.status') }}</label>
                            <p>{{ $subscription->status }}</p>
                        </div>

                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.paid_amount') }}</label>
                            <p>{{ $subscription->getPaidAmountAttribute() }}</p>
                        </div>

                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.remaining_amount') }}</label>
                            <p>{{ $subscription->service->price - $subscription->getPaidAmountAttribute() }}</p>
                        </div>
                        <div class="col-12 col-sm-3 mb-1">
                            <label class="form-label">{{ trans('common.remaining_invitions') }}</label>
                            <p>{{ $subscription->remaining_invitions }}</p>
                        </div>
                    </div>

                    <div class="row pt-3">
                        <div class="col-12">
                            <a href="{{ route('admin.subscription.index') }}"
                                class="btn btn-primary mt-1 me-1">{{ trans('common.Back to list') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
