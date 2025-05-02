<div class="offcanvas offcanvas-end" id="edit-service-modal">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Edit Service</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form id="form-edit-service" method="POST" action="{{ route('admin.service.update') }}">
            @csrf
            @method('Post') <!-- Ensure PUT method for update -->

            <input type="hidden" name="id" id="edit-service-id">

            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="edit-serviceName">{{ __('common.name of service') }}</label>
                <div class="input-group input-group-merge">
                    <span id="edit-serviceName2" class="input-group-text"><i class="icon-base bx bx-cog"></i></span>
                    <input type="text" id="edit-serviceName" class="form-control" name="name"
                        placeholder="{{ __('common.name of service') }}" aria-label="اسم الخدمة"
                        aria-describedby="edit-serviceName2" required>
                </div>
            </div>

            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="edit-servicePrice">{{ trans('common.price') }} </label>
                <div class="input-group input-group-merge">
                    <span id="edit-servicePrice2" class="input-group-text"><i class="icon-base bx bx-dollar"></i></span>
                    <input type="number" id="edit-servicePrice" name="price" class="form-control"
                        placeholder="{{ trans('common.price') }}" aria-label="سعر الخدمة"
                        aria-describedby="edit-servicePrice2" required step="0.01">
                </div>
            </div>


            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="edit-sessionCount"> {{ __('common.Number of sessions') }}</label>
                <div class="input-group input-group-merge">
                    <span id="edit-sessionCount2" class="input-group-text"><i
                            class="icon-base bx bx-calendar-check"></i></span>
                    <input type="number" id="edit-sessionCount" name="session_count" class="form-control"
                        placeholder="{{ __('common.Number of sessions') }}" aria-label="عدد الجلسات المتاحة"
                        aria-describedby="edit-sessionCount2" required min="0">
                </div>
            </div>
            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="edit-servicePrice">{{ trans('common.Number of Invitions') }} </label>
                <div class="input-group input-group-merge">
                    <span id="edit-servicePrice2" class="input-group-text"><i
                            class="icon-base bx bx-user-plus"></i></span>
                    <input type="number" id="edit-serviceInvitions" name="num_invitions" class="form-control"
                        placeholder="{{ trans('common.Number of Invitions') }}" aria-label="عدد الدعوات "
                        aria-describedby="edit-servicePrice2" required min="0">
                </div>
            </div>
            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="edit-servicePrice">{{ trans('common.freeze_days') }} </label>
                <div class="input-group input-group-merge">
                    <span id="edit-servicePrice2" class="input-group-text"><i
                            class="icon-base bx bx-pause-circle"></i></span>
                    <input type="number" id="edit-freezeDays" name="freeze_days" class="form-control"
                        placeholder="{{ trans('common.freeze_days') }}" aria-label="عدد أيام التجميد"
                        aria-describedby="edit-servicePrice2" required min="0">
                </div>
            </div>



            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="edit-serviceDescription">{{ __('common.description') }} </label>
                <div class="input-group input-group-merge">
                    <span id="edit-serviceDescription2" class="input-group-text"><i
                            class="icon-base bx bx-edit"></i></span>
                    <textarea id="edit-serviceDescription" name="description" class="form-control" placeholder=""
                        aria-label="{{ __('common.description') }}" aria-describedby="edit-serviceDescription2" rows="4"></textarea>
                </div>
            </div>

            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary data-submit me-sm-4 me-1">Submit</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>
