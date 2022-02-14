<?php include('controllers/ck_notificationController.php'); ?>
<main class="container">
    <div class="d-flex flex-column justify-content-center">
        <!------------------- DataTables Example ----------------->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a class="btn btn-outline-success" href="ck_leaveForm.php" role="button"><i class="fa-solid fa-angle-left"></i> Back</a>
                <h4 class="m-0 font-weight-bold text-dark text-center">Notifications</h4>
            </div>
            <div class="card-header py-3 text-center">
                <h6 class="m-0 font-weight-bold text-primary">You have <?php echo $notifCount; ?> Notification(s)</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" id="userTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Notification ID</th>
                                <th>Details</th>
                                <th>Key</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <!-- View Modal -->
    <div class="modal fade" id="viewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Notification Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewDetails">
                    <div class="form-group mb-2 row">
                        <div class="col-md-6">
                            <label class="col-sm-5">Employee No.</label>
                            <input readonly class="form-control" id="employeeNumber" name="employeeNumber" val></input>
                        </div>
                        <div class="col-md-6">
                            <label class="col-sm-5">Employee Name</label>
                            <input readonly class="form-control" id="employeeName" name="employeeName"></input>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-sm-0 mb-1" hidden>
                        <div class="row">
                            <label class="col-sm-5">List ID</label>
                            <input readonly class="form-control" id="listId" name="listId"></input>
                        </div>
                    </div>
                    <div class="form-group mb-2 row">
                        <div class="col-md-6">
                            <label class="col-sm-5">Designation</label>
                            <input readonly class="form-control" id="designation" name="designation"></input>
                        </div>
                        <div class="col-md-6">
                            <label class="col-sm-5">Department</label>
                            <input readonly class="form-control" id="department" name="department"></input>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <div class="col-md-12 mb-sm-0 mb-1">
                            <div>
                                <label class="col-sm-5">Purpose of Leave</label>
                                <textarea readonly class="form-control" id="purposeofLeave" name="purposeofLeave"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2 row">
                        <div class="col-md-6">
                            <label class="col-sm-5">Leave From:</label>
                            <input readonly class="form-control" id="leaveFrom" name="leaveFrom"></input>
                        </div>
                        <div class="col-md-6">
                            <label class="col-sm-5">Leave To:</label>
                            <input readonly class="form-control" id="leaveTo" name="leaveTo"></input>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#approveModal">Approve</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#disapproveModal">Disapprove</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Approve Modal -->
    <div class="modal fade" id="approveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Approve Leave</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <div class="col-md-12 mb-sm-0 mb-1">
                            <div>
                                <label class="col-sm-5">Reason for Approval: </label>
                                <textarea class="form-control" id="reasonForApproval" name="reasonForApproval" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="approve">Approve</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Disapprove Modal -->
    <div class="modal fade" id="disapproveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Disapprove Leave</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <div class="col-md-12 mb-sm-0 mb-1">
                            <div>
                                <label class="col-sm-5">Reason for Disapproval: </label>
                                <textarea class="form-control" id="reasonForDisapproval" name="reasonForDisapproval" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="disapprove">Disapprove</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View HR Modal -->
    <div class="modal fade" id="viewHRModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title titleName" id="staticBackdropLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewDetails">
                    <div class="form-group mb-2 row">
                        <div class="col-md-6">
                            <label class="col-sm-5">Employee No.</label>
                            <input readonly class="form-control" id="empNum" name="empNum" val></input>
                        </div>
                        <div class="col-md-6">
                            <label class="col-sm-5">Employee Name</label>
                            <input readonly class="form-control" id="empName" name="empName"></input>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-sm-0 mb-1" hidden>
                        <div class="row">
                            <label class="col-sm-5">List ID</label>
                            <input readonly class="form-control" id="list" name="list"></input>
                        </div>
                    </div>
                    <div class="form-group mb-2 row">
                        <div class="col-md-6">
                            <label class="col-sm-5">Designation</label>
                            <input readonly class="form-control" id="des" name="des"></input>
                        </div>
                        <div class="col-md-6">
                            <label class="col-sm-5">Department</label>
                            <input readonly class="form-control" id="dept" name="dept"></input>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <div class="col-md-12 mb-sm-0 mb-1">
                            <div>
                                <label class="col-sm-5">Purpose of Leave</label>
                                <textarea readonly class="form-control" id="purpose" name="purpose"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2 row">
                        <div class="col-md-6">
                            <label class="col-sm-5">Leave From:</label>
                            <input readonly class="form-control" id="from" name="from"></input>
                        </div>
                        <div class="col-md-6">
                            <label class="col-sm-5">Leave To:</label>
                            <input readonly class="form-control" id="to" name="to"></input>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <div class="col-md-12 mb-sm-0 mb-1">
                            <div>
                                <label class="col-sm-6">Reason of Superior</label>
                                <textarea readonly class="form-control" id="reasonOfApproval" name="reasonOfApproval" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <div class="col-md-12 mb-sm-0 mb-1">
                            <div>
                                <label class="col-sm-6">Date of Approval</label>
                                <input readonly class="form-control" id="dateOfApproval" name="dateOfApproval">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <div class="col-md-12 mb-sm-0 mb-1">
                            <div>
                                <label class="col-sm-5">Leave Type</label>
                                <select name="leaveType" id="leaveType" class="form-control">
                                    <option value="">Whole Day</option>
                                    <option value="0.5">Half Day</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <div class="col-md-12 mb-sm-0 mb-1">
                            <div>
                                <label class="col-sm-5">Leave Remarks</label>
                                <textarea class="form-control" id="leaveRemarks" name="leaveRemarks"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2 row">
                        <div class="col-md-6">
                            <label class="col-sm-5">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1">With Pay</option>
                                <option value="0">Without Pay</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="col-sm-5">Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="0">Sick Leave</option>
                                <option value="1">Vacation Leave</option>
                                <option value="2">Bereavement Leave</option>
                                <option value="3">Maternity Leave</option>
                                <option value="4">Emergency Leave</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-2 row">
                        <div class="col-md-6">
                            <label class="col-sm-12">Trasportation Allowance (if any)</label>
                            <select name="transpoAllowance" id="transpoAllowance" class="form-control">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="col-sm-5">Quarantine Flag</label>
                            <select name="quarantine" id="quarantine" class="form-control">
                                <option value="0">Default</option>
                                <option value="1">Due to Covid-19</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="setStatusBTN">Set Status</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</main>