		<?php include('controllers/ck_leaveFormController.php'); ?>
		<main class="col-md-12 ms-sm-auto col-lg-12 px-md-4">
			<div id="blur">
				<div class="preloader" style="display: none;">
					<img src="assets/images/Settings.gif" alt="preloader" id="preloader">
				</div>
				<div class="pt-3">
					<a href="../../../index.php?title=Dashboard" class="btn btn-outline-light text-dark float-sm-start"><i class="fas fa-angle-left"></i> Back</a>
				</div>
				<ul class="nav nav-pills justify-content-center border-bottom">
					<!-- <a class="nav-link" href="ck_leaveForm.php?title=Leave Input Form">
		                <div class="nav-link border border-primary"><i class="fas fa-file-alt"></i> Leave Form </div>
		            </a> -->
					<a class="nav-link" href="charise_byPass.php?title=Bypass">
						<div class="nav-link border border-primary"><i class="fa-solid fa-key"></i> Bypass </div>
					</a>
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
									<form method="POST" id="leaveForm">
										<div class="form-group">
											<label for="Employee">Employee: </label>
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
										<!--                                     	<div class="form-group h-50">
											<label for="Signature">Signature: </label>
                                        	<div id="sig"></div>
											<textarea class="d-none" id="signature" name="signature"></textarea>
											<button class="btn btn-secondary mt-2" id="clearSig">Clear Signature</button>
										</div> -->
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