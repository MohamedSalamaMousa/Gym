<div class="offcanvas offcanvas-end" id="add-new-service">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">New Member</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form id="form-add-new-service" method="POST" action="{{ route('admin.member.store') }}">
            @csrf <!-- Include CSRF Token -->
            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="serviceName">{{ __('common.name') }}</label>
                <div class="input-group input-group-merge">
                    <span id="serviceName2" class="input-group-text"><i class="icon-base bx bx-cog"></i></span>
                    <input type="text" id="serviceName" class="form-control" name="name"
                        placeholder="{{ __('common.name') }}" aria-label="اسم الخدمة" aria-describedby="serviceName2"
                        required>
                </div>
            </div>

            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="servicePrice">{{ trans('common.phone') }} </label>
                <div class="input-group input-group-merge">
                    <span id="servicePrice2" class="input-group-text"><i class="icon-base bx bxs-phone"></i>
                    </span>
                    <input type="text" id="servicePrice" name="phone" class="form-control"
                        placeholder="{{ trans('common.phone') }}" aria-label="سعر الخدمة"
                        aria-describedby="servicePrice2" required step="0.01">
                </div>
            </div>

            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="sessionCount"> {{ __('common.whatsapp') }}</label>
                <div class="input-group input-group-merge">
                    <span id="sessionCount2" class="input-group-text"><i class="icon-base bx bxl-whatsapp"></i></span>
                    <input type="text" id="sessionCount" name="whatsapp" class="form-control"
                        placeholder="{{ __('common.whatsapp') }}" aria-label="عدد الجلسات المتاحة" required>
                </div>
            </div>

            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="serviceDescription">{{ __('common.emergency_contact') }} </label>
                <div class="input-group input-group-merge">
                    <span id="serviceDescription2" class="input-group-text"><i class="icon-base bx bxs-phone"></i>
                    </span>
                    <input type="text" id="sessionCount" name="emergency_contact" class="form-control"
                        placeholder="{{ __('common.emergency_contact') }}" aria-label="عدد الجلسات المتاحة">
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
