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
if($top_navigate_index != "")
{
	$top_navigate_return = $top_navigate_index;
}
?>
<div class="top_navigate"> 
	<span>
		<?php echo $top_navigate_return;?>
	</span> 
	<span><?php echo $top_title;?></span> 
    <?php echo $top_url;?>
    <?php 
        if(isset($top_button)){
            echo $top_button;
        }
    ?>
</div>