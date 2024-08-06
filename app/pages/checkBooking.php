<!-- START: Bagian cek pemesanan -->
<section style="background-color: #d8edfe; color: #094067;" id="checkBooking">
    <div class="container">
        <div class="text-center my-5">
            <h3>Check Booking</h3>
            <p style="color: #5f6c7b;">Use the form below to view your booking details.</p>
        </div>
        <div class="text-center mb-4">
            <p>Make sure the <span style="font-weight: bold;">invoice ID & email address</span> you entered are correct, please repeat.</p>
        </div>
        <div class="d-flex justify-content-center mb-5">
            <div class="card w-100" style="border: none;">
                <div class="card-body">
                    <form action="app/pages/invoice.php" method="get">
                        <div class="row">
                            <div class="col-12 col-md-4 mb-2 mb-md-0">
                                <input type="text" class="form-control" name="invoice_id" placeholder="Invoice ID" required>
                            </div>
                            <div class="col-12 col-md-6 mb-2 mb-md-0">
                                <input type="email" class="form-control" name="email" placeholder="Email *" required>
                            </div>
                            <div class="col-12 col-md-2">
                                <button class="btn btn-primary btn-block" type="submit">Submit</button>   
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END: Bagian cek pemesanan -->