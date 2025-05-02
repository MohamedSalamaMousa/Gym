@extends('AdminPanel.layouts.master')

@section('content')
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <!-- Add New Captain Button -->
                    <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#add-new-captain"
                        aria-controls="add-new-captain">
                        <i class="bx bx-plus-circle"></i> {{ __('common.Add New Captain') }}
                    </button>
                </div>

                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>{{ trans('common.name') }}</th>
                                <th>{{ trans('common.phone') }}</th>

                                <th>{{ trans('common.status') }}</th>
                                <th>{{ trans('common.Wallet') }}</th>
                                <th>{{ trans('common.created_by') }}</th>
                                <th>{{ __('common.cleared_by') }}</td>
                                <th>{{ trans('common.updated_by') }}</th>
                                <th>{{ trans('common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($captains as $captain)
                                <tr>
                                    <td><strong>{{ $captain->name }}</strong></td>
                                    <td>{{ $captain->phone }}</td>

                                    <td>
                                        <span
                                            class="badge bg-{{ $captain->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ trans('common.' . $captain->status) }}
                                        </span>
                                    </td>
                                    <td><strong>{{ $captain->totalWalletBalance() }} </strong></td>
                                    <td>
                                        @if ($captain->created_by)
                                            {{ $captain->created_by }}
                                        @else
                                            {{ __('common.not available') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($captain->cleared_by)
                                            {{ $captain->cleared_by }}
                                        @else
                                            {{ __('common.not updated') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($captain->updated_by)
                                            {{ $captain->updated_by }}
                                        @else
                                            {{ __('common.not updated') }}
                                        @endif
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-icon btn-info view-subscription-btn"
                                            onclick="window.location.href='{{ route('admin.captain.show', $captain->id) }}'"
                                            title="{{ __('common.view') }}">
                                            <i class="bx bx-show"></i>
                                        </button>
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.captain.edit', $captain->id) }}"
                                            class="btn btn-icon btn-info" data-bs-toggle="tooltip"
                                            title="{{ trans('common.edit') }}">
                                            <i class="bx bx-edit"></i>
                                        </a>

                                        <!-- Wallet Adjustment -->
                                        <button type="button" class="btn btn-icon btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#walletModal{{ $captain->id }}" title="تعديل الرصيد">
                                            <i class="bx bx-dollar-circle"></i>
                                        </button>

                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-icon btn-danger"
                                            onclick="confirmDelete('{{ route('admin.captain.destroy', $captain->id) }}', '{{ $captain->id }}')"
                                            title="{{ trans('common.delete') }}">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                        <!-- Clear Wallet Button -->
                                        <!-- Clear Wallet Button (Trigger Modal) -->
                                        <button type="button" class="btn btn-icon btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#clearWalletModal{{ $captain->id }}" title="تصفية المستحقات">
                                            <i class="bx bx-reset"></i>
                                        </button>


                                    </td>
                                </tr>
                                <!-- Clear Wallet Confirmation Modal -->
                                <div class="modal fade" id="clearWalletModal{{ $captain->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">تأكيد تصفية المستحقات</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="إغلاق"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>هل أنت متأكد أنك تريد تصفية مستحقات الكابتن
                                                    <strong>{{ $captain->name }}</strong> لبداية شهر جديد؟
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('admin.captain.clearWallet', $captain->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">تأكيد</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">إلغاء</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Wallet Modal -->
                                <div class="modal fade" id="walletModal{{ $captain->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{ route('admin.captain.adjustWallet', $captain) }}">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">تعديل الرصيد - {{ $captain->name }}</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">المبلغ</label>
                                                        <input type="number" name="amount" class="form-control" required
                                                            step="0.01">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">نوع العملية</label>
                                                        <select name="type" class="form-control" required>
                                                            <option value="add">إضافة</option>
                                                            <option value="subtract">خصم</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">ملاحظة</label>
                                                        <textarea name="note" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">تأكيد</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">إلغاء</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    @include('AdminPanel.captains.create') {{-- لو عندك فورم إضافة كابتن --}}
@endsection
