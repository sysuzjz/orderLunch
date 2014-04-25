<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8">
		<title>订餐啦！</title>
		<link rel="stylesheet" type="text/css" href="./style/css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="./style/css/public.css" />
		<link rel="stylesheet" type="text/css" href="./style/css/admin.css" />
	</head>

	<?php
		require("./action/public.action.php");
		$menu = array();
		$queryStr = "SELECT * FROM menu ORDER BY type ASC ";
		$queryResult = mysql_query($queryStr);
		$queryResultNum = mysql_num_rows($queryResult);
		for($i = 0; $i < $queryResultNum; $i++) {
			$temp = mysql_fetch_array($queryResult);
			array_push($menu, $temp);
		}

		$orderList = array();
		$queryStr = "SELECT * FROM orders WHERE isPaid = 0 ORDER BY time DESC";
		$queryResult = mysql_query($queryStr);
		$queryResultNum = mysql_num_rows($queryResult);
		for($i = 0; $i < $queryResultNum; $i++) {
			$temp = mysql_fetch_array($queryResult);
			$temp['userName'] = getNameById($temp['userId']);
			$temp['helperName'] = getNameById($temp['helper']);
			$temp['lunchMsg'] = getMsgByLunchType($temp['lunchType']);
			array_push($orderList, $temp);
		}

		$userList = array();
		$queryStr = "SELECT id, name FROM user ";
		$queryResult = mysql_query($queryStr);
		$queryResultNum = mysql_num_rows($queryResult);
		for($i = 0; $i < $queryResultNum; $i++) {
			$temp = mysql_fetch_array($queryResult);
			array_push($userList, $temp);
		}
	?>

	<body>
		<div id="head">
			<?php if(!isset($_SESSION['adminId'])) { ?>
				<ul>
					<li><a href="#login" role="button" class="btn" data-toggle="modal" id="btn-login">登录</a></li>
				</ul>
				<div id="login" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  	<div class="modal-header">
				    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				    	<h3 id="myModalLabel">登录</h3>
				  	</div>
				  	<div class="modal-body">
				    	<form class="form-horizontal">
				  			<div class="control-group">
						    	<label class="control-label" for="studentId">学号</label>
						    	<div class="controls">
						      		<input type="text" id="studentId" placeholder="学号，8位">
					    		</div>
						  	</div>
						  	<div class="control-group">
					    		<label class="control-label" for="password">密码</label>
						    	<div class="controls">
						      		<input type="password" id="password" placeholder="密码">
						    	</div>
						  	</div>
						  	<input type="submit" class="login-submit invisible" />
						</form>
				  	</div>
				  	<div class="modal-footer">
					    <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
					    <button class="btn btn-primary login-submit">登录</button>
				  	</div>
				</div>
			<?php } else { ?>
				<ul>
					<li><a href="./action/logout.action.php" class="btn">退出</a></li>
					<li><a href="#add-order" role="button" class="btn" data-toggle="modal">手动添加订单</a></li>
					<li><a href="#edit-menu" role="button" class="btn" data-toggle="modal">编辑菜单</a></li>
				</ul>
			<?php } ?>
		</div>
			
			<?php if(isset($_SESSION['adminId'])) { ?>
				<div id="main-content">
					<div id="edit-menu" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  	<div class="modal-header">
					    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					    	<h3 id="myModalLabel">编辑菜单</h3>
					  	</div>
					  	<div class="modal-body">
					    	<form class="form-horizontal" id="menu-list">
					    		<div class="control-group" >
				    				<input type="text" class="input-mini" value="代号" disabled="disabled" />
				    				<input type="text" value="菜名" disabled="disabled" />
				    				<input type="text" class="input-mini" value="价格" disabled="disabled" />
				    				<button class="btn btn-primary" disabled="disabled">更改</button>
				    				<button class="btn btn-primary" disabled="disabled">删除</button>
				    			</div>
					    		<?php foreach ($menu as $currentMenu) { ?>
					    			<div class="control-group">
					    				<input type="text" class="input-mini" value="<?= $currentMenu['type'] ?>" />
					    				<input type="text" value="<?= $currentMenu['name'] ?>" />
					    				<input type="number" class="input-mini" step="0.5" value="<?= $currentMenu['price'] ?>" />
					    				<button class="save-edit btn btn-primary">更改</button>
					    				<button class="delete-menu btn btn-primary">删除</button>
					    			</div>
					    		<?php } ?>
							</form>
					  	</div>
					  	<div class="modal-footer">
					  		<button class="btn btn-primary add-menu pull-left">增加新的一行</button>
						    <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
						    <button class="btn btn-primary" id="edit-all">一键更改</button>
					  	</div>
					</div>
					<div id="add-order" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  	<div class="modal-header">
					    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					    	<h3 id="myModalLabel">订餐单</h3>
					  	</div>
                        <div class="modal-body">
                            <div>
                                <input type="text" class="input-mini" value="订餐人" disabled="disabled"  />
                                <input type="text" value="订餐代号" disabled="disabled" />
                                <input type="text" class="input-mini" value="价格" disabled="disabled" />
                                <input type="text" class="btn btn-primary input-mini" value="操作"  disabled="disabled" />
                            </div>
					    	<form class="form-horizontal" id="menu-list">
					    		<div class="control-group menu-msg hide" id="menu-model">
						    		<select class="select-person select-mini">
						    			<option value="">请选择</option>
						    			<?php foreach ($userList as $user) { ?>
						    				<option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
						    			<?php } ?>
						    		</select>
						    		<select class="select-menu">
						    			<option value="">请选择</option>
						    			<?php foreach ($menu as $currentMenu) { ?>
						    				<option value="<?= $currentMenu['type'] ?>"><?= $currentMenu['type'] ?> <?= $currentMenu['name'] ?> <?= $currentMenu['price'] ?>元</option>
						    			<?php } ?>
						    		</select>
						    		<input type="text" class="input-mini" disabled="disabled" value="0元" />
						 			<button class="remove-order btn btn-primary">删除</button>
						    	</div>
						    	<div class="control-group menu-msg" >
						    		<select class="select-person select-mini">
						    			<option value="">请选择</option>
						    			<?php foreach ($userList as $user) { ?>
						    				<option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
						    			<?php } ?>
						    		</select>
						    		<select class="select-menu">
						    			<option value="">请选择</option>
						    			<?php foreach ($menu as $currentMenu) { ?>
						    				<option value="<?= $currentMenu['type'] ?>"><?= $currentMenu['type'] ?> <?= $currentMenu['name'] ?> <?= $currentMenu['price'] ?>元</option>
						    			<?php } ?>
						    		</select>
						    		<input type="text" class="input-mini" disabled="disabled" value="0元" />
						 			<button class="remove-order btn btn-primary">删除</button>
						    	</div>
							</form>
					  		总计： <input type="text" class="input-mini" id="total-price" disabled="dis" value="0" /> 元
					  	</div>
					  	<div class="modal-footer">
					  		<button class="btn btn-primary add-order pull-left">增加新的一行</button>

					    	<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
					    	<button class="btn btn-primary" id="order-submit">提交订单</button>
					  	</div>
					</div>
					<div class="order-list">
						<h3 class="alert">订单记录</h3>
						<div class="well">
							<ul>
								<?php if(count($orderList) == 0) { ?>
									<p>无</p>
								<?php } else { ?>

								<table class="table table-striped table-bordered table-hover">
									<thead>
										<th>时间</th>
										<th>订餐人</th>
										<th>代号</th>
										<th>菜名</th>
										<th>价格</th>
										<th>代付人</th>
										<th>实付金额</th>
										<th>找零</th>
										<th>操作</th>
									</thead>
									<tbody>
										
									<?php
										foreach ($orderList as $order) { ?>
										<tr data-id="<?= $order['orderId'] ?>">
											<td class="order-list-time"><?= date("Y-m-d h:i:s",$order['time']) ?></td>
											<td class="order-list-user" data-id="<?= $order['userId'] ?>"><?= $order['userName'] ?></td>
											<td><?= $order['lunchType'] ?></td>
											<td class="order-list-name"><?= $order['lunchMsg']['name'] ?></td>
											<td class="order-list-price"><?= $order['lunchMsg']['price'] ?></td>
											<td>
												<?php if($order['helperName']) { ?>
													<select class="select-mini">
														<option value="<?= $order['helper'] ?>"><?= $order['helperName'] ?></option>
													</select>
													
												<?php } else { ?>
													<select class="select-mini">
														<option value="">请选择</option>
														<?php foreach ($userList as $user) { ?>
															<option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
														<?php } ?>
													</select>
												<?php } ?>
											</td>
											<td><input type="number" class="input-mini" step="0.5" min="0" value="0" /></td>
											<td><input type="number" class="input-mini" step="0.5" min="0" value="0" /></td>
											<td>
												<button class="btn btn-primary pay-submit">确认</button>
												<button class="btn btn-warning pay-delete">删除</button>
											</td>
										</tr>
									<?php }} ?>
									</tbody>
								</table>
							</ul>
						</div>
					</div>
				</div>
			<?php } ?>

	</body>
	<script type="text/javascript" src="./style/js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="./style/js/bootstrap.js"></script>
	<script type="text/javascript" src="./style/js/addOrder.js"></script>
	<script type="text/javascript" src="./style/js/admin.js"></script>
	<?php if(!isset($_SESSION['adminId'])) { ?>
		<script type="text/javascript">
			$("#btn-login").trigger('click');
		</script>
	<?php } ?>
</html>
