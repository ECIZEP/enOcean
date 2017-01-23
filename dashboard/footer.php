	<div class="modal fade modal-dialog-center" id="addDeviceModal" tabindex="-1" role="dialog" aria-labelledby="addDeviceModal" aria-hidden="true">
		<div class="modal-dialog ">
			<div class="modal-content-wrap">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title">添加设备</h4>
					</div>
					<div class="modal-body">
						<form class="form-horizontal">
							<div class="form-group">
								<label class="control-label col-md-4">选择已检测到的设备</label>
								<div class="col-md-8">
									<select id="select-device" style="width: auto;display: inline-block;vertical-align: middle;" class="form-control">
										<?php getUnbindDeviceOption(); ?>
									</select>
									<button class="btn btn-success pull-right" type="button"><i class="fa fa-refresh"></i> 刷新</button>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4">输入新设备的名称</label>
								<div class="col-md-8">
									<input size="16" type="text" id="deviceName" class="form-control">
								</div>
							</div>
							<div class="form-group last">
								<label class="control-label col-md-4">输入新设备的备注</label>
								<div class="col-md-8">
									<input size="16" type="text" id="deviceRemark" class="form-control">
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
						<button class="btn btn-warning" id="addDeviceModalConfirm" type="button">确定</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade modal-dialog-center" id="addControllerModal" tabindex="-1" role="dialog" aria-labelledby="addDeviceModal" aria-hidden="true">
		<div class="modal-dialog ">
			<div class="modal-content-wrap">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title">添加控制器</h4>
					</div>
					<div class="modal-body">
						<form class="form-horizontal">
							<div class="form-group">
								<label class="control-label col-md-4">请选择所属设备</label>
								<div class="col-md-8">
									<select name="minbeds" id="minbeds" style="width: auto;display: inline-block;vertical-align: middle;" class="form-control">
										<option>DFGSDFH001</option>
										<option>SDGASDG342</option>
										<option>SDGAGASD32</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4">输入控制器的名称</label>
								<div class="col-md-8">
									<input size="16" type="text" id="deviceName" class="form-control">
								</div>
							</div>
							<div class="form-group last">
								<label class="control-label col-md-4">选择控制器类型</label>
								<div class="col-md-8">
									<select name="minbeds" id="minbeds" style="width: auto;display: inline-block;vertical-align: middle;" class="form-control">
										<option>开关</option>
										<option>选择模式</option>
										<option>滑块控制</option>
										<option>数值监控</option>
									</select>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
						<button class="btn btn-warning" id="controllerModalConfirm" type="button">确定</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- modal dialog end -->
	<script src="../js/jquery-3.1.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/jquery.nicescroll.js"></script>
	<script src="../assets/toastr/toastr.min.js"></script>
	<script src="../assets/bootstap-fileupload/bootstrap-fileupload.js"></script>
	<script src="../js/common-scripts.js"></script>
</body>
</html>