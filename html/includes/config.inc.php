<?php #config.inc.php

//定义两个用户报告错误的常量
DEFINE('LIVE',TRUE);   //是否把详细的出错信息发送到网页上，如果LIVE是FALSE就发送，是TRUE就不发送.建议开发阶段设置为FALSE，使用阶段设置为TRUE。
DEFINE('EMAIL','2986957136@qq.com');    //定义管理员邮箱，把站点的出错信息发送给管理员邮箱

//定义两个用于站点级设置的常量
define('BASE_URL','http://localhost/html/');    //定义根域，用于方便重定向
define('MySQL','/var/www/html/mysqli_connect.php');    //定义MySQL连接脚本的绝对路径，任何文件都可以通过引用这个变量来包含连接脚本

//设置时区
date_default_timezone_set('Asia/Shanghai');

//自定义错误处理函数，这个函数接收五个参数：错误编号、出错信息、发生错误的脚本、发生错误的行号以及现存变量的数组。
function my_error_handler($e_number,$e_message,$e_file,$e_line,$e_vars){
    $message = "An error occurred in script '$e_file' on line $e_line : $e_message\n";

    $message .= "Date/Time: " . date('n-j-Y H:i:s') . "\n"; //往错误信息中加入时间

    if(!LIVE){  //在网页上打印详细的错误信息
        echo '<div class="error">' . nl2br($message);   //打印错误信息

        //echo '<per>' . print_r($e_vars,1) . "\n";   //打印现存数组
        //debug_print_backtrace();    //报告调用了哪些函数以及包含了哪些文件
        echo '</per></div>';
    }
    else{   //不打印详细的错误信息，将错误的详细信息发送给管理员，只告知用户发生了错误
        $body = $message . "\n" . print_r($e_vars,1);
        mail(EMAIL,'Site Error!',$body,'From:email@example.com');

        if($e_number != E_NOTICE){  //简单告知用户发生了错误
            #echo '<div class="error">A system error occurred.We apologize for the inconvenience. </div><br />';
        }
    }
}
//告诉PHP使用我们自定义的错误处理函数
set_error_handler('my_error_handler');

$points = range(1,100); //判定每道题目的分数，数组的长度决定问题的个数
$running = true;    //规定用户是否可以提交代码

#代码和问题的存储文件
$CODEDIR = 'code';
$PROBLEMDIR = 'peoblems';

//刷新排行榜之间的时间间隔（毫秒）
$getLeaderInterval = 10000;
//论坛刷新时间间隔（毫秒）
$getChatInterval = 1000;
?>

