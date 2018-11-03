<?php
include("include/data_base.php");
$head_title = "";
$top_title = "";
include( "include/head_.php" );
include( "include/top_navigate.php" );
?>
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
    <video src="./video/hengchuan.mp4" controls="controls" playsinline width="100%">
                您的浏览器不支持 video 标签。
                </video>
</div>
<div class="div3"></div>
<div class="div4"></div>
<div class="div5"></div>
<button class="div6">
</button>

<?php
include( "include/foot_.php" );
?>