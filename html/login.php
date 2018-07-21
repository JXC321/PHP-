<?php # - login.php
require('includes/config.inc.php');
include('includes/header.html');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require(MySQL);

    if(!empty($_POST['username'])){
        $u = mysqli_real_escape_string($dbc,$_POST['username']);
    }
    else{
        $u = FALSE;
        echo '请输入用户名';
    }

    if(!empty($_POST['password'])){
        $p = mysqli_real_escape_string($dbc,$_POST['password']);
    }
    else{
        $p = FALSE;
        echo '请输入密码';
    }

    if($u && $p){
        $q = "select * from users where (username='$u' and password=SHA1('$p'))";
        $r = mysqli_query($dbc,$q) or trigger_error("Query:$q\n<br/>MySQL Error:" . mysqli_error($dbc));

        if(@mysqli_num_rows($r) == 1){
            $_SESSION = mysqli_fetch_array($r,MYSQLI_ASSOC);
            mysqli_free_result($r);
            mysqli_close($dbc);

            $url = BASE_URL ;#. 'index.php';
            ob_end_clean();
            #header("Location:$url");
            header('location: '.$_SERVER['HTTP_REFERER']);
            exit();
            echo '登录成功，欢迎你';
        }
        else{
            echo '<p class="error">你输入的用户名和密码不匹配</p>';
        }
    }
    else{
        echo '<p class="error">请重试</p>';
    }
}
?>
<?php
/*
<h1>Login</h1>
<from action="login.php" method="post">
<fieldset>
<p><b>邮箱:</b> <input type="text" name="email" size="20" maxlength="60" /> </p>
<p><b>密码:</b><input type="password" name="pass" size="20" maxlength="20" /> </p>
<div align="center"><input type="submit" name="submit" value="login" /> </div>
</fieldset>
</form>
 */
?>
<?php include('includes/footer.html');
