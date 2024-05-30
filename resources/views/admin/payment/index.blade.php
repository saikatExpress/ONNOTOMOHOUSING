@extends('admin.layout.app')
@section('content')
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <p class="text-right">
            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#createPaymentModal">
                Create New Payment
            </button>
        </p>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User List</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    @if (session('error'))
                        <div class="alert alert-danger text-white" id="errorAlert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('message'))
                        <div class="alert alert-success" id="successAlert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Share Holder List</h3>
                            </div>
                            <div style="display: none;" id="paymentLoader">
                                <img style="width: 50px;height:50px;border-radius:50%;" src="{{ asset('GIF/new-loader.gif') }}" alt="Loading...">
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>USER ID</th>
                                        <th>IMAGE</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Whatsapp</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                       <tr>
                                            <td>{{ $payment->user->id }}</td>
                                            <td>
                                                <img width="50" height="50" class="thumbnail" style="border-radius: 50%;" src="{{ asset('storage/' . $payment->bank_slip) }}" alt="Bank Slip">
                                            </td>
                                            <td>{{ $payment->user->name }}</td>
                                            <td>{{ $payment->user->mobile }}</td>
                                            <td>
                                                <a href="https://wa.me/880{{ $payment->user->whatsapp }}" target="_blank">
                                                    {{ $payment->user->whatsapp }}
                                                </a>
                                            </td>
                                            <td>{{ number_format($payment->amount) }}</td>
                                            <td>
                                                @if ($payment->is_approve == 1)
                                                    <label class="btn btn-sm btn-success" for="">Approve</label>
                                                @else
                                                    <label class="btn btn-sm btn-warning" for="">Pending</label>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" data-id="{{ $payment->id }}" class="btn btn-sm btn-success approveBtn">
                                                    Approve
                                                </button>
                                                <button type="button" class="btn btn-sm btn-warning">
                                                    Pending
                                                </button>
                                                <button type="button" class="btn btn-sm btn-primary editBtn" data-id="{{ $payment->id }}">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger cancelBtn" data-id="{{ $payment->id }}">
                                                    Cancel
                                                </button>
                                                <a href="{{ route('make.invoice', ['id' => $payment->id]) }}" class="btn btn-sm btn-primary">
                                                    Invoice
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <div class="image-preview" id="imagePreview"></div>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Rendering engine</th>
                                        <th>Browser</th>
                                        <th>Platform(s)</th>
                                        <th>Engine version</th>
                                        <th>Data grade</th>
                                        <th>CSS grade</th>
                                        <th>Deposite grade</th>
                                        <th>Actions grade</th>
                                    </tr>
                                </tfoot>
                            </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="createPaymentModal" tabindex="-1" aria-labelledby="createPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPaymentModalLabel">Create New Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createPaymentForm" action="{{ route('payment.save') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Amount Deposited -->
                <div class="mb-3">
                    <label for="amount" class="form-label">Select Holder:</label>
                    <select class="form-control" name="userId" id="userId">
                        @foreach ($shareHolders as $holder)
                            <option value="{{ $holder->id }}">{{ $holder->name }}</option>
                        @endforeach
                    </select>
                    <span id="amountErr" class="text-danger text-sm"></span>
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount Deposited:</label>
                    <input type="number" step="0.01" name="amount" class="form-control" id="amount" required>
                    <span id="amountErr" class="text-danger text-sm"></span>
                </div>
                <!-- Bank Deposit Slip Upload -->
                <div class="mb-3">
                    <label for="depositSlip" class="form-label">Bank Deposit Slip:</label>
                    <input type="file" class="form-control" name="depositSlip" id="depositSlip" accept="image/*" required onchange="previewDepositSlip(event)">
                    <div class="image-preview mt-2" id="depositSlipPreview">
                    <img src="#" alt="Deposit Slip Image" id="depositSlipImage" style="display: none;" class="img-thumbnail">
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitPaymentForm()">Submit Payment</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPaymentModal" tabindex="-1" aria-labelledby="editPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPaymentModalLabel">Edit Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPaymentForm" enctype="multipart/form-data" method="POST">
                        @csrf
                        <input type="hidden" id="editPaymentId">
                        <!-- Amount Deposited -->
                        <div class="mb-3">
                            <label for="editAmount" class="form-label">Amount Deposited:</label>
                            <input type="number" step="0.01" name="amount" class="form-control" id="editAmount">
                            <span id="editAmountErr" class="text-danger text-sm"></span>
                        </div>

                        <!-- Bank Deposit Slip Upload -->
                        <div class="mb-3">
                            <label for="editDepositSlip" class="form-label">Bank Deposit Slip:</label>
                            <input type="file" class="form-control" name="depositSlip" id="editDepositSlip" accept="image/*" onchange="previewEditDepositSlip(event)">
                            <div class="image-preview mt-2" id="editDepositSlipPreview">
                                <img src="#" alt="Deposit Slip Image" id="editDepositSlipImage" style="display: none;" class="img-thumbnail">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Payment</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('user/custom/js/payment.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Automatically hide success message after 2 seconds
            setTimeout(function() {
                $('#successAlert').fadeOut('slow');
            }, 2000);

            // Automatically hide error message after 2 seconds
            setTimeout(function() {
                $('#errorAlert').fadeOut('slow');
            }, 2000);
        });
    </script>
    <script>
        $(document).ready(function(){
            $('.thumbnail').hover(function(event) {
                // Get the source of the thumbnail
                var src = $(this).attr('src');

                // Get the position of the thumbnail
                var position = $(this).offset();

                // Set the source of the image preview and show it
                $('#imagePreview').html('<img src="' + src + '" width="200" height="200">');
                $('#imagePreview').css({
                    'top': position.top + 'px',
                    'left': position.left + $(this).width() + 'px'
                }).show();
            }, function() {
                // Hide the image preview when not hovering
                $('#imagePreview').hide();
            });

            // Ensure the preview hides when the mouse leaves the image preview
            $('#imagePreview').hover(function() {
                $(this).show();
            }, function() {
                $(this).hide();
            });
        });
    </script>

    <script>
        function submitPaymentForm() {
            var form = $('#createPaymentForm')[0];
            var formData = new FormData(form);

            $.ajax({
                url: form.action,
                type: form.method,
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if(response && response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Created',
                            text: 'Payment created successfully!',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'There was an error creating the payment.',
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was an error creating the payment.',
                    });
                }
            });
        }
    </script>
@endsection
