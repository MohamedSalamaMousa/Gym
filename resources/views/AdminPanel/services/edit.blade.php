<div class="offcanvas offcanvas-end" id="edit-service-modal">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">{{ __('common.edit') }} {{ __('common.service') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form id="form-edit-service" method="POST">
            @csrf
            @method('PUT') <!-- Ensure the PUT request is sent -->
            <input type="hidden" id="editServiceId" name="id">

            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="editServiceName">{{ __('common.name of service') }}</label>
                <div class="input-group input-group-merge">
                    <span id="editServiceName2" class="input-group-text"><i class="icon-base bx bx-cog"></i></span>
                    <input type="text" id="editServiceName" class="form-control" name="name" required>
                </div>
            </div>

            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="editServicePrice">{{ trans('common.price') }}</label>
                <div class="input-group input-group-merge">
                    <span id="editServicePrice2" class="input-group-text"><i class="icon-base bx bx-dollar"></i></span>
                    <input type="number" id="editServicePrice" name="price" class="form-control" required
                        step="0.01">
                </div>
            </div>

            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="editSessionCount">{{ __('common.Number of sessions') }}</label>
                <div class="input-group input-group-merge">
                    <span id="editSessionCount2" class="input-group-text"><i
                            class="icon-base bx bx-calendar-check"></i></span>
                    <input type="number" id="editSessionCount" name="session_count" class="form-control" required
                        min="0">
                </div>
            </div>

            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="editServiceDescription">{{ __('common.description') }}</label>
                <div class="input-group input-group-merge">
                    <span id="editServiceDescription2" class="input-group-text"><i
                            class="icon-base bx bx-edit"></i></span>
                    <textarea id="editServiceDescription" name="description" class="form-control" rows="4"></textarea>
                </div>
            </div>

            <div class="col-sm-12">
                <button type="submit"
                    class="btn btn-primary data-submit me-sm-4 me-1">{{ __('common.update') }}</button>
                <button type="reset" class="btn btn-outline-secondary"
                    data-bs-dismiss="offcanvas">{{ __('common.cancel') }}</button>
            </div>
        </form>
    </div>
</div>
