<div style="position: absolute;right: 38px;top: 0px"><img src="img/cate-icon-shadow.png" style="height: 40px"></div>
<div class="horizontal-list" id="horizontal_list_div">
	<ul id="horizontal-list">
		<li value="0" class="active" id="all"><a>推荐</a></li>
		<li value="-1" id="vip" onclick="window.open('huiyuan.php?view=1895&type=join', '_self')"><a><img src="img/vip.png" style="width: 14px">VIP</a></li>
		<!-- <li value="-1" id="vip" onclick="window.open('vip.php', '_self')"><a ><img src="img/vip.png"style="width: 20px">VIP</a></li> -->
		<?php 
		$query_cate = "SELECT * FROM item_cate where ic_type = 'teacher'";
		if ($result_cate = mysqli_query($mysqli,$query_cate)) {
			for ($ct=0;$row_cate = mysqli_fetch_assoc($result_cate);$ct++) {
		?>
			<li value="<?php echo $row_cate['ic_cid'];?>" id="sort_menu_<?php echo $row_cate['ic_cid'];?>"><a><?php echo $row_cate['ic_name'];?></a></li>
		<?php 
			}
		}
		?>

	</ul>
</div>
<div style="position: absolute;right: 0px;top: 0px"><a href="item_cate.php"><img src="img/cate-icon.png" style="height: 40px"></a></div>