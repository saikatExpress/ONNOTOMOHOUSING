@extends('admin.layout.app')

<style>
    #searchResults {
        background-color: #fff;
        padding: 5px;
        border-radius: 4px;
        margin-top: 10px;
    }
</style>
@section('content')

    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <p class="text-right">
            <a class="btn btn-sm btn-success" href="{{ route('expense.list') }}">
                Expense List
            </a>
        </p>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Create Expense</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <form id="searchForm">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Share Holder</label>
                        <select name="holder_id" id="holderId" class="form-control">
                            <option value="0">Select</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="">Amounty Type</label>
                    <select name="amount_type" id="amountType" class="form-control">
                        <option value="" disabled selected>Select</option>
                        <option value="credit">Credit</option>
                        <option value="debit">Debit</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">From</label>
                        <input type="date" name="from_date" id="fromDate" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">To</label>
                        <input type="date" name="to_date" id="toDate" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-sm btn-primary">Search</button>
                </div>
            </form>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <a href="#" id="downloadExcel" class="btn btn-sm btn-success">Download Excel</a>
                <a href="#" id="downloadPdf" class="btn btn-sm btn-success">Download PDF</a>
            </div>
            <div class="col-md-12">
                <div id="searchResults"></div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        $(document).ready(function() {
            // Submit form via AJAX
            $('#searchForm').submit(function(e) {
                e.preventDefault(); // Prevent form submission

                var formData = $(this).serialize(); // Serialize form data
                var url = '/search'; // Adjust URL based on your route

                $.ajax({
                    type: 'GET',
                    url: url,
                    data: formData,
                    success: function(response) {
                        $('#searchResults').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            $('#downloadExcel').click(function(e) {
                e.preventDefault();

                // Collect table data
                var csv = [];
                var rows = $('#searchResults table tbody tr');
                rows.each(function(index, row) {
                    var rowData = [];
                    $(row).find('td').each(function(index, cell) {
                        rowData.push($(cell).text().trim());
                    });
                    csv.push(rowData.join(','));
                });

                // Convert data to CSV format
                var csvContent = "data:text/csv;charset=utf-8," + csv.join('\n');

                // Create download link
                var encodedUri = encodeURI(csvContent);
                var link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", "data.csv");
                document.body.appendChild(link);

                // Trigger download
                link.click();
            });


            // Download PDF
            $('#downloadPdf').click(function(e) {
                e.preventDefault();

                // Trigger AJAX request to generate PDF
                $.ajax({
                    url: '/generate-pdf',
                    type: 'GET',
                    success: function(response) {
                        // Redirect to the generated PDF file
                        window.location.href = response.url;
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

        });
    </script>
@endsection
