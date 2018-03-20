<?php

session_start();
require('dbconnect.php');

echo '<br>';echo '<br>';echo '<br>';echo '<br>';
// var_dump($_SESSION);
if (isset($_SESSION['id']) && $_SESSION['time']+3600>time()) {
  $_SESSION['time']=time();
// loginした人の情報、nick_name取得
$sql='SELECT * FROM `members` WHERE `member_id`=?';
$data=array($_SESSION['member_id']);
$stmt=$dbh->prepare($sql);
$stmt->execute($data);
$id=$stmt->fetch(PDO::FETCH_ASSOC);
}else{
  header('Location: 4login.php');
  exit;
}
// つぶやきinsert
if (!empty($_POST) && isset($_POST)) {
   if ($_POST['tweet'] == '') {
      $error['tweet'] = 'blank';
    }
    if (!isset($error)) {
  $sql_insert='INSERT INTO `tweets` SET `tweet`=?,`member_id`=?,`reply_tweet_id`=?,`created`=NOW(),`modified`=NOW()';
  $data_insert=array($_POST['tweet'],$_SESSION['member_id'],-1);
  $stmt_insert=$dbh->prepare($sql_insert);
  $stmt_insert->execute($data_insert);
}
}

// page機能
// issetでerror
$page='';
if (!empty($_GET('page'))) {
  $page=$_GET['page'];
}else{
  $page=1;
}

$page=max($page,1);
$page_tweet_number=5;
$sql_page='SELECT COUNT(*) AS `page_number` FROM `tweets` WHERE `delete_flag`=0';
$stmt_page=$dbh->prepare($sql_page);
$stmt_page->execute();
$page_number=$stmt_page->fetch(PDO::FETCH_ASSOC);
$max_page_number=ceil($page_number['page_number']);

$page=min($max_page_number,$page);

$start=($page-1)*$page_tweet_number;



// 全件取得
$sql_select="SELECT `tweets`.*, `members`.`nick_name`,`members`.`picture_path` FROM `tweets` LEFT JOIN `members` ON `tweets`.`member_id`=`members`.`member_id` WHERE `delete_flag`=0 ORDER BY `modified` DESC LIMIT".$start.",".$page_tweet_number;
$stmt_select=$dbh->prepare($sql_select);
$stmt_select->execute();
$tweets_info=array();
while (true) {
  $tweet_info=$stmt_select->fetch(PDO::FETCH_ASSOC);
  if ($tweet_info== false) {
    break;
  }
  $tweets_info[]=$tweet_info;
}

// echo '<pre>';
// var_dump($tweets_info);
// echo '</pre>';






 ?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SeedSNS</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/form.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

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
                <li><a href="logout.html">ログアウト</a></li>
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-4 content-margin-top">
        <legend>ようこそ
<?php echo $id['nick_name']; ?>
        さん！</legend>
        
        <form method="post" action="" class="form-horizontal" role="form">
            <!-- つぶやき -->

            <div class="form-group">
              <label class="col-sm-4 control-label">つぶやき</label>
              <div class="col-sm-8">
                <textarea name="tweet" cols="50" rows="5" class="form-control" placeholder="例：Hello World!"></textarea>
              </div>
            </div>
          <ul class="paging">
            <input type="submit" class="btn btn-info" value="つぶやく">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <li><a href="5index.php?page=<?php $page-1; ?>" class="btn btn-default">前</a></li>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <li><a href="5index.php?page=<?php $page+1; ?>" class="btn btn-default">次</a></li>
          </ul>
        </form>
      </div>
      <?php foreach ($tweets_info as $one_tweet_info) { ?>
      <div class="col-md-8 content-margin-top">
        <div class="msg">
          <img src="picture_path/<?php echo $one_tweet_info['picture_path'] ?>" width="48" height="48">
          <p>
            <?php echo $one_tweet_info['tweet']; ?><span class="name"> (<?php echo $one_tweet_info['nick_name']; ?>) </span>
            <?php if ($_SESSION['member_id']!==$one_tweet_info['member_id']): ?>
            [<a href="9reply.php?action=reply&tweet_id=<?php echo $one_tweet_info['tweet_id']; ?>">Re</a>]
            <?php endif ?>
          </p>
          <p class="day">
            <a href="6view.php?action=view&tweet_id=<?php echo $one_tweet_info['tweet_id']; ?>">
             <?php echo $one_tweet_info['modified']; ?>
            </a>
            <?php if ($_SESSION['member_id']==$one_tweet_info['member_id']): ?>
              [<a href="8edit.php?action=update&tweet_id=<?php echo $one_tweet_info['tweet_id']; ?>" style="color: #00994C;">編集</a>]
            <?php endif ?>
            <?php if ($_SESSION['member_id']==$one_tweet_info['member_id']): ?>
            [<a href="7delete.php?action=delete&tweet_id=<?php echo $one_tweet_info['tweet_id']; ?>" style="color: #F33;">削除</a>]
            <?php endif ?>
          </p>
        </div>
      </div>
        <?php } ?>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery-3.1.1.js"></script>
    <script src="assets/js/jquery-migrate-1.4.1.js"></script>
    <script src="assets/js/bootstrap.js"></script>
  </body>
</html>
