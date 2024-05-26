@extends('user.layout.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="text-primary">Payment Form</h4>
                </div>
                <div class="card-body">
                    <!-- Instructions -->
                    <div class="alert alert-info">
                        <h5 style="color: #fff;">Instructions:</h5>
                        <ul>
                            <li style="color: #fff;">Fill in the amount you have deposited.</li>
                            <li style="color: #fff;">Upload a clear image of the bank deposit slip.</li>
                            <li style="color: #fff;">Ensure all details are correct before submitting the form.</li>
                        </ul>
                    </div>

                    <!-- Payment Form -->
                    <form action="{{ route('payment.store') }}" method="POST" id="paymentForm" enctype="multipart/form-data">
                        @csrf
                        <!-- Amount Deposited -->
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount Deposited : </label>
                            <input type="number" step="0.01" name="amount" class="form-control" id="amount">
                            <span id="amountErr" class="text-danger text-sm"></span>
                        </div>

                        <!-- Bank Deposit Slip Upload -->
                        <div class="mb-3">
                            <label for="depositSlip" class="form-label">Bank Deposit Slip : </label>
                            <input type="file" class="form-control" name="depositSlip" id="depositSlip" accept="image/*" required onchange="previewDepositSlip(event)">
                            <div class="image-preview mt-2" id="depositSlipPreview">
                                <img src="#" alt="Deposit Slip Image" id="depositSlipImage" style="display: none;" class="img-thumbnail">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Submit Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $(document).ready(function(){
        $('#paymentForm').on('submit', function(event){
            event.preventDefault();

            const amount = $('#amount').val();
            const formData = new FormData(this);

            if (!amount) {
                $('#amountErr').text('Please enter the amount deposited.');
                return false;
            }

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if(response && response.message){
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Submitted',
                            text: 'Payment submitted successfully!',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Optionally, you can redirect the user or reset the form
                                $('#paymentForm')[0].reset();
                                $('#depositSlipImage').hide();
                            }
                        });
                    }
                },
                error: function(error) {
                    // Handle errors
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });
</script>

<!-- JavaScript to preview the uploaded image -->
<script>
    function previewDepositSlip(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('depositSlipImage');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
