		<?php include('controllers/ck_leaveFormController.php'); ?>
		<main class="col-md-12 ms-sm-auto col-lg-12 px-md-4">
			<div id="blur">
				<div class="preloader" style="display: none;">
					<img src="assets/images/Settings.gif" alt="preloader" id="preloader">
				</div>
				<div class="pt-3">
					<a href="../../index.php?title=Dashboard" class="btn btn-outline-light text-dark float-sm-start"><i class="fas fa-angle-left"></i> Back</a>
				</div>
				<ul class="nav nav-pills justify-content-center border-bottom">
					<!-- <a class="nav-link" href="ck_leaveForm.php?title=Leave Input Form">
		                <div class="nav-link border border-primary"><i class="fas fa-file-alt"></i> Leave Form </div>
		            </a> -->
					<?php

					if ($_SESSION['idNumber'] == '0197' or $_SESSION['idNumber'] == '0940') {
					?>
						<a class="nav-link" href="charise_byPass.php?title=Bypass">
							<div class="nav-link border border-primary"><i class="fa-solid fa-key"></i> Bypass </div>
						</a>
						<a class="nav-link" href="charise_checkBypassStatus.php?title=Bypass Status">
							<div class="nav-link border border-primary"><i class="fa-solid fa-circle-question"></i> Bypass Status </div>
						</a>
					<?php
					}
					?>
					<a class="nav-link" href="val_checkLeaveStatus.php?title=Leave Status">
						<div class="nav-link border border-primary"><i class="fa-solid fa-circle-question"></i> Status </div>
					</a>

				</ul>
				<div class="container d-flex justify-content-center align-items-center py-3">
					<div class="col-md-6"></div>
					<div class="col-md-6 justify-content-center align-items-center">
						<div class="card">
							<div class="card-header">
								<h4 class="text-center">Leave Form</h4>
							</div>
							<div class="card-body">
								<div class="row-md-12">
									<form method="POST" id="leaveForm" enctype="multipart/form-data">
										<div class="form-group">
											<label for="Employee" class="fw-bold">Employee: </label>
											<select class="form-control" id="employee_active" name="employee_active">
												<?php foreach ($userById as $key => $currentUser) : ?>
													<option value="<?php echo $currentUser['idNumber'] ?>" selected><?php echo $currentUser['firstName'] . " " . $currentUser['surName'] ?></option>
												<?php endforeach; ?>
												<optgroup label="Select Other Employees">
													<?php foreach ($users as $key => $allUsers) : ?>
														<option value="<?php echo $allUsers['idNumber'] ?>"><?php echo $allUsers['firstName'] . " " . $allUsers['surName'] ?></option>
													<?php endforeach; ?>
												</optgroup>
											</select>
										</div>
										<div class="form-group mt-2">
											<label for="leaveFrom" class="fw-bold">Leave From: </label>
											<input class="form-control calendar" id="leaveFrom" name="leaveFrom" placeholder="Leave From">
										</div>
										<div class="form-group mt-2">
											<label for="leaveTo" class="fw-bold">Leave To: </label>
											<input class="form-control calendar" id="leaveTo" name="leaveTo" placeholder="Leave To">
										</div>
										<div class="form-group mt-2">
											<label for="purpose" class="fw-bold">Purpose of Leave: </label>
											<textarea class="form-control" id="purpose" name="purpose" rows="3"></textarea>
										</div>
										<div class="form-group mt-2">
											<label for="uploadFile" class="fw-bold">Proof Document: (Optional)</label>
											<input class="form-control" type="file" id="uploadFile">
										</div>
										<div class="form-check mt-2">
											<input class="form-check-input" type="checkbox" value="1" id="halfDay">
											<label class="form-check-label fw-bold" for="halfDay">
												Check the box if you are requesting a half day leave
											</label>
										</div>
										<button class="btn btn-primary text-light mt-3" type="submit">Request Leave</button>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6"></div>
				</div>
			</div>
		</main>