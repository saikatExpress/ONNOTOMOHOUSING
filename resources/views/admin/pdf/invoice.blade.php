<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        /* Define your CSS styles for the PDF invoice */
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-header {
            padding: 20px;
            background-color: #f0f0f0;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-table th, .invoice-table td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>Invoice</h1>
    </div>

    <div class="invoice-details">
        <!-- Display invoice details here -->
        <p>Invoice Date: </p>
        <p>Invoice Number: </p>
    </div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Approve By</th>
            </tr>
        </thead>
        <tbody>
            <!-- Iterate over invoice data and display rows -->
            {{-- @foreach ($data as $payment)
                <tr>
                    <td>{{ $payment->name }}</td>
                    <td>{{ $payment->name }}</td>
                    <td>{{ $payment->name }}</td>
                    <td>{{ $payment->name }}</td>
                </tr>
            @endforeach --}}
        </tbody>
    </table>
</body>
</html>
