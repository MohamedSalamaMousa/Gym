@extends('AdminPanel.layouts.master')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h3 class="mb-4 text-center text-primary">📷 {{ __('common.Scan Member Barcode') }}</h3>

            <form id="barcode-form" class="text-center">
                <div class="form-group mb-3">
                    <input type="text" name="barcode" id="barcode" autofocus
                        class="form-control form-control-lg text-center border-primary" placeholder="Scan barcode here...">
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-50">تأكيد الحضور</button>
            </form>

            <div id="response-message" class="mt-4 text-center"></div>
        </div>
    </div>

    <script>
        document.getElementById('barcode-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const barcode = document.getElementById('barcode').value;

            fetch("{{ route('admin.attendance.mark') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        barcode: barcode
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const messageDiv = document.getElementById('response-message');
                    messageDiv.innerHTML = `<strong>${data.message}</strong>`;
                    messageDiv.className = data.status === 'success' ? 'alert alert-success' :
                        'alert alert-danger';

                    // Reset input
                    document.getElementById('barcode').value = '';
                    document.getElementById('barcode').focus();
                });
        });
    </script>
@endsection
