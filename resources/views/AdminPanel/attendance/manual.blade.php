@extends('AdminPanel.layouts.master')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h3 class="mb-4 text-center text-primary">📋 تسجيل الحضور اليدوي</h3>

            <form id="manual-attendance-form" class="text-center">
                @csrf
                <div class="form-group mb-3">
                    <label>اختر العضو:</label>
                    <select name="member_id" id="member_id" class="form-select select2 form-control-lg">
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>اختر الخدمة:</label>
                    <select name="service_id" id="service_id" class="form-select select2 form-control-lg">
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-50">تأكيد الحضور</button>
            </form>

            <div id="response-message" class="mt-4 text-center"></div>
        </div>
    </div>

    <script>
        document.getElementById('manual-attendance-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const member_id = document.getElementById('member_id').value;
            const service_id = document.getElementById('service_id').value;

            fetch("{{ route('admin.attendance.manualMark') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        member_id: member_id,
                        service_id: service_id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const messageDiv = document.getElementById('response-message');
                    messageDiv.innerHTML = `<strong>${data.message}</strong>`;
                    messageDiv.className = data.status === 'success' ? 'alert alert-success' :
                        'alert alert-danger';
                });
        });
    </script>
@endsection
