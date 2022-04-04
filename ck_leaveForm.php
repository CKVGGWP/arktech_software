<!DOCTYPE html>
<html lang="en">

<!-- Start of Head -->

<?php include('views/includes/head/head.php'); ?>
<link rel="stylesheet" href="assets/css/flatpickr.min.css">
<?php include('controllers/ck_emptySession.php'); ?>


<!-- End of Head -->

<body>

    <!-- Start of Header -->

    <?php include('views/includes/header/charise_header.php'); ?>

    <!-- End of Header -->

    <div class="container-fluid">
        <div class="row">
           
            <!-- Start of Leave Form -->

            <?php include('views/leaveForm/val_body.php'); ?>
        
            <!-- End of Leave Form -->
        </div>
    </div>

    <!-- Start of Footer -->

    <?php include('views/includes/footer/footer.php'); ?>
    <script src="assets/js/flatpickr.min.js"></script>
    <script src="assets/js/ck_leaveForm.js"></script>

    <!-- End of Footer -->
</body>

</html>