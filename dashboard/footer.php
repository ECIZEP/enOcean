
	<div class="modal fade modal-dialog-center" id="addDeviceModal" tabindex="-1" role="dialog" aria-hidden="true">
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
	<div class="modal fade modal-dialog-center" id="addControllerModal" tabindex="-1" role="dialog" aria-hidden="true">
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
									<select id="select-bindDevice" class="form-control btn-input">
										<?php getDeviceString("addController");?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4">输入控制器的名称</label>
								<div class="col-md-8">
									<input size="16" type="text" id="controllerName" class="form-control">
								</div>
							</div>
							<div class="form-group last">
								<label class="control-label col-md-4">选择控制器类型</label>
								<div class="col-md-8">
									<select name="minbeds" id="controllerType" class="form-control btn-input">
										<?php 
											$typeArray = getControllerTypeName();
											foreach ($typeArray as $key => $value) {
												echo "<option>".$value["typeName"]."</option>";
											}
										?>
									</select>
								</div>
							</div>
							<div class="selectMode hide">
								<div class="form-group">
									<label class="control-label col-md-4">输入模式名(空格隔开)</label>
									<div class="col-md-8">
										<input id="modeNamesInput"  size="16" type="text" class="form-control">
									</div>
								</div>
							</div>
							<div class="sliderMode ObserveMode hide">
								<div class="form-group">
									<label class="control-label col-md-4" id="modeName">输入滑块控制范围</label>
									<div class="col-md-8">
										<input id="minValueInput" size="12" type="text" class="form-control btn-input" placeholder="最小值">
										—
										<input id="maxValueInput" size="12" type="text" class="form-control btn-input" placeholder="最大值">
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
						<button class="btn btn-warning" id="addControllerConfirm" type="button">确定</button>
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
	<script src="../js/common-scripts.js?v=1.4"></script>
</body>
</html>