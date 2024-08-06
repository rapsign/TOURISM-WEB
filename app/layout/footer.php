</main>
<!-- END: main content -->
<footer class="footer">
    <div class="container">
        <!-- START: Footer -->
        <p>
            <a href="?page=home">Home</a>
            <a href="?page=destination">Destination</a>
            <a href="?page=gallery">Gallery</a>
            <a href="?page=about">About</a>
            <a href="?page=contact">Contact</a>
            <a href="?page=paymentConfirmation">Payment Confirmation</a>
            <a href="?page=checkBooking">Check Booking</a>
        </p>
        <div class="social-icons">
            <a href="https://www.facebook.com/" class="fa fa-facebook" title="Facebook"></a>
            <a href="https://www.instagram.com/" class="fa fa-instagram" title="Instagram"></a>
            <a href="https://x.com/" class="fa fa-twitter" title="Twitter"></a>
            <a href="https://web.whatsapp.com/" class="fa fa-whatsapp" title="WhatsApp"></a>
        </div>
        <p>1939085860-2 | Rinaldi A Prayuda</p>
        <!-- END: footer -->
    </div>
</footer>
<!-- START: JavaScript -->
<script src="public/assets/js/jquery-3.5.1.min.js"></script>
<script src="public/assets/js/popper.min.js"></script>
<script src="public/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="public/assets/js/masonry.pkgd.min.js"></script>
<script>
    window.addEventListener('scroll', function() {
        var navbar = document.querySelector('.navbar');
        var viewportHeight = window.innerHeight;
        if (window.scrollY > viewportHeight * 0.5) { 
            navbar.classList.add('navbar-scroll', 'fixed-top');
        } else {
            navbar.classList.remove('navbar-scroll', 'fixed-top');
        }
    });
</script>
<!-- END: JavaScript -->
</body>
</html>

