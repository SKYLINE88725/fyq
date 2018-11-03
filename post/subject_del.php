<?php 
include( "../db_config.php" );
if ( !$member_login ) {
	echo "<script> alert('请先登陆帐号');parent.location.href='index.php'; </script>";
	exit;
}
$sub_id = $_POST['subject_del_id'];

$query_teac = "SELECT * FROM subject_list where sub_id = {$sub_id}";
if ($result_teac = mysqli_query($mysqli, $query_teac))
{
	$row_teac = mysqli_fetch_assoc($result_teac);
	$tlclass = $row_teac['sub_teacher_id'];
	$sql_commoditydel	= mysqli_query($mysqli,"UPDATE  `teacher_list` SET  `delete_status` =  '0' WHERE  `sub_id` = '{$sub_id}'");
    $sql_commoditydel	= mysqli_query($mysqli,"UPDATE  `subject_list` SET  `delete_status` =  '0' WHERE  `sub_id` = '{$sub_id}'");
    //$sql_keyword_tydel = mysqli_query($mysqli,"DELETE FROM search_keyword WHERE key_item = '{$sub_id}'");
	$sql_college_flow = mysqli_query($mysqli,"UPDATE college_list SET cl_allcount = cl_allcount-1 WHERE cl_id = '{$tlclass}'");
	echo 1;
}
?>