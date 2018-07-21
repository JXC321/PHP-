<?php
include('includes/config.inc.php');
include('includes/header.html');

//if($_SERVER['REQUEST_METHOD'] == 'POST'){
if($_SESSION['username']){
    //取得登录用户的用户名和提交问题的ID
	$username = $_SESSION['username'];
	$file = $_POST['pid'];

    //根据选择的语言，确定文件的扩展名。目前仅仅支持python、C++、C和Java
    switch ($_POST['language']){
    case 1:
        $langtype = 'cpp';
        break;
    case 2:
        $langtype = 'c';
        break;
    case 3:
        $langtype = 'java';
        break;
    case 4:
        $langtype = 'php';
        break;
    case 5:
        $langtype = 'py';
        break;
    }

    //创建用户目录，并在用户目录下创建存储代码的文件
    $userDir = "$CODEDIR/".$username."/";
    $uploadDir = $userDir . $file . "/";
    $codefile = $uploadDir . $file . '.' . $langtype;
    echo $codefile . "\n";


	if(!file_exists("$CODEDIR/"))
	{
		mkdir("$CODEDIR/") or die ("Could not create upload directory");
	}
	 
	if(!file_exists($userDir))
	{
		mkdir($userDir);
		chmod($userDir, 0777);
	}
	if(!file_exists($uploadDir))
	{
		mkdir($uploadDir);
		chmod($uploadDir, 0777);
    }

    if(file_exists($codefile)){
        unlink($codefile);
    }
    $f = fopen($codefile,'w');
    fwrite($f,$_POST['usercode']);
    fclose($f);

    //执行判题脚本，用python2写的简易脚本
    exec("python2 acm $codefile $file", $output, $verdict);
    $result = array('Accapted','Compile Error','Wrong Answer','Time Limit','Memory Limit');
    $r = $result[$verdict];
    echo $r;
}
include('includes/footer.html');
?>
