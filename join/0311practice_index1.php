<?php

session_start();
require('../dbconnect.php');

echo '<br>'; echo '<br>';echo '<br>';echo '<br>';
echo '<pre>';
  var_dump($_POST);
  echo '</pre>';

if (!empty($_POST) && isset($_POST)) {

  $nick_name=htmlspecialchars($_POST['nick_name']);
  $email=htmlspecialchars($_POST['email']);
  $email_check=htmlspecialchars($_POST['email_check']);
  $password=htmlspecialchars($_POST['password']);

    if ($nick_name=='') {
      $error['nick_name']='blank'; }

    if ($email=='') {
      $error['email']='blank'; }

    if ($email_check=='') {
      $error['email_check']='blank'; }

    if ($password=='') {
      $error['password']='blank';
    }elseif (strlen($password)< 5) {
      $error['password']='length';}


    if (!isset($error)) {

      if ($email!==$email_check) {
        $error['email_check']='email_check';}

        $sql_select='SELECT COUNT(*) AS `duplicated` FROM `members` WHERE `  email`=?';
        $data_select=array($email);
        $stmt_select=$dbh->prepare($sql_select);
        $stmt_select->execute($data_select);

        $duplicated=$stmt_select->fetch(PDO::FETCH_ASSOC);

        if($duplicated['duplicated']>=1){
          $error['email']= 'duplicated';}
    }

    if (!isset($error)) {


// var_dump($_FILES);

// exit();

      $ext=substr($_FILES['picture_path']['name'], -3);
      $ext=strtolower($ext);

      if ($ext == 'jpg' || $ext == 'png') {

        $picture_path= date(YmdHis).$_FILES['picture_path']['name'];

        move_uploaded_file($_FILES['picture_path']['tmp_name'], '../picture_path/'.$picture_path);

        $_SESSION['join']=$_POST;
        $_SESSION['join']['picture_path']=$picture_path;

         header('Location: 0311practice_check.php');

        exit();
}
      }else{
        $error['image']='type';}

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
    <!--
      designフォルダ内では2つパスの位置を戻ってからcssにアクセスしていることに注意！
     -->

  </head>
  <body>
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.html"><span class="strong-title"><i class="fa fa-twitter-square"></i> Seed SNS</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>
  <form action="" method="POST" enctype="multipart/form-data">
  
          <div class="container">
            <div class="row">
              <div class="col-md-6 col-md-offset-3 content-margin-top">
                <legend>会員登録</legend>
                <form method="post" action="" class="form-horizontal" role="form      " enctype="miultipart/form-data">
                  <!-- ニックネーム -->
                  <div class="form-group">
                    <label class="col-sm-4 control-label">ニックネーム</label>
                    <div class="col-sm-8">
                      <input type="text" name="nick_name" class="form-control"         placeholder="例： Seed kun">
                    </div>
                    
      <?php if (isset($error['nick_name']) && $error['nick_name']=='blank') { ?>
                    <p class="error">ニックネームを入力してください</p>
      <?php } ?>

                  </div>
                  <!-- メールアドレス -->
                  <div class="form-group">
                    <label class="col-sm-4 control-label">メールアドレス</label>
                    <div class="col-sm-8">
                      <input type="email" name="email" class="form-control"         placeholder="例： seed@nex.com">
                    </div>
     <?php if (isset($error['email']) && $error['email']=='blank') { ?>
                    <p class="error">emailを入力してください</p>
      <?php } ?>     
       <?php if (isset($error['email']) && $error['email']=='duplicated') { ?>
                    <p class="error">emailの重複です</p>
      <?php } ?>            
                  </div>
      
                  <!-- メールアドレス -->
                  <div class="form-group">
                    <label class="col-sm-4 control-label">メールアドレス</label>
                    <div class="col-sm-8">
                      <input type="email" name="email_check" class="form-control      "   placeholder="例： seed@nex.com">
                    </div>
      <?php if (isset($error['email_check']) && $error['email_check']=='email_check') { ?>
                    <p class="error">emailが間違っています</p>
      <?php } ?> 
                  </div>
      
                  <!-- パスワード -->
                  <div class="form-group">
                    <label class="col-sm-4 control-label">パスワード</label>
                    <div class="col-sm-8">
                      <input type="password" name="password" class="form-control      "   placeholder="">
                    </div>
      <?php if (isset($error['password']) && $error['password']=='blank') { ?>
                    <p class="error">passwordを入力してください</p>
      <?php } ?>
      <?php if (isset($error['password']) && $error['password']=='length') { ?>
                    <p class="error">passwordの文字数が足りません</p>
      <?php }  ?>
                  </div>
                  <!-- プロフィール写真 -->
                  <div class="form-group">
                    <label class="col-sm-4 control-label">プロフィール写真</label>
                    <div class="col-sm-8">
                      <input type="file" name="picture_path" class="form-control      ">
                    </div>
                  </div>
                  <input type="submit" class="btn btn-default" value="確認画面へ">
                </form>
              </div>
            </div>
          </div>

  </form>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../assets/js/jquery-3.1.1.js"></script>
    <script src="../assets/js/jquery-migrate-1.4.1.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
  </body>
</html>