<?php
//退出登录，如果没有登录直接返回主页；否则退出登录并返回主页
require('includes/config.inc.php');
$page_title = 'Logout';
include('includes/header.html');

//利用SESSION数组是否存储了user_name字段来判断用户是否登录
if(!isset($_SESSION['username'])){ //未登录的直接重定向到首页
    $url = BASE_URL . 'index.php';
    ob_end_clean();
    header("Location:$url");
    exit();
}
else{   //登录的清除session和cookie再重定向到首页
    $_SESSION = array();
    session_destroy();
    setcookie(session_name(),'',time()-3600);
    header('location: '.$_SERVER['HTTP_REFERER']);
}
include('includes/footer.html');
?>
