$(".add-order").click(function(event) {
	event.preventDefault();
	$("#menu-model").clone(true).removeClass('hide').appendTo('#add-order form');
});

$(".remove-order").click(function(event) {
	event.preventDefault();
	$(this).parent().remove();
	setTotalPrice();
});

$("#order-submit").click(function(event) {
	event.preventDefault();
	var orders = new Array();
	var userIds = new Array();
	var count = 0;
	if($("#add-order").find("select").length != $("select.select-menu").length) {
		$("#add-order form .menu-msg").each(function() {
			var $selects = $(this).find("select");
			var userId = $selects.eq(0).val();
			var order = $selects.eq(1).val();
			if(userId && order) {
				userIds[count] = userId;
				orders[count] = order;
				count++;
			}
		});
	} else {
		$("#add-order form select.select-menu").each(function() {
			if($(this).val()) {
				orders[count] = $(this).val();
				count++;
			}
		});
	}
	if(count > 0) {
		$.ajax({
			type: "post",
			url: "./action/addOrder.action.php",
			data: {
				"orders": orders,
				"id": userIds
			},
			success: function(msg) {
				msg = $.parseJSON(msg);
				if(msg['status'] == true) {
					alert("提交成功");
					window.location.reload();
				} else {
					alert(msg['msg']);
				}
			}
		})
	}
});

$("#add-order form select.select-menu").change(function(event) {
	event.preventDefault();
	var text = $(this).find("option:selected").text();
	text = text.split(" ")[2];
	if(!text)
		text = "0元";
	$(this).siblings('input[type=text]').val(text);
	setTotalPrice();
});

function setTotalPrice() {
	var total = 0;
	$("#add-order form input[type=text]").each(function() {
		var temp = parseFloat($(this).val());
		total += temp;
	})
	$("#total-price").val(total);
}