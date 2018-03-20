
<!-- index0307/0307hw/thanks/login0309class/index0309class/logout0312class -->

<!-- index0307/0307hw/thanks/re_login/0313index_pre/logout0312class/update0313/ -->


<?php

session_start();
require('dbconnect.php');
// (1)0312
// もともと入っていた情報を初期化
$_SESSION=array();

// (2)ini_get
// (3)setcookie(name)のnew version
// 有効期限切れにする
if (ini_get('session.use_cookies')) {
  $params = session_get_cookie_params();
  setcookie(session_name(),'',time()-42000,$params['path'],$params['domain'],$params['secure'],$params['httponly']);
}

// (4)sessionの情報を削除
session_destroy();

// (5)cookieの情報削除
setcookie('email', '', time()-3000);
setcookie('password', '', time()-3000);

// (6)ログアウト機能が実装されているかの確認
header('Location: 0313index_pre.php');
exit;
// (7)logout->index->loginの流れで
// indexの
// if (!isset($_SESSION['id'])) {
//  header('Location: login0309class.php');
// exit;}
// に行ってこれが成立してloginの画面に飛ぶ
 ?>