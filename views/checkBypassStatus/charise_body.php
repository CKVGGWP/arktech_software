<main>
    <div class="d-flex flex-column justify-content-center">
        <div class="col-md-12 mt-3 px-4">
            <div class="pb-3">
                <a href="ck_leaveForm.php?title=Leave 20Input Form" class="btn btn-outline-light text-dark"><i class="fas fa-angle-left"></i> Back</a>
            </div>
            <!------------------- DataTables Example ----------------->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="text-center">Bypass Status</h4>
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
                        <table class="table table-bordered table-striped table-hover text-center text-nowrap" id="userTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                <th class="text-nowrap">Employee ID</th>
                                 <th class="text-nowrap">Name</th>
                                <th class="text-nowrap">Type</th>
                                    <th class="text-nowrap">Leave From</th>
                                    <th class="text-nowrap">Leave To</th>
                                    <th class="text-wrap">Remarks</th>
                                    <th>Status</th>
                                    <th class="text-nowrap">Leave Type</th>
                                    <th class="text-wrap">Transportation Allowance</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>