<?php
//修改密码，如果处于登录状态
require('includes/config.inc.php');
$page_title = 'Chang your password';
include('includes/header.html');

if(!isset($_SESSION['username'])){
    $url = BASE_URL . 'index.php';
    ob_end_clean();
    header("Location:$url");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require(MySQL);

    $p = false;
    if(preg_match('/^(\w){4,20}$/',$_POST['password1'])){
        if($_POST['password1'] == $_POST['password2']){
            $p = mysqli_real_escape_string($dbc,$_POST['password1']);
        }
        else{
            echo '<p class="error">你输入的密码不匹配，请重新输入';
        }
    }
    else{
        echo '请输入规范格式的密码';
    }

    if($p){
        $q = "update users set password=SHA1('$p') where username='{$_SESSION['username']}'";
        $r = mysqli_query($dbc,$q) or trigger_error("Query:$q\n<br />MySQL Error:" . mysqli_error($dbc));
        if(mysqli_affected_rows($dbc) == 1){
            echo '<h3>修改密码成功</h3>';
            mysqli_close($dbc);
            include('includes/footer.html');
            exit();
        }
        else{
            echo '<p class="error">密码修改未成功，请确保新密码符合规范或者联系管理员';
        }
    }
    else{
        echo '请重新尝试';
    }
    mysqli_close($dbc);
}
?>

<h1>修改密码</h1>
<form action="change_pass.php" method="post">
<fieldset>
<p><b>新密码：</b> <input type="password" name="password1" size="20" maxlength="20" /><small>密码只能使用数字、字母和下划线，位数在4到20之间</small></p>
<p><b>重复密码：</b> <input type="password" name="password2" size="20" maxlength="20" /></p>
</fieldset>
<div align="center"><input type="submit" name="submit" value="Chang my password" /></div>

<?php include('includes/footer.html');
