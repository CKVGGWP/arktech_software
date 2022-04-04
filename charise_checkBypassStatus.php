<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Start of Head -->
	
    <?php include('views/includes/head/head.php'); ?>
    <?php include('controllers/ck_emptySession.php'); ?>
	<!-- DIASABLE METHOD-->
    <style>
    	div.dataTables_paginate {
			display:none;
		}
    </style>


    <!-- End of Head -->
</head>

<body>
<!-- Start of Header -->

    <?php include('views/includes/header/charise_header.php'); ?>

    <!-- End of Header -->

    <!-- Start of index -->

    <?php include('views/checkBypassStatus/charise_body.php'); ?>

    <!-- End of index -->

    <!-- Start of Footer -->

    <?php include('views/includes/footer/footer.php'); ?>
    <script src="assets/js/ck_byPassLeaveStatus.js"></script>

    <!-- End of Footer -->
</body>

</html>