$(".login-submit").click(function(event) {
	event.preventDefault();
	var sid = $("#studentId").val();
	var password = $("#password").val();
	if(!sid || !password) {
		alert("信息不完整！");
	} else {
		$.ajax({
			type: "post",
			url: "./action/adminLogin.action.php",
			data: {
				"sid": sid,
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
});

$(".add-menu").on("click", function() {
	var $newMenu = createNewMenu();
	$("#menu-list").append($newMenu);
})

$("#edit-menu").on("click", ".save-edit", function(event) {
	event.preventDefault();
	var $siblings = $(this).siblings("input");
	var type = $siblings[0].value,
		name = $siblings[1].value,
		price = $siblings[2].value;
	if(!type || !name || !price) {
		alert("不能为空");
	} else {
		$.ajax({
			type: "post",
			url: "./action/editMenu.action.php",
			data: {
				"type": type,
				"name": name,
				"price": price
			},
			success: function(msg) {
				msg = $.parseJSON(msg);
				if(msg['status'] == false) {
					alert(msg['msg']);
				}
			}
		})
	}
})

$("#edit-all").on("click", function(event) {
	event.preventDefault();
	$(".save-edit").each(function() {
		$(this).trigger('click');
	})
})

$("#edit-menu").on("click", ".delete-menu", function(event) {
	event.preventDefault();
	var thisNode = $(this);
	var $siblings = $(this).siblings("input");
	var type = $siblings[0].value;
	if(!type) {
		removeNode(thisNode.parent());
	} else {
		$.ajax({
			type: "post",
			url: "./action/deleteMenu.action.php",
			data: {
				"type": type
			},
			success: function(msg) {
				msg = $.parseJSON(msg);
				if(msg['status'] == false) {
					alert(msg['msg']);
				} else {
					removeNode(thisNode.parent());
				}
			}
		})
	}

});

$(".order-list").on("click", ".pay-submit", function(event) {
	event.preventDefault();
	var $closestTr = $(this).closest('tr');
	var orderId = $closestTr.attr("data-id");
	var $inputNumberNode = $closestTr.find('input[type=number]');
	var paid = $inputNumberNode.eq(0).val();
	var repaid = $inputNumberNode.eq(1).val();
	var helper = $closestTr.find('select').val();
	var price = $closestTr.find('.order-list-price').text();
	var uid = $closestTr.find('.order-list-user').attr("data-id");
	if(!helper) {
		alert("不能为空");
	} else {
		$.ajax({
			type: "post",
			url: "./action/orderManage.action.php",
			data: {
				"orderId": orderId,
				"paid": paid,
				"repaid": repaid,
				"uid": uid,
				"helper": helper,
				"price": price,
				"isDeleteBtn": 0
			},
			success: function(msg) {
				msg = $.parseJSON(msg);
				if(msg['status']) {
					if(paid != "0")
						$closestTr.remove();
					else
						alert("更改成功");
				} else {
					alert(msg['msg']);
				}
			}
		})
	}
})

$(".order-list").on("click", ".pay-delete", function(event) {
	event.preventDefault();
	var $closestTr = $(this).closest('tr');
	var orderId = $closestTr.attr("data-id");
	if(confirm("这个按钮仅在下错了订单或是某人准备BG的时候才点，你确认要继续吗")) {
		$.ajax({
			type: "post",
			url: "./action/orderManage.action.php",
			data: {
				"orderId": orderId,
				"isDeleteBtn": 1
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
	}
})

function createNewMenu() {
	var newMenu = '<div class="control-group">' + '\n' +　'<input type="text" class="input-mini" />' + '\n' + '<input type="text">' + '\n' + '<input type="number" class="input-mini" step="0.5" />' + '\n' + '<button class="save-edit btn btn-primary">更改</button>' + '\n' + '<button class="delete-menu btn btn-primary">删除</button>' + '\n' + '</div>';
	return $(newMenu);
}

function removeNode(node) {
	node.remove();
}
