<!-- Freeze Subscription Modal -->
<div class="modal fade" id="freezeModal" tabindex="-1" aria-labelledby="freezeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.subscription.freeze') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="freezeModalLabel">تجميد الاشتراك</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="subscription_id" id="freeze-subscription-id">
                    <div class="mb-3">
                        <label for="freeze_days" class="form-label">عدد أيام التجميد</label>
                        <input type="number" min="1" class="form-control" name="freeze_days"
                            id="freeze-days-input" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </form>
    </div>
</div>
