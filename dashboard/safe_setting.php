<?php 
	include("header.php");
?>
<!-- main content start -->
<div class="content">
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<header class="panel-heading">
					安全设置
				</header>
				<div class="panel-body bg-white">
					<form class="form-horizontal tasi-form" method="get">
						<div class="form-group">
							<label class="col-sm-2 col-xs-4 control-label">更改邮箱</label>
							<label class="col-sm-6 col-xs-8 control-label">
								你当前的邮箱是：<?php echo get_email()?>		
							</label>
							<div class="col-sm-4 col-xs-12">
								<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal1"><i class="fa fa-pencil"></i> 更改</button>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 col-xs-4 control-label">换绑手机</label>
							<label class="col-sm-6 col-xs-8 control-label" id="phoneLabel">
								你当前的手机号是：<span><?php echo get_phone_number()?></span>
							</label>
							<div class="col-sm-4 col-xs-12">
								<button type="button" class="btn btn-info" data-toggle="modal" data-target="#changePhoneModal"><i class="fa fa-pencil"></i> 更改</button>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 col-xs-4 control-label">更改密码</label>
							<label class="col-sm-6 col-xs-8 control-label">建议您90天更换一次密码</label>
							<div class="col-sm-4 col-xs-12">
								<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal3"><i class="fa fa-pencil"></i> 更改</button>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 col-xs-4 control-label">联系地址</label>
							<div class="col-sm-6 col-xs-8">
								<input type="text" id="address" class="form-control round-input" value="<?php echo get_address()?>">
							</div>
							<div class="col-sm-4 col-xs-12">
								<button type="button" id="addressBtn" class="btn btn-info" disabled="true"><i class="fa fa-pencil"></i> 更改</button>
							</div>
						</div>
						
					</form>
				</div>
			</section>
		</div>
	</div>
</div>
<!-- main content end -->

<!-- modal dialog start -->
<div class="modal fade modal-dialog-center" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog ">
		<div class="modal-content-wrap">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">修改邮箱</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
					<div class="form-group last">
							<label class="control-label col-md-3">更改的邮箱</label>
							<div class="col-md-6">
								<input size="16" id="myModal1Input" type="text" class="form-control">
							</div>
						</div>
					</form>

				</div>
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
					<button class="btn btn-warning" id="myModal1Confirm" type="button">确定</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade modal-dialog-center" id="changePhoneModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog ">
		<div class="modal-content-wrap">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">换绑手机</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
						<div class="form-group last">
							<label class="control-label col-md-4">更改的手机号</label>
							<div class="col-md-8">
								<input size="16" id="changePhoneInput" type="text" class="form-control">
							</div>
						</div>
						<div class="form-group last">
							<label class="control-label col-md-4">验证码</label>
							<div class="col-md-8">
								<input size="16" type="text" class="form-control btn-input verifycodeInput">
								<button value="change_phoneNumber" data-phoneNumber="<?php echo get_phone_number();?>" class="btn btn-success pull-right sendMessage" type="button">发送验证码</button>
							</div>
							
						</div>
					</form>

				</div>
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
					<button class="btn btn-warning" id="changePhoneConfirm" type="button">确定</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade modal-dialog-center" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog ">
		<div class="modal-content-wrap">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">修改密码</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-md-4">输入原密码</label>
							<div class="col-md-8">
								<input size="16" type="password" id="password" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4">输入新密码</label>
							<div class="col-md-8">
								<input size="16" type="password" id="newPassword" class="form-control">
							</div>
						</div>
						<div class="form-group last">
							<label class="control-label col-md-4">再输入一遍新密码</label>
							<div class="col-md-8">
								<input size="16" type="password" id="newPassword2" class="form-control">
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
					<button class="btn btn-warning" id="myModal3Confirm" type="button">确定</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 
	include("footer.php");
?>