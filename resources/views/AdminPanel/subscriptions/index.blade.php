@extends('AdminPanel.layouts.master')
@section('content')
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <!-- Add New Button -->
                    <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#add-new-service"
                        aria-controls="add-new-service">
                        <i class="bx bx-plus-circle"></i> {{ __('common.Add New Subscription') }}
                    </button>
                    <!-- Search Filters -->
                    <div class="card mt-3 mb-4">
                        <div class="card-body">
                            <form action="{{ route('admin.subscription.index') }}" method="GET" class="row g-3">
                                <div class="col-md-3">
                                    <input type="text" name="member_name" value="{{ request('member_name') }}"
                                        class="form-control" placeholder="{{ __('common.member_name') }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="service_name" value="{{ request('service_name') }}"
                                        class="form-control" placeholder="{{ __('common.service') }}">
                                </div>
                                <div class="col-md-2">
                                    <select name="status" class="form-select">
                                        <option value="">{{ __('common.status') }}</option>
                                        <option value="active" @selected(request('status') == 'active')>{{ __('common.active') }}
                                        </option>
                                        <option value="expired" @selected(request('status') == 'inactive')>{{ __('common.inactive') }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                                        class="form-control">
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="bx bx-search"></i> {{ __('common.search') }}
                                    </button>
                                    <a href="{{ route('admin.subscription.index') }}" class="btn btn-light">
                                        {{ __('common.Reset') }}
                                    </a>
                                    <a href="{{ route('admin.subscription.export', request()->query()) }}"
                                        class="btn btn-success">
                                        <i class="bx bx-download"></i> {{ __('common.Export') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

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

                                    <th>{{ trans('common.actions') }}</th>
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
                                            <button type="button" class="btn btn-icon btn-warning freeze-subscription-btn"
                                                data-bs-toggle="modal" data-bs-target="#freezeModal"
                                                data-subscription-id="{{ $value->id }}" title="تجميد الاشتراك">
                                                <i class="icon-base bx bx-pause-circle"></i>
                                                @if (is_null($value->remaining_freeze_days))
                                                    <span class="badge bg-label-info">{{ $value->service->freeze_days }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-label-info">{{ $value->remaining_freeze_days }}
                                                    </span>
                                                @endif
                                            </button>

                                            @if ($value->getPaidAmountAttribute() != $value->service->price)
                                                <button class="btn btn-success add-payment-btn" data-bs-toggle="modal"
                                                    data-bs-target="#paymentModal"
                                                    data-subscription-id="{{ $value->id }}"
                                                    title="{{ __('common.payment_sub') }}">
                                                    <i class="bx bx-credit-card"></i>


                                                </button>
                                            @endif


                                            <button type="button" class="btn btn-icon btn-info view-subscription-btn"
                                                onclick="window.location.href='{{ route('admin.subscription.show', $value->id) }}'"
                                                title="{{ __('common.view') }}">
                                                <i class="bx bx-show"></i>
                                            </button>
                                            <a href="{{ route('admin.subscription.edit', $value->id) }}"
                                                class="btn btn-icon btn-info" data-bs-toggle="tooltip"
                                                title="{{ trans('common.edit') }}">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.subscription.invoice', $value->id) }}"
                                                class="btn btn-icon btn-warning" title="طباعة الفاتورة" target="_blank">
                                                <i class="bx bx-printer"></i>
                                            </a>
                                            <!-- Delete Button -->
                                            <?php $delete = route('admin.subscription.destroy', ['id' => $value->id]); ?>
                                            <button type="button" class="btn btn-icon btn-danger"
                                                onclick="confirmDelete('{{ $delete }}','{{ $value->id }}')"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-original-title="{{ trans('common.delete') }}">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach

                        </table>
                        {{ $subscriptions->links('vendor.pagination.default') }}
                    </div>
                </div>
            </div>
        </div>
        @include('AdminPanel.subscriptions.create')
        <!-- Modal to edit existing  -->
        @include('AdminPanel.subscriptions.new_paid_amount')
        @include('AdminPanel.subscriptions.freeze_days')

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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const freezeModal = document.getElementById('freezeModal');
                freezeModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const subscriptionId = button.getAttribute('data-subscription-id');


                    document.getElementById('freeze-subscription-id').value = subscriptionId;

                });
            });
        </script>
    @endsection
