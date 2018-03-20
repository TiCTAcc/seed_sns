<?php


$tweet_sql="SELECT `tweets`.*, `members`.`nick_name`, `members`.`picture_path` FROM `tweets` LEFT JOIN `members` ON `tweets`.`member_id`=`members`.`member_id` WHERE `delete_flag`=0 ORDER BY `tweets`.`modified` DESC LIMIT ".$start.",".$page_number;

$tweet_stmt=$dbh->prepare($tweet_sql);
$tweet_stmt->execute();
$tweet_list=array();
while(true){
$tweet=$tweet_stmt->fetch(PDO::FETCH_ASSOC);
if ($tweet == false) {
  break;}
   $tweet_list[]=$tweet;}


   ?>


   <?php $tweet_sql='SELECT `tweets`.*, `members`.`nick_name`, `members`.`picture_path` FROM `tweets` LEFT JOIN `members` ON `tweets`.`member_id`=`members`.`member_id` WHERE `delete_flag`=0 ORDER BY `tweets`.`modified` DESC LIMIT '.$start.",".$page_number;

$tweet_stmt=$dbh->prepare($tweet_sql);
$tweet_stmt->execute();
$tweet_list=array();
while(true){
$tweet=$tweet_stmt->fetch(PDO::FETCH_ASSOC);
if ($tweet == false) {
  break;}
   $tweet_list[]=$tweet;} ?>
   大丈夫。


     $tweet_sql='SELECT `tweets`.*, `members`.`nick_name`, `members`.`picture_path` FROM `tweets` LEFT JOIN `members` ON `tweets`.`member_id`=`members`.`member_id` WHERE `delete_flag`=0 ORDER BY `tweets`.`modified` DESC LIMIT $start,$page_number';

      $tweet_sql='SELECT `tweets`.*, `members`.`nick_name`, `members`.`picture_path` FROM `tweets` LEFT JOIN `members` ON `tweets`.`member_id`=`members`.`member_id` WHERE `delete_flag`=0 ORDER BY `tweets`.`modified` DESC LIMIT ?,?';

      "SELECT `tweets`.*, `members`.`nick_name`, `members`.`picture_path` FROM `tweets` LEFT JOIN `members` ON `tweets`.`member_id`=`members`.`member_id` WHERE `delete_flag`=0 ORDER BY `tweets`.`modified` DESC LIMIT ?,?"

      $tweet_sql="SELECT `tweets`.*, `members`.`nick_name`, `members`.`picture_path` FROM `tweets` LEFT JOIN `members` ON `tweets`.`member_id`=`members`.`member_id` WHERE `delete_flag`=0 ORDER BY `tweets`.`modified` DESC LIMIT ?,$page_number";

        $tweet_sql="SELECT `tweets`.*, `members`.`nick_name`, `members`.`picture_path` FROM `tweets` LEFT JOIN `members` ON `tweets`.`member_id`=`members`.`member_id` WHERE `delete_flag`=0 ORDER BY `tweets`.`modified` DESC LIMIT ?".",".$page_number;