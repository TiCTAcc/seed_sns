<!-- index0307/0307hw/thanks/login0309class/index0309class/logout0312class -->


<?php
session_start();
require('dbconnect.php');

// echo '<br>';echo '<br>';echo '<br>';
// echo '<pre>';
// var_dump($_SESSION);
// echo '<br>';
// var_dump($_POST);
// echo '</pre>';

// (8)0312ログインのcheckの強化
if (!isset($_SESSION['id']) && $_SESSION['time']+3600 >time()) {
$_SESSION['time']=time();

// ログインしているユーザーの情報を取得
  $login_sql = 'SELECT * FROM `members` WHERE `member_id`=?';
  $login_data = array($_SESSION['id']);
  $login_stmt = $dbh->prepare($login_sql);
  $login_stmt->execute($login_data);
  $login_member = $login_stmt->fetch(PDO::FETCH_ASSOC);


 }
 else{
  header('Location: login0309class.php');
  exit;
}

// (2)exitの位置

if (!empty($_POST)) {
  if ($_POST['tweet'] == '') {
    $error['tweet']='blank';}

  if (!isset($error)) {
    $sql_insert='INSERT INTO `tweets` SET `tweet`=? ,`member_id`=? ,`reply_tweet_id`=-1, `created`=NOW(), `modified`=NOW()';
    $data_insert=array($_POST['tweet'],$_SESSION['id']);
    $stmt_insert=$dbh->prepare($sql_insert);
    $stmt_insert->execute($data_insert);
  }

}
// (9)0312テーブルの結合
// INNER JOIN=両方のテーブルに存在するデータのみ取得
// OUTER JOIN(left join right join)
// idは被らないように作るのがベスト

$tweet_sql='SELECT * FROM `tweets` LEFT JOIN `members` ON `tweets`.`member_id`=`members`.`member_id` WHERE `delete_flag`=0 ORDER BY `tweets`.`created` DESC';
$tweet_stmt=$dbh->prepare($tweet_sql);
$tweet_stmt->execute();
$tweet_list=array();
while(true){
$tweet=$tweet_stmt->fetch(PDO::FETCH_ASSOC);
if ($tweet == false) {
  break;}
   $tweet_list[]=$tweet;}



echo '<pre>';
var_dump($tweet_list);
echo '</pre>';
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
                <li><a href="logout0312class.php">ログアウト</a></li>
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
<?php  if(isset($_SESSION['id'])){
$sql_select= 'SELECT `nick_name` FROM `members` WHERE `member_id`=? ';
$data_select=array($_SESSION['id']);
$stmt_select=$dbh->prepare($sql_select);
$stmt_select->execute($data_select);

$name=$stmt_select->fetch(PDO::FETCH_ASSOC);
echo $name['nick_name'];
}
?>
        さん！</legend>
        <form method="post" action="" class="form-horizontal" role="form">
            <!-- つぶやき -->
            <div class="form-group">
              <label class="col-sm-4 control-label">つぶやき</label>
              <div class="col-sm-8">
                <textarea name="tweet" cols="50" rows="5" class="form-control" placeholder="例：Hello World!"></textarea>
                
                <?php if (isset($error['tweet']) && $error['tweet']== 'blank') { ?>
                <p class="error">つぶやきを入力してください。</p>
                 <?php } ?>

              </div>
            </div>
          <ul class="paging">
            <input type="submit" class="btn btn-info" value="つぶやく">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <li><a href="index.html" class="btn btn-default">前</a></li>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <li><a href="index.html" class="btn btn-default">次</a></li>
          </ul>
        </form>
      </div>

      <div class="col-md-8 content-margin-top">
        <?php foreach ($tweet_list as $value) {
          // echo '<pre>';
          // var_dump($value);
          //  echo '</pre>';

           ?>

        <div class="msg">
          <img src="http://c85c7a.medialib.glogster.com/taniaarca/media/71/71c8671f98761a43f6f50a282e20f0b82bdb1f8c/blog-images-1349202732-fondo-steve-jobs-ipad.jpg" width="48" height="48">
          <p>
            つぶやき<span class="name"> <?php echo $value['tweet']; ?> </span>
            [<a href="#">Re</a>]
          </p>
          <p class="day">
            <a href="view.html">
              <?php echo $value['created']; ?>
            </a>
            [<a href="#" style="color: #00994C;">編集</a>]
            [<a href="#" style="color: #F33;">削除</a>]
          </p>
        </div>
       <?php } ?>
      </div>

    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery-3.1.1.js"></script>
    <script src="assets/js/jquery-migrate-1.4.1.js"></script>
    <script src="assets/js/bootstrap.js"></script>
  </body>
</html>
