 <!-- START: Ambil Data Invoice ID dan Email -->
<?php $invoice_id = isset($_GET['invoice_id']) ? intval($_GET['invoice_id']) : 'Invoice ID (without #)';?>
<?php $total = isset($_GET['total']) ? intval($_GET['total']) : 'example 20000000';?>
 <!-- END: Ambil Data Invoice ID dan Email -->
  
 <!-- START: Konfirmasi Pembayaran -->
<section style="color:#094067" id="paymentConfirmation">
    <div class="container">
        <div class="text-center my-5">
            <h3>Payment Confirmation</h3>
            <p style="color: #5f6c7b;">Fill in the form below to confirm your payment</p>
        </div>
        <form method="POST" action="app/controller/paymentProcess.php">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- START: Form Input untuk Konfirmasi Pembayaran -->
                            <div class="mb-3">
                                <label for="invoice_id">Invoice ID</label>
                                <input type="text" class="form-control" name="invoice_id" value="<?php echo $invoice_id; ?>" placeholder="Invoice ID (without #)" required>
                            </div>
                            <div class="mb-3">
                            <label for="transfer_date">Transfer Date</label>
                                <input type="date" class="form-control" name="transfer_date" required>
                            </div>
                            <div class="mb-3">
                            <label for="transfer_amount">Transfer Amount</label>
                                <input type="number" class="form-control" name="transfer_amount" value="<?php echo $total; ?>" placeholder="example 20000000" required>
                            </div>
                            <div class="mb-3">
                            <label for="transfer_purpose">Choose Bank Account</label>
                                <select name="transfer_purpose" class="form-control" required>
                                    <option value="" disabled selected>Select Bank Account</option>
                                    <option value="Mandiri - 7264726422 an. Rinaldi A Prayuda">Mandiri - 7264726422 an. Rinaldi A Prayuda</option>
                                    <option value="BNI - 857287582 an. Rinaldi A Prayuda">BNI - 857287582 an. Rinaldi A Prayuda</option>
                                    <option value="BRI - 89756734643 an. Rinaldi A Prayuda">BRI - 89756734643 an. Rinaldi A Prayuda</option>
                                </select>
                            </div>
                            <div class="mb-3">
                            <label for="name">Fullname</label>
                                <input type="text" class="form-control" name="full_name" placeholder="Full Name" required>
                            </div>
                            <div class="mb-3">
                            <label for="phone">Phone</label>
                                <input type="tel" class="form-control" name="phone" placeholder="Phone Number" required>
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                            <label for="notes">Notes</label>
                                <textarea class="form-control" name="notes" rows="3" placeholder="(optional)"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            <!-- END: Form Input untuk Konfirmasi Pembayaran -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="card" style="border: none;">
                        <div class="card-body">
                            <!-- START: Informasi Rekening Bank -->
                            <div class="row">
                                <div class="col-12 text-center mb-4">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/175px-Bank_Mandiri_logo_2016.svg.png?20211228163717" alt="Mandiri Logo">
                                    <h5 class="my-2">an. Rinaldi A Prayuda</h5>
                                    <h5>7264726422</h5>
                                </div>
                                <div class="col-12 text-center mb-4">
                                    <img src="https://upload.wikimedia.org/wikipedia/en/thumb/2/27/BankNegaraIndonesia46-logo.svg/175px-BankNegaraIndonesia46-logo.svg.png?20231129045255" alt="BNI Logo">
                                    <h5 class="my-2">an. Rinaldi A Prayuda</h5>
                                    <h5>857287582</h5>
                                </div>
                                <div class="col-12 text-center mb-4">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/BANK_BRI_logo.svg/175px-BANK_BRI_logo.svg.png?20180118061811" alt="BRI Logo">
                                    <h5 class="my-2">an. Rinaldi A Prayuda</h5>
                                    <h5>89756734643</h5>
                                </div>
                            </div>
                            <!-- END: Informasi Rekening Bank -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
 <!-- END: Konfirmasi Pembayaran -->
