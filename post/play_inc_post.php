<?php 
include( "../db_config.php" );
if ( !$member_login ) {
	echo "<script> alert('请先登陆帐号');parent.location.href='index.php'; </script>";
	exit;
}
$tl_id = $_POST['tl_id'];
$sub_id = $_POST['sub_id'];

$sql_play_inc = mysqli_query($mysqli,"UPDATE teacher_list SET tl_Sales = tl_Sales+1 WHERE tl_id = '{$tl_id}'");
$sql_sub_play_inc = mysqli_query($mysqli,"UPDATE subject_list SET sub_play_cnt = sub_play_cnt+1 WHERE sub_id = '{$sub_id}'");
echo 1;

?>