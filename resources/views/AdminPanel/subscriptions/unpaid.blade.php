@extends('AdminPanel.layouts.master')
@section('content')
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="alert alert-warning">
                    <strong>إجمالي المبالغ غير المسددة:</strong> {{ $totalUnpaid }} جنيه
                </div>
                <div class="card-header">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ trans('common.member_name') }}</th>
                                    <th>{{ trans('common.service') }}</th>
                                    <th>{{ __('common.start_date') }}</th>
                                    <th>{{ __('common.end_date') }}</th>
                                    <th>{{ __('common.remaining_amount') }}</th>
                                    <th>{{ __('common.status') }}</th>
                                    <th>{{ __('common.subscription_type') }}</th>
                                    <th>{{ __('common.action') }}</th>


                                </tr>
                            </thead>
                            @foreach ($subscriptions as $value)
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                            <strong>{{ $value->member->name }}</strong>
                                        </td>
                                        <td>{{ $value->service->name }}</td>

                                        <td>{{ $value->start_date }} </td>
                                        <td>{{ $value->end_date }} </td>
                                        <td>
                                            @if ($value->getPaidAmountAttribute() != $value->service->price)
                                                {{ $value->service->price - $value->getPaidAmountAttribute() }}
                                            @else
                                                {{ __('common.paid') }}
                                            @endif
                                        <td>
                                            @if ($value->status == 'active')
                                                <span class="badge bg-label-success me-1">{{ __('common.active') }}</span>
                                            @else
                                                <span class="badge bg-label-danger me-1">{{ __('common.inactive') }}</span>
                                            @endif

                                        <td>
                                            @if ($value->is_individual)
                                                <span class="badge bg-label-primary">{{ __('common.individual') }}</span>
                                            @else
                                                <span class="badge bg-label-secondary">{{ __('common.group') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-success add-payment-btn" data-bs-toggle="modal"
                                                data-bs-target="#paymentModal" data-subscription-id="{{ $value->id }}"
                                                title="{{ __('common.payment_sub') }}">
                                                <i class="bx bx-credit-card"></i>


                                            </button>
                                        </td>

                                    </tr>
                                </tbody>
                            @endforeach

                        </table>

                    </div>
                </div>
            </div>
        </div>
        @include('AdminPanel.subscriptions.new_paid_amount')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const paymentModal = document.getElementById('paymentModal');

                if (paymentModal) {
                    paymentModal.addEventListener('show.bs.modal', function(event) {
                        const button = event.relatedTarget;
                        const subscriptionId = button.getAttribute('data-subscription-id');

                        // تأكد إنه بيركب
                        console.log('Selected subscription ID:', subscriptionId);

                        const hiddenInput = paymentModal.querySelector('input[name="subscription_id"]');
                        if (hiddenInput) {
                            hiddenInput.value = subscriptionId;
                        }
                    });
                }
            });
        </script>
    @endsection
