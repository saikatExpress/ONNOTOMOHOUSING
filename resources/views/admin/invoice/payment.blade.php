<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f4f4f4;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .invoice-header, .invoice-footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-header img {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .invoice-body {
            margin-bottom: 20px;
        }
        .invoice-details {
            margin-bottom: 20px;
            width: 100%;
        }
        .invoice-details th, .invoice-details td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
        }
        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <img src="{{ asset('logos/ONNOTOTOWER.png') }}" alt="Company Logo">
            <h1>Invoice</h1>
        </div>
        <div class="invoice-body">
            <h2>Payment Details</h2>
            <table class="invoice-details">
                <tr>
                    <th>Invoice Number</th>
                    <td>{{ $payment->id }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $payment->user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $payment->user->email }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $payment->user->mobile }}</td>
                </tr>
                <tr>
                    <th>Amount</th>
                    <td>${{ number_format($payment->amount, 2) }}</td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>{{ $payment->status ? 'Approved' : 'Pending' }}</td>
                </tr>

                <tr>
                    <th>Date</th>
                    <td>{{ $payment->created_at->format('d M Y') }}</td>
                </tr>
            </table>
        </div>
        <div class="invoice-footer">
            <a href="#" class="btn" id="printInvoice">Print</a>
            <a href="{{ route('invoice.pdf', $payment->id) }}" class="btn">Download PDF</a>
        </div>
    </div>

    <script>
        document.getElementById('printInvoice').addEventListener('click', function() {
            window.print();
        });
    </script>
</body>
</html>
