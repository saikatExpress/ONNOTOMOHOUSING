$(document).ready(function(){
    $(document).on('click', '.approveBtn', function(){
        var paymentId = $(this).data('id');

        if(paymentId != null){
            $.ajax({
                url: '/give/approve/payment/' + paymentId,
                type: 'GET',
                beforeSend: function(){
                    $('#paymentLoader').show();
                },
                complete: function(){
                    $('#paymentLoader').hide();
                },
                success: function(response){
                    if(response && response.success  == true){
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Approved',
                            text: 'Payment approved successfully!',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    }
                    if(response && response.message){
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: 'Payment already approved!',
                        })
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });
        }
    });

    // Edit Payment Form
    $(document).on('click', '.editBtn', function(){
        var paymentId = $(this).data('id');

        $.ajax({
            url: '/fetch/payment/' + paymentId,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#editPaymentId').val(response.payment.id);
                    $('#editAmount').val(response.payment.amount);
                    if (response.payment.bank_slip) {
                        $('#editDepositSlipImage').attr('src', '/storage/' + response.payment.bank_slip).show();
                    }
                    $('#editPaymentModal').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Payment not found',
                    });
                }
            }
        });
    });

    $('#editPaymentForm').on('submit', function(event) {
        event.preventDefault();

        var paymentId = $('#editPaymentId').val();
        var formData = new FormData(this);

        $.ajax({
            url: '/payment/update/' + paymentId,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Payment Updated',
                        text: 'Payment updated successfully!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'There was an error updating the payment.',
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'There was an error updating the payment.',
                });
            }
        });
    });

    function previewEditDepositSlip(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('editDepositSlipImage');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    window.previewEditDepositSlip = previewEditDepositSlip;

    $(document).on('click', '.cancelBtn', function(){
        var paymentId = $(this).data('id');
        var $row = $(this).closest('tr'); // Save the reference to the row for later

        // Show SweetAlert confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Make the AJAX request to delete the payment
                $.ajax({
                    url: '/delete/payment/' + paymentId, // Adjust the URL to match your route
                    type: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}' // Laravel CSRF token
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Deleted!',
                                'Your payment has been deleted.',
                                'success'
                            );
                            // Remove the row from the table
                            $row.remove();
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was an error deleting the payment.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'There was an error deleting the payment.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
