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

function printLastestLog(){
	$sql = "select * from logbook where username = '{$_SESSION["username"]}' order by logDate DESC	 limit 4";
	$fourLogs = DBManager::query_mysql($sql);
	//initial odd true
	$odd = true;
	foreach ($fourLogs as $key => $value) {
		echo '<div class="activity ';
		if(!$odd){
			echo 'alt ';
		}
		if($value["noticeLevel"] == "0"){
			echo 'normal"><span><i class="fa fa-flag"></i></span>';
		}elseif($value["noticeLevel"] == "1"){
			echo 'warning"><span><i class="fa fa-info-circle"></i></span>';
		}elseif($value["noticeLevel"] ==  "2"){
			echo 'danger"><span><i class="fa fa-bullhorn"></i></span>';
		}
		echo '<div class="activity-desk"><div class="panel"><div class="panel-body">';
		if($odd){
			echo '<div class="arrow"></div>';
			//now is odd,the next is even
			$odd = false;
		}else{
			echo '<div class="arrow-alt"></div>';
			//now is even,the next is odd
			$odd = true;
		}
		echo '<h4><i class=" fa fa-clock-o"></i>'.$value["logDate"].'</h4><p>'.$value["content"].'</p></div></div></div></div>';
	}
}

function printQuickSwitcher($para){
	$selected = str_replace(" ",",",get_quickCon());
	$sql = "select * from tablecontroller,devices where tablecontroller.controllerId in({$selected}) and tablecontroller.deviceId = devices.deviceId";
	$resultArray = DBManager::query_mysql($sql);
	$switcher = "";
	$selectorAndSlider = "";
	$observer = "";
	foreach ($resultArray as $key => $value) {
		if($value["typeName"] == "开关"){
			$switcher = $switcher.'<div class="form-group"><label class="col-xs-4 control-label">'.$value["controName"].'-'.$value["devicename"].'</label>';
			$switcher = $switcher.'<div class="col-xs-8 text-right"><div class="switch has-switch">';
			if($value["data"] == 1){
				$switcher = $switcher.'<div class="switch-on switch-animate" data-controllerid="'.$value["controllerId"].'">';
			}else{
				$switcher = $switcher.'<div class="switch-off switch-animate" data-controllerid="'.$value["controllerId"].'">';
			}
			$switcher = $switcher.'<input type="checkbox" checked="" data-toggle="switch"><span class="switch-left">ON</span><label>&nbsp;</label><span class="switch-right">OFF</span></div></div></div></div>';
		}elseif($value["typeName"] == "下拉选择"){
			$selectorAndSlider = $selectorAndSlider.'<div class="form-group"><label class="col-xs-4 control-label">'.$value["controName"].'-'.$value["devicename"].'</label><div class="col-xs-8"><select data-controllerid="'.$value["controllerId"].'" class="form-control bound-s selector">';
			$optionArray = explode(" ",$value["modeNames"]);
			foreach ($optionArray as $key => $value) {
				$selectorAndSlider = $selectorAndSlider.'<option>'.$value.'</option>';
			}
			$selectorAndSlider = $selectorAndSlider.'</select></div></div>';
		}elseif($value["typeName"] == "滑块控制"){
			$selectorAndSlider = $selectorAndSlider.'<div class="form-group"><label class="col-xs-4 control-label">'.$value["controName"].'-'.$value["devicename"].'</label><div class="col-xs-8"><div class="slider-container" data-controllerid="'.$value["controllerId"].'" data-offsetwidth=""><div class="slider ui-slider-horizontal ui-widget-content">';
			$sql = "select controName,data,minValue,maxValue_ from controller where controllerId = '{$value["controllerId"]}' limit 1";
			$result = DBManager::query_mysql($sql)["0"];
			$range = floatval($value['data'] - $result["minValue"])/floatval($result["maxValue_"] - $result["minValue"]) * 100;
			$selectorAndSlider = $selectorAndSlider.'<div class="ui-slider-range ui-widget-header" style="width:'.$range.'%"></div>';
			$selectorAndSlider = $selectorAndSlider.'<a href="javascript:;" class="ui-slider-handle ui-state-default" style="left:'.$range.'%"></a></div>';
			$selectorAndSlider = $selectorAndSlider.'<div class="slider-info">当前值:<span id="slider-amount" data-min="'.$result["minValue"].'" data-max="'.$result["maxValue_"].'">'.$value['data'].'</span></div></div></div></div>';
		}elseif($value["typeName"] == "数值监控"){
			$sql = "select minValue,maxValue_ from controller where controllerId = '{$value["controllerId"]}' limit 1";
			$result = DBManager::query_mysql($sql)["0"];
			$observer = $observer.'<div class="charts charts-dashboard" data-min="'.$result["minValue"].'" data-max="'.$result["maxValue_"].'" data-title="'.$value["controName"].'-'.$value["devicename"].'" data-controllerid="'.$value["controllerId"].'"></div>';
		}
	}
	if($para == "switcher"){
		echo $switcher;
	}elseif($para == "selectorAndSlider"){
		echo $selectorAndSlider;
	}elseif($para == "observer"){
		echo $observer;
	}
	
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
								<a href="./safe_setting.php"><button class="btn btn-success btn-xs"><i class="fa fa-puzzle-piece"></i> 管理快捷</button></a>
								<a class="fa fa-chevron-down"></a>
								<a class="fa fa-times"></a>
							</span>
						</header>
						<div class="panel-body">
							<form class="form-horizontal tasi-form">
								<?php printQuickSwitcher("switcher");?>
							</form>
						</div>
					</section>
				</div>
				<div class="col-md-6">
					<section class="panel">
						<header class="panel-heading">
							快捷状态选择
							<span class="tools pull-right">
								<a href="./safe_setting.php"><button class="btn btn-success btn-xs"><i class="fa fa-puzzle-piece"></i> 管理快捷</button></a>
								<a class="fa fa-chevron-down"></a>
								<a class="fa fa-times"></a>
							</span>
						</header>
						<div class="panel-body">
							<form class="form-horizontal tasi-form">
								<?php printQuickSwitcher("selectorAndSlider");?>
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
					最近操作
					<span class="tools pull-right">
						<a href="./logbook.php" style="color: white" class="btn btn-success btn-xs"><i class="fa fa-tags"></i> 更多记录</a>
						<a class="fa fa-chevron-down"></a>
						<a class="fa fa-times"></a>
					</span>
				</header>
				<div class="panel-body profile-activity">
					<?php printLastestLog(); ?>
				</div>
			</section>
		</div>
		<div class="col-lg-6">
			<section class="panel">
				<header class="panel-heading">
					数值监控
					<span class="tools pull-right">
						<a class="fa fa-chevron-down"></a>
						<a class="fa fa-times"></a>
					</span>
				</header>
				<div class="panel-body">
					<?php printQuickSwitcher("observer");?>
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
<script src="../js/echarts.min.js"></script>
<script src="../js/deviceChart.js?v=2"></script>
<?php 
include("footer.php");
?>