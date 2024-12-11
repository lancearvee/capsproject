<?php
function verify_login_admin($pdo, $username, $password) {
$query = $pdo->query("select * from tbl_users where username = '$username'");
while($row=$query->fetch())
{
  if($row["pass"]==$password)
  {
    $statement = $pdo->query("select * from tbl_users where username = '$username'");
    $row = $statement->fetch();
    $_SESSION['access_level'] = $row['access_level'];
    return $row;
  }
}
  
} // end verify_login_admin


function get_user_data_admin($pdo, $username) {
	//$user = ["username"];
	//$query = $pdo->query("select * from tbl_users where username = '$user'");
	$statement = $pdo->query("select * from tbl_users where username = '$username'");
  	return $statement->fetch();
}
?>