<!-- index0307/0307hw/thanks/re_login/0313index_pre/logout0312class/update0313/ -->


<?php


$page='';

if (isset($_GET['page'])) {
  $page=$_GET['page'];
}else{
  $page=1;
}

$page=max($page,1);

$page_number=5;

$sql='SELECT COUNT(*) AS `tweet_count` FROM `tweets` WHERE `delete_flag`=0';
$stmt=$dbh->prepare($sql);
$stmt->execute();
$tweet_count=$stmt->fetch(PDO::FETCH_ASSOC);

$all_page_number=ceil($tweet_count/$page_number);

$page=min($page,$all_page_number);

$start=($page-1)*$page_number;

$tweet_sql="SELECT `tweets`.*, `members`.`nick_name`,`members`.`picture_path` FROM `tweets` LEFT JOIN `members` ON `tweets`.`member_id`=`members`.`member_id` WHERE `delete_flag`=0 ORDER BY `modified` DESC LIMIT".$start.",".$page_number;

?>

<?php

$page='';

if (isset($_GET['page'])) {
  $page=$_GET['page'];
}else{
  $page=1;
}

$page=max($page,1);

$page_number=5;

$sql='SELECT COUNT(*) AS `count` FROM `tweets` WHERE `delete_flag`=0';
$stmt=$dbh->prepare($sql);
$stmt->execute();

$count=$stmt->fetch(PDO::FETCH_ASSOC);

$all_page_number=ceil($count['count']/$page_number);

$page=min($page,$all_page_number);

$start=($page-1)*$all_page_number;

$tweet_sql="SELECT `tweets`.* ,`members`.`nick_name`,`members`.`picture_path` FROM `tweets` LEFT JOIN `members` ON `tweets`.`member_id`=`members`.`member_id` WHERE `delete_flag`=0 ORDER BY `modified` DESC";

?>