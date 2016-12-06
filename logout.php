<?php 
include("dbconn.php");
session_destroy();
echo '<script>alert("Session 已清除!!");window.location = "index.php";</script>';
exit();
?>