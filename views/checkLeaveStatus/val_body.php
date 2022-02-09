<?php //include('controllers/val_checkLeaveStatus.php'); 
?>
<main class="container">
    <div class="row d-flex justify-content-center">
        <!------------------- DataTables Example ----------------->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Users</h6>
            </div>
            <div class="card-body">

                <!------------------------ Textbox Search ----------------------->
                <div class="row mb-3 ml-1">
                    <div class="form-group mb-3">
                        <label for="userFirstname">First Name</label>
                        <div class="col-sm">
                            <input type="name" class="form-control" id="userFirstname" onkeyup="searchFirstName()" name="userFirstname">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="userSurname">Last Name</label>
                        <div class="col-sm">
                            <input type="name" class="form-control" id="userSurname" onkeyup="searchSurname()" name="userSurname">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="userTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Date Issued</th>
                                <th>Employee No.</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Purpose</th>
                                <th>Leave From</th>
                                <th>Leave To</th>
                                <th>Status</th>
                                <th>Reason of Superior</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>