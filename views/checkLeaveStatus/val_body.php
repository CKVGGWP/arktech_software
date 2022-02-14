<main class="container">
    <div class="d-flex flex-column justify-content-center">
        <!------------------- DataTables Example ----------------->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a class="btn btn-outline-success" href="ck_leaveForm.php" role="button"><i class="fa-solid fa-angle-left"></i> Back</a>
                <h4 class="m-0 font-weight-bold text-dark text-center">Check Leave Status</h4>
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
                    <table class="table table-bordered text-center" id="userTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Date Issued</th>
                                <!-- <th>Employee No.</th> -->
                                <th>Name</th>
                                <!-- <th>Designation</th>
                                <th>Department</th> -->
                                <th>Purpose</th>
                                <th>Leave From</th>
                                <th>Leave To</th>
                                <th>Reason of Superior</th>
                                <th>Date</th>
                                <th>HR Leave Remarks</th>
                                <th>HR Leave Type</th>
                                <th>HR Status</th>
                                <th>Transportation Allowance</th>
                                <th>Status</th>
                                <!-- <th>Approved / Denied by Superior</th>
                                <th>Approved / Denied by Leader</th>
                                <th>Date Approved / Denied by Leader</th>
                                <th>Date Approved / Denied by Superior</th>
                                <th>LeaderApproval Flag</th> -->
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