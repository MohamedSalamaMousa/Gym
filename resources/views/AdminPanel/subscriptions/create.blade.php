<div class="offcanvas offcanvas-end" id="add-new-service">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">New Subscription</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form id="form-add-new-service" method="POST" action="{{ route('admin.subscription.store') }}">
            @csrf <!-- Include CSRF Token -->
            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="memberSelect">{{ __('common.select_member') }}</label>
                <div class="input-group input-group-merge">
                    <span id="memberSelect2" class="input-group-text"><i class="icon-base bx bx-user"></i></span>
                    <!-- Changed icon to represent member -->
                    <select id="memberSelect" name="member_id" class="form-select select2" aria-label="Select Member">
                        <option value="" selected>{{ __('common.select_member') }}</option>
                        @foreach ($members as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="serviceSelect">{{ __('common.select_service') }}</label>
                <div class="input-group input-group-merge">
                    <span id="serviceSelect2" class="input-group-text"><i class="icon-base bx bx-cog"></i></span>
                    <!-- Service icon remains the same -->
                    <select id="serviceSelect" name="service_id" class="form-select select2"
                        aria-label="Select Service">
                        <option value="" selected>{{ __('common.select_service') }}</option>
                        @foreach ($services as $value)
                            <option value="{{ $value->id }}" data-session-count="{{ $value->session_count }}">
                                {{ $value->name }} - {{ $value->price }}
                            </option>
                        @endforeach

                    </select>
                </div>
            </div>

            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="startDate">{{ __('common.start_date') }}</label>
                <div class="input-group input-group-merge">
                    <span id="startDate2" class="input-group-text"><i class="icon-base bx bx-calendar"></i></span>
                    <!-- Calendar icon for start date -->
                    <input type="date" id="startDate" name="start_date" class="form-control"
                        placeholder="{{ __('common.start_date') }}" aria-label="{{ __('common.start_date') }}"
                        aria-describedby="startDate2" required>
                </div>
            </div>

            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="endDate">{{ __('common.end_date') }}</label>
                <div class="input-group input-group-merge">
                    <span id="endDate2" class="input-group-text"><i class="icon-base bx bx-calendar"></i></span>
                    <!-- Calendar icon for end date -->
                    <input type="date" id="endDate" name="end_date" class="form-control"
                        placeholder="{{ __('common.end_date') }}" aria-label="{{ __('common.end_date') }}"
                        aria-describedby="endDate2" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('common.paid_amount') }}</label>
                <input type="number" name="paid_amount" class="form-control" step="0.01" required>
            </div>

            <!-- Checkbox: Is Individual -->
            <div class="col-sm-12 form-check form-switch mt-3">
                <input class="form-check-input" type="checkbox" id="isIndividual" name="is_individual" value="1">
                <label class="form-check-label" for="isIndividual">{{ __('common.is_individual') }}</label>
            </div>

            <!-- Captain Select (hidden by default) -->
            <div class="col-sm-12 form-control-validation mt-3 d-none" id="captainSelectWrapper">
                <div class="mb-3">
                    <label class="form-label">{{ __('common.captain_percentage') }}</label>
                    <input type="number" name="captain_percentage" class="form-control" step="any">
                </div>
                <label class="form-label" for="captainSelect">{{ __('common.select_captain') }}</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-dumbbell"></i></span>
                    <select id="captainSelect" name="captain_id" class="form-select select2"
                        aria-label="{{ __('common.select_captain') }}">
                        <option value="">{{ __('common.select_captain') }}</option>
                        @foreach ($captains as $captain)
                            <option value="{{ $captain->id }}">{{ $captain->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <br>
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary data-submit me-sm-4 me-1">Submit</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>
@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const serviceSelect = document.getElementById('serviceSelect');
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');

        function calculateEndDate() {
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            const sessionCount = parseInt(selectedOption.getAttribute('data-session-count'));

            const startDateValue = startDateInput.value;

            if (startDateValue && sessionCount && !isNaN(sessionCount)) {
                const startDate = new Date(startDateValue);
                startDate.setDate(startDate.getDate() + (sessionCount - 1)); // نضيف (عدد الجلسات - 1) يوم
                const year = startDate.getFullYear();
                const month = ('0' + (startDate.getMonth() + 1)).slice(-2);
                const day = ('0' + startDate.getDate()).slice(-2);
                endDateInput.value = `${year}-${month}-${day}`;
            } else {
                endDateInput.value = '';
            }
        }

        serviceSelect.addEventListener('change', calculateEndDate);
        startDateInput.addEventListener('change', calculateEndDate);
    });
    </script>



    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%', // لضمان أنها تأخذ عرض العنصر بالكامل
                dropdownParent: $('#add-new-service') // مهم لو كان داخل offcanvas/modal
            });

            const isIndividual = document.getElementById('isIndividual');
            const captainSelectWrapper = document.getElementById('captainSelectWrapper');

            isIndividual.addEventListener('change', function() {
                if (this.checked) {
                    captainSelectWrapper.classList.remove('d-none');
                } else {
                    captainSelectWrapper.classList.add('d-none');
                    $('#captainSelect').val(null).trigger('change'); // clear selection
                }
            });
        });
    </script>
@endsection
