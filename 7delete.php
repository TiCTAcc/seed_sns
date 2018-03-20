<?php
session_start();
require('dbconnect.php');


var_dump($_GET);

if (isset($_GET)) {
$sql='SELECT * FROM `tweets` WHERE `tweet_id`=?';
$data=array($_GET['tweet_id']);
$stmt=$dbh->prepare($sql);
$stmt->execute($data);
$delete=$stmt->fetch(PDO::FETCH_ASSOC);

$sql_update='UPDATE `tweets` SET `delete_flag`=1,`modified`=NOW() WHERE `tweet_id`=?';
$data_update=array($delete['tweet_id']);
$stmt_update=$dbh->prepare($sql_update);
$stmt_update->execute($data_update);


header('Location: 5index.php');
exit;
}






 ?>