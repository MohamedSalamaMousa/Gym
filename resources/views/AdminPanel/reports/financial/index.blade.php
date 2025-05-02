@extends('AdminPanel.layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">

                <form action="{{ route('admin.reports.financial.index') }}" method="GET" class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label>{{ __('common.start_date') }}</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>{{ __('common.end_date') }}</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bx bx-search"></i> {{ __('common.search') }}
                        </button>
                        <a href="{{ route('admin.reports.financial.index') }}" class="btn btn-light">
                            {{ __('common.Reset') }}
                        </a>
                        <a href="{{ route('admin.reports.financial.pdf', request()->query()) }}" class="btn btn-danger">
                            <i class="bx bx-download"></i> {{ __('common.download_pdf') }}
                        </a>
                    </div>
                </form>

                <h5 class="mb-3">{{ __('common.today_subscriptions') }}</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('common.member_name') }}</th>
                                <th>{{ __('common.service') }}</th>
                                <th>{{ __('common.paid_amount') }}</th>
                                <th>{{ __('common.paid_at') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subscriptions as $sub)
                                <tr>
                                    <td>{{ $sub->subscription->member->name ?? '-' }}</td>
                                    <td>{{ $sub->subscription->service->name ?? '-' }}</td>
                                    <td>{{ $sub->paid_amount }}</td>
                                    <td>{{ $sub->paid_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">{{ __('common.no_data_found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $subscriptions->appends(request()->query())->links('vendor.pagination.default') }}

                </div>

                <hr>

                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="alert alert-success text-center">
                            <h6>{{ __('common.total_income') }}</h6>
                            <h4>{{ $totalIncome }} {{ __('common.currency') }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-danger text-center">
                            <h6>{{ __('common.total_outcome') }}</h6>
                            <h4>{{ $totalOutcome }} {{ __('common.currency') }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-primary text-center">
                            <h6>{{ __('common.net_total') }}</h6>
                            <h4>{{ $totalIncome - $totalOutcome }} {{ __('common.currency') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
