@extends('AdminPanel.layouts.master')

@section('content')
    @include('AdminPanel.layouts.common.response-messages')

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ trans('common.edit_subscription') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.subscription.update', $subscription->id) }}" method="POST">
                        @csrf


                        <div class="row g-3 pt-2">

                            <!-- Member -->
                            <div class="col-md-6 col-lg-4">
                                <label for="member_id" class="form-label">{{ trans('common.select_member') }}</label>
                                <select name="member_id" id="member_id" class="form-select select2" required>
                                    <option value="">{{ trans('common.select_member') }}</option>
                                    @foreach ($members as $member)
                                        <option value="{{ $member->id }}"
                                            {{ $subscription->member_id == $member->id ? 'selected' : '' }}>
                                            {{ $member->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Service -->
                            <div class="col-md-6 col-lg-4">
                                <label for="service_id" class="form-label">{{ trans('common.select_service') }}</label>
                                <select name="service_id" id="service_id" class="form-select select2" required>
                                    <option value="">{{ trans('common.select_service') }}</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}"
                                            {{ $subscription->service_id == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Start Date -->
                            <div class="col-md-6 col-lg-4">
                                <label for="start_date" class="form-label">{{ trans('common.start_date') }}</label>
                                <input type="date" class="form-control" name="start_date" id="start_date"
                                    value="{{ $subscription->start_date }}" required />
                            </div>

                            <!-- End Date -->
                            <div class="col-md-6 col-lg-4">
                                <label for="end_date" class="form-label">{{ trans('common.end_date') }}</label>
                                <input type="date" class="form-control" name="end_date" id="end_date"
                                    value="{{ $subscription->end_date }}" required />
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="end_date" class="form-label">{{ trans('common.remaining_invitions') }}</label>
                                <input type="number" class="form-control" name="remaining_invitions" id="end_date"
                                    value="{{ $subscription->remaining_invitions }}" required min=0 value="0" />
                            </div>

                            {{-- <!-- Paid Amount -->
                            <div class="col-md-6 col-lg-4">
                                <label for="paid_amount" class="form-label">{{ trans('common.paid_amount') }}</label>
                                <input type="number" step="0.01" class="form-control" name="paid_amount"
                                    id="paid_amount" value="{{ $subscription->paid_amount }}" />
                            </div> --}}
                            <!-- Status -->
                            {{-- <div class="col-md-6 col-lg-4 mt-4">
                                <label for="status" class="form-label">{{ trans('common.status') }}</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="active" {{ $subscription->status == 'active' ? 'selected' : '' }}>
                                        {{ trans('common.active') }}</option>
                                    <option value="expired" {{ $subscription->status == 'expired' ? 'selected' : '' }}>
                                        {{ trans('common.inactive') }}</option>
                                </select>
                            </div> --}}

                            <!-- Is Individual -->
                            <div class="col-md-6 col-lg-4 mt-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_individual" id="is_individual"
                                        value="1" {{ $subscription->is_individual ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="is_individual">{{ trans('common.is_individual') }}</label>
                                </div>
                            </div>

                            <!-- Captain (if individual) -->
                            <div class="col-md-6 col-lg-4" id="captainSelectWrapper"
                                style="{{ $subscription->is_individual ? '' : 'display:none;' }}">
                                <label for="captain_id" class="form-label">{{ trans('common.select_captain') }}</label>
                                <select name="captain_id" id="captain_id" class="form-select select2">
                                    <option value="">{{ trans('common.select_captain') }}</option>
                                    @foreach ($captains as $captain)
                                        <option value="{{ $captain->id }}"
                                            {{ $subscription->captain_id == $captain->id ? 'selected' : '' }}>
                                            {{ $captain->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="mb-3">
                                    <label class="form-label">{{ __('common.captain_percentage') }}</label>
                                    <input type="number" name="captain_percentage" class="form-control" step="any"
                                        value="{{ $subscription->captain_percentage }}">
                                </div>
                            </div>
                        </div>

                        <div class="row pt-4">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> {{ trans('common.Save changes') }}
                                </button>
                                <a href="{{ route('admin.subscription.index') }}" class="btn btn-secondary ms-2">
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

@section('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                dropdownParent: $('.card-body') // لضمان عمله بشكل صحيح داخل الصفحة
            });

            const individualCheckbox = document.getElementById('is_individual');
            const captainSelectWrapper = document.getElementById('captainSelectWrapper');

            individualCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    captainSelectWrapper.style.display = 'block';
                } else {
                    captainSelectWrapper.style.display = 'none';
                    $('#captain_id').val(null).trigger('change');
                }
            });
        });
    </script>
@endsection
