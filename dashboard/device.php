<?php 
include("header.php");

if($_SERVER['REQUEST_METHOD'] == "GET"){
	if(isset($_GET["unique"])){
		$sql = "select * from tablecontroller where deviceId = '{$_GET["unique"]}'";
		$resultArray = DBManager::query_mysql($sql);
		$sql = "select * from devices where deviceId = '{$_GET["unique"]}'";
		$deviceInfo = DBManager::query_mysql($sql)["0"];
	}
}


function getConnectState(){
	$sql = "select connectState from devices where deviceId = '{$_GET["unique"]}'";
	return DBManager::query_mysql($sql)["0"]["connectState"];
}

function printController($resultArray){
	foreach ($resultArray as $key => $value) {
		echo '<tr><td>'.$value["controName"].'</td><td>'.$value["typeName"].'</td><td>';
		if($value["typeName"] == "开关"){
			if($value["data"] == "0"){
				echo "OFF</td>";
			}elseif($value["data"] == "1"){
				echo "ON</td>";
			}
		}elseif($value["typeName"] == "下拉选择"){
			echo IndexOfModeName($value["modeNames"],$value["data"]);
		}else{
			echo $value["data"]."</td>";
		}
		echo '<td><button data-toggle="modal" data-target="#modifyController" data-controllerid="'.$value["controllerId"].'" class="btn btn-primary btn-xs midifyController"><i class="fa fa-pencil"></i></button>&nbsp;<button data-toggle="modal" data-target="#deleteController" data-controllerid="'.$value["controllerId"].'" class="btn btn-danger btn-xs deleteController"><i class="fa fa-trash-o"></i></button></td></tr>';
	}
}

function printSwitcher($resultArray){
	foreach ($resultArray as $key => $value) {
		if($value["typeName"] == "开关"){
			echo '<div class="form-group"><label class="col-xs-4 control-label">'.$value["controName"].'</label>';
			echo '<div class="col-xs-8 text-right"><div class="switch has-switch">';
			if($value["data"] == 1){
				echo '<div class="switch-on switch-animate" data-controllerid="'.$value["controllerId"].'">';
			}else{
				echo '<div class="switch-off switch-animate" data-controllerid="'.$value["controllerId"].'">';
			}
			echo '<input type="checkbox" checked="" data-toggle="switch"><span class="switch-left">ON</span><label>&nbsp;</label><span class="switch-right">OFF</span></div></div></div></div>';
		}
	}
}

function getSliderRange($deviceId){
	$sql = "select data,minValue,maxValue_ from controller where deviceId = '{$deviceId}'";
	$result = DBManager::query_mysql($sql)["0"];

}

function printSelectorAndSlider($resultArray){
	foreach ($resultArray as $key => $value) {
		if($value["typeName"] == "下拉选择"){
			echo '<div class="form-group"><label class="col-xs-4 control-label">'.$value["controName"].'</label><div class="col-xs-8"><select data-controllerid="'.$value["controllerId"].'" class="form-control bound-s selector">';
			$optionArray = explode(" ",$value["modeNames"]);
			foreach ($optionArray as $key => $value) {
				echo '<option>'.$value.'</option>';
			}
			echo '</select></div></div>';
		}elseif($value["typeName"] == "滑块控制"){
			echo '<div class="form-group"><label class="col-xs-4 control-label">'.$value["controName"].'</label><div class="col-xs-8"><div class="slider-container" data-controllerid="'.$value["controllerId"].'" data-offsetwidth=""><div class="slider ui-slider-horizontal ui-widget-content">';
			$sql = "select controName,data,minValue,maxValue_ from controller where controllerId = '{$value["controllerId"]}' limit 1";
			$result = DBManager::query_mysql($sql)["0"];
			$range = floatval($value['data'] - $result["minValue"])/floatval($result["maxValue_"] - $result["minValue"]) * 100;
			echo '<div class="ui-slider-range ui-widget-header" style="width:'.$range.'%"></div>';
			echo '<a href="javascript:;" class="ui-slider-handle ui-state-default" style="left:'.$range.'%"></a></div>';
			echo '<div class="slider-info">当前值:<span id="slider-amount" data-min="'.$result["minValue"].'" data-max="'.$result["maxValue_"].'">'.$value['data'].'</span></div></div></div></div>';
		}
	}
}

function printCharts($resultArray){
	foreach ($resultArray as $key => $value) {
		if($value["typeName"] == "数值监控"){
			$sql = "select * from controller where controllerId ='{$value["controllerId"]}' limit 1";
			$result = DBManager::query_mysql($sql)["0"];
			echo '<div class="charts" style="width: 100%;height:600px;margin-bottom:20px;" data-min="'.$result["minValue"].'" data-max="'.$result["maxValue_"].'" data-title="'.$value["controName"].'" data-controllerid="'.$value["controllerId"].'"></div>';
		}	
	}
}

?>
<!-- main content start -->
<div class="content">
	<div class="alert alert-danger" style="display: none;">
		<a href="javascript:;" class="close" data-dismiss="alert">
			&times;
		</a>
		<strong>警告！</strong>您的设备<?php echo $deviceInfo["devicename"];?>已经断开连接，建议不要对设备的控制器进行操作
	</div>
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<header class="panel-heading">
					<?php echo $deviceInfo["devicename"];?>
					<span class="tools pull-right">
						<?php
							$connectState = getConnectState();
						 	if($connectState == 0){
						 		echo '<span id="deviceState" class="label label-info label-mini">已断开</span>';
						 	}elseif ($connectState == 1) {
						 		echo '<span id="deviceState" class="label label-success label-mini">已连接</span>';
						 	}
						 ?>
						<a class="fa fa-chevron-down"></a>
						<a class="fa fa-times"></a>
					</span>
				</header>
				<div class="panel-body">
					<div class="row no-padding" style="margin-bottom: 15px;">
						<div class="col-sm-8 col-xs-8">
							<button data-toggle="modal" data-target="#modifyDevice" class="btn btn-primary btn-responsive">
								<i class="fa fa-pencil"></i> 编辑设备
							</button>
							<button data-toggle="modal" data-target="#addControllerModal" class="btn btn-success btn-responsive"><i class="fa fa-plus"></i> 添加控制器
							</button>
						</div>
						<div class="col-sm-4 col-xs-4">
							<button data-toggle="modal" data-target="#deleteDevice" class="btn btn-danger pull-right btn-responsive"><i class="fa fa-trash-o"></i> 删除设备
							</button>
						</div>
					</div>
					<table class="table table-bordered table-striped table-advance table-hover">
						<thead>
							<tr>
								<th class="hidden-phone">名称</th>
								<th>类型</th>
								<th>状态</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody class="fortr">
							<?php printController($resultArray);?>
						</tbody>
					</table>
				</div>
			</section>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<section class="panel">
				<header class="panel-heading">
					开关控制
					<span class="tools pull-right">
						<a class="fa fa-chevron-down"></a>
						<a class="fa fa-times"></a>
					</span>
				</header>
				<div class="panel-body">
					<form class="form-horizontal tasi-form">
						<?php printSwitcher($resultArray);?>
					</form>
				</div>
			</section>
		</div>
		<div class="col-md-6">
			<section class="panel">
				<header class="panel-heading">
					状态选择
					<span class="tools pull-right">
						<a class="fa fa-chevron-down"></a>
						<a class="fa fa-times"></a>
					</span>
				</header>
				<div class="panel-body">
					<form class="form-horizontal tasi-form">
						<?php printSelectorAndSlider($resultArray);?>
					</form>
				</div>
			</section>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12" >
			<section class="panel">
				<header class="panel-heading">
					数据监控
					<span class="tools pull-right">
						<a class="fa fa-chevron-down"></a>
						<a class="fa fa-times"></a>
					</span>
				</header>
				<div class="panel-body">
					<?php printCharts($resultArray);?>
				</div>
			</section>
		</div>
	</div>
</div>
<!-- main content end -->

<!-- modal dialog start -->
<div class="modal fade modal-dialog-center" id="modifyDevice" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog ">
		<div class="modal-content-wrap">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">修改<?php echo $deviceInfo["devicename"];?>设备信息</h4>
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
					<button data-deviceid="<?php echo $_GET["unique"];?>" class="btn btn-warning" id="modifyDeviceConfirm" type="button">确定</button>
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
					<h4 class="modal-title">删除<?php echo $deviceInfo["devicename"];?>安全验证</h4>
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
					<button data-deviceid="<?php echo $_GET["unique"];?>" class="btn btn-warning" id="deleteDeviceConfirm" type="button">确定</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade modal-dialog-center" id="modifyController" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog ">
		<div class="modal-content-wrap">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">修改控制器信息</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-md-4">控制器名称：</label>
							<div class="col-md-8">
								<input size="16" type="text" id="modifyControllerName" class="form-control">
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
					<button data-controllerid="" class="btn btn-warning" id="modifyControllerConfirm" type="button">确定</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade modal-dialog-center" id="deleteController" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog ">
		<div class="modal-content-wrap">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">删除操作安全验证</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
					<div class="form-group last">
							<label class="control-label col-md-4">请输入密码完成操作：</label>
							<div class="col-md-8">
								<input size="16" id="deleteControllerInput" type="password" class="form-control">
							</div>
						</div>
					</form>

				</div>
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
					<button class="btn btn-warning" data-controllerid="" id="deleteControllerConfirm" type="button">确定</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="../js/echarts.min.js"></script>
<script src="../js/deviceChart.js?v=1"></script>
<?php 
include("footer.php");
?>