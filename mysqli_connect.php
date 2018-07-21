<?php # - mysqli_content.php
//数据库连接脚本，用于定义数据库连接的各项信息。

//用常量定义数据库用户、密码、主机名和数据库名
DEFINE('db_user','guest');
DEFINE('db_password','qwer1234');
DEFINE('db_host','localhost');
DEFINE('db_name','SCNU');

//连接数据库
$dbc = @mysqli_connect(db_host,db_user,db_password,db_name);

if(!$dbc){
    trigger_error('Could ont connect to MySQL: ' . mysqli_content_error());
}
else{   //创建编码
    mysqli_set_charset($dbc,'utf8');
}
