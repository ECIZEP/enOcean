<?php 
include("header.php");
if(!isset($_SESSION)){
	session_start();
}
$start = 0;
$sql_count = DBManager::query_mysql("select count(*) from logbook where username = '{$_SESSION['username']}'")["0"]["0"];
$pageCount = (int)($sql_count/15 + 1);
if(isset($_GET['page'])){
	$start = $_GET['page']*15 - 15;
}
$sql = "select * from logbook where username = '{$_SESSION['username']}' order by logDate DESC limit ".$start.",15";
$records = DBManager::query_mysql($sql);

function getCountString($start,$sql_count){
	if($sql_count == 0){
		return "你可能加载了假数据库，暂无记录";
	}
	if($start+15 < $sql_count){
		return ($start+1)."到".($start+15)."条，共".$sql_count."条记录";
	}else{
		return ($start+1)."到".$sql_count."条，共".$sql_count."条记录";
	}
	
}

function getPagination($pageCount){
	if(isset($_GET["page"])){
		$currentPage = $_GET["page"];
	}else{
		$currentPage = 1;
	}
	echo '<li class="prev"><a href="'.$_SERVER['PHP_SELF'].'?page=1">首页</a></li>';
	if($currentPage == 1){
		echo '<li class="disabled"><a>1</a></li>';
		if($pageCount > 1){
			echo '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.($currentPage+1).'">2</a></li>';
		}
		echo '<li><a>...</a></li>';
	}else{
		echo '<li class="prev"><a href="'.$_SERVER['PHP_SELF'].'?page='.($currentPage-1).'">上一页</a></li>';
		echo '<li><a>...</a></li>';
		echo '<li class="disabled"><a>'.$currentPage.'</a></li>';
		echo '<li><a>...</a></li>';
	}
	if($currentPage != $pageCount){
		echo '<li class="next"><a href="'.$_SERVER['PHP_SELF'].'?page='.($currentPage+1).'">下一页</a></li>';
		echo '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$pageCount.'">尾页</a></li>';
	}else{
		echo '<li class="disabled"><a href="'.$_SERVER['PHP_SELF'].'?page='.$pageCount.'">尾页</a></li>';
	}
	

}


?>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<header class="panel-heading">
					操作记录
					<span class="tools pull-right">
						<a href="javascript:;" class="fa fa-chevron-down"></a>
						<a href="javascript:;" class="fa fa-times"></a>
					</span>
				</header>
				<div class="panel-body">
					<div class="row no-padding">
						<div class="col-sm-8 col-xs-8">
							<select name="minbeds" id="minbeds" style="width: auto;display: inline-block;" class="form-control bound-s">
								<option>10</option>
								<option>20</option>
								<option>30</option>
							</select>
							&nbsp;&nbsp;&nbsp;条/每页
						</div>
						<div class="col-sm-4 col-xs-4">
							<div class="btn-group pull-right">
								<button class="btn btn-danger" ><i class="fa fa-trash-o"></i> 批量删除
								</button>
							</div>
						</div>
					</div>
					<table class="table table-bordered table-striped table-advance table-hover">
						<thead>
							<tr>
								<th></th>
								<th>时间</th>
								<th>内容</th>
								<th>删除</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								foreach ($records as $key => $value) {
									echo '<td><label class="label_check c_off"><input name="sample-checkbox-02" id="checkbox-03" value="1" type="checkbox">&nbsp;</label></td><td>';
									echo $value["logDate"]."</td><td>".$value["content"]."</td>";
									echo '<td><button type="button" class="btn btn-danger btn-sm">&nbsp;<i class="fa fa-trash-o "></i>&nbsp;</button></td></tr>';
								}
							?>
						</tbody>
					</table>
					<div class="row no-padding">
						<div class="col-sm-4">
							<div class="dataTables_info" id="hidden-table-info_info"><?php echo getCountString($start,$sql_count);?></div>
						</div>
						<div class="col-sm-8">
							<ul class="pagination dataTables_info pull-right">
								<?php getPagination($pageCount) ?>
							</ul>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</section>

<?php 
include("footer.php");
?>