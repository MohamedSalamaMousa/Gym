<div class="offcanvas offcanvas-end" id="add-new-supply">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">New Gym Supply</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form id="form-add-new-supply" method="POST" action="{{ route('admin.gymSupply.store') }}">
            @csrf <!-- Include CSRF Token -->

            <!-- Item Name -->
            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="itemName">{{ __('common.item_name') }}</label>
                <div class="input-group input-group-merge">
                    <span id="itemName2" class="input-group-text"><i class="icon-base bx bx-cog"></i></span>
                    <input type="text" id="itemName" class="form-control" name="item_name"
                        placeholder="{{ __('common.item_name') }}" aria-label="اسم الأداة" aria-describedby="itemName2"
                        required>
                </div>
            </div>

            <!-- Quantity -->
            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="quantity">{{ trans('common.quantity') }}</label>
                <div class="input-group input-group-merge">
                    <span id="quantity2" class="input-group-text"><i class="icon-base bx bx-cube"></i></span>
                    <input type="number" id="quantity" name="quantity" class="form-control"
                        placeholder="{{ trans('common.quantity') }}" aria-label="الكمية" aria-describedby="quantity2"
                        required>
                </div>
            </div>

            <!-- Unit Price -->
            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="unitPrice">{{ trans('common.unit_price') }}</label>
                <div class="input-group input-group-merge">
                    <span id="unitPrice2" class="input-group-text"><i class="icon-base bx bx-dollar"></i></span>
                    <input type="number" id="unitPrice" name="unit_price" class="form-control"
                        placeholder="{{ trans('common.unit_price') }}" aria-label="سعر الوحدة"
                        aria-describedby="unitPrice2" required step="0.01">
                </div>
            </div>

            <!-- Purchase Date -->
            <div class="col-sm-12 form-control-validation">
                <label class="form-label" for="purchaseDate">{{ __('common.purchase_date') }}</label>
                <div class="input-group input-group-merge">
                    <span id="purchaseDate2" class="input-group-text"><i class="icon-base bx bx-calendar"></i></span>
                    <input type="date" id="purchaseDate" name="purchase_date" class="form-control"
                        placeholder="{{ __('common.purchase_date') }}" aria-label="تاريخ الشراء"
                        aria-describedby="purchaseDate2" required>
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
