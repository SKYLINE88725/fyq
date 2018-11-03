<?php
include("include/config.php");
include("include/data_base.php");
include("include/member_db.php");
if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = '';
}
//echo $member_login;
include("include/shipping_address.php");
$receive_address = mb_exist_shipping($member_login, $mysqli);

$mb_id = $receive_address['mb_id'];
$query = "SELECT * FROM `shipping address` where `mb_id` = $mb_id AND `status` = 1";

$result = mysqli_query($mysqli, $query);
$row_data = mysqli_fetch_assoc($result);
$mb_receiving_address = $row_data['mb_receiving_address'];
$mb_shipping_id = $row_data['id'];
// $data['status'] = $row_data['status'];

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
    $top_navigate_return = '<div onClick="YDB.GoBack()"><img src="/img/return_top.png" alt="返回"></div>';
} else {
    if (@$_SERVER["HTTP_REFERER"]) {
        $top_navigate_return = '<a href="/" target="_self"><img src="/img/return_top.png" alt="返回"></a>';
    } else {
        $top_navigate_return = '<a href="/" target="_self"><img src="/img/return_top.png" alt="返回"></a>';
    }
}
echo "<script> var tid=".$tid;
echo "</script>"
?>
<div class="top_navigate"> 
	<span>
		<?php echo $top_navigate_return;?>
	</span> 
	<span><?php echo $top_title;?></span> 
</div>
<!-- <style type="text/css">
    .viewqrcode canvas {
        width: 100%;
    }
    .tc_detailed_foot_gps {
        color: #FFFFFF;
    }

    #area_4,#area_5,#area_6,#area_7,#area_8,#area_9 ul {
        margin-top: -13px;
    }
</style> -->


<style type="text/css">
    .region_speis div {
        display: block;
        width: 100%;
        height: 20px;
        line-height: 20px;
        text-align: center;
        font-size: 0.8em;
        text-decoration: none;
    }
    .region_level div {
        color: #525252;
        text-decoration: none;
        font-size: 0.8em;
        display: block;
        height: 42px;
        line-height: 42px;
        border-bottom: 1px solid #dbdbdb;
        padding-left: 3%;
        background-color: #FFFFFF;
    }
    .open_region {
        font-size: 0.8em;
    }
    .open_region span {
        height: 36px;
        line-height: 36px;
        background-color: inherit;
    }
    .open_region div {
        display: block;
        float: left;
        width: 20%;
        height: 30px;
        line-height: 30px;
        text-align: center;
        margin-top: 1%;
        margin-left: 1%;
        margin-right: 1%;
    }
    .region_serch {
        margin-top: 48px;
    }
    .region_serch input {
        background-color: #ffffff;
        width: 96%;
    }

.div1 {
    background:url(./img/vipback/vip_back1.png);
    background-repeat: no-repeat;
    background-size: contain;
    width: 100%;
    height: 60.5333333333vw;
}
.div2 {
    background:url(./img/vipback/vip_back2.png);
    background-repeat: no-repeat;
    background-size: contain;
    width: 100%;
    height: 52.133333333vw;

    padding-left: 10px;
    padding-right: 10px;
}
.div3 {
    background:url(./img/vipback/vip_back3.png);
    background-repeat: no-repeat;
    background-size: contain;
    width: 100%;
    height: 86.8vw;
}

.div4 {
    background:url(./img/vipback/vip_back4.png);
    background-repeat: no-repeat;
    background-size: contain;
    width: 100%;
    height: 64.13333333333vw;
}

.div5 {
    background:url(./img/vipback/vip_back5.png);
    background-repeat: no-repeat;
    background-size: contain;
    width: 100%;
    height: 123.33333333333333vw;
}

.div6 {
    background:url(./img/vipback/vip_back6_.png);
    background-repeat: no-repeat;
    background-size: cover;
    width: 100%;
    height: 14.533333333333333vw;
    bottom: 0px;
    position: fixed;
    left: 0px;
    right: 0px;
}

</style>
<div class="div1"></div>
<div class="div2">
    <video src="./video/hengchuan.mp4" controls="controls" width="100%">
                您的浏览器不支持 video 标签。
                </video>
</div>
<div class="div3"></div>
<div class="div4"></div>
<div class="div5"></div>

<?php 
		if ($row['shop_menu'] == "partner") {
		?>
		<div class="tc_detailed_foot">
		<button class="div6" >
		<li class="item_buy"></li>
		</button>
		</div>
<?php
		}
?>
<!-- <div class="video" style = "margin-top: 150px;
    margin-left: 20px;width: 90%">

		<video src="./video/hengchuan.mp4" controls="controls" width="100%">
              
        </video>
</div> -->

<!-- <div class="tc_detailed_foot" style="z-index: 100;">
	<ul>	
		<?php 
		if ($row['shop_menu'] == "partner") {
		?>

		<li class="item_buy" style="color: white;background-color: red;margin-bottom: 50px; margin-left: 100px;">我要助力19.9元</li>
		<?php
		}
		?>
	</ul>
</div> -->

<div class="tc_detailed_confirm">
	<ul>
		<li class="tc_detailed_confirm_view">
			<div> <img src="<?php echo $row['tc_mainimg'];?>" alt=""> </div>
			<div>
				<p>
					<?php echo $row['tl_name'];?><span><img src="img/off_tc.png" alt="取消" class="tc_detailed_off"></span>
				</p>
				<p>
					<?php if ($row_cate['ic_name']) {echo $row_cate['ic_name'];}?>
				</p>
				<?php 
				if ($row['tl_point_type'] == "0") {
				?>
				<p>
					<font color="#cdcdcd">价格:</font>
					<font color="#ff0000">￥
						<?php echo $row['tl_price'];?>
					</font>
				</p>
				<?php 
				}
				?>
				<?php 
				if ($row['tl_point_type'] == "1") {
				?>
				<p class="item_point">
					<img src="img/point_ico.png" alt="幸福豆图标"><?php echo $row['tl_point_commodity'];?>
				</p>
				<?php 
				}
				?>
				<?php 
				if ($row['tl_point_type'] == "2") {
				?>
				<p class="item_point">
					<span>￥<?php echo $row['tl_price'];?></span>
					<img src="img/point_ico.png" alt="幸福豆图标"><?php echo $row['tl_point_commodity'];?>
				</p>
				<?php 
				}
				?>
			</div>
		</li>
		<?php 
if ($type == "company") {
?>
		<li class="tc_detailed_confirm_squantity"> <span>获取数量</span>
			<div class="tc_detailed_confirm_count"><img src="img/shopchartcount1.png" alt="减" class="businesses_detailed_jian">
				<input type="number" name="businesses_detailed_count" value="1">
				<img src="img/shopchartcount2.png" alt="加" class="businesses_detailed_jia">
			</div>
		</li>
		<?php 
}
?>
		
		<li class="tc_detailed_confirm_confirm"> 确定 </li>
	</ul>
</div>
<div class="tc_detailed_bg"></div>

<div class="view_qrcode">
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
</div>

<script type="text/javascript">
        var mb_id = "<?php echo $mb_id;?>";
	var shipping_id = "<?php echo $mb_shipping_id;?>";

	$( document ).ready( function () {
		if ( mb_id ) {
			$.ajax({
				type: 'POST',
				url: "/include/shipping_address.php?action=getting_default_shipping_address",
				data: { 
					mb_id: mb_id,
				},
				headers: {"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"},
				success: function(response) {
					var mb_ship_province = JSON.parse(response).mb_ship_province ? JSON.parse(response).mb_ship_province + ', ' : "";
					var mb_ship_city = JSON.parse(response).mb_ship_city ? JSON.parse(response).mb_ship_city + ', ' : "";
					var mb_ship_district = JSON.parse(response).mb_ship_district ? JSON.parse(response).mb_ship_district + ', ' : "";
					var mb_receiving_address = JSON.parse(response).mb_receiving_address ? JSON.parse(response).mb_receiving_address : "";
					
					$.trim($('.tc_detailed_line4 a:nth-child(2) p').text(mb_ship_province + mb_ship_city + mb_ship_district + mb_receiving_address));
				},
				error: function (request, error) {
			        alert(" 不能这样做因为: " + error);
			    },
			});
		}

        $('.viewqrcode').qrcode({
            text: "<?php echo $picUrl;?>"
        })
		// $( ".top_navigate" ).append( "<span class=\"tc_qrcode\"><img src=\"img/qrcode_ico.png\" alt=\"二维码\"></span>" );

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
			//alert(data);
		});

		// $( ".tc_comtent_more p" ).click( function () {
			
		// } )
		$(".tc_detailed_foot .item_buy").click(function () {
			<?php 
		if ($type == "join") {
		?>
			$( ".tc_detailed_confirm_confirm" ).click();
			<?php 
		} else {
		?>
			$( ".tc_detailed_confirm, .tc_detailed_bg" ).css("display","block");
			<?php 
		}
		?>
		} )
		
		$( ".tc_detailed_off" ).click( function () {
			$( ".tc_detailed_confirm, .tc_detailed_bg" ).css("display","none");
		} )

		$( ".businesses_detailed_jian" ).click( function () {
			var businesses_detailed_val = $( "[name='businesses_detailed_count']" ).val();
			if ( parseInt( businesses_detailed_val ) > 1 ) {
				$( "[name='businesses_detailed_count']" ).val( parseInt( businesses_detailed_val ) - 1 );
			}
		} )
		$( ".businesses_detailed_jia" ).click( function () {
			var businesses_detailed_val = $( "[name='businesses_detailed_count']" ).val();
			if ( parseInt( businesses_detailed_val ) > 0 ) {
				$( "[name='businesses_detailed_count']" ).val( parseInt( businesses_detailed_val ) + 1 );
			}
		} )

		$( ".top_navigate .tc_qrcode" ).click( function () {
			$( ".view_qrcode, .tc_detailed_bg" ).css( "display", "block" );
		} )
		$( ".tc_detailed_bg" ).click( function () {
				$( ".view_qrcode, .tc_detailed_bg, #chatContainer").css( "display", "none" );
			} )
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
	} );

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

	function check_shipping_address(url) {
		var shipping_address = $.trim($('.tc_detailed_line4 a:nth-child(2) p.point_1').text());
		if(mb_id){
			if(shipping_address){
				window.open( url + '&shipping_address=' + shipping_address ,'_self')	
			} else {
				alert("请您先设定收货地址一下。");
				window.location = "/member_shipping_address.php?from_detail=1&detail_item=<?php echo $_GET['view']; ?>&detail_type=<?php echo $_GET['type']; ?>";
			}
		} else {
			$.get("post/login_ajax.php",function(data,status){
				$(".animsition").html(data);
			});
		}
			
	}
</script>
<script type="text/javascript">
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
</script>


<?php
include( "include/foot_.php" );
?>