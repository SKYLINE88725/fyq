<?php 
include("db_config.php");
$sub_id = @$_GET['sub_id'];
if (!$sub_id) {
	exit;
}
$query = "SELECT * FROM	subject_list LEFT JOIN college_list ON subject_list.sub_teacher_id = college_list.cl_id WHERE subject_list.sub_id = '{$sub_id}'";
if ($result = mysqli_query($mysqli, $query))
{
	$row = mysqli_fetch_assoc($result);
}

$query_cate = "SELECT * FROM item_cate where ic_cid = '".$row['sub_cate_cid']."' and ic_type = 'teacher'";
if ($result_cate = mysqli_query($mysqli,$query_cate)) {
	$row_cate = mysqli_fetch_assoc($result_cate);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title><?php echo $row['sub_title'];?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script>
function follow_id(fid) {
	var follow_ico = $("#follow_"+fid).attr("src");
	console.log(follow_ico);
	$.post("../post/follow.php",
	  {
		phone_num:"<?php echo $member_login;?>",
		follow_ico:follow_ico,
		shop_id:fid
	  },
	  function(data,status){
		if (data == "0") {
			  alert("请先登录使用!");
		  }
		  if (data == "1") {
			  alert("关注成功");
			  $("#follow_"+fid).attr("src","img/on_ok.png");
		  }
		  if (data == "2") {
			  alert("关注已取消");
			  $("#follow_"+fid).attr("src","img/off_ok.png");
		  }
	  });
}
</script>
</head>

<body>
<?php 
	$top_title = $row['sub_title'];
	$top_url = '<span style="text-align: right; width: auto; margin-right:2%;" onClick="window.location.href=\'my_commodity_add.php?sub_id='.$sub_id.'\'">新讲课发布<span>';
	$return_url = "..";
	include("include/top_navigate.php");
?>

    
<img src="<?php echo $row['cl_logo'];?>" style="width: 100%;height: 100px;filter: blur(2px);top:48px;position: absolute;">
<div style="position: relative;margin-top: 80px;">
	<img src="<?php echo $row['sub_picture'];?>" style="width: 100px;box-shadow: 0px 0px 15px 3px rgba(0,0,0,.3);border: solid white 2px;float: left;margin: 18px 20px">
	<div style="padding: 15px; color: white">
		<p><?php echo $row['cl_name'];?></p>
		<p style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;"><?php echo $row['cl_province'];?> <?php echo $row['cl_city'];?> <?php echo $row['cl_area'];?></p>
	</div>
	<div style="color: #333">
		<p class="businesses_blog_list_cate">
            <img src="img/series.png" style="vertical-align: text-top;width: 24px;"><span style="margin: 0px 5px"><?php echo $row['sub_lecture_count'];?>集</span>
			<span style="float: right;padding: 0px 6px;background-color: #ff655e;color: white;border-radius: 3px;margin-right: 10px"><?php echo $row_cate['ic_name'];?></span>
		</p>
		<p><img src="img/reciever.png" style="vertical-align: top;width: 24px;"><span style="width: 20%; margin: 2px 5px"><?php echo $row['sub_follow_count'];?></span></p>
	</div>
</div>
<div class="clearfix"></div>
<div style="margin: 10px; padding: 10px;background-color: white;color: #333">
	<p><?php echo $row['sub_desc'];?></p>
</div>



<?php 
	$tid = $row['cl_id'];
	$query_list = "SELECT * FROM teacher_list where tl_class = '{$tid}' AND sub_id= '{$sub_id}' ORDER BY tl_id desc";
	if ($result_list = mysqli_query($mysqli, $query_list))
	{
		while( $row_list = mysqli_fetch_assoc($result_list) ){ 
			$tlid = $row_list['tl_id'];
			$sql_follow = mysqli_query($mysqli, "SELECT count(*) FROM follow_list where fl_phone = '{$member_login}' and fl_tid = '{$tlid}'");
			$follow_rs = mysqli_fetch_array($sql_follow,MYSQLI_NUM);
			$follow_totalNumber = $follow_rs[0];
			if ($follow_totalNumber) {
				$follow_img = "img/on_ok.png";
			} else {
				$follow_img = "img/off_ok.png";
			}
			$shop_type = $row_list['shop_menu'];
			$shop_cate = $row_list['tl_cate'];
			$query_cate = "SELECT * FROM item_cate where ic_cid = '{$shop_cate}' and ic_type = '{$shop_type}'";
			if ($result_cate = mysqli_query($mysqli,$query_cate)) {
				$row_cate = mysqli_fetch_assoc($result_cate);
			}
?>
		<div class="businesses_blog_list" style="margin: 10px; padding: 10px;background-color: white;color: #333">
		    <a class="mui-card-content"  href="detailed_view.php?view=<?php echo $row_list['tl_id'];?>&type=company" target="_self">
		    	<p class="businesses_blog_list_title mui-h4"><?php echo $row_list['tl_name'];?></p>
		    	<p class="businesses_blog_list_title mui-h5"><?php echo $row_list['tl_summary'];?></p>
		    	<p class="businesses_blog_list_title mui-h5"><img src="img/reciever.png" style="vertical-align: top;width: 24px;"><span style="width: 20%; margin: 2px 5px"><?php echo $row['sub_follow_count'];?></span><span><img id="follow_<?php echo $row_list['tl_id'];?>" onClick="follow_id('<?php echo $row_list['tl_id'];?>')" src="<?php echo $follow_img;?>" alt="" style="width: 20px;float: right;"></span></p>
		    </a>
		</div>

<?php 
		}
	}
?>




</body>
</html>