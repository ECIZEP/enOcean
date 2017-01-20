<?php 
	include("header.php");
?>
<!-- profile content start -->
<div class="content">
	<div class="row">
		<div class="profile-header row-margin clearfix">
			<div class="col-sm-3 text-right">
				<a class="head-img">
					<img class="photoUrl" width="110" height="110" src="<?php echo get_photoUrl(); ?>">
				</a>
			</div>
			<div class="col-sm-9 text-left bind-info">
				<p class="nickname"><?php echo get_nickname(); ?></p>
				<div>
					<span><i class="fa fa-envelope"></i><?php echo get_email(true); ?></span>
					<span><i class="fa fa-phone"></i><?php echo get_phone_number(true); ?></span>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-info">
		<div class="panel-body bg-white">
			<form class="form-horizontal tasi-form">
				<div class="form-group">
					<label class="col-sm-2 col-xs-4 control-label">用户名</label>
					<div class="col-sm-10 col-xs-8">
						<input type="text" id="username-profile" class="form-control" disabled value="<?php echo get_username(); ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-xs-4 control-label">昵称</label>
					<div class="col-sm-10 col-xs-8">
						<input type="text" id="nickname-profile" class="form-control" value="<?php echo get_nickname(); ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-xs-4 control-label">修改头像</label>
					<div class="col-sm-10 col-xs-8">
						<div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden">
							<div class="fileupload-new thumbnail">
								<img src="../images/no-image.png" alt="">
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;"></div>
							<div>
								<span class="btn btn-white btn-file">
									<span class="fileupload-new"><i class="fa fa-paper-clip"></i>选择图片</span>
									<span class="fileupload-exists"><i class="fa fa-undo"></i> 更换</span>
									<input id="file" type="file" class="default">
								</span>
								<a id="photo-remove" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> 移除</a>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-xs-4 control-label">邮箱</label>
					<div class="col-sm-10 col-xs-8">
						<p class="form-control-static"><?php echo get_email(); ?>
						</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-xs-4 control-label">手机号码</label>
					<div class="col-sm-10 col-xs-8">
						<p class="form-control-static"><?php echo get_phone_number(); ?>
						</p>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">个性签名</label>
					<div class="col-sm-10">
						<input type="text" id="personal-profile" class="form-control round-input" value="<?php echo get_personal(); ?>">
					</div>
				</div>
				<div class="text-right">
					<button type="button" id="profile-update" class="btn btn-info " disabled>
						<i class="fa fa-refresh"></i> 更新资料
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- profile content end -->

<?php 
	include("footer.php");
?>