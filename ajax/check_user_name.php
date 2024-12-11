<?php 
	include '../userLogin/db_con.php';

  	$userName = $_GET['user_name'];

  $query = "select count(*) as `count` 
from `users` 
where `name` = '$name';";
  $stmt = $con->prepare($query);
  $stmt->execute();

	$r = $stmt->fetch(PDO::FETCH_ASSOC);
  $count = $r['count'];

  echo $count;

?>