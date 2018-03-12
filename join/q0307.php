<?php
require('dbconnect_join.php');

if (empty($_POST)) {
  echo '入力';
}else{
  echo 'ok';
}

var_dump($_POST);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>会員登録(practice4)</title>
</head>
<body>
  <h1>会員登録</h1>
    <form action="" method="POST">
      <div>
        <h2>name:</h2><br>
        <input type="text" name="name">
      </div>
      <div>
        <h2>email:</h2><br>
        <input type="text" name="email">
      </div>
      <div>
        <h2>password:</h2><br>
        <input type="password" name="password">
      </div>
      <div>
        <h2>picture:</h2><br>
        <input type="file" name="picture">
      </div>
      <div>
        <input type="submit" value="送信">
      </div>
    </form>  
</body>
</html>
