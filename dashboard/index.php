<?php 
include("header.php");
if(!isset($_SESSION)){
	session_start();
}

function getDeviceCount(){
	$sql = "select COUNT(*) from devices where owner ='{$_SESSION["username"]}'";
	echo DBManager::query_mysql($sql)["0"]["0"];
}

function getControllerCount(){
	$sql = "select count(*) from devices,controller where devices.owner = '{$_SESSION["username"]}' and devices.deviceId = controller.deviceId";
	echo DBManager::query_mysql($sql)["0"]["0"];
}


function getLogCount(){
	$sql = "select count(*) from logbook where username = '{$_SESSION["username"]}'";
	echo DBManager::query_mysql($sql)["0"]["0"];
}


function format($a,$b){
	if(strtotime($a)>strtotime($b)) list($a,$b)=array($b,$a);
	$start  = strtotime($a);
	$stop   = strtotime($b);
	$extend = ($stop-$start)/86400;
	return intval($extend);
}

function getDayCount(){
	$sql = "select registerDate from account where username = '{$_SESSION["username"]}'";
	$date = DBManager::query_mysql($sql)["0"]["registerDate"];
	$date = explode(" ", $date)["0"];
	$nowDate = date("Y-m-d");
	echo format($date,$nowDate);
}

?>
<!-- main content start -->
<div class="content">
	<div class="row state-overview">
		<div class="col-lg-3 col-sm-6">
			<section class="panel">
				<div class="symbol terques">
					<i class="fa fa-laptop"></i>
				</div>
				<div class="value">
					<h1 class="count"><?php getDeviceCount();?></h1>
					<p>设备数</p>
				</div>
			</section>
		</div>
		<div class="col-lg-3 col-sm-6">
			<section class="panel">
				<div class="symbol red">
					<i class="fa fa-magnet"></i>
				</div>
				<div class="value">
					<h1 class=" count2"><?php getControllerCount();?></h1>
					<p>控制器</p>
				</div>
			</section>
		</div>
		<div class="col-lg-3 col-sm-6">
			<section class="panel">
				<div class="symbol yellow">
					<i class="fa fa-gears"></i>
				</div>
				<div class="value">
					<h1 class=" count3"><?php getLogCount();?></h1>
					<p>操作记录</p>
				</div>
			</section>
		</div>
		<div class="col-lg-3 col-sm-6">
			<section class="panel">
				<div class="symbol blue">
					<i class="fa fa-clock-o"></i>
				</div>
				<div class="value">
					<h1 class=" count4"><?php  getDayCount();?></h1>
					<p>使用时间/天</p>
				</div>
			</section>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4">
			<!--widget start-->
			<aside class="profile-nav">
				<section class="panel">
					<div class="user-heading profile-header">
						<a class="head-img" href="./profile.php">
							<img alt="" src="<?php echo get_photoUrl(); ?>">
						</a>
						<h1><?php echo get_nickname(); ?></h1>
						<p><?php echo get_personal(); ?></p>
					</div>
					<ul class="nav nav-pills nav-stacked">
						
						
						<li>
							<a href="./profile.php">
								 更多资料
								<span class="label label-primary pull-right r-activity"><i class="fa fa-user"></i></span>
							</a>
						</li>
						<li>
							<a> 
								安全设置
								<span class="label label-warning pull-right r-activity"><i class="fa fa-shield"></i></span>
							</a>
						</li>
						<li>
							<a href="./logbook.php"> 
								最近操作
								<span class="label label-info pull-right r-activity"><i class="fa fa-clock-o"></i></span>
							</a>
						</li>
					</ul>
				</section>
			</aside>
			<!--widget end-->
		</div>
		<div class="col-lg-8">
			
			<section class="panel">
				<header class="panel-heading">
					设备
					<span class="tools pull-right">
						<button data-toggle="modal" data-target="#addDeviceModal" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> 添加设备</button>
						<a class="fa fa-chevron-down"></a>
						<a class="fa fa-times"></a>
					</span>
				</header>
				<div class="panel-body">
					<table class="table table-bordered table-striped table-advance table-hover">
						<thead>
							<tr>
								<th class="hidden-phone">名称</th>
								<th>备注</th>
								<th>状态</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php getDeviceString("table");?>
						</tbody>
					</table>
				</div>
			</section>
			<div class="row no-padding">
				<div class="col-md-6">
					<section class="panel">
						<header class="panel-heading">
							快捷开关
							<span class="tools pull-right">
								<button class="btn btn-success btn-xs"><i class="fa fa-puzzle-piece"></i> 管理快捷</button>
								<a class="fa fa-chevron-down"></a>
								<a class="fa fa-times"></a>
							</span>
						</header>
						<div class="panel-body">
							<form class="form-horizontal tasi-form">
								<div class="form-group">
									<label class="col-xs-6 control-label text-center">空调——电源开关</label>
									<div class="col-xs-6 text-right">
										<div class="switch has-switch">
											<div class="switch-on switch-animate">
												<input type="checkbox" checked="" data-toggle="switch">
												<span class="switch-left">ON</span>
												<label>&nbsp;</label>
												<span class="switch-right">OFF</span>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-6 control-label text-center">电视机——屏幕开关</label>
									<div class="col-xs-6 text-right">
										<div class="switch has-switch">
											<div class="switch-on switch-animate">
												<input type="checkbox" checked="" data-toggle="switch">
												<span class="switch-left">ON</span>
												<label>&nbsp;</label>
												<span class="switch-right">OFF</span>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</section>
				</div>
				<div class="col-md-6">
					<section class="panel">
						<header class="panel-heading">
							快捷状态选择
							<span class="tools pull-right">
								<button class="btn btn-success btn-xs"><i class="fa fa-puzzle-piece"></i> 管理快捷</button>
								<a class="fa fa-chevron-down"></a>
								<a class="fa fa-times"></a>
							</span>
						</header>
						<div class="panel-body">
							<form class="form-horizontal tasi-form">
								<div class="form-group">
									<label class="col-sm-4 col-xs-4 control-label">空调模式</label>
									<div class="col-sm-8 col-xs-8">
										<select name="minbeds" id="minbeds" class="form-control bound-s">
											<option>制冷模式</option>
											<option>暖气模式</option>
											<option>睡眠模式</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">温度控制</label>
									<div class="col-sm-8">
										<div class="slider-container" data-offsetwidth="">
											<div class="slider ui-slider-horizontal ui-widget-content">
												<div class="ui-slider-range ui-widget-header" style="width: 0%;"></div>
												<a href="javascript:;" class="ui-slider-handle ui-state-default" style="left: 0%"></a>
											</div>
											<div class="slider-info">
												当前值:
												<span data-min="10" data-max="30" id="slider-amount">10</span>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<section class="panel ">
				<header class="panel-heading">
					操作记录
					<span class="tools pull-right">
						<a class="fa fa-chevron-down"></a>
						<a class="fa fa-times"></a>
					</span>
				</header>
				<div class="panel-body profile-activity">

					<div class="activity terques">
						<span>
							<i class="fa fa-info-circle"></i>
						</span>
						<div class="activity-desk">
							<div class="panel">
								<div class="panel-body">
									<div class="arrow"></div>
									<i class=" fa fa-clock-o"></i>
									<h4>10:45 AM</h4>
									<p>Purchased new equipments for zonal office setup and stationaries.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="activity alt purple">
						<span>
							<i class="fa fa-rocket"></i>
						</span>
						<div class="activity-desk">
							<div class="panel">
								<div class="panel-body">
									<div class="arrow-alt"></div>
									<i class=" fa fa-clock-o"></i>
									<h4>12:30 AM</h4>
									<p>Lorem ipsum dolor sit amet consiquest dio</p>
								</div>
							</div>
						</div>
					</div>
					<div class="activity blue">
						<span>
							<i class="fa fa-bullhorn"></i>
						</span>
						<div class="activity-desk">
							<div class="panel">
								<div class="panel-body">
									<div class="arrow"></div>
									<i class=" fa fa-clock-o"></i>
									<h4>10:45 AM</h4>
									<p>Please note which location you will consider, or both. Reporting to the VP  you will be responsible for managing.. </p>
								</div>
							</div>
						</div>
					</div>
					<div class="activity alt green">
						<span>
							<i class="fa fa-beer"></i>
						</span>
						<div class="activity-desk">
							<div class="panel">
								<div class="panel-body">
									<div class="arrow-alt"></div>
									<i class=" fa fa-clock-o"></i>
									<h4>12:30 AM</h4>
									<p>Please note which location you will consider, or both.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="col-lg-6">
			<section class="panel">
				<header class="panel-heading">
					Chats
					<span class="tools pull-right">
						<a class="fa fa-chevron-down"></a>
						<a class="fa fa-times"></a>
					</span>
				</header>
				<div class="panel-body">
					<div class="timeline-messages">
						<!-- Comment -->
						<div class="msg-time-chat">
							<a href="#" class="message-img"><img class="avatar" src="img/chat-avatar.jpg" alt=""></a>
							<div class="message-body msg-in">
								<span class="arrow"></span>
								<div class="text">
									<p class="attribution"><a href="#">Jhon Doe</a> at 1:55pm, 13th April 2013</p>
									<p>Hello, How are you brother?</p>
								</div>
							</div>
						</div>
						<!-- /comment -->

						<!-- Comment -->
						<div class="msg-time-chat">
							<a href="#" class="message-img"><img class="avatar" src="img/chat-avatar2.jpg" alt=""></a>
							<div class="message-body msg-out">
								<span class="arrow"></span>
								<div class="text">
									<p class="attribution"> <a href="#">Jonathan Smith</a> at 2:01pm, 13th April 2013</p>
									<p>I'm Fine, Thank you. What about you? How is going on?</p>
								</div>
							</div>
						</div>
						<!-- /comment -->

						<!-- Comment -->
						<div class="msg-time-chat">
							<a href="#" class="message-img"><img class="avatar" src="img/chat-avatar.jpg" alt=""></a>
							<div class="message-body msg-in">
								<span class="arrow"></span>
								<div class="text">
									<p class="attribution"><a href="#">Jhon Doe</a> at 2:03pm, 13th April 2013</p>
									<p>Yeah I'm fine too. Everything is going fine here.</p>
								</div>
							</div>
						</div>
						<!-- /comment -->

						<!-- Comment -->
						<div class="msg-time-chat">
							<a href="#" class="message-img"><img class="avatar" src="img/chat-avatar2.jpg" alt=""></a>
							<div class="message-body msg-out">
								<span class="arrow"></span>
								<div class="text">
									<p class="attribution"><a href="#">Jonathan Smith</a> at 2:05pm, 13th April 2013</p>
									<p>well good to know that. anyway how much time you need to done your task?</p>
								</div>
							</div>
						</div>
						<!-- /comment -->
						<!-- Comment -->
						<div class="msg-time-chat">
							<a href="#" class="message-img"><img class="avatar" src="img/chat-avatar.jpg" alt=""></a>
							<div class="message-body msg-in">
								<span class="arrow"></span>
								<div class="text">
									<p class="attribution"><a href="#">Jhon Doe</a> at 1:55pm, 13th April 2013</p>
									<p>Hello, How are you brother?</p>
								</div>
							</div>
						</div>
						<!-- /comment -->
					</div>
					<div class="chat-form">
						<div class="input-cont ">
							<input type="text" class="form-control col-lg-12" placeholder="Type a message here...">
						</div>
						<div class="form-group">
							<div class="pull-right chat-features">
								<a>
									<i class="fa fa-camera"></i>
								</a>
								<a>
									<i class="fa fa-link"></i>
								</a>
								<a class="btn btn-danger">Send</a>
							</div>
						</div>

					</div>
				</div>
			</section>
		</div>
	</div>
</div>
<!-- main content end -->

<!-- modal dialog start -->
<div class="modal fade modal-dialog-center" id="modifyDevice" tabindex="-1" role="dialog" aria-labelledby="addDeviceModal" aria-hidden="true">
	<div class="modal-dialog ">
		<div class="modal-content-wrap">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">修改<span class="modifyTitle"></span>设备信息</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-md-4">设备名称：</label>
							<div class="col-md-8">
								<input size="16" type="text" id="modifyDeviceName" class="form-control">
							</div>
						</div>
						<div class="form-group last">
							<label class="control-label col-md-4">设备的备注：</label>
							<div class="col-md-8">
								<input size="16" type="text" id="modifyDeviceRemark" class="form-control">
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
					<button data-deviceid="" class="btn btn-warning" id="modifyDeviceConfirm" type="button">确定</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade modal-dialog-center" id="deleteDevice" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog ">
		<div class="modal-content-wrap">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">删除<span class="deleteTitle"></span>安全验证</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
					<div class="form-group last">
							<label class="control-label col-md-4">请输入验证码：</label>
							<div class="col-md-8">
								<input size="16" type="text" class="form-control btn-input verifycodeInput">
								<button value="delete_device" data-phonenumber="<?php echo get_phone_number();?>" class="btn btn-success pull-right sendMessage" type="button">发送验证码</button>
							</div>
						</div>
					</form>

				</div>
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
					<button data-deviceid="" class="btn btn-warning" id="deleteDeviceConfirm" type="button">确定</button>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
include("footer.php");
?>