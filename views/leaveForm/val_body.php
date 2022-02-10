        <?php include('controllers/ck_leaveFormController.php'); ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div id="blur">
                <div class="preloader" style="display: none;">
                    <img src="assets/images/Settings.gif" alt="preloader" id="preloader">
                </div>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Leave Form</h1>
                </div>
                <div class="container d-flex justify-content-center align-items-center">
                    <div class="col-md-6"></div>
                    <div class="col-md-6 justify-content-center align-items-center">
                        <div class="card">
                            <div class="card-body">
                                <div class="row-md-12">
                                    <form method="POST" id="leaveForm">
                                        <div class="form-group">
                                            <label for="Employee">Employee: </label>
                                            <select class="form-control" id="employee_active" name="employee_active">
                                                <?php foreach ($userById as $key => $currentUser) : ?>
                                                    <option value="<?php echo $currentUser['idNumber'] ?>" selected><?php echo $currentUser['firstName'] . " " . $currentUser['surName'] ?></option>
                                                <?php endforeach; ?>
                                                <?php foreach ($users as $key => $allUsers) : ?>
                                                    <option value="<?php echo $allUsers['idNumber'] ?>"><?php echo $allUsers['firstName'] . " " . $allUsers['surName'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="leaveFrom">Leave From: </label>
                                            <input class="form-control calendar" id="leaveFrom" name="leaveFrom" placeholder="Leave From">
                                        </div>
                                        <div class="form-group">
                                            <label for="leaveTo">Leave To: </label>
                                            <input class="form-control calendar" id="leaveTo" name="leaveTo" placeholder="Leave To">
                                        </div>
                                        <div class="form-group">
                                            <label for="purpose">Purpose of Leave: </label>
                                            <textarea class="form-control" id="purpose" name="purpose" rows="3"></textarea>
                                        </div>
                                        <button class="btn btn-primary mt-3" type="submit">Request Leave</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                </div>
            </div>
        </main>