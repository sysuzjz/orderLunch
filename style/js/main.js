$(".register-submit").click(function(event) {
	event.preventDefault();
	var sid = $("#inputId").val();
	var email = $("#inputEmail").val();
	var name = $("#inputName").val();
	var password = $("#inputPassword").val();
	var repeatPassword = $("#inputRepeatPassword").val();
	if(!sid || !email || !password || !repeatPassword) {
		alert("信息不完整！");
	} else if(!validId(sid)) {
		alert("请输入正确的学号！");
	} else if(!isChinese(name) || name.length > 4 || name.length < 2) {
		alert("请用真实姓名！");
	} else if(!validEmail(email) || email.length > 40) {
		alert("邮箱格式不对！")
	} else if(password.length > 20) {
		alert("密码要那么长干嘛！");
	} else if(repeatPassword != password) {
		alert("两次密码要一样！");
	} else {
		$.ajax({
			type: "post",
			url: "./action/register.action.php",
			data: {
				"sid": sid,
				"email": email,
				"name": name,
				"password": password
			},
			success: function(msg) {
				msg = $.parseJSON(msg);
				if(msg['status']) {
					window.location.reload();
				} else {
					alert(msg['msg']);
				}
			}
		})
	}
})

$(".login-submit").click(function(event) {
	event.preventDefault();
	var sid = $("#studentId").val();
	var password = $("#password").val();
	var remember = $("#remember").prop("checked");
	if(!sid || !password) {
		alert("信息不完整！");
	} else if(!validId(sid)) {
		alert("请输入正确的学号！");
	} else {
		$.ajax({
			type: "post",
			url: "./action/login.action.php",
			data: {
				"sid": sid,
				"password": password,
				"remember": remember
			},
			success: function(msg) {
				msg = $.parseJSON(msg);
				if(msg['status']) {
					window.location.reload();
				} else {
					alert(msg['msg']);
				}
			}
		})
	}
});

$(".personal-submit").click(function(event) {
	event.preventDefault();
	var email = $("#newEmail").val();
	var name = $("#newName").val();
	var password = $("#newPassword").val();
	var repeatPassword = $("#newRepeatPassword").val();
	if(!name || !email) {
		alert("信息不完整！");
	} else if(!isChinese(name) || name.length > 4 || name.length < 2) {
		alert("请用真实姓名！");
	} else if(!validEmail(email) || email.length > 20) {
		alert("邮箱格式不对！")
	} else if(password.length > 20) {
		alert("密码要那么长干嘛！");
	} else if(repeatPassword != password) {
		alert("两次密码要一样！");
	} else {
		$.ajax({
			type: "post",
			url: "./action/personal.action.php",
			data: {
				"email": email,
				"name": name,
				"password": password
			},
			success: function(msg) {
				msg = $.parseJSON(msg);
				if(msg['status']) {
					alert("修改成功");
				} else {
					alert(msg['msg']);
				}
			}
		})
	}
})

$(".assume-list").on("click", ".delete-order", function(event) {
	event.preventDefault();
	var $closestTr = $(this).closest("tr");
	var orderId = $closestTr.attr('data-id');
	$.ajax({
		type: "post",
		url: "./action/deleteOrder.action.php",
		data: {
			"orderId": orderId
		},
		success: function(msg) {
			msg = $.parseJSON(msg);
			if(msg['status']) {
				$closestTr.remove();
			} else {
				alert(msg['msg']);
			}
		}
	})
})

function validId(sid) {
	var exp = /\d{8}/;
	if(sid.length != 8 || !exp.test(sid)) {
		return false;
	}
	return true;
}

function validEmail(email) {
	var filter  = /^([a-zA-Z0-9_\.\-])+\@([a-zA-Z0-9\-]+\.)+([a-zA-Z0-9]{2,4})+$/;
	return filter.test(email);
}

function isChinese(name) {
	for(s in name) {
		var index = escape(name[s]).indexOf("%u");
		if(index < 0) 
			return false;
	}
	return true;
}
