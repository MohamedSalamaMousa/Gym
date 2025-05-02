<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.subscription.payment.store') }}">
            @csrf
            <input type="hidden" name="subscription_id" value="">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">إضافة دفعة جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">قيمة الدفعة</label>
                        <input type="number" step="0.01" name="paid_amount" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">حفظ الدفعة</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                </div>
            </div>
        </form>
    </div>
</div>
