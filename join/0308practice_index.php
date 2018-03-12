<?php

session_start();
require('../dbconnect.php');

echo '<br>';echo '<br>';echo '<br>';
var_dump($_POST);



if (!empty($_POST)) {
  if ($_POST['nickname']=='') {
   $error['nickname'] = 'blank';}

  if ($_POST['email']=='') {
   $error['email'] = 'blank';}

  if ($_POST['password']=='') {
   $error['password'] = 'blank';}elseif(strlen($_POST['password'])<4) {
    $error['password']='length';}


  if (!isset($error)) {
  $sql_select='SELECT COUNT(*) AS `count` FROM `members` WHERE `email`=?';
  $data_select=array($_POST['email']);
  $stmt_select=$dbh->prepare($sql_select);
  $stmt_select->execute($data_select);
  $members=$stmt_select->fetch(PDO::FETCH_ASSOC);

    if ($members['count'] >=1) {
    $error['email']='duplicated';}
// echo '<br>'; echo '<br>'; echo '<br>'; echo '<br>';
//   var_dump($members);
      if (!isset($error)) {
      $ext= substr($_FILES['picture']['name'], -3);
      $ext=strtolower($ext);

        if ($ext='jpg' || $ext='png') {
        $picture_path = date(YmdHis).$_FILES['picture']['name'];

        move_uploaded_file($_FILES['picture']['tmp_name'], '../picture_path/'.$pictue_path);

$_SESSION['a']=$_POST;

        header('Location: 0308practice_check.php');

        exit();
        }else{
          $error['image']='type';
        }
}
  }

}

 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>0309practice会員登録</title>
</head>
<body>
  <h1>会員登録</h1>
  <form action="" method="POST" enctype="multipart/form-data">
    <div>
      <h1>nickname</h1>
      <input type="text" name="nickname">
     
      <?php if (isset($error['nickname']) && $error['nickname']='blank') {
        echo '*nicknameは必須です';} ?>

    </div>
    <div>
      <h1>email</h1>
      <input type="text" name="email">

       <?php if (isset($error['email'])){
               if($error['email']=='blank'){ echo '*emailは必須です';}
               elseif ($error['email']=='duplicated') { echo 'emailが重複です';
        }} ?>

    </div>
    <div>
      <h1>password</h1>
      <input type="password" name="password">
    </div>
    <div>
      <h1>picture</h1>
      <input type="file" name="picture">
    </div>
      <input type="submit" value="登録">
  </form>
</body>
</html>