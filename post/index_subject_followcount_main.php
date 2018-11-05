<?php
include("../include/config.php");    
include("../include/data_base.php");
include("../include/member_db.php");
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = '';
}

$member_view = member_db($member_login,"mb_id,mb_point,mb_ico","../include/data_base.php");
$member_view = json_decode($member_view, true);
$member_id = $member_view['mb_id'];

if (isset($_COOKIE["user_region"])) {
    $user_region = $_COOKIE["user_region"];
} else {
    $user_region = "";
}
if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = "";
}

if (isset($_COOKIE["gpsla"])) {
    $gpsla = $_COOKIE["gpsla"];
} else {
    $gpsla = 0;
}
if (isset($_COOKIE["gpslo"])) {
    $gpslo = $_COOKIE["gpslo"];
} else {
    $gpslo = 0;
}

if (isset($_POST['item_count'])) {
    $item_count = $_POST['item_count'];
} else {
    $item_count = 0;
}
if(isset($_POST['sort_id'])) {
    $sort_id = $_POST['sort_id'];
} else {
    $sort_id = 0;
}

if($sort_id == 0)
    $query = "select * from subject_list order by sub_play_cnt, sub_follow_count, sub_time desc limit $item_count, 10";
else
    $query = "select * from subject_list where sub_cate_cid = '{$sort_id}' order by sub_play_cnt, sub_follow_count, sub_time desc limit $item_count, 10";



$nnn = 0;
$result = mysqli_query($mysqli, $query);
if ($result)
{
    while( $row = mysqli_fetch_assoc($result) ){
?>

<ul class="mui-table-view ad-list" style="">
    <li class="mui-table-view-cell">
         
        <a href="lecture_list.php?sub_id=<?php echo $row['sub_id'];?>&amp;type=user">
            <img class="mui-pull-left" src="<?php echo $row['sub_picture'];?>" style="/*outline: 1px solid #d3d2d4;*/width:80px;height:80px;border-radius:6px;margin-right:12px;">
            <!-- <img class="mui-pull-left" style="width:80px;height:80px;border-radius:10px;margin-right:5px;" src="../upload/compress/15411369151976720.jpg"> -->
            <div class="mui-media-body" style="font-size: 0.42rem; line-height: 0.42rem;">
                <?php echo $row['sub_title'];?>
                <p style="font-size: 0.32rem; margin-top: 10px; line-height: none;" class="mui-ellipsis">
                    <?php echo $row['sub_desc'];?>
                </p>
            </div>
            <div style="margin-bottom:0px;">
                <div class="mui-pull-left mui-col-xs-8 mui-col-sm-8 mui-clearfix" style="margin-top: 10px;">
                     <span style="color: #999999;margin-top: 10px;">
                        <img src="img/reciever.png" style="width: 24px; vertical-align: bottom;">
                        <span style="font-size: 0.32rem; color: #999999;"><?php echo $row['sub_play_cnt'];?></span>
                    </span>
                    <span style="float:right">
                        <img src="img/series.png" style="width: 24px; vertical-align: bottom;">
                        <span style="font-size: 0.32rem; color: #999999;"><?php echo $row['sub_lecture_count'];?>集</span>
                    </span>
                </div>
            </div>            
        </a>
        
    </li>
</ul>
<?php
    }
}
?>
