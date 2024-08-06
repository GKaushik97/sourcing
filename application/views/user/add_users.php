<?php
/**
 * Add user
 */
?>
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<form class="needs-validation" method="post" name="add_user" id="add_user" novalidate>
			<div class="modal-header">
		        <h5 class="modal-title">Add User</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		     </div>
			<div class="modal-body">
				<div class="row mb-2">
					<label class="col-form-label col-sm-4 text-end" for="fname">First Name&nbsp;<span class="error text-danger">*</span>&nbsp;:</label>
					<div class="col-sm-6 has-validation">
						<input class="form-control form-control-sm" placeholder="Please Enter First Name" type="text" name="fname" id="fname" value="<? echo set_value('fname'); ?>" required>
						<span class="text-danger"><? echo form_error('fname'); ?></span>
						<div class="invalid-feedback">
				        	Please Enter First Name.
				      	</div>
					</div>
				</div>
				<div class="row mb-2">
					<label class="col-form-label col-sm-4 text-end" for="lname">Last Name&nbsp;<span class="error text-danger">*</span>&nbsp;:</label>
					<div class="col-sm-6 has-validation">
						<input class="form-control form-control-sm" type="text" placeholder="Please Enter Last Name" name="lname" id="lname" value="<? echo set_value('lname'); ?>" required>
						<span class="text-danger"><? echo form_error('lname'); ?></span>
						<div class="invalid-feedback">
				        	Please Enter Last Name.
				      	</div>
					</div>
				</div>
				<div class="row mb-2">
					<label class="col-form-label col-sm-4 text-end" for="username">Username&nbsp;<span class="error text-danger">*</span>&nbsp;:</label>
					<div class="col-sm-6 has-validation">
						<input class="form-control form-control-sm" type="text" placeholder="Please Enter User Name" name="username" id="username" value="<? echo set_value('username'); ?>" required>
						<span class="text-danger"><? echo form_error('username'); ?></span>
						<diV class="invalid-feedback">
							Please Enter Username
						</diV>
					</div>
				</div>
				<div class="row mb-2">
					<label class="col-form-label col-sm-4 text-end" for="password">Password&nbsp;<span class="error text-danger">*</span>&nbsp;:</label>
					<div class="col-sm-6 has-validation">
						<input class="form-control form-control-sm" type="password" placeholder="Please Enter Password" name="password" id="password" value="<? echo set_value('password'); ?>" required>
						<span class="text-danger"><? echo form_error('password'); ?></span>
						<diV class="invalid-feedback">
							Please Enter Password
						</diV>
					</div>
				</div>
				<div class="row mb-2">
					<label class="col-form-label col-sm-4 text-end" for="c_password">Confirm Password&nbsp;<span class="error text-danger">*</span>&nbsp;:</label>
					<div class="col-sm-6 has-validation">
						<input class="form-control form-control-sm" type="password" placeholder="Please Confirm Password" name="c_password" id="c_password" value="<? echo set_value('password'); ?>" required>
						<span class="text-danger"><? echo form_error('c_password'); ?></span>
						<diV class="invalid-feedback">
							Please Enter Confirm Password
						</diV>
					</div>
				</div>
				<diV class="row mb-2">
					<label class="col-form-label col-sm-4 text-end" for="role">Role&nbsp;<span class="error text-danger">*</span>&nbsp;:</label>
					<div class="col-sm-6 has-validation">
						<select name="role" id="role" class="form-select form-select-sm" required>
							<option value="">Select</option>
							<?
							foreach ($roles as $key => $value) {
								?>
								<option value="<? echo $value['id']; ?>" <? if($value['id']==set_value('role')) print 'selected="selected"'; ?>><? echo $value['name']; ?></option>
								<?
							}
							?>
						</select>
						<span class="text-danger"><? echo form_error('roles'); ?></span>
						<diV class="invalid-feedback">
							Please Select Role
						</diV>
					</div>
				</diV>
				<div class="row mb-2">
					<label class="col-form-label col-sm-4 text-end" for="email">Email&nbsp;<span class="error text-danger">*</span>&nbsp;:</label>
					<div class="col-sm-6 has-validation">
						<input class="form-control form-control-sm" placeholder="Please Enter Email" type="email" name="email" id="email" value="<? echo set_value('email'); ?>" required>
						<span class="text-danger"><? echo form_error('email'); ?></span>
						<div class="invalid-feedback">
							Please Enter Email
						</div>
					</div>
				</div>
				<div class="row mb-2">
					<label class="col-form-label col-sm-4 text-end" for="mobile">Mobile Number&nbsp;<span class="error text-danger">*</span>&nbsp;:</label>
					<div class="col-sm-6 has-validation">
						<input class="form-control form-control-sm" type="number" placeholder="Please Enter Mobile Number" name="mobile" id="mobile" value="<? echo set_value('mobile'); ?>" required>
						<span class="text-danger"><? echo form_error('mobile'); ?></span>
						<div class="invalid-feedback">
							Please Enter Mobile Number
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success btn-sm"><span class="mdi mdi-plus"></span>&nbsp;Add</button>
				<button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="mdi mdi-close"></span>&nbsp;Close</button>
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
                	insertUsers();
                }
                form.classList.add('was-validated')
            }, false)
        })
    });
</script>
