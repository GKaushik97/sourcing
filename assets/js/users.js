function users_body(rows, pageno, sortby, sort_order)
	{
		var qStr = {
			"rows":rows, 
			"pageno":pageno, 
			"sortby":sortby, 
			"sort_order":sort_order,
			"keywords" : $("#keywords").val()
		};
		$.post(WEB_ROOT+'User/index_body', qStr, function(data) {
			$("#user-body").html(data);
		})
	}

	function reset_user_body()
	{
		$("#keywords").val("");
		users_body(20, 1, 'id', 'desc');
	}

	// Add users
	function users_add()
	{
		preLoader();
		$.post(WEB_ROOT+'User/addUser', function(data) {
			loadModal(data);
    		closePreLoader();
		});
	}

	// Insert users
	function insertUsers()
	{
		var params = $("#add_user").serializeArray();
		$.post(WEB_ROOT+'User/insertUsers', params, function(data) {
			$(".modal-dialog").parent().html(data);
			// location.reload();
			reset_user_body();
		});
	}

	// Edit users
	function usersEdit(id)
	{
		$.post(WEB_ROOT+'User/usersEdit', {'id' : id}, function(data) {
			loadModal(data);
		});
	}

	// Update users
	function updateUsers()
	{
		var params = $("#edit_user").serializeArray();
		$.post(WEB_ROOT+'User/updateUsers', params, function(data) {
			$(".modal-dialog").parent().html(data);
			reset_user_body();
			// location.reload();
		});
	}

	// User change status
	function userChangeStatus(id, status) 
	{
		if(status == 0) {
			if(confirm('Are You Sure.? It Will Change Status In This User')) {
				$.post(WEB_ROOT+'User/usersChangeStatus', {'id' : id, 'status' : status}, function(data) {
					reset_user_body();
					// location.reload();
				})
			}
		} else {
			if(confirm('Are You Sure.? It Will Change Status In This User')) {
				$.post(WEB_ROOT+'User/usersChangeStatus', {'id' : id, 'status' : status}, function(data) {
					reset_user_body();
					// location.reload();
				})
			}
		}
	}

	// Delete
	function usersDelete(id)
	{
		if(confirm('Are You Sure.? It Will Delete In This User')) {
			$.post(WEB_ROOT+'User/deleteUser', {'id' : id}, function(data) {
				reset_user_body();
				// location.reload();
			});
		}
	}

	// View
	function userView(id)
	{
		$.post(WEB_ROOT+'User/usersView', {'id' : id}, function(data) {
			loadModal(data);
		});
	}
	// reset password
	function user_resetPassword(id) {
		if(confirm('Are you sure reset password to "12345678" ?')) {
			$.post(WEB_ROOT+"user/resetPassword", {"id":id}, function (data) {
				reset_user_body();
			});
		}
	}

function update_password_submit(e) {
        e.preventDefault();
        var id = $('#id').val();
        var old_pass = "";
        // Old Password Checking
        /*var oldpassword = $('#oldpassword').val();
        if (oldpassword == '') {
            $('#oldpassword_alert').html("<span class='text-danger'>The Old Password Field is required.</span>");
            return false;
        }
        else {
            $.post(WEB_ROOT+"users/check_password", {"id":id, "password":oldpassword}, function(data) {
                old_pass = data;
                if (data == 1) {
                    $('#oldpassword_alert').html('');
                }
                else {
                    $('#oldpassword_alert').html("<span class='text-danger'>Please Enter Correct Old Password</span>");
                    return false;
                }
            });
        }*/
        // New Password Checking
        var password = $('#password').val();
        if (password == '') {
            $('#password_alert').html("<span class='text-danger'>The New Password Field is required.</span>");
            return false;
        }
        else {
            if((password.length) < 8) {
                $('#password_alert').html("<span class='text-danger'>The Password Minimum Length 8</span>");
                return false;
            }
            else {
                $('#password_alert').html('');
            }
        }
        // Confirm New Password Checking
        var Cpassword = $('#passconf').val();
        if (Cpassword == '') {
            $('#cpassword_alert').html("<span class='text-danger'>The Confirm Password Field is required.</span>");
            return false;
        }
        else {
            if((Cpassword.length) < 8) {
                $('#cpassword_alert').html("<span class='text-danger'>The Confirm Password Minimum Length 8</span>");
                return false;
            }
            else {
                $('#cpassword_alert').html('');
            }
        }
        // New Password Matching
        if(password != Cpassword) {
            $('#password_alert').html("<span class='text-danger'>The Passwords Mismatch </span>");
            return false;
        }
        else {
            $('#password_alert').html('');
        }
        //
        var params = $('#update_password_form').serializeArray();
	$.post(WEB_ROOT + "user/update_password", params, function (data) {
        	if (data == 1) {
            	window.location.href = WEB_ROOT + 'user';
        	}
        });
    }