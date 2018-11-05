<?php
include("include/config.php");
include("include/data_base.php");
include("include/member_db.php");
if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = '';
}

// include("include/shipping_address.php");
// $receive_address = mb_exist_shipping($member_login, $mysqli);

// $mb_id = $receive_address['mb_id'];
// $query = "SELECT * FROM `shipping address` where `mb_id` = $mb_id AND `status` = 1";

// $result = mysqli_query($mysqli, $query);
// $row_data = mysqli_fetch_assoc($result);
// $mb_receiving_address = $row_data['mb_receiving_address'];
// $mb_shipping_id = $row_data['id'];


$member_view = member_db($member_login,"mb_id,mb_point,mb_ico","include/data_base.php");
$member_view = json_decode($member_view, true);
$member_view_mb_id = $member_view['mb_id'];
if (isset($_GET['view'])) {
    $tid = $_GET['view'];
} else {
    $tid = '';
}
if (isset($_GET['type'])) {
    $type = $_GET['type'];
} else {
    $type = '';
}

if (isset($_GET['mphone'])) {
    $mphone = $_GET['mphone'];
} else {
    $mphone = '';
}

if (!$tid || !$type) {
	exit;
}

$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
$sql_follow = mysqli_query( $mysqli, "SELECT count(fl_id) FROM follow_list where fl_phone = '{$member_login}' and fl_tid = '{$tid}'" );
$follow_rs = mysqli_fetch_array( $sql_follow, MYSQLI_NUM );
$follow_totalNumber = $follow_rs[ 0 ];
if ( $follow_totalNumber ) {
	$follow_img = "img/on_ok.png";
} else {
	$follow_img = "img/off_ok.png";
}

$query = "SELECT tl.*, me.mb_nick, me.mb_ico FROM teacher_list AS tl LEFT JOIN fyq_member AS me ON tl.tl_phone=me.mb_phone where tl_id = '{$tid}'";
$result = mysqli_query( $mysqli, $query );
$row = mysqli_fetch_assoc( $result );

$shop_type = $row['shop_menu'];
$shop_cate = $row['tl_cate'];
$query_cate = "SELECT * FROM item_cate where ic_cid = '{$shop_cate}' and ic_type = '{$shop_type}'";
if ($result_cate = mysqli_query($mysqli,$query_cate)) {
	$row_cate = mysqli_fetch_assoc($result_cate);
}

$cl_id = $row[ 'tl_class' ];
$query_view = "SELECT * FROM college_list where cl_id = '{$cl_id}'";
$result_view = mysqli_query( $mysqli, $query_view );
$row_view = mysqli_fetch_assoc( $result_view );

$sub_id = $row[ 'sub_id' ];
$query_subject = "SELECT * FROM subject_list where sub_id = '{$sub_id}'";
$result_subject = mysqli_query( $mysqli, $query_subject );
$row_subject = mysqli_fetch_assoc( $result_subject );

$member_id = $member_view_mb_id;
$picUrl = '../detailed_view.php?view='.$tid.'&type='.$type.'&mphone='.$member_login.'&qid='.$member_id;//二维码扫描出的链接

$head_title = $row['tl_name'];
$top_title = "";//$row['tl_name'];
include( "include/head_.php" );

if ($type == "individual") {
    $return_url = "teacher.php";
}
if ($type == "join") {
    $return_url = "subscriber.php";
}
//include( "include/top_navigate.php" );
?>
<?php 
if (strstr($_SERVER['HTTP_USER_AGENT'],"fuyuanquan.net")) {
    $top_navigate_return = '<div onClick="window.history.back()"><img src="/img/return_top.png" alt="返回"></div>';
} else {
    if (@$_SERVER["HTTP_REFERER"]) {
        $top_navigate_return = '<div onClick="window.history.back()"><img src="/img/return_top.png" alt="返回"></div>';
    } else {
        $top_navigate_return = '<div onClick="window.history.back()"><img src="/img/return_top.png" alt="返回"></div>';
    }
}
echo "<script> var tid=".$tid;
echo "</script>"
?>
<style>
	.hide{
		display: none;
	}
	.show{
		display: block;
	}
</style>
<!-- <link href="http://vjs.zencdn.net/7.0/video-js.min.css" rel="stylesheet">
<script src="http://vjs.zencdn.net/7.0/video.min.js"></script> -->

<div class="top_navigate"> 
	<span>
		<?php echo $top_navigate_return;?>
	</span> 
	<span><?php echo $top_title;?></span> 
</div>
<style type="text/css">
    .viewqrcode canvas {
        width: 100%;
    }
    .tc_detailed_foot_gps {
        color: #FFFFFF;
    }

    #area_4,#area_5,#area_6,#area_7,#area_8,#area_9 ul {
        margin-top: -13px;
    }
</style>
<!-- <div class="swiper-container swiper4">
<div class="swiper-wrapper">
		<?php 
		$pictures = (explode("|",$row['tl_pictures']));
		$pictures_length=count($pictures);
		for($x=0;$x<$pictures_length;$x++)
		{
			if (strstr($pictures[$x],"server")) {
				$pictures_src = "../fuyuanquan/".$pictures[$x];
			} else {
				$pictures_src = $pictures[$x];
			}
		?>
		<div class="swiper-slide"><img src="<?php echo $pictures_src;?>" alt="">
		</div>
		<?php 
		}
		?>
	</div>
	
	<div class="swiper-pagination"></div>
	
	<div class="swiper-button-next"></div>
	<div class="swiper-button-prev"></div>
</div> -->
<div style="margin-top: 48px;background-color:white">
	<br>
	<div class="mui-h4" style="text-align: center;"><?php echo $row['tl_name'];?></div>
	<div style="text-align: center;margin-top: 20px"><img style="width: 100px; height: 100px; box-shadow: 0px 0px 15px 3px rgba(0,0,0,.3);border: solid white 2px;" src="<?php echo $row_subject['sub_picture'];?>"></div>
	<div style="text-align: center;"><img src="img/reciever.png" style="vertical-align: bottom;width: 24px;"><span style="width: 20%; margin: 2px 5px"><?php echo $row['tl_Sales'];?></div>
	<div class="mui-h5" style="text-align: center;margin: 20px;background-color: #efeff4;border-radius: 30px;padding: 0px 20px;"><?php echo $row['tl_summary'];?></div>

	<div style="margin: 10px">
		<div class="<?php $l=explode(".", $row['tl_video']); echo end($l) !== "mp4" ? "hide":"show"; ?>">
			<video src="<?php echo 'videoplayer/playsong.php?filename='.$row['tl_video'] ?>" controls="controls" width="100%" autoplay playsinline>
	        您的浏览器不支持 video 标签。
	        </video>
		</div>
		<div class="<?php $l=explode(".", $row['tl_video']); echo end($l) !== "mp4" ? "show":"hide"; ?>">
			<audio controls autoplay style="width:100%">					
				<source src="<?php echo 'videoplayer/playsong.php?filename='.$row['tl_video'] ?>">
			</audio>
		</div>

	</div>

</div>

<?php
if ( $type == "company" ) {
?>
<div style="background-color:white;padding: 10px;margin-bottom: 10px">
	<div style="float: left"><img style="width: 60px;height: 60px" src="<?php echo $row_view['cl_logo'];?>"></div>
	<div style="float: left;margin-left: 10px">
		<p style="margin: 0px"><?php echo $row_view['cl_name'];?></p>
		<p style="margin: 0px"><?php echo $row['tc_province1'];?><?php echo $row['tc_city1'];?><?php echo $row['tl_district1'];?></p>
		<p style="margin: 0px">电话： <?php echo $row['tl_phone'];?></p>
	</div>

	<div style="float: right;"><img id="follow_<?php echo $row['tl_id'];?>" onClick="follows('<?php echo $tid;?>','<?php echo $member_login;?>','<?php echo $follow_img;?>')" src="<?php echo $follow_img;?>" alt="收藏" style="width: 20px"></div>
	<div class="clearfix"></div>
</div>
<?php
}
?>


<?php 
	$query_list = "SELECT * FROM teacher_list where sub_id= '{$sub_id}' ORDER BY tl_id desc";
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
		<div class="mui-card" style="margin: 1px 0px; padding: 0px 20px;background-color: white;color: #333;box-shadow: none;" id="commodity_<?php echo $row_list['tl_id'];?>">
		    <a class="mui-card-content"  href="detailed_view.php?view=<?php echo $row_list['tl_id'];?>&type=company" target="_self">
		    	<p class="businesses_blog_list_title mui-h4 mui-ellipsis"><?php echo $row_list['tl_name'];?></p>
		    	<p class="businesses_blog_list_title mui-h5 mui-ellipsis"><?php echo $row_list['tl_summary'];?></p>
		    	<p class="businesses_blog_list_title mui-h5"><img src="img/reciever.png" style="vertical-align: top;width: 24px;"><span style="width: 20%; margin: 2px 5px"><?php echo $row_list['tl_Sales'];?></span><span><img id="follow_<?php echo $row_list['tl_id'];?>" onClick="follow_id('<?php echo $row_list['tl_id'];?>')" src="<?php echo $follow_img;?>" alt="" style="width: 20px;float: right;"></span></p>
		    </a>
		    <div class="clearfix"></div>
<?php
			if ($type == "teacher") {
?>		    
		    <div class="businesses_blog_list_cate" style="position: absolute; top: 5px; right: 5px">
                <!-- <div class="mui-btn mui-btn-primary"><a style="color: #FFFFFF;" href="my_commodity_alter.php?id=<?php echo $row_list['tl_id'];?>">修改</a></div> -->
                <div class="mui-btn" onClick="lecture_del('<?php echo $row_list['tl_id'];?>')">删除</div>
            </div>
<?php
			}
?>		    
		</div>
<?php
		}
	}
?>

<div class="tc_detailed_bg"></div>

<?php
if($member_login && $row["mb_nick"]):
    ?>
    <script type="text/javascript" src="/js/chat.js"></script>
    <div id="chatContainer" style="display: none;">
        <div id="chatTitleBar"><?php echo $row["mb_nick"]?></div>

        <input id="chatTo" style="display: none;" value="<?php echo $row["tl_phone"]?>">
        <input id="to_ico" style="display: none;" value="<?php echo $row["mb_ico"]?>">
        <input id="me_ico" style="display: none;" value="<?php echo $member_view['mb_ico']?>">

        <div id="chatLineHolder"></div>
        <div id="chatBottomBar">
            <form id="submitForm" method="post" action="">
                <input id="chatText" name="chatText" class="rounded" maxlength="255" />
                <input type="submit" class="blueButton" value="发送" />
            </form>

        </div>
    </div>
    <?php
endif;
?>
<!-- <div class="view_qrcode">
	<ul>
		<li>
			<img src="<?php echo $row['tc_mainimg'];?>" alt="">
			<video class="mui-pull-left" src="<?php echo $main_img;?>" type="video/mp4" style="outline: 1px solid #d3d2d4;width:80px;height:80px;border-radius:10px;margin-right:5px;"></video>
		</li>
		<li>
			<div class="viewqrcode"></div>
			<div style="width: 60%;">
				<p>
					<?php echo $row['tl_name'];?>
				</p>
				<p>
					<span>
						<?php 
						if ($row['tl_point_type'] == "0") {
							echo $row['tl_price'];
						}
						if ($row['tl_point_type'] == "1") {
							echo "<img src=\"img/point_ico.png\" alt=\"幸福豆图标\">".$row['tl_point_commodity'];
						}
						if ($row['tl_point_type'] == "2") {
							echo "<span>￥".$row['tl_price']."</span>";
							echo "<img src=\"img/point_ico.png\" alt=\"幸福豆图标\">".$row['tl_point_commodity'];
						}
						if ($row['tl_point_type'] == "3") {
							echo ($row['tl_price']/10)."折";
						}
						?>
					</span>
					<?php 
					if ($row['tl_point_type'] == "0") {
					?>
					<span>
						<?php echo $row['tl_original'];?>
					</span>
					<?php 
					}
					?>
				</p>
			</div>
		</li>
		<li>截屏保存分享给您的朋友</li>
	</ul>
</div> -->
<!-- <button onClick="test_pay_success()">Test</button> -->
<script type="text/javascript">
    //     var mb_id = "<?php echo $mb_id;?>";
	// var shipping_id = "<?php echo $mb_shipping_id;?>";


	$( document ).ready( function () {
		$.ajax({
			type: 'POST',
			url: "/post/play_inc_post.php",
			data:{
				tl_id: <?php echo $row['tl_id'];?>,
				sub_id: <?php echo $row['sub_id'];?>,
			},
			headers: {"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"},
			success: function(response) {
			},
			error: function (request, error){

			}
		});
		// if ( mb_id ) {
		// 	$.ajax({
		// 		type: 'POST',
		// 		url: "/include/shipping_address.php?action=getting_default_shipping_address",
		// 		data: { 
		// 			mb_id: mb_id,
		// 		},
		// 		headers: {"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"},
		// 		success: function(response) {
		// 			var mb_ship_province = JSON.parse(response).mb_ship_province ? JSON.parse(response).mb_ship_province + ', ' : "";
		// 			var mb_ship_city = JSON.parse(response).mb_ship_city ? JSON.parse(response).mb_ship_city + ', ' : "";
		// 			var mb_ship_district = JSON.parse(response).mb_ship_district ? JSON.parse(response).mb_ship_district + ', ' : "";
		// 			var mb_receiving_address = JSON.parse(response).mb_receiving_address ? JSON.parse(response).mb_receiving_address : "";
					
		// 			$.trim($('.tc_detailed_line4 a:nth-child(2) p').text(mb_ship_province + mb_ship_city + mb_ship_district + mb_receiving_address));
		// 		},
		// 		error: function (request, error) {
		// 	        alert(" 不能这样做因为: " + error);
		// 	    },
		// 	});
		// }

        $('.viewqrcode').qrcode({
            text: "<?php echo $picUrl;?>"
        })
		$( ".top_navigate" ).append( "<span class=\"tc_qrcode\"><img src=\"img/qrcode_ico.png\" alt=\"二维码\"></span>" );

		$( ".tc_detailed_content" ).css( {
			"display": "block",
		} );
		$.post("post/view_content.php",
		{
			viewid:"<?php echo $tid;?>"
		},
		function(data,status){
		$(".tc_detailed_content").html(data);
			// scrollTo('.tc_detailed_content');
		});

		// $( ".tc_comtent_more p" ).click( function () {
			
		// } )
		// $(".tc_detailed_foot .item_buy").click(function () {
		// 	<?php 
		// if ($type == "join") {
		// ?>
		// 	$( ".tc_detailed_confirm_confirm" ).click();
		// 	<?php 
		// } else {
		// ?>
		// 	$( ".tc_detailed_confirm, .tc_detailed_bg" ).css("display","block");
		// 	<?php 
		// }
		// ?>
		// } )
		
		// $( ".tc_detailed_off" ).click( function () {
		// 	$( ".tc_detailed_confirm, .tc_detailed_bg" ).css("display","none");
		// } )

		// $( ".businesses_detailed_jian" ).click( function () {
		// 	var businesses_detailed_val = $( "[name='businesses_detailed_count']" ).val();
		// 	if ( parseInt( businesses_detailed_val ) > 1 ) {
		// 		$( "[name='businesses_detailed_count']" ).val( parseInt( businesses_detailed_val ) - 1 );
		// 	}
		// } )
		// $( ".businesses_detailed_jia" ).click( function () {
		// 	var businesses_detailed_val = $( "[name='businesses_detailed_count']" ).val();
		// 	if ( parseInt( businesses_detailed_val ) > 0 ) {
		// 		$( "[name='businesses_detailed_count']" ).val( parseInt( businesses_detailed_val ) + 1 );
		// 	}
		// } )

		// $( ".top_navigate .tc_qrcode" ).click( function () {
		// 	$( ".view_qrcode, .tc_detailed_bg" ).css( "display", "block" );
		// } )
		// $( ".tc_detailed_bg" ).click( function () {
		// 		$( ".view_qrcode, .tc_detailed_bg, #chatContainer").css( "display", "none" );
		// 	} )
		$( ".tc_point_commodity" ).click( function () {
			var tc_point_commodity_selected = $( ".tc_point_commodity" ).is( '.point_selected' );
			if ( tc_point_commodity_selected ) {
				$( this ).removeClass( "point_selected" );
			} else {
				$( this ).addClass( "point_selected" );
			}
		} )
		
		$("#player").on("play", function () {
			
			if ($('#player').attr("src") == "" || $('#player').attr("src") === undefined){
				$.post('record/play_request.php', {'tid': tid}, function (data,status) {
					
					if (data < 0){
						alert("Log in failed");					
					}
					else if (data < 1){
						alert("请先支付!");
					}
					else if (data == 1){
						$('#player').attr("src", "record/playsong.php?tid=" + tid);						
						player.load();
						player.play();
					}
					
				});
			}
			else{
				
			}
		});
		// videojs("home_video", {"height":"auto", "width":"auto"}).ready(function(){
		// 	var myPlayer = this;    // Store the video object
		// 	var aspectRatio = 9/16; // Make up an aspect ratio

		// 	function resizeVideoJS(){
		// 	// Get the parent element's actual width
		// 	var width = document.getElementById(myPlayer.id()).parentElement.offsetWidth;
		// 	// Set width to fill parent element, Set height
		// 	myPlayer.width(width);
		// 	myPlayer.height( width * aspectRatio );
		// 	}

		// 	resizeVideoJS(); // Initialize the function
		// 	window.onresize = resizeVideoJS; // Call the function on resize
		// });
	});

	function test_pay_success() {
		alert("sf");
			$.post("pay_success.php",
				{
					
				},
				function(data,status){
					
				});
		}

	//点击更多滑倒详细内容
	function scrollTo(ele, speed) {
		if (!speed) speed = 600;
		if (!ele) {
			$("html,body").animate( {
				scrollTop: 0
			},speed);
		} else {
			if (ele.length > 0) $("html,body").animate({
				scrollTop:$(ele).offset().top-48
			},speed);
		}
		return false;
	}

	// function check_shipping_address(url) {
	// 	var shipping_address = $.trim($('.tc_detailed_line4 a:nth-child(2) p.point_1').text());
	// 	if(mb_id){
	// 		if(shipping_address){
	// 			window.open( url + '&shipping_address=' + shipping_address ,'_self')	
	// 		} else {
	// 			alert("请您先设定收货地址一下。");
	// 			window.location = "/member_shipping_address.php?from_detail=1&detail_item=<?php echo $_GET['view']; ?>&detail_type=<?php echo $_GET['type']; ?>";
	// 		}
	// 	} else {
	// 		$.get("post/login_ajax.php",function(data,status){
	// 			$(".animsition").html(data);
	// 		});
	// 	}
			
	// }

</script>
<!-- <script type="text/javascript">
        $(".tc_detailed_confirm_confirm, .tc_detailed_foot .item_point").click(function(){ 
		var shipping_address = "shipping_address";//$.trim($('.tc_detailed_line4 a:nth-child(2) p.point_2').text());
		if ( mb_id ) {
			if (shipping_address) {
	if ($("[name='businesses_detailed_count']").length > 0){
		var detailed_count = $("[name='businesses_detailed_count']").val();
	} else {
		var detailed_count = 1;
	}
	var point_selected = $(".tc_point_commodity").is(".point_selected");
	if (point_selected) {
		point_selected = 1;
	} else {
		point_selected = 0;
	}
	$.post("post/payment_.php",{
			sid: "<?php echo $row['tl_id'];?>",
			squantity: detailed_count,
			point_selected: point_selected,
						mphone: "<?php echo ($mphone > '0') ? $mphone : "0";?>",
						shipping_id: "<?php echo $mb_shipping_id;?>"
		},
		function (data, status) {
						console.log(data);
			if (data == "5") {
				alert("此讲课暂时无法获取!");
				return;
			} else if (data == "6") {
				alert("您当前积分不够获取此产品");
				return;
			} else if (data == "10") {
				alert("请先登录后操作");
				ShowLoginForm();
				return;
			} else if (data == "8") {
                alert("此产品仅限一次获取");
				return;
			} else if (data.length > 30) {
                document.title = data;
				return;
            } else if (data) {
				location.href = "payment.php?tradeno=" + data;
			}
	});
			} else {
				location.href = "payment.php?tradeno=" + data;
			
				// alert("请您先设定收货地址一下。");
				// window.location = "/member_shipping_address.php?from_detail=1&detail_item=<?php echo $_GET['view']; ?>&detail_type=<?php echo $_GET['type']; ?>";
			}
		} else {
			$.get("post/login_ajax.php",function(data,status){
				$(".animsition").html(data);
			});
		}
	});
</script> -->
<?php 
$endlat = $row['GPS_Y'];
$endlon = $row['GPS_X'];
?>
<script type="text/javascript">
var isiPhone = userAgent.indexOf('iPhone') != -1;
$(".tc_detailed_foot_gps").click(function(){
    //if (isfuyuanquan) {
        YDB.NavigatorInfo("getnavigator");
    //} else {
    //    alert("导航功能只能在 APP 内使用");
    //}
})
  
function DoWithGPSapple (la,lo){
    startlats = la-0.006;
    startlons = lo-0.0065;
    endlats = <?php echo $endlat;?>-0.006;
    endlons = <?php echo $endlon;?>-0.0065;
    YDB.appleNavigation(startlats, startlons, endlats, endlons);
}
function DoWithGPSBaidu (la,lo){
    YDB.NavigatorBaiduPath(la, lo, "<?php echo $endlat;?>", "<?php echo $endlon;?>");
}
function DoWithGPSGaode (la,lo){
    startlats = la-0.006;
    startlons = lo-0.0065;
    endlats = <?php echo $endlat;?>-0.006;
    endlons = <?php echo $endlon;?>-0.0065;
    YDB.NavigatorGaodePath(startlats, startlons, "", endlats, endlons, "");
}
  
function getnavigator(info){
    var info = $.parseJSON(info);
    var baiduMap = info.bMap;
    var gaodeMap = info.aMap;
    var googleMap = info.gMap;
    if (isiPhone) {
        YDB.GetGPS('DoWithGPSapple');
    } else {
        if (baiduMap == "true") {
            YDB.GetGPS('DoWithGPSBaidu');
            return false;
        } else
        if (gaodeMap == "true") {
            YDB.GetGPS('DoWithGPSGaode');
            return false;
        } else {
            alert("请先安装百度地图或高德地图");
            return false;
        }
    }
}
</script>
<?php
include( "include/foot_.php" );
?>