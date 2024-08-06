</main>
    <!-- START: JavaScript files -->
    <script src="../../../public/assets/js/jquery-3.5.1.min.js"></script>
    <script src="../../../public/assets/js/popper.min.js"></script>
    <script src="../../../public/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../../public/assets/dataTables/datatables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#bookingTable').DataTable({
            responsive: true
        });
    });
    </script>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this destination?');
        }
    </script>
    <!-- END: JavaScript files -->
</body>
</html>
