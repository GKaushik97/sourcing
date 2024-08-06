<?php
/**
 * Edit user
 */
?>
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<form class="needs-validation" name="edit_user" id="edit_user" method="post" novalidate>
			<div class="modal-header">
				<h5 class="modal-title">Edit User</h5>
				<button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="close"></button>
			</div>
			<div class="modal-body">
				<div class="row mb-2">
					<input type="hidden" name="id" id="id" value="<? echo $users['id']; ?>">
					<label class="col-form-label col-sm-4 text-end" for="fname">First Name&nbsp;<span class="error text-danger">*</span>&nbsp;:</label>
					<div class="col-sm-6 has-validation">
						<input class="form-control form-control-sm" type="text" name="fname" id="fname" value="<? echo $users['fname']; ?>" required>
						<span class="text-danger"><? echo form_error('fname'); ?></span>
						<div class="invalid-feedback">
							Please Enter First Name
						</div>
					</div>
				</div>
				<div class="row mb-2">
					<label class="col-form-label col-sm-4 text-end" for="lname">Last Name&nbsp;<span class="error text-danger">*</span>&nbsp;:</label>
					<div class="col-sm-6 has-validation">
						<input class="form-control form-control-sm" type="text" name="lname" id="lname" value="<? echo $users['lname']; ?>" required>
						<span class="text-danger"><? echo form_error('lname'); ?></span>
						<div class="invalid-feedback">
							Please Enter Last Name
						</div>
					</div>
				</div>
				<div class="row mb-2">
					<label class="col-form-label col-sm-4 text-end" for="role">Role&nbsp;<span class="error text-danger">*</span>&nbsp;:</label>
					<div class="col-sm-6 has-validation">
						<select class="form-select form-select-sm" name="role" id="role">
							<option value="">Select</option>
							<?
							foreach ($roles as $key => $value) {
								?>
								<option value="<? echo $value['id']; ?>" <? if($users['role'] == $value['id']) echo 'selected="selected"'; ?>><? echo $value['name']; ?></option>
								<?
							}
							?>
						</select>
						<span class="text-danger"><? echo form_error('role'); ?></span>
						<div class="invalid-feedback">
							Please Select Role
						</div>
					</div>
				</div>
				<div class="row mb-2">
					<label class="col-form-label col-sm-4 text-end" for="email">Email&nbsp;<span class="error text-danger">*</span>&nbsp;:</label>
					<div class="col-sm-6 has-validation">
						<input class="form-control form-control-sm" type="email" name="email" id="email" value="<? echo $users['email']; ?>" required>
						<span class="text-danger"><? echo form_error('email'); ?></span>
						<div class="invalid-feedback">
							Please Enter Email
						</div>
					</div>
				</div>
				<div class="row mb-2">
					<label class="col-form-label col-sm-4 text-end" for="mobile">Mobile number&nbsp;<span class="error text-danger">*</span>&nbsp;:</label>
					<div class="col-sm-6 has-validation">
						<input class="form-control form-control-sm" type="number" name="mobile" id="mobile" value="<? echo $users['mobile']; ?>" required>
						<span class="text-danger"><? echo form_error('mobile'); ?></span>
						<div class="invalid-feedback">
							Please Enter Mobile Number
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success btn-sm" type="submit"><span class="mdi mdi-check"></span>&nbsp;Update</button>
				<button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal"><span class="mdi mdi-close"></span>&nbsp;Close</button>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$(function() {
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                else {
                	event.preventDefault();
                	updateUsers();
                }
                form.classList.add('was-validated')
            }, false)
        })
    });
</script>