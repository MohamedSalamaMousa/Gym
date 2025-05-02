@extends('AdminPanel.layouts.master')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <!-- الاشتراكات الفعالة -->
            <div class="col-md-3">
                <div class="card shadow text-center p-4">
                    <h5 class="text-success">الاشتراكات الفعالة</h5>
                    <h2>{{ $activeSubscriptions }}</h2>
                </div>
            </div>

            <!-- الاشتراكات المنتهية -->
            <div class="col-md-3">
                <div class="card shadow text-center p-4">
                    <h5 class="text-danger">الاشتراكات المنتهية</h5>
                    <h2>{{ $inactiveSubscriptions }}</h2>
                </div>
            </div>

            <!-- عدد الأعضاء -->
            <div class="col-md-3">
                <div class="card shadow text-center p-4">
                    <h5 class="text-primary">عدد الأعضاء</h5>
                    <h2>{{ $members }}</h2>
                </div>
            </div>

            <!-- عدد الكابتن -->
            <div class="col-md-3">
                <div class="card shadow text-center p-4">
                    <h5 class="text-warning">عدد الكابتن</h5>
                    <h2>{{ $coaches }}</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
