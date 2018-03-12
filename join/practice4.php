<?php
require('dbconnect_join.php');

if (!empty($_POST)) {
  if ($_POST['name']=='') {
$error['name']= 'blank'; }

  if ($_POST['email']=='') {
$error['email']= 'blank'; }

  if ($_POST['password']=='') {
$error['password']= 'blank'; }

  if (strlen($_POST['password'])<4) {
$error['password'] = 'length'; }
}

echo 'var_dump($_POST)'.'<br>';
var_dump($_POST);
echo '<br>';

if (empty($_POST)){
  echo 'empty'.'<br>';}
elseif (!empty($_POST)) {
  echo 'not empty'.'<br>';}
echo '<br>';

echo 'var_dump($error)'.'<br>';
var_dump($error);
echo '<br>';

if (!isset($error) && !empty($_POST['email'])) {
  $sql_select='SELECT COUNT(*) AS `email_count` FROM `members` WHERE `email`=?';
  $data_select=array($_POST['email']);
  $stmt_select=$dbh->prepare($sql_select);
  $stmt_select->execute($data_select);

  $email_count=$stmt_select->fetch(PDO::FETCH_ASSOC); 
  
  if ($mail_count['email_count']>= 1) {
    $error['email']='duplicated';}
}

echo 'var_dump($email_count)'.'<br>';
var_dump($email_count);
echo '<br>';

echo 'var_dump($email_count [email_count])'.'<br>';
var_dump($email_count['email_count']);
echo '<br>';

if (!empty($_POST) && !isset($error) && !empty($_FILES)) {

$ext=substr($_FILES['picture'], -3);

if ($ext =='jpg' || $ext == 'png') {
  $picture=date('YmdHis').$_FILES['picture']['name'];

  move_uploaded_file($_FILES['picture']['tmp_name'], '../picture_path/'.$picture);

}else{
  $error['image'] ='type';
}
}

if (!empty($_POST) && !isset($error)) {

  $_SESSION['join']=$_POST;
  $_SESSION['join']['picture']=$picture;

}

echo 'var_dump($_FILES_picture)';
var_dump($_FILES['picture']);
echo '<br>';

echo 'var_dump($_FILES)'.'<br>';
var_dump($_FILES);
echo '<br>';


if (!isset($error) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {

$name=htmlspecialchars($_POST['name']);
$email=htmlspecialchars($_POST['email']);
$password=htmlspecialchars($_POST['password']);

$sql_insert='INSERT INTO `practice3` SET `name`=?, `email`=?, `password`=?';
$data_insert=array($name, $email,$password);
$stmt_insert=$dbh->prepare($sql_insert);
$stmt_insert->execute($data_insert);


}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>会員登録(practice4)</title>
</head>
<body>
  <h1>会員登録</h1>
    <form action="" method="POST" enctype="multipart/form-data">
      <div>
        <h2>name:</h2><br>
        <input type="text" name="name">

<?php  if (isset($error['name']) && $error['name']=='blank') {
      echo '<p>nameが入力されていません</p>'; }?>

      </div>
      <div>
        <h2>email:</h2><br>
        <input type="text" name="email">

<?php  if (isset($error['email']) && $error['email']=='blank') {
      echo 'emailが入力されていません'; } elseif (isset($error['email']) && $error['email']=='duplicated') {
      echo 'emailの重複'; } ?>

      </div>
      <div>
        <h2>password:</h2><br>
        <input type="password" name="password">

<?php  if (isset($error['password']) && $error['password']=='blank') {
      echo 'passwordが入力されていません'; }
      elseif (isset($error['password']) && $error['password']=='length') {
      echo 'passwordの長さが足りません';  }?>

      </div>
      <div>
        <h2>picture:</h2><br>
        <input type="file" name="picture">
        <?php if (isset($error['image']) && $error['image']=='type') {
        echo '拡張子が違います。';
        } ?>
      </div>
      <div>
        <input type="submit" value="送信">
      </div>
    </form>  
</body>
</html>
