<?php include('controllers/val_checkLeaveStatus.php');
?>
<main class="container">
    <div class="d-flex justify-content-center">
        <!------------------- DataTables Example ----------------->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Check Leave Status</h6>
            </div>
            <div class="card-body">

                <!------------------------ Textbox Search ----------------------->
                <div class="row mb-3 ml-1">
                    <div class="form-group mb-3">
                        <label for="userFirstname">Filter & Search</label>
                        <div class="col-sm">
                            <input type="name" class="form-control" id="filter" onkeyup="filter()" name="filter">
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
                                <th>Approved / Denied by Superior</th>
                                <th>Approved / Denied by Leader</th>
                                <th>Date Approved / Denied by Leader</th>
                                <th>Date Approved / Denied by Superior</th>
                                <th>LeaderApproval Flag</th>
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