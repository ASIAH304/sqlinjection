<?php 
include("dbconn.php");
if( !isset( $_SESSION['account'] ) ){
	echo '<script>alert("請先登入");window.location = "index.php";</script>';
	exit();
}
$_SESSION['level'] = 2;
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
		<h1>成績管理系統 學生成績查詢</h1>
		<a href="logout.php">登出</a>
	</div>
	<?php if( $_SESSION['is_admin'] != 1 ){?>
	<div class="alert alert-danger">很可惜，你登入的不是管理員，請 <a href="logout.php">登出</a> 重新嘗試</div>
	<?php }else{?>
	<div class="alert alert-success">管理員 <?php echo $_SESSION['account'] ?> 您好</div>

	<div class="well">
		<h2>說明</h2>
		<li>您必須透過 SQL injection 獲取 <span class="label label-danger">所有學生</span>成績，才可進行第三關。</li>
		<li>請善用系統提供給你的 <span class="label label-info">SQL 語法</span>。</li>
		<li>若發生 <code>Fatal error: Call to a member function fetch_object()</code> 類似的錯誤，這並非系統設計瑕疵，而是你的 SQL 語法錯誤。</li>
		<li>注意：為了避免資料遺失，資料庫管理帳號僅有 <code>SELECT</code> 及 <code>UPDATE</code> 權限 </li>
	</div>
	<?php 
		$students = array();
		if( isset($_GET['id'])  ){
			$sql = "SELECT * FROM student WHERE id = {$_GET['id']} limit 1";
			$result = mysqli_query($db, $sql, MYSQLI_USE_RESULT);
			while ($row = $result->fetch_object()){
				$students[] = $row;
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
			<pre>SELECT * FROM student WHERE id = {$_GET['id']} limit 1</pre>
		</div>
	</div>
	<?php }?>
	<?php if( count($students) >= 100 ){?>
	<?php $_SESSION['level'] = 3;?>
	<div class="alert alert-info">下一關：<a href="page.php">前往</a></div>
	<?php }?>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>學號(id)</th>
				<th>姓名(name)</th>
				<th>成績(score)</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($students as $key => $student): ?>
			<tr>
				<td><?php echo $student->id ?></td>
				<td><?php echo $student->name ?></td>
				<td><?php echo $student->score ?></td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<?php }?>
</body>
</html>
