<div class="offcanvas offcanvas-end" id="add-new-service">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">New Service</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form id="form-add-new-service" method="POST" action="{{ route('admin.service.store') }}">
            @csrf <!-- Include CSRF Token -->
            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="serviceName">{{ __('common.name of service') }}</label>
                <div class="input-group input-group-merge">
                    <span id="serviceName2" class="input-group-text"><i class="icon-base bx bx-cog"></i></span>
                    <input type="text" id="serviceName" class="form-control" name="name"
                        placeholder="{{ __('common.name of service') }}" aria-label="اسم الخدمة"
                        aria-describedby="serviceName2" required>
                </div>
            </div>

            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="servicePrice">{{ trans('common.price') }} </label>
                <div class="input-group input-group-merge">
                    <span id="servicePrice2" class="input-group-text"><i class="icon-base bx bx-dollar"></i></span>
                    <input type="number" id="servicePrice" name="price" class="form-control"
                        placeholder="{{ trans('common.price') }}" aria-label="سعر الخدمة"
                        aria-describedby="servicePrice2" required step="0.01">
                </div>
            </div>


            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="sessionCount"> {{ __('common.Number of sessions') }}</label>
                <div class="input-group input-group-merge">
                    <span id="sessionCount2" class="input-group-text"><i
                            class="icon-base bx bx-calendar-check"></i></span>
                    <input type="number" id="sessionCount" name="session_count" class="form-control"
                        placeholder="{{ __('common.Number of sessions') }}" aria-label="عدد الجلسات المتاحة"
                        aria-describedby="sessionCount2" required min="0">
                </div>
            </div>

            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="servicePrice">{{ trans('common.Number of Invitions') }} </label>
                <div class="input-group input-group-merge">
                    <span id="servicePrice2" class="input-group-text"><i class="icon-base bx bx-user-plus"></i></span>
                    <input type="number" id="servicePrice" name="num_invitions" class="form-control"
                        placeholder="{{ trans('common.Number of Invitions') }}" aria-label="عدد الدعوات "
                        aria-describedby="servicePrice2" required min="0">
                </div>
            </div>

            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="sessionCount"> {{ __('common.freeze_days') }}</label>
                <div class="input-group input-group-merge">
                    <span id="sessionCount2" class="input-group-text"> <i class="icon-base bx bx-pause-circle"></i>
                        <!-- أيقونة التجميد --></span>
                    <input type="number" id="sessionCount" name="freeze_days" class="form-control"
                        placeholder="{{ __('common.freeze_days') }}" aria-label="عدد أيام التجميد"
                        aria-describedby="sessionCount2" required min="0">
                </div>
            </div>

            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="serviceDescription">{{ __('common.description') }} </label>
                <div class="input-group input-group-merge">
                    <span id="serviceDescription2" class="input-group-text"><i class="icon-base bx bx-edit"></i></span>
                    <textarea id="serviceDescription" name="description" class="form-control" placeholder=""
                        aria-label="{{ __('common.description') }}" aria-describedby="serviceDescription2" rows="4"></textarea>
                </div>
            </div>

            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary data-submit me-sm-4 me-1">Submit</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>
