<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>فاتورة اشتراك</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            width: 80mm;
            margin: 0 auto;
            padding: 10px;
            font-size: 14px;
        }

        .invoice-box {
            border: 1px dashed #000;
            padding: 10px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .row {
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
        }

        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 12px;
        }

        @media print {
            body {
                width: 80mm;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <div class="title">فاتورة اشتراك</div>

        <div class="row"><span>الاسم:</span> <span>{{ $subscription->member->name }}</span></div>
        <div class="row"><span>الخدمة:</span> <span>{{ $subscription->service->name }}</span></div>
        <div class="row"><span>تاريخ البداية:</span> <span>{{ $subscription->start_date }}</span></div>
        <div class="row"><span>تاريخ الانتهاء:</span> <span>{{ $subscription->end_date }}</span></div>
        <div class="row"><span>السعر الكلي:</span> <span>{{ $subscription->service->price }} </span></div>
        <div class="row"><span>المدفوع:</span> <span>{{ $subscription->getPaidAmountAttribute() }} </span></div>
        <div class="row"><span>المتبقي:</span>
            <span>{{ $subscription->service->price - $subscription->getPaidAmountAttribute() }} </span>
        </div>

        <!-- Barcode -->
        <div class="row" style="justify-content: center; margin-top: 15px;">
            {!! DNS1D::getBarcodeSVG($subscription->id . '-' . substr($subscription->member->uuid, 0, 6), 'C128', 2, 50) !!}
        </div>

        <div class="footer">
            شكراً لاشتراكك معنا<br>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
