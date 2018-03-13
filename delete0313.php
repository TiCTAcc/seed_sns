<?php

require('dbconnect.php');

var_dump($_GET);

if (!empty($_GET) && $_GET['action']=='delete') {
$sql_select='SELECT * FROM `tweets` WHERE `tweet_id`=?';
$data_select=array($_GET['tweet_id']);
$stmt_select=$dbh->prepare($sql_select);
$stmt_select->execute($data_select);
$update=$stmt_select->fetch(PDO::FETCH_ASSOC);
}

if ($_GET['action']=='delete') {

$sql_delete='UPDATE `tweets` SET `delete_flag`=1 , `modified`=NOW() WHERE `tweet_id`=?';
$data_delete=array($_GET['tweet_id']);
$stmt_delete=$dbh->prepare($sql_delete);
$stmt_delete->execute($data_delete);

header('Location: 0313index_pre.php');
exit;
}

 ?>

 <!DOCTYPE html>
 <html lang="ja">
 <head>
   <meta charset="UTF-8">
   <title>0313delete</title>
 </head>
 <body>
   
 </body>
 </html>