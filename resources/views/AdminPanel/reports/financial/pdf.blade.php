<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    

    <style>
        @font-face {
            font-family: 'arabic';
            src: url("{{ public_path('fonts/Amiri-Regular.ttf') }}") format("truetype");
        }

        body {
            font-family: 'arabic';
            direction: rtl;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #888;
            padding: 8px;
            text-align: center;
        }

        h2,
        h4,
        h6 {
            text-align: center;
        }

        p {
            text-align: center;
            margin-top: 10px;
        }

        .summary {
            margin-top: 30px;
            text-align: center;
        }

        .summary h4 {
            margin: 8px 0;
        }
    </style>
</head>

<body>

    <h2>Financial Report</h2>

    @if ($start_date && $end_date)
        <p>From: {{ $start_date }} to: {{ $end_date }}</p>
    @else
        <p>Today's Date: {{ now()->format('Y-m-d') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Member Name</th>
                <th>Service</th>
                <th>Amount Paid</th>
                <th>Payment Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($subscriptions as $sub)
                <tr>
                    <td>{{ $sub->subscription->member->name ?? '-' }}</td>
                    <td>{{ $sub->subscription->service->name ?? '-' }}</td>
                    <td>{{ $sub->paid_amount }} EGP</td>
                    <td>{{ \Carbon\Carbon::parse($sub->paid_at)->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No Data Available</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <h4>Total Income: {{ $totalIncome }} EGP</h4>
        <h4>Total Expenses: {{ $totalOutcome }} EGP</h4>
        <h4>Net: {{ $totalIncome - $totalOutcome }} EGP</h4>
    </div>

</body>

</html>
