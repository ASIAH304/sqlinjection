<?php 
include("dbconn.php");
if( !isset( $_SESSION['account'] ) ){
	echo '<script>alert("請先登入");window.location = "index.php";</script>';
	exit();
}
if( $_SESSION['level'] > 2 ){
	$_SESSION['level'] = 3;
}else{
	echo '<script>alert("別跳關唷 =) ");window.location = "index.php";</script>';
	exit();
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>成績管理系統</title>
	<link rel="stylesheet" href="bootstrap.min.css">
</head>
<body class="container">
	<div class="page-header">
		<h1>成績管理系統 學生成績修改</h1>
	</div>
	<div class="well">
		<h2>說明</h2>
		<li>您必須透過 SQL injection 更改 <span class="label label-danger">所有學生</span>成績。</li>
		<li>請善用系統提供給你的 <span class="label label-info">SQL 語法</span>。</li>
		<li>若發生 <code>Fatal error: Call to a member function fetch_object()</code> 類似的錯誤，這並非系統設計瑕疵，而是你的 SQL 語法錯誤。</li>
		<li>注意：為了避免資料遺失，資料庫管理帳號僅有 <code>SELECT</code> 及 <code>UPDATE</code> 權限 </li>
	</div>
	<?php  if( isset($_POST['score']) && isset($_GET['id']) ){
			$sql = "UPDATE student SET score = {$_POST['score']} WHERE id = {$_GET['id']}";
			if( mysqli_query($db, $sql, MYSQLI_USE_RESULT) ){?>
			<div class="alert alert-success">成功更改 <?php echo $db->affected_rows ?> 位學生</div>
				<?php if( $db->affected_rows >= 100){?>
				<div class="alert alert-info">恭喜您完成基礎關卡！！請停留此畫面：<?php echo date("Y-m-d H:i:s")?></div>
				<script>alert("恭喜您完成基礎關卡！！請停留此畫面：<?php echo date("Y-m-d H:i:s")?>");</script>
				<?php }?>
			<?php }else{?>
			<div class="alert alert-danger">更改學生成績失敗</div>
			<?php }?>
		
		<div class="panel panel-primary">
			<div class="panel-heading">SQL 語法</div>
			<div class="panel-body">
				<pre><?php echo htmlentities($sql, ENT_QUOTES, 'utf-8') ?></pre>
			</div>
		</div>
	<?php }else{?>
		<?php if( isset($_GET['id']) ){?>
		<div class="panel panel-primary">
			<div class="panel-heading">SQL 語法</div>
			<div class="panel-body">
				<pre>UPDATE student SET score = {$_POST['score']} WHERE id = <?php echo htmlentities($_GET['id'], ENT_QUOTES, 'utf-8') ?></pre>
			</div>
		</div>
		<?php }else{?>
		<div class="panel panel-primary">
			<div class="panel-heading">SQL 語法</div>
			<div class="panel-body">
				<pre>UPDATE student SET score = {$_POST['score']} WHERE id = {$_GET['id']}</pre>
			</div>
		</div>
		<?php }?>
	<?php }?>
	<form class="form-horizontal" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
		<div class="form-group">
			<label class="col-sm-2 control-label">Score</label>
			<div class="col-sm-10">
				<input type="number" class="form-control" placeholder="Score" name="score">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">Update</button>
			</div>
		</div>
	</form>
</body>
</html>
