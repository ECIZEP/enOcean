<?php 
include("header.php");
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
					<h1 class="count">5</h1>
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
					<h1 class=" count2">18</h1>
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
					<h1 class=" count3">328</h1>
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
					<h1 class=" count4">10328</h1>
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
						<!-- <li>
							<a>
								<i class="fa fa-envelope-o"></i> Message
								<span class="label label-success pull-right r-activity">10</span>
							</a>
						</li> -->
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
										<div class="slider-container">
											<div id="slider-range-min" class="slider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
												<div class="ui-slider-range ui-widget-header"></div>
												<a class="ui-slider-handle ui-state-default" ></a>
											</div>
											<div class="slider-info">
												当前值:
												<span class="slider-info" id="slider-amount">0</span>
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
							<i class="fa fa-shopping-cart"></i>
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
<?php 
include("footer.php");
?>