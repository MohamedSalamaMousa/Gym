@extends('AdminPanel.layouts.master')

@section('content')
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h3 class="mb-4 text-center text-primary">🔍 البحث عن حضور مشترك</h3>

            <form action="{{ route('admin.attendance.search') }}" method="POST" class="mb-4">
                @csrf
                <div class="input-group">
                    <input type="text" name="name" class="form-control" placeholder="أدخل اسم المشترك"
                        value="{{ old('name') }}">
                    <button type="submit" class="btn btn-primary">بحث</button>
                </div>
            </form>

            @if (isset($subscriptions) && $subscriptions->count())
                @foreach ($subscriptions as $subscription)
                    <div class="mb-4">
                        <h5>👤 {{ $subscription->member->name }}</h5>
                        <table class="table table-bordered table-striped">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>تاريخ الحضور</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subscription->attendances as $attendance)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $attendance->created_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">لا يوجد حضور مسجل</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @elseif(isset($subscriptions))
                <div class="alert alert-warning text-center">لم يتم العثور على مشترك بهذا الاسم.</div>
            @endif
        </div>
    </div>
@endsection
