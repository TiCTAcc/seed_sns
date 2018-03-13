<?php

session_start();
// require('dbconnect.php');

$_SESSION=array();

if (ini_get('session.use_cookies')) {
  $params=session_get_cookie_params();
  setcookie(session_name(),'',time()-42000, $params['path'],$params['domain'],$sparam['secure'],$sparam['httponly']);
}

session_destroy();

 setcookie('email', '', time() - 3000);
    setcookie('password', '', time() - 3000);

    header('Location: index.php');
exit;




 ?>