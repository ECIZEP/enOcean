<?php 
include("header.php");
?>
<script src="../js/echarts.js"></script>
<!-- main content start -->
<div class="content">
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<header class="panel-heading">
					空调——设备属性列表
					<span class="tools pull-right">
						<a href="javascript:;" class="fa fa-chevron-down"></a>
						<a href="javascript:;" class="fa fa-times"></a>
					</span>
				</header>
				<div class="panel-body">
					<table class="table table-bordered table-striped table-advance table-hover">
						<thead>
							<tr>
								<th>序列号</th>
								<th class="hidden-phone">名称</th>
								<th>类型</th>
								<th>状态</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><a href="#">1</a></td>
								<td class="hidden-phone">电源开关</td>
								<td>开关</td>
								<td><span class="label label-info label-mini">未绑定</span></td>
								<td>
									<button id="modify" class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal4"><i class="fa fa-check"></i></button>
									<button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
									<button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
								</td>
							</tr>
							<tr>
								<td>
									<a href="#">
										2
									</a>
								</td>
								<td class="hidden-phone">温度控制</td>
								<td>多值型</td>
								<td><span class="label label-danger label-mini">已掉线</span></td>
								<td>
									<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
									<button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
									<button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
								</td>
							</tr>
							<tr>
								<td><a href="#">3</a></td>
								<td class="hidden-phone">屏幕开关</td>
								<td>开关</td>
								<td><span class="label label-success label-mini">已连接</span></td>
								<td>
									<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
									<button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
									<button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
								</td>
							</tr>
							<tr>
								<td>
									<a href="#">
										6
									</a>
								</td>
								<td class="hidden-phone">空调模式</td>
								<td>多值型</td>
								<td><span class="label label-success label-mini">已连接</span></td>
								<td>
									<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
									<button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
									<button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
								</td>
							</tr>
							<tr>
								<td><a href="#">9</a></td>
								<td class="hidden-phone">功率监控</td>
								<td>数值型</td>
								<td><span class="label label-primary label-mini">待定</span></td>
								<td>
									<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
									<button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
									<button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
								</td>
							</tr>

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
						<a href="javascript:;" class="fa fa-chevron-down"></a>
						<a href="javascript:;" class="fa fa-times"></a>
					</span>
				</header>
				<div class="panel-body">
					<form class="form-horizontal tasi-form">
						<div class="form-group">
							<label class="col-sm-4 col-xs-4 control-label text-center">电源开关</label>
							<div class="col-sm-8 col-xs-8 text-right">
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
							<label class="col-sm-4 col-xs-4 control-label text-center">屏幕开关</label>
							<div class="col-sm-8 col-xs-8 text-right">
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
					状态选择
					<span class="tools pull-right">
						<a href="javascript:;" class="fa fa-chevron-down"></a>
						<a href="javascript:;" class="fa fa-times"></a>
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
	<div class="row"  >
		<div class="col-md-12" >
			<section class="panel">
				<header class="panel-heading">
					功率监控
					<span class="tools pull-right">
						<a href="javascript:;" class="fa fa-chevron-down"></a>
						<a href="javascript:;" class="fa fa-times"></a>
					</span>
				</header>
				<div class="panel-body" id="echart" style="width: 100%;height:500px">

				</div>
			</section>
		</div>
	</div>
	<script type="text/javascript">
	        // 基于准备好的dom，初始化echarts实例
	        var myChart = echarts.init(document.getElementById('echart'));

	        // 指定图表的配置项和数据
	        var option = {
	        	title: {
	        		text: '电压实时监控'
	        	},
	        	tooltip: {},
	        	legend: {
	        		data:['电压']
	        	},
	        	xAxis: {
	        		data: ["衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子"]
	        	},
	        	yAxis: {},
	        	series: [{
	        		name: '电压',
	        		type: 'line',
	        		data: [5, 20, 36, 10, 10, 20]
	        	}]
	        };
	        // 使用刚指定的配置项和数据显示图表。
	        myChart.setOption(option);
	</script>
</div>
<!-- main content end -->

<!-- modal start -->
<div class="modal fade modal-dialog-center" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog ">
		<div class="modal-content-wrap">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Modal Tittle</h4>
				</div>
				<div class="modal-body">

					Body goes here...

				</div>
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
					<button class="btn btn-warning" type="button"> Confirm</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- modal end -->
<?php 
include("footer.php");
?>