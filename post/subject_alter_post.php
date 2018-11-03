<?php 
include( "../db_config.php" );
if ( !$member_login ) {
    echo "<script> alert('请先登陆帐号');parent.location.href='index.php'; </script>";
    exit;
}
if (isset($_POST["sub_id"])) {
    $sub_id = $_POST["sub_id"]; 
} else {
    exit;
}
if (isset($_POST["sub_title"])) {
    $sub_title = $_POST["sub_title"]; 
} else {
    $sub_title = '';
}
if (isset($_POST["sub_desc"])) {
    $sub_desc = $_POST["sub_desc"];
} else {
    $sub_desc = '';
}
if (isset($_POST["sub_teacher_id"])) {
    $sub_teacher_id = $_POST["sub_teacher_id"];
} else {
    $sub_teacher_id = '';
}
if (isset($_POST["sub_cate_cid"])) {
    $sub_cate_cid = $_POST["sub_cate_cid"];
} else {
    $sub_cate_cid = '';
}
if (isset($_POST["sub_cate_type"])) {
    $sub_cate_type = $_POST["sub_cate_type"];
} else {
    $sub_cate_type = '';
}
if (isset($_POST["sub_picture"])) {
    $sub_picture = $_POST["sub_picture"];
} else {
    $sub_picture = '';
}
if (isset($_POST["sub_phone"])) {
    $sub_phone = $_POST["sub_phone"];
} else {
    $sub_phone = '';
}

$sql_subject_alter = mysqli_query($mysqli,"UPDATE subject_list SET sub_title = '{$sub_title}', sub_desc = '{$sub_desc}', sub_picture = '{$sub_picture}' WHERE sub_id = '{$sub_id}'");
    
if ($sql_subject_alter) {
    echo 1;
    
    /*if ($sub_recommend) {
        $query_recommend_count = "SELECT itr_id FROM item_recommend where itr_phone = '{$sub_recommend}' and itr_item = '{$up_id}'";
            if ($result_recommend_count = mysqli_query($mysqli, $query_recommend_count))
            {
                if (!mysqli_num_rows($result_recommend_count)) {
                    $sql_item_recommend = mysqli_query($mysqli,"INSERT INTO item_recommend (itr_phone,itr_item) VALUES ('{$sub_recommend}', '{$up_id}')");
                }
            }
    }*/
}
?>