<div class="offcanvas offcanvas-end" id="add-new-captain">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">New Captain</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form id="form-add-new-captain" method="POST" action="{{ route('admin.captain.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">{{ __('common.name') }}</label>
                <input type="text" name="name" class="form-control" placeholder="{{ __('common.name') }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('common.email') }}</label>
                <input type="email" name="email" class="form-control" placeholder="{{ __('common.email') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('common.phone') }}</label>
                <input type="text" name="phone" class="form-control" placeholder="{{ __('common.phone') }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('common.address') }}</label>
                <textarea name="address" class="form-control" placeholder="{{ __('common.address') }}"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('common.city') }}</label>
                <input type="text" name="city" class="form-control" placeholder="{{ __('common.city') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('common.status') }}</label>
                <select name="status" class="form-control">
                    <option value="active">{{ __('common.active') }}</option>
                    <option value="inactive">{{ __('common.inactive') }}</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('common.Wallet') }}</label>
                <input type="number" name="price" class="form-control" required step="0.01">
            </div>
            <br>
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary data-submit me-sm-4 me-1">Submit</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>
