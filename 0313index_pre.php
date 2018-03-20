<!-- index0307/0307hw/thanks/re_login/0313index_pre/logout0312class/update0313/ re.php-->


<?php
  session_start();
  // DBの接続
  require('dbconnect.php');

  // // ログインチェック
  // if (!isset($_SESSION['id'])) {
  //   // ログインしていない時
  //   // 強制遷移する
  //   header('Location: login0309class.php');
  //   exit;
  // }

  // if (!isset($error)) {
  //   $sql_insert='INSERT INTO `tweets` SET `tweet`=? ,`member_id`=? ,`reply_tweet_id`=-1, `created`=NOW(), `modified`=NOW()';
  //   $data_insert=array($_POST['tweet'],$_SESSION['id']);
  //   $stmt_insert=$dbh->prepare($sql_insert);
  //   $stmt_insert->execute($data_insert);}

  if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    // ログインしている
    // ログイン時間の更新
    $_SESSION['time'] = time();
    // ログインユーザー情報取得
    $login_sql = 'SELECT * FROM `members` WHERE `member_id`=?';
    $login_data = array($_SESSION['id']);
    $login_stmt = $dbh->prepare($login_sql);
    $login_stmt->execute($login_data);
    $login_member = $login_stmt->fetch(PDO::FETCH_ASSOC);
  } else {
    // ログインしていない、または時間切れの場合
    header('Location: re_login.php');
    exit;
  }



  // つぶやくボタンが押された時
  if (!empty($_POST)) {

    // 入力チェック
    if ($_POST['tweet'] == '') {
      $error['tweet'] = 'blank';
    }

    if (!isset($error)) {
      // SQL文作成(INSERT INTO)
      // tweet=つぶやいた内容
      // member_id=ログインした人のid
      // reply_tweet_id=-1
      // created=現在日時。now()を使用
      // modified=現在日時。now()を使用

      $sql = 'INSERT INTO `tweets` SET `tweet`=?, `member_id`=?, `reply_tweet_id`=?, `created`=NOW(), `modified`=NOW()';
      $data = array($_POST['tweet'], $_SESSION['id'], -1);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

    }
  }


// ページング機能(1)0314start
$page='';

if (isset($_GET['page'])) {
  $page=$_GET['page'];
}else{
  $page=1;
}

// (2)イレギュラーな数値に対応
$page=max($page,1);

$page_number=5;


$page_sql='SELECT COUNT(*) AS `page_count` FROM `tweets`  WHERE `delete_flag`=0';
$page_stmt=$dbh->prepare($page_sql);
$page_stmt->execute();
$page_count=$page_stmt->fetch(PDO::FETCH_ASSOC);

// (3)ceil関数
$all_page_number=ceil($page_count['page_count']/$page_number);

echo '<br>';echo '<br>';echo '<br>';echo '<br>';
var_dump($page_count);
var_dump($all_page_number);

$page=min($page, $all_page_number);
// 表示するデータの取得開始場所
$start=($page-1)*$page_number;








  // ログインしているユーザーの情報を取得
  $login_sql = 'SELECT * FROM `members` WHERE `member_id`=?';
  $login_data = array($_SESSION['id']);
  $login_stmt = $dbh->prepare($login_sql);
  $login_stmt->execute($login_data);
  $login_member = $login_stmt->fetch(PDO::FETCH_ASSOC);

// 0314selectいじる（４）
  $tweet_sql="SELECT `tweets`.*, `members`.`nick_name`, `members`.`picture_path` FROM `tweets` LEFT JOIN `members` ON `tweets`.`member_id`=`members`.`member_id` WHERE `delete_flag`=0 ORDER BY `tweets`.`modified` DESC LIMIT ".$start.",".$page_number;

$tweet_stmt=$dbh->prepare($tweet_sql);
$tweet_stmt->execute();
$tweet_list=array();
while(true){
$tweet=$tweet_stmt->fetch(PDO::FETCH_ASSOC);
if ($tweet == false) {
  break;}
   $tweet_list[]=$tweet;}



// echo '<br>';echo '<br>';echo '<br>';echo '<br>';
// echo '<pre>';
// var_dump($_SESSION);

// echo '</pre>';

  // // 一覧用の投稿全件取得
  // $tweet_sql = 'SELECT * FROM `tweets` ORDER BY `created` DESC';
  // $tweet_stmt = $dbh->prepare($tweet_sql);
  // $tweet_stmt->execute();

  // // 空の配列を用意
  // $tweet_list = array(); // データがない時のエラーを防ぐ

  // // 一覧用の投稿全件取得
  // while (true) {
  //   $tweet = $tweet_stmt->fetch(PDO::FETCH_ASSOC);
  //   if ($tweet == false) {
  //     break;
  //   }
  //   $tweet_list[] = $tweet;
  // }

  // echo '<pre>';
  // var_dump($tweet_list);
  // echo '</pre>';
// if ($_GET['action']=='delete' ) {


// }


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
        <legend>ようこそ<?php echo $login_member['nick_name']; ?>さん</legend>
        <form method="post" action="" class="form-horizontal" role="form">
            <!-- つぶやき -->
            <div class="form-group">
              <label class="col-sm-4 control-label">つぶやき</label>
              <div class="col-sm-8">
                <textarea name="tweet" cols="50" rows="5" class="form-control" placeholder="例：Hello World!"></textarea>
                <?php if (isset($error) && $error['tweet'] == 'blank') { ?>
                    <p class="error">つぶやき内容を入力してください。</p>
                <?php } ?>
              </div>
            </div>
          <ul class="paging">
            <input type="submit" class="btn btn-info" value="つぶやく">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <?php if ($page==1) { ?>
                <li>前</li>
                <?php }else{ ?>
                 <li><a href="0313index_pre.php?page=<?php echo $page-1 ?>" class="btn btn-default">前</a></li>
                 <?php } ?>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <?php if ($page==$all_page_number) { ?>
                 <li>後</li>

               <?php }else{ ?>
                <li><a href="0313index_pre.php?page=<?php echo $page+1 ?>" class="btn btn-default">次</a></li>
                <?php } ?>
                <li><?php echo $page; ?>/<?php echo $all_page_number ?></li>
          </ul>
        </form>
      </div>


      <div class="col-md-8 content-margin-top">
        <?php foreach($tweet_list as $one_tweet) {



          ?>
        <div class="msg">
          <img src="picture_path/<?php echo $one_tweet['picture_path']?>" width="48" height="48">
          <p>
            <?php echo $one_tweet['tweet']; ?><span class="name"><br>name:   <?php echo $one_tweet['nick_name']?> </span>

<?php if ($_SESSION['id']!==$one_tweet['member_id']) {
  ?>
            [<a href="re.php?action=re&tweet_id=<? echo $one_tweet['tweet_id']?>">Re</a>]
            <?php } ?>
          </p>
          <p class="day">
            <a href="view0314.php?tweet_id=<?php echo $one_tweet['tweet_id']; ?>">
              <?php echo date($one_tweet['modified']); ?>
            </a>
            <!-- はてな以降はパラメータ -->
 <?php if ($one_tweet['nick_name']==$login_member['nick_name']) { ?>




            [<a href="update0313.php?action=update&tweet_id=<?php echo $one_tweet['tweet_id']; ?>" style="color: #00994C;">編集</a>]
            [<a href="delete0313.php?action=delete&tweet_id=<?php echo $one_tweet['tweet_id']; ?>" style="color: #F33;">削除</a>]

<?php if ($one_tweet['reply_tweet_id']>=1) { ?>
  

            [<a href="view0314.php?tweet_id=<?php echo $one_tweet['reply_tweet_id']; ?>" style="color: #a9a9a9;">返信元のメッセージを表示</a>] 
            <?php } ?>
<?php } ?>

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