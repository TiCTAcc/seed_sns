<!-- view0314.php/delete0314.php -->

<!-- index0307/0307hw/thanks/login0309class/index0309class/logout0312class -->

<!-- index0307/0307hw/thanks/re_login/0313index_pre/logout0312class/update0313/ -->



<?php

session_start();
require('dbconnect.php');

var_dump($_GET);

if (isset($_GET) && $_GET['action']=='delete') {
$sql_select='SELECT * FROM `tweets` WHERE `tweet_id`=?';
$data_select=array($_GET['tweet_id']);
$stmt_select=$dbh->prepare($sql_select);
$stmt_select->execute($data_select);
$delete_id=$stmt_select->fetch(PDO::FETCH_ASSOC);
var_dump($delete_id);

  $sql='UPDATE `tweets` SET `delete_flag`=1 WHERE `tweet_id`=?';
  $data=array($delete_id['tweet_id']);
  $stmt=$dbh->prepare($sql);
  $stmt->execute($data);

  header('Location: 0313index_pre.php');
  exit;

}


 ?>