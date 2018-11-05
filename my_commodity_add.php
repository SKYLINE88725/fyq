<?php
include( "db_config.php" );
if ( !$member_login ) {
	echo "<script> alert('请先登陆帐号');parent.location.href='index.php'; </script>";
	exit;
}
$sub_id = @$_GET['sub_id'];
if (!$sub_id) {
    exit;
}

$query_member = "SELECT * FROM fyq_member where mb_phone = '{$member_login}'";
$result_member = mysqli_query($mysqli, $query_member);
$row_member = mysqli_fetch_assoc($result_member);

$query_merchant = "SELECT * FROM merchant_entry where me_user = '{$member_login}'";
$result_merchant = mysqli_query($mysqli, $query_merchant);
$query_college = "SELECT * FROM college_list where cl_phone = '{$member_login}'";
$result_college = mysqli_query($mysqli, $query_college);
$row_merchant = "";
//print_r($result_merchant);
if ($result_merchant->num_rows > 0 || $result_college->num_rows > 0)
{
	$row_merchant = mysqli_fetch_assoc($result_merchant);
    if ($row_merchant['me_state'] == '0') 
	{
        echo "<script> alert('专家入驻审核中！');parent.location.href='index.php'; </script>";
        exit;
    }
}
else
{
	echo "<script> alert('专家入驻后才能操作！');parent.location.href='merchant_entry.php'; </script>";
    exit;
}
$college_id = mysqli_query( $mysqli, "SELECT cl_id FROM college_list where cl_phone = '{$member_login}'" );
$college_rs = mysqli_fetch_array( $college_id, MYSQLI_NUM );
$i_class = $college_rs[ 0 ];

$head_title = "新讲课发布";
include("include/head_.php");
$top_title = "新讲课发布";
$top_url = "";
$top_button = "<a class='top-navigate-btn' id='commodity_in'>完成</a>";

$return_url = "..";
include("include/top_navigate_commodity.php");
?>
<script src="fuyuanquan/assets/vendor/jquery/jquery.min.js"></script>
<script src="fuyuanquan/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="fuyuanquan/assets/scripts/klorofil-common.js"></script>
<script src="fuyuanquan/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="umeditor/third-party/template.min.js?t=<?php echo time();?>"></script>
<!-- <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=vmmlFR9V8hDzNoPgpGOh8NwGpfjqaGDE"></script> -->
<script src="fuyuanquan/js/distpicker.data.js"></script>
<script src="fuyuanquan/js/distpicker.js"></script>
<link rel="stylesheet" href="fuyuanquan/assets/vendor/bootstrap/css/bootstrap.min.css">

<!-- plupload file production -->
<script type="text/javascript" src="./js/plupload.full.min.js"></script>
<!-- ICONS -->
<link rel="apple-touch-icon" sizes="76x76" href="fuyuanquan/assets/img/apple-icon.png">
<link rel="icon" type="image/png" sizes="96x96" href="fuyuanquan/assets/img/favicon.png">
<link rel="stylesheet" type="text/css" href="fuyuanquan/diyUpload/css/webuploader.css">
<link rel="stylesheet" type="text/css" href="fuyuanquan/diyUpload/css/diyUpload.css">
<link rel="stylesheet" href="fuyuanquan/assets/css/main.css">
<link rel="stylesheet" type="text/css" href="fuyuanquan/diyUpload/css/globle.css">
<style type="text/css">
    .merchant_entry {
        float: left;
        width: 100%;
        margin-top: 48px;
    }
    .merchant_entry .good_uploader_container{
        margin-top: 10px;
        /*margin-left: 14px;*/
        padding-left: 14px;
        padding-right: 14px;
    }
    @media only screen and (max-width: 320px) {
        .merchant_entry {
            float: left;
            width: initial;
            margin-top: 48px;
        }
        .merchant_entry .good_uploader_container{
            margin-top: 10px;
            /*margin-left: 14px;*/
            padding-left: 35px;
            padding-right: 35px;
        }
    }
    @media only screen and (max-width: 414px) {
        .merchant_entry .good_uploader_container{
            margin-top: 10px;
            padding-left: 14px;
            padding-right: initial;
        }
    }
    .merchant_entry ul {
        
    }
    .merchant_entry li {
        float: left;
        width: 100%;
        border-bottom: 5px solid #f5f5f5;
        padding-bottom: 12px;
        background-color: #FFFFFF;
    }
    .merchant_entry li div#feedback img{
        width: inherit;
    }
    .merchant_entry input {
        width: 90%;
    }
    .merchant_entry_title {
        margin-left: 10px;
        height: 46px;
        line-height: 46px;
        float: left;
        font-size: 1.2em;
    }
    .merchant_entry_content {
        width: 100%;
        float: left;
        text-align: center;
        position: relative;
        margin-bottom: 6px;
    }
    .merchant_entry_content i {
        position: absolute;
        width: 100px;
        height: 100px;
        top: 14px;
        left: 0px;
        right: 0px;
        margin: 0 auto;
    }
    .merchant_upload img {
        width: 35%;
    }
    .merchant_entry_content .inputfile {
        display: none;
    }
    .merchant_entry_post {
        text-align: center;
        padding-top: 12px;
    }
    .merchant_entry_post input {
        background-color: #FF5722;
        color: #fff;
        border: 0px;
    }
    .merchant_contract_down {
        display: block;
        height: 60px;
        line-height: 60px;
        font-size: 1.2em;
        font-weight: bold;
    }

    .circle {
	  	background: red;
		width: 60px;
		height: 60px;
		border-radius: 50%;
		margin-left: auto;
		margin-right: auto;
		margin-bottom: 67px;
		position: relative;
		top: 15px;
	}

</style>
	<div class="merchant_entry">
		<span id="" class="commodity_in_pic"></span>
		<ul>
        	<li>
                <div class="input-group" style="float: left; margin-left: 10px; width: 90%; margin-top:10px;">
                    <label class="shanggpin_label input-group-addon">专辑标题</label>
                    <input type="text" class="form-control" placeholder="请输入讲课标题" name="commodity_title" >
                </div>
                
            	<input class="form-control" type="hidden" alt="备用金" name="commodity_spare" value="0.00">
                <input class="form-control" type="hidden" alt="现金" name="commodity_point_type" value="0">
                <input class="form-control" type="hidden" alt="首页顺序" name="commodity_index" value="0">
                <input class="form-control" type="hidden" alt="推荐顺序" name="commodity_array" value="0">
                <input class="form-control" type="hidden" alt="不详" name="commodity_point" value="0">
                <input class="form-control" type="hidden" alt="不详" name="commodity_vpoint" value="0">
                <input class="form-control" type="hidden" alt="推荐此商家手机号" name="commodity_recommend" value="">
                <input class="form-control" type="hidden" alt="商家店铺号" name="commodity_class" value="<?php echo $i_class;?>">
                <input class="form-control" type="hidden" alt="商家手机号" name="commodity_phone" value="<?php echo $member_login;?>">
                <input class="form-control" type="hidden" alt="无分销" name="commodity_distribution_level" value="0">
			</li>
            <li>
                <div class="input-group" style="float: left; margin-left: 10px; width: 90%; margin-top:10px;">
                    <div style="font-weight: bold; margin-bottom: 5px;">专辑内容</div>
                    <textarea class="form-control" placeholder="请输入专辑内容" rows="4" name="commodity_summary" ></textarea>
                </div>            

			</li>
            <li>
				<div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
			</li>
			<li>				
				<div id="container">
					<a id="pickfiles" class="mui-btn mui-btn-primary" href="javascript:;">选择文本文件</a> 
					<a id="uploadfiles" class="mui-btn mui-btn-primary" href="javascript:;">上载</a>
					<!-- <pre id="console"></pre> -->
				</div>
			</li>
			<li>
				<div id="feedback" style="float: left; width: 100%;margin-top: 20px;"></div>
			</li>
            <!--<li>
            	<div style=" text-align:center;">
            		<button type="button" class="btn btn-success" id="commodity_in">提交</button>
                </div>
            </li>-->
		</ul>
    </div>	
    <script type="text/javascript" src="fuyuanquan/diyUpload/js/webuploader.min.js"></script>
    <script type="text/javascript" src="fuyuanquan/diyUpload/js/diyUpload_.js"></script>
	<script type="text/javascript">
		var last_uploaded_file = {}
		$( ".commodity_in_pic span" ).click( function () {
			$( this ).parent().remove();
		} )
		$( "#commodity_in" ).click( function () {
			var commodity_title = $( "[name='commodity_title']" ).val().trim();
			var commodity_phone = $( "[name='commodity_phone']" ).val();
            var commodity_spare = $("[name='commodity_spare']").val();
			var commodity_point = $( "[name='commodity_point']" ).val();
			var commodity_point_type = $( "[name='commodity_point_type']" ).val();
			var commodity_array = $( "[name='commodity_array']" ).val();
			var commodity_cate = $( "[name='commodity_cate']" ).val();
            var commodity_vpoint = $( "[name='commodity_vpoint']" ).val();
			var commodity_display = $( "[name='commodity_display']" ).val();
			var commodity_refund = $( "[name='commodity_refund']" ).val();
			var commodity_gpsx = $( "[name='commodity_gpsx']" ).val();
			var commodity_gpsy = $( "[name='commodity_gpsy']" ).val();
            var commodity_recommend = $( "[name='commodity_recommend']" ).val();
			var commodity_distribution_level = $( "[name='commodity_distribution_level']" ).val();
			if ( $( "[name='commodity_class']" ).length > 0 ) {
				var commodity_class = $( "[name='commodity_class']" ).val();
			} else {
				var commodity_class = "<?php echo $i_class;?>";
			}
			var commodity_summary = $( "[name='commodity_summary']" ).val().trim();
			var commodity_content = $( ".edui-body-container" ).html();
			var commodity_mainimg = $( "#feedback img" ).attr( "src" );
			var commodity_index = $("[name='commodity_index']").val();
			
			if ( !commodity_title || !commodity_summary) {
				var msgstr = "内容填写不完整!";
				if(!commodity_title)
				{
					alert('请填写专辑标题！');	
					return false;
				}
				if(!commodity_summary)
				{
					alert('请填写活动内容！');	
					return false;
				}
			}
			else 
			{
				if (!last_uploaded_file || jQuery.isEmptyObject(last_uploaded_file)){
					alert("화일을 업로드 하세요.");
					return;
				}
				$( this ).attr( "disabled", "disabled" ).text( "提交中..." ).prepend( '<i class="fa fa-spinner fa-spin"></i>' );
				$.post( "post/commodity_add_post.php", {
						com_title: commodity_title,
						com_phone: commodity_phone,
                        com_spare: commodity_spare,
						com_point: commodity_point,
						com_point_type: commodity_point_type,
						com_array: commodity_array,
						com_cate: commodity_cate,
                        com_vpoint: commodity_vpoint,
						com_display:commodity_display,
						com_refund: commodity_refund,
						com_recommend:commodity_recommend,
						com_distribution_level: commodity_distribution_level,
						com_class: commodity_class,
						com_summary: commodity_summary,
						com_content: commodity_content,
						com_mainimg: commodity_mainimg,
						com_index:commodity_index,
						com_shopmenu: "<?php echo $sort;?>",
						media_filename: last_uploaded_file.filename,
						media_filetitle: last_uploaded_file.filetitle,
                        sub_id: "<?php echo $sub_id;?>"
					},
					function ( data, status ) {						
						if ( data == "1" ) {
							alert('发布成功！');
							location.href = "lecture_list.php?sub_id=<?php echo $sub_id;?>&type=teacher";
						}
						else
						{
							alert('发布失败！');
							location.href = "lecture_list.php?sub_id=<?php echo $sub_id;?>&type=teacher";
						}
					} );
			}
		} )
		
		$('#distpicker').distpicker({
				province:'<?php echo $row_member['mb_province'];?>',
				city:'<?php echo $row_member['mb_city'];?>',
				district:'<?php echo $row_member['mb_area'];?>'
			});
	</script>
	
	<script type="text/javascript">
	// Custom example logic

	var uploader = new plupload.Uploader({
		runtimes : 'html5,flash,silverlight,html4',
		browse_button : 'pickfiles', // you can pass an id...
		container: document.getElementById('container'), // ... or DOM Element itself
		url : 'upload_file.php',
		flash_swf_url : '../js/Moxie.swf',
		silverlight_xap_url : '../js/Moxie.xap',
		multi_selection: false,
		filters : {
			max_file_size : '500mb',
			mime_types: [
				// {title : "Image files", extensions : "jpg,gif,png"},
				{title : "Video files", extensions : "mp4"},
				{title : "Audio files", extensions : "mp3"},
				//{title : "Zip files", extensions : "zip"}
			]
		},

		init: {
			PostInit: function() {
				document.getElementById('filelist').innerHTML = '';

				document.getElementById('uploadfiles').onclick = function() {
					last_uploaded_file = {};
					uploader.start();
					return false;
				};
			},

			FilesAdded: function(up, files) {
				plupload.each(files, function(file) {
					//document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
					document.getElementById('filelist').innerHTML = '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
				});
			},

			UploadProgress: function(up, file) {
				document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			},

			Error: function(up, err) {
				document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
			},
			QueueChanged: function(up){
				if (up.files.length >= 2)
					up.files.splice(0, up.files.length-1);
				var f = up.files;
			},
			FileUploaded: function(up, file, result){
				if (result['status'] == 200){
					var obj = JSON.parse(result.response);
					last_uploaded_file = {
						"filename": obj.filename,
						"filetitle": file.name
					};
					
				}
			}
			
		}
	});

	uploader.init();

	</script>

    <script type="text/javascript">
 //响应返回数据容器
 		$( document ).ready(function(){
			$("#spic").click(()=>{
				$(".inputfile").click();
			})
			//响应文件添加成功事件
			$(".inputfile").change(function(){
				var onfiles = $(this).attr("class");
				//创建FormData对象
				var data = new FormData();
				//为FormData对象添加数据
				// $.each($(this)[0].files, function (i,file) {
				// 	data.append('upload_file'+i,file);
				// } );
				// image/jpeg
				var file = $(this)[0].files[0];
				if (file.type !== 'video/mp4' && file.type !== 'audio/mp3'){
					alert("옳바른 화일 형식이 아닙니다.");
					return;
				}

				data.append('upload_file0', file);
				$("#feedback").html('<img src="../img/loding.gif" alt="加载中" style="width:50px;">');
				//$("#lfile").show(); //显示加载图片//<img src="../img/loding.gif" alt="加载中">
				//发送数据
				var file1 = $("input:file").prop( "name" );
				$.ajax( {
					url: '../submit_img.php?imgtype=nosize&file_name=' + file1,
					type: 'POST',
					data: data,
					cache: false,
					contentType: false, //不可缺参数
					processData: false, //不可缺参数
					success: function ( data ) {
						$("#feedback").html('<img src="/upload/'+data+'" alt="" style="width:inherit;">');
						//$("#feedback").attr('src','../upload/compress/'+data);
						//$( "#lfile" ).hide(); //加载成功移除加载图片
					},
					error: function () {
						alert( '上传出错' );
						//$( "#lfile" ).hide(); //加载失败移除加载图片
						$("#feedback").html('');
					}
				} );
			} );			
		} ); 

// JavaScript Document
</script>
</body>

</html>