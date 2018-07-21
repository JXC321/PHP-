<?php # - register.php
//登录功能的实现

//导入配置文件、设置标题、导入头文件
require('includes/config.inc.php');
$page_title = 'Register';
include('includes/header.html');

if($_SERVER['REQUEST_METHOD'] == 'POST'){   //如果数据以POST方式提交
    require(MySQL); //连接数据库

    $trimmed = array_map('trim',$_POST); //将POST数组中的每个元素去掉两侧的空白字符和预定义的字符，然后赋予trimmed数组
    $u = $e = $p = FALSE;   //定义验证用户名、Email、密码的变量

    if(preg_match('/^\w{2,40}$/',$trimmed['username'])){ //用户名2到40字符大小的字母和数字的组合
        $u = mysqli_real_escape_string($dbc,$trimmed['username']);  //符合规则则存储用户名
    }
    else{
        echo '<p class="error">请输入正确的用户名</p>';
    }

    if(filter_var($trimmed['email'],FILTER_VALIDATE_EMAIL)){    //使用过滤器扩展验证邮件地址
        $e = mysqli_real_escape_string($dbc,$trimmed['email']); //符合规则的则存储起来
    }
    else{
        echo '<p>请输入正确的Email地址</p>';
    }

    if(preg_match('/^\w{4,20}$/',$trimmed['pass1'])){   //密码的长度在4到20个字符，只能包含字母、数字和下划线。
        if($trimmed['pass1'] == $trimmed['pass2']){
            $p = mysqli_real_escape_string($dbc,$trimmed['pass1']);
        }
        else{
            echo '<p>输入的密码不匹配</p>';
        }
    }
    else{
        echo '请输入密码</p>';
    }
    
    //获取用户的姓名和大学名称
    $fn = mysqli_real_escape_string($dbc,$trimmed['firstname']);
    $ln = mysqli_real_escape_string($dbc,$trimmed['lastname']);
    $c = mysqli_real_escape_string($dbc,$trimmed['college']);

    if($u && $e && $p){    //如果数据全部验证通过
        $q = "select * from users where username='$u'";
        $r = mysqli_query($dbc,$q) or trigger_error("Query:$q\n<br />MySQL Error:" . mysqli_error($dbc));

        if(mysqli_num_rows($r) == 0){   //如果用户所用的用户名还没注册过，则将用户的注册信息插入数据库中
            #$a = md5(uniqid(rand(),true));

            $q = "insert into users(username,email,password,firstname,lastname,college) values('$u','$e',SHA1('$p'),'$fn','$ln','$c')";
            $r = mysqli_query($dbc,$q) or trigger_error("Query:$q\n<br />MySQL Error: " . mysqli_error($dbc));

            if(mysqli_affected_rows($dbc) == 1){    //注册成功
                //激活用户帐号功能，暂时不做
                #$body = "Thank you for registering at <SCNU OJ>.To activate your account,please click on this link:\n\n";
                #$body .= BASE_URL . 'activate.php?x=' . urlencode($e) . "&y=$a";

                #mail($trimmed['email'],'Registration Confirmation',$body,'From:2986957136@qq.com');

                echo '<h3>注册成功，欢迎您</h3>';
                include('includes/footer.html');
                exit();
            }
            else{   //系统问题导致信息写入数据库失败
                echo '<p class="error">系统问题，注册未成功，请稍后再试</p>';
            }
        }
        else{   //用户名已经被使用了
            echo '<p class="error">该用户名已经被使用注册，请使用别的用户名</p>';
        }
    }
    else{   //某项数据验证未通过
        echo '<p class="error">检查数据格式后重新注册</p>';
    }
    mysqli_close($dbc);
}
?>
<style>

.info{
    float: left;
}

.input{
    float: right;
}

.wrap{
    width:400px;
    margin: 8px auto;
}
.wrap::after{
    content: '';
    display: block;
    clear: both;
}
</style>
<form class="regform" action="register.php" method="post" style="text-align:cneter;border:3px">
    <fieldest>
        <div class="wrap"><b class="info">UserName:</b><input class="input" type="text" name="username" size="20" maxlength="20" value="<?php if(isset($trimmed['username'])) echo $trimmed['username']; ?>" placeholder="用户名" require/> </div>
        <div class="wrap"><b class="info">Email:</b><input class="input" type="text" name="email" size="20" maxlength="60" value="<?php if(isset($trimmed['email'])) echo $trimmed['email']; ?>" placeholder="用户邮箱" require/> </div>
        <div class="wrap"><b class="info">Password:</b><input class="input" type="password" name="pass1" size="20" maxlength="20" value="" placeholder="密码" require/>
        </div>
        <div class="wrap"><b class="info">Confirm Password:</b><input class="input" type="password" name="pass2" size="20" maxlength="20" value="" placeholder="重复密码" require/></div>
        <div class="wrap"><b class="info">FirstName</b><input class="input" type="text" name="firstname" size="20" maxlength="20" value="<?php isset($trimmed['firstname']) ? $trimmed['firstname'] : ''; ?>" /> </div>
        <div class="wrap"><b class="info">LastName:</b><input class="input" type="text" name="lastname" size="20" maxlength="20" value="<?php isset($trimmed['lastname']) ? $trimmed['lastname'] : ''; ?>"  /></div>
        <div class="wrap"><b class="info">College:</b><input class="input" type="text" name="college" size="20" maxlength="20" value="华南师范大学" placeholder="学校名称"/></div>
</fieldest>
<div align="center"> <input class="sub" type="submit" name="submit" value="Register" /></div>
</form>

<?php include('includes/footer.html');
