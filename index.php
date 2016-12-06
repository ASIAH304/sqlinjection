<?php 
include("dbconn.php");
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
		<h1>成績管理系統</h1>
	</div>
	<div class="well">
		<h2>說明</h2>
		<li>您必須透過 SQL injection 獲取 <span class="label label-danger">管理員</span>帳號，才可進行第二關。</li>
		<li>請善用系統提供給你的 <span class="label label-info">SQL 語法</span>。</li>
		<li>若發生 <code>Fatal error: Call to a member function fetch_object()</code> 類似的錯誤，這並非系統設計瑕疵，而是你的 SQL 語法錯誤。</li>
		<li>注意：為了避免資料遺失，資料庫管理帳號僅有 <code>SELECT</code> 及 <code>UPDATE</code> 權限 </li>
	</div>
	<?php 
		if( isset($_POST['account']) && isset($_POST['password']) ){
			$sql = "SELECT * FROM admin WHERE account = '{$_POST['account']}' and password = '{$_POST['password']}' and is_admin = 1";
			$result = mysqli_query($db, $sql, MYSQLI_USE_RESULT);
			$row = $result->fetch_object();
			if( is_null($row) ){
				echo '<script>alert("登入失敗");</script>';
			}else{
				$_SESSION['account'] = $row->account;
				$_SESSION['is_admin'] = $row->is_admin;
				echo '<script>alert("登入成功 sql=>> '.$sql.' ");window.location = "admin.php";</script>';
			}?>
	<div class="panel panel-primary">
		<div class="panel-heading">SQL 語法</div>
		<div class="panel-body">
			<pre><?php echo htmlentities($sql, ENT_QUOTES, 'utf-8') ?></pre>
		</div>
	</div>
	<?php }else{?>
	<div class="panel panel-primary">
		<div class="panel-heading">SQL 語法</div>
		<div class="panel-body">
			<pre>SELECT * FROM admin WHERE account = '{$_POST['account']}' and password = '{$_POST['password']}' and is_admin = 1</pre>
		</div>
	</div>
	<?php }?>
	<form class="form-horizontal" method="post">
		<div class="form-group">
			<label class="col-sm-2 control-label">Account</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" placeholder="Account" name="account">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Password</label>
			<div class="col-sm-10">
				<input type="password" class="form-control" placeholder="Password" name="password">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">Sign in</button>
			</div>
		</div>
	</form>
	<?php $admins = array(); ?>
	<?php if( isset($_GET['q'])  ){ 
		$sql = "SELECT * FROM admin WHERE {$_GET['q']} limit 1";
		$result = mysqli_query($db, $sql, MYSQLI_USE_RESULT);
		while ($row = $result->fetch_object()){
			$admins[] = $row;
		}
	?>
	<div class="panel panel-primary">
		<div class="panel-heading">SQL 語法</div>
		<div class="panel-body">
			<pre><?php echo htmlentities($sql, ENT_QUOTES, 'utf-8') ?></pre>
		</div>
	</div>
	<?php }else{?>
	<div class="panel panel-primary">
		<div class="panel-heading">SQL 語法</div>
		<div class="panel-body">
			<pre>SELECT * FROM admin WHERE {$_GET['q']} limit 1</pre>
		</div>
	</div>
	<?php }?>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>帳號(id)</th>
				<th>管理員(score)</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($admins as $key => $admin): ?>
			<tr>
				<td><?php echo $admin->account ?></td>
				<td><?php echo $admin->is_admin ?></td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</body>
</html>
