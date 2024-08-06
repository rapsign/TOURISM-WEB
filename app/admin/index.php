<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../public/assets/images/favicon.ico">
    <link href="../../public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../public/assets/css/style.admin.css" rel="stylesheet">
    <link href="../../public/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Admin - Login</title>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-center align-items-center">
            <div class="card w-50">
                <div class="card-body">
                    <h2 class="text-center">Admin Login</h2>
                    <!-- START: Form Login -->
                    <form action="controller/login.php" method="post">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                    <!-- END: Form Login -->
                </div>
            </div>
        </div>
    </div>

    <!-- START: Area Toast untuk menampilkan pesan error -->
    <div aria-live="polite" aria-atomic="true" style="position: absolute; top: 0; right: 0;">
        <div id="toast-container" class="toast-container">
        </div>
    </div>
    <!-- END: Area Toast untuk menampilkan pesan error -->

    <script src="../../public/assets/js/jquery-3.5.1.min.js"></script>
    <script src="../../public/assets/bootstrap/js/bootstrap.min.js"></script>
    <script>
        // START: Script untuk menampilkan pesan error sebagai toast
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (isset($_GET['error'])): ?>
                var toastHTML = `<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" >
                                    <div class="toast-header">
                                        <strong class="mr-auto">Error</strong>
                                        <small>Just now</small>
                                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="toast-body">
                                        <?= $_GET['error']; ?>
                                    </div>
                                </div>`;
                document.getElementById('toast-container').innerHTML = toastHTML;
                var toastElement = $('.toast');
                toastElement.toast({ delay: 5000 });
                toastElement.toast('show');
                toastElement.on('hidden.bs.toast', function () {
                    window.location.href = 'index.php';
                });
            <?php endif; ?>
        });
        // END: Script untuk menampilkan pesan error sebagai toast
    </script>
</body>
</html>
