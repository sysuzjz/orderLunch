<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8">
		<title>订餐啦！</title>
		<link rel="stylesheet" type="text/css" href="./style/css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="./style/css/public.css" />
		<link rel="stylesheet" type="text/css" href="./style/css/main.css" />
	</head>
	<?php
		require("./action/public.action.php");
		$debtList = array();
		$queryStr = "SELECT * FROM debt WHERE debt > 0 ORDER BY debt DESC";
		$queryResult = mysql_query($queryStr);
		$queryResultNum = mysql_num_rows($queryResult);
		for($i = 0; $i < $queryResultNum; $i++) {
			$temp = mysql_fetch_array($queryResult);
			$temp['userName'] = getNameById($temp['userId']);
			$temp['debterName'] = getNameById($temp['debter']);
			array_push($debtList, $temp);
		}

		if(isset($_SESSION['id'])) {
			$uid = $_SESSION['id'];

			$personalMsg = array();
			$queryStr = "SELECT name, email FROM user WHERE id = '$uid' LIMIT 1";
			$queryResult = mysql_query($queryStr);
			$personalMsg = mysql_fetch_array($queryResult);

			$helpList = array();
			$queryStr = "SELECT lunchType, time, helper FROM orders WHERE userId = '$uid' AND isPaid = 0 AND helper > 0 AND helper != userId ";
			$queryResult = mysql_query($queryStr);
			$queryResultNum = mysql_num_rows($queryResult);
			for($i = 0; $i < $queryResultNum; $i++) {
				$temp = mysql_fetch_array($queryResult);
				$temp['helperName'] = getNameById($temp['helper']);
				$temp['price'] = getMsgByLunchType($temp['lunchType']);
				$temp['price'] = $temp['price']['price'];
				array_push($helpList, $temp);
			}

			$assumeList = array();
			$queryStr = "SELECT * FROM orders WHERE userId = '$uid' ORDER BY time DESC ";
			$queryResult = mysql_query($queryStr);
			$queryResultNum = mysql_num_rows($queryResult);
			for($i = 0; $i < $queryResultNum; $i++) {
				$temp = mysql_fetch_array($queryResult);
				$temp['helperName'] = getNameById($temp['helper']);
				$temp['lunchMsg'] = getMsgByLunchType($temp['lunchType']);
				array_push($assumeList, $temp);
			}

			$menu = array();
			$queryStr = "SELECT * FROM menu ORDER BY type ASC ";
			$queryResult = mysql_query($queryStr);
			$queryResultNum = mysql_num_rows($queryResult);
			for($i = 0; $i < $queryResultNum; $i++) {
				$temp = mysql_fetch_array($queryResult);
				array_push($menu, $temp);
			}
			
		}
	?>
	<body>
		<div id="head">
			<?php if(!isset($_SESSION['id'])) { ?>
				<ul>
					<!-- <li><a href="#registerBox" role="button" class="btn" data-toggle="modal">注册</a></li> -->
					<li><a href="#login" role="button" class="btn" data-toggle="modal">登录</a></li>
				</ul>
				<a href="#tips" role="button" class="btn invisible" data-toggle="modal" id="btn-tips">提示</a>
				<div id="tips" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  	<div class="modal-header">
				    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				    	<h3 id="myModalLabel">温馨提示</h3>
				  	</div>
				  	<div class="modal-body">
                        <!-- <p>1.大家不要随便注册啦，用真名真学号注册啦！！</p> -->
                        <ul>
                            <li>
                                    <span style="color: red;">订餐时间: </span>
                                     <?php foreach ($orderTime as $time) { ?>
				  				    <span><?= $time['beginTime'] ?> - <?= $time['endTime'] ?>&nbsp;</span>
				  			    <?php } ?>
				  		    </li>

		    		  		<li>这网站没做什么安全性设置，大家就别锻炼自己的黑客技术啦，一攻就破的= =</li>
	    			  		<li>大家也不要随便订餐啦，要不然前台订餐的人会打死你的</li>
    				  		<li>这个网站虽然叫做订餐系统，但实质上更偏向于记账系统，大家就轻虐哈~</li>
                            <li>下订单之后<?= $editableTime / 60  ?>分钟内可以删除原来的订单，但要注意订餐截止时间哦~</li>
                        </ul>
				  		
				  	</div>
				  	<div class="modal-footer">
					    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">我知道了</button>
				  	</div>
				</div>
				<!-- <div id="registerBox" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  	<div class="modal-header">
				    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				    	<h3 id="myModalLabel">注册新用户</h3>
				  	</div>
				  	<div class="modal-body">
				  		<form class="form-horizontal">
				  			<div class="control-group">
						    	<label class="control-label" for="inputId">学号</label>
						    	<div class="controls">
						      		<input type="text" id="inputId" placeholder="学号，8位">
					    		</div>
						  	</div>
						  	<div class="control-group">
						    	<label class="control-label" for="inputName">姓名</label>
						    	<div class="controls">
						      		<input type="text" id="inputName" placeholder="真实姓名，中文">
					    		</div>
						  	</div>
						  	<div class="control-group">
						    	<label class="control-label" for="inputEmail">邮箱</label>
						    	<div class="controls">
						      		<input type="email" id="inputEmail" placeholder="邮箱">
					    		</div>
						  	</div>
						  	<div class="control-group">
					    		<label class="control-label" for="inputPassword">密码</label>
						    	<div class="controls">
						      		<input type="password" id="inputPassword" placeholder="密码">
						    	</div>
						  	</div>
						  	<div class="control-group">
						    	<label class="control-label" for="inputRepeatPassword">重复密码</label>
						    	<div class="controls">
						      		<input type="password" id="inputRepeatPassword" placeholder="重复密码">
					    		</div>
						  	</div>
						  	<input type="submit" class="register-submit invisible" />
						</form>
				  	</div>
				  	<div class="modal-footer">
					    <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
					    <button class="btn btn-primary register-submit">注册</button>
				  	</div>
				</div> -->
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
						  	<div class="control-group">
							    <div class="controls">
							      	<label class="checkbox">
							        	<input type="checkbox" id="remember" checked="checked"> 记住密码
							      	</label>
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
					<li><a href="#personMsgBox" role="button" class="btn" data-toggle="modal"><?= $_SESSION['name'] ?></a></li>
				</ul>
				<div id="personMsgBox" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  	<div class="modal-header">
				    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				    	<h3 id="myModalLabel">更改个人信息</h3>
				  	</div>
				  	<div class="modal-body">
				  		<form class="form-horizontal">
						  	<div class="control-group">
						    	<label class="control-label" for="newName">姓名</label>
						    	<div class="controls">
						      		<input type="text" id="newName" placeholder="真实姓名，中文" value="<?= $personalMsg['name'] ?>" />
					    		</div>
						  	</div>
						  	<div class="control-group">
						    	<label class="control-label" for="newEmail">邮箱</label>
						    	<div class="controls">
						      		<input type="email" id="newEmail" placeholder="邮箱" value="<?= $personalMsg['email'] ?>" />
					    		</div>
						  	</div>
						  	<div class="control-group">
					    		<label class="control-label" for="newPassword">密码</label>
						    	<div class="controls">
						      		<input type="password" id="newPassword" placeholder="填了会覆盖原密码">
						    	</div>
						  	</div>
						  	<div class="control-group">
						    	<label class="control-label" for="newRepeatPassword">重复密码</label>
						    	<div class="controls">
						      		<input type="password" id="newRepeatPassword" placeholder="重复密码">
					    		</div>
						  	</div>
						  	<input type="submit" class="personal-submit invisible" />
						</form>
				  	</div>
				  	<div class="modal-footer">
					    <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
					    <button class="btn btn-primary personal-submit">更改</button>
				  	</div>
				</div>
			<?php } ?>
		</div>
		<div id="main-content">
			<?php if(isset($_SESSION['id'])) { ?>
				<a href="#add-order" class="btn btn-primary btn-large" role="button" data-toggle="modal">我要订餐</a>
				<div id="add-order" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  	<div class="modal-header">
				    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				    	<h3 id="myModalLabel">订餐单</h3>
				  	</div>
				  	<div class="modal-body">
				  		<p>
				  			<span style="color: red;">订餐时间: </span>
				  			<?php foreach ($orderTime as $time) { ?>
				  				<span><?= $time['beginTime'] ?> - <?= $time['endTime'] ?>&nbsp;</span>
				  			<?php } ?>
				  		</p>
				    	<form class="form-horizontal" id="menu-list">
				    		<div class="control-group menu-msg hide" id="menu-model">
					    		<select class="select-menu">
					    			<option value="">请选择</option>
					     			<?php foreach ($menu as $currentMenu) { ?>
					    				<option value="<?= $currentMenu['type'] ?>"><?= $currentMenu['type'] ?> <?= $currentMenu['name'] ?> <?= $currentMenu['price'] ?>元</option>
					    			<?php } ?>
					    		</select>
					    		<input type="text" class="input-mini" disabled="disabled" value="0元" />
					 			<button class="remove-order btn btn-primary">删除</button>
					    	</div>
					    	<div class="control-group menu-msg " >
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
			<?php } ?>

			<div class="debt-list">
				<h4 class="alert">欠债黑名单</h4>
				<div class="well">
					<ul>
						<?php if(count($debtList) == 0) { ?>
							<p>无</p>
						<?php } else {
							foreach ($debtList as $debt) { ?>
								<li><?= $debt['userName'] ?> 欠了 <?= $debt['debterName'] ?> <span class="alert-msg"><?= $debt['debt'] ?></span> 元！！！</li>	
						<?php }} ?>
					</ul>
				</div>
			</div>
			<?php if(isset($_SESSION['id'])) { ?>
				<div class="help-list">
					<h4 class="alert">欠债记录</h4>
					<div class="well">
						<ul>
							<?php if(count($helpList) == 0) { ?>
								<p>无</p>
							<?php } else {
								foreach ($helpList as $help) { ?>
									<li><?= $help['helperName'] ?> 在 <?= date("Y-m-d" ,$help['time']) ?> 帮你预付了 <?= $help['price'] ?> 元</li>	
							<?php }} ?>
						</ul>
					</div>
				</div>
				<div class="assume-list">
					<h4 class="alert">消费记录</h4>
					<div class="well">
						<ul>
							<?php if(count($assumeList) == 0) { ?>
								<p>无</p>
							<?php } else { ?>

							<table class="table table-striped table-bordered table-hover">
								<thead>
									<th>时间</th>
									<th>代号</th>
									<th>价格</th>
									<th>代付人</th>
									<th>实付金额</th>
									<th>找零</th>
									<th>操作</th>
								</thead>
								<tbody>
									
								<?php
									foreach ($assumeList as $assume) { ?>
									<tr data-id="<?= $assume['orderId'] ?>">
										<td><?= date("Y-m-d h:i:s",$assume['time']) ?></td>
										<td><?= $assume['lunchType'] ?></td>
										<td><?= $assume['lunchMsg']['price'] ?></td>
										<td><?= $assume['helperName'] ?></td>
										<td><?= $assume['actuallyPaid'] ?></td>
										<td><?= $assume['returnMoney'] ?></td>
										<td><button class="btn btn-warning delete-order" <?= time() + $timeError - $assume['time'] > $editableTime ? "disabled" : "" ?>>删除</button></td>
									</tr>
								<?php }} ?>
								</tbody>
							</table>
						</ul>
					</div>
				</div>
			<?php } ?>
		</div>

	</body>
	<script type="text/javascript" src="./style/js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="./style/js/bootstrap.js"></script>
	<script type="text/javascript" src="./style/js/addOrder.js"></script>
	<script type="text/javascript" src="./style/js/main.js"></script>
	<?php if(!isset($_SESSION['id'])) { ?>
		<script type="text/javascript">
			$("#btn-tips").trigger('click');
		</script>
	<?php } ?>
</html>
