<?php
if(!($_SERVER['REQUEST_METHOD'] == 'POST')){
echo '<h1 align="center">Submit Your Solution</h1>';
$pid = isset($_GET['pid']) ? $_GET['pid'] : 1;
echo <<<ABX
<form action="" method="post">
<div class="des" align="center">
问题ID&nbsp;<input type="text" name="problemid" style="width:120px;background-color:F4FBFF;margin-right:40px" value="$pid" />
编程语言&nbsp;
<span style="border:#B7CBFF 1px dashed;width:120px;height:22px;padding:0">
    <select name="language" style="width:121px;font-size:14px;font-family:Arial;background-color:F4FBFF;margin:-1px">
    <option value="1">C++</option>
    <option value="2">C</option>
    <option value="3">Java</option>
    <option value="4">PHP</option>
    </select>
</span>
<br /><br />
<textarea name="usercode" class="code" style="width: 667px; height: 373px"></textarea>
<br />
<input type="submit" value="提交" class="button" />&nbsp;&nbsp;&nbsp;<input type="reset" value="清除" class="button" />
</div>
</form>
</div>
ABX;
}
else{
if(isset($_SESSION['username'])){
	$username = $_SESSION['username'];
	$file = $_POST['problemid'];

    //根据选择的语言，确定文件的扩展名。目前仅仅支持C++、C和Java、PHP
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
    }
    //创建用户目录，并在用户目录下创建存储代码的文件
    $userDir = "$CODEDIR/".$username."/";
    $uploadDir = $userDir . $file . "/";
    $codefile = $uploadDir . $file . '.' . $langtype;
    #echo $codefile . "\n";


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
    echo '<h1 align="center">Submit Your Solution</h1>';
    #echo '提交结果:' . $r;
    require_once('submissions.php');
    $_SERVER['REQUEST_METHOD'] == '';
}}
?>
