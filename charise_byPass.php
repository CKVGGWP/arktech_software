<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('views/includes/head/charise_head.php'); ?>
    <link rel="stylesheet" href="assets/css/flatpickr.min.css">
    <?php include('controllers/ck_emptySession.php'); ?>
</head>

<body>

 <!-- Start of Header -->

    <?php include('views/includes/header/charise_header.php'); ?>

    <!-- End of Header -->

    <!-- Start of Index -->

    <main class="container-fluid">

        <?php include('views/leaveFormBypass/charise_body.php'); ?>

    </main>

    <!-- End of Index -->


    <!-- Start of Footer -->

    <?php include('views/includes/footer/charise_footer.php'); ?>
    <script src="assets/js/flatpickr.min.js"></script>
    <script src="assets/js/charise_custom.js"></script>

    <!-- End of Footer -->

</body>

</html>