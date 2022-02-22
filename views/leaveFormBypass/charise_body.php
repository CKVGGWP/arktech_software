		<?php include('controllers/ck_byPassController.php'); ?>
		<div class="row d-flex justify-content-center align-items-center">
			<div class="col-md-8 mt-5">
				<div class="card">
					<div class="card-header text-white">
						<a href="ck_leaveForm.php?title=Leave 20Input Form" class="btn btn-outline-light text-dark"><i class="fas fa-angle-left"></i> Back</a>
					</div>
					<div class="card-body" style="height: auto;">
						<div class="row mb-2">
							<div class="data-response col-md-12" style="display: none;">
								<div class="alert alert-success"></div>
							</div>
						</div>
						<form action="POST" id="submitLeave">
							<div class="form-group col-md-12">
								<label>Employee:</label> <br>
								<select class="category form-control" name="employees" id="employees" multiple>
									<?php foreach ($users as $key => $allUsers) : ?>
										<option value="<?php echo $allUsers['idNumber'] ?>"><?php echo $allUsers['firstName'] . " " . $allUsers['surName'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group col-md-12">
								<label class="control-label" for="date">Date: </label>
								<input class="form-control calendar" id="leaveDates" name="leaveDates" />
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<label class="control-label" for="leaveType">Leave Type: </label>
									<select name="leaveType" id="leaveType" class="form-control">
										<option value="">Whole Day</option>
										<option value="0.5">Half Day</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-6">
									<label class="control-label" for="status">Status: </label>
									<select name="status" id="status" class="form-control">
										<option value="0">Without Pay</option>
										<option value="1">With Pay</option>
									</select>
								</div>
								<div class="col-md-6">
									<label class="control-label" for="type">Type: </label>
									<select name="type" id="type" class="form-control">
										<option value="0">Sick Leave</option>
										<option value="1">Vacation Leave</option>
										<option value="2">Bereavement Leave</option>
										<option value="3">Maternity Leave</option>
										<option value="4">Emergency Leave</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-6">
									<label class="control-label" for="allowance">Trasportation Allowance: </label>
									<select name="transpo" id="transpo" class="form-control">
										<option value="0">No</option>
										<option value="1">Yes</option>
									</select>
								</div>
								<div class="col-md-6">
									<label class="control-label" for="allowance">Quarantine Flag: </label>
									<select name="quarantine" id="quarantine" class="form-control">
										<option value="0">Default</option>
										<option value="1">Due to COVID-19</option>
									</select>
								</div>
							</div>
							<div class="form-group col-md-12">
								<label for="purpose">Purpose of Leave: </label>
								<textarea class="form-control" id="purpose" name="purpose" rows="3"></textarea>
							</div>
							<div class="form-group mt-2 col-md-12">
								<button class="btn btn-primary store-data btn-md" type="submit">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>