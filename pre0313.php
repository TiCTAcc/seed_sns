<?php

$tweet_sql='SELECT * FROM `tweets` LEFT JOIN `members` ON `tweets`.`member_id`=`members`.`member_id`';


session_start();
require('dbconnect.php');
$_SESSION=array();

if (ini_get('session.use_cookies')) {
  $params=session_get_cookie_params();
  setcookie(session_name(),'',time()-42000,$params['path'],$params['domain'],$params['secure'],$params['httponly']);
}

session_destroy();

setcookie();

header('Location: index.php');
exit;

 ?>