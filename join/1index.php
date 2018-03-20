<?php
session_start();
require('../dbconnect.php');

// echo '<br>';echo '<br>';echo '<br>';echo '<br>';
// var_dump($_POST);

if (!empty($_POST)) {

// (1)バリエーション
  if ($_POST['nick_name']=='') {
    $error['nick_name']='blank';
  }
  if ($_POST['email']=='') {
    $error['email']='blank';
  }
  if ($_POST['password']=='') {
    $error['password']='blank';
  }elseif (strlen($_POST['password'])<4) {
    $error['password']='length';
  }


// (3)COUNT AS
if (!isset($error)) {
  $sql='SELECT COUNT(*) AS `count_email` FROM `members` WHERE `email`=?';
  $data=array($_POST['email']);
  $stmt=$dbh->prepare($sql);
  $stmt->execute($data);
  $members=$stmt->fetch(PDO::FETCH_ASSOC);

  if ($members['count_email']>=1) {
    $error['email']='duplicated';
  }

// (4)$_FILES
  // (5)pictureの扱い方
// (6)$_SESSION
  // (7)header(string)

if (!empty($_FILES) && isset($_FILES)) {
  if ($_FILES=='') {
    $error['picture_path']='blank';
  }else{
    $ext=substr($_FILES['picture_path']['name'], -3);
    $ext=strtolower($ext);
  if ($ext=='jpg') {
   $picture_path=date('YmdHis').$_FILES['picture_path']['name'];

   move_uploaded_file($_FILES['picture_path']['tmp_name'], "../picture_path/".$picture_path);

   $_SESSION['join']=$_POST;
   $_SESSION['join']['picture_path']=$picture_path;

echo '<br>';echo '<br>';echo '<br>';echo '<br>';
var_dump($_SESSION);
   header('Location: 2check.php');
   exit;
 }else{

$error['picture_path']='type';

 }
}
// end if (!empty($_FILES) && isset($_FILES))
}
}
// end if (!empty($_POST) && isset($_POST))
}
 ?>



<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SeedSNS</title>

    <!-- Bootstrap -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../assets/css/form.css" rel="stylesheet">
    <link href="../assets/css/timeline.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">


  </head>
  <body>
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">

          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.html"><span class="strong-title"><i class="fa fa-twitter-square"></i> Seed SNS</span></a>
          </div>

          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
              </ul>
          </div>

      </div>

  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3 content-margin-top">
        <legend>会員登録</legend>
        <!-- (2)multipart/form-data -->
        <form method="post" action="" class="form-horizontal" role="form" enctype="multipart/form-data">

          <div class="form-group">
            <label class="col-sm-4 control-label">ニックネーム</label>
            <div class="col-sm-8">
              <input type="text" name="nick_name" class="form-control" placeholder="例： Seed kun">
            </div>
            <?php if (isset($error['nick_name']) && $error['nick_name']=='blank') { ?>
            <p class="error">nick_nameが空欄です</p>
            <?php } ?>
          </div>

          <div class="form-group">
            <label class="col-sm-4 control-label">メールアドレス</label>
            <div class="col-sm-8">
              <input type="email" name="email" class="form-control" placeholder="例： seed@nex.com">
            </div>
            <?php if (isset($error['email']) && $error['email']=='blank') { ?>
            <p class="error">emailが空欄です</p>
            <?php } ?>
            <?php if (isset($error['email']) && $error['email']=='duplicated') { ?>
            <p class="error">emailが重複してます</p>
            <?php } ?>
          </div>

          <div class="form-group">
            <label class="col-sm-4 control-label">パスワード</label>
            <div class="col-sm-8">
              <input type="password" name="password" class="form-control" placeholder="">
            </div>
            <?php if (isset($error['password']) && $error['password']=='blank') { ?>
            <p class="error">passwordが空欄です</p>
            <?php }elseif (isset($error['password']) && $error['password']=='length') { ?>
            <p class="error">passwordがshortです</p>
            <?php } ?>
          </div>

          <div class="form-group">
            <label class="col-sm-4 control-label">プロフィール写真</label>
            <div class="col-sm-8">
              <input type="file" name="picture_path" class="form-control">
            </div>
            <?php if (isset($error['picture_path']) && $error['picture_path']=='blank') { ?>
            <p class="error">pictureが空欄です</p>
            <?php } ?>
            <?php if (isset($error['picture_path']) && $error['picture_path']=='type') { ?>
            <p class="error">拡張子の変更が必要です</p>
            <?php } ?>
          </div>

          <input type="submit" class="btn btn-default" value="確認画面へ">
        </form>
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../assets/js/jquery-3.1.1.js"></script>
    <script src="../assets/js/jquery-migrate-1.4.1.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
  </body>
</html>
