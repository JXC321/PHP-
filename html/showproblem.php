<?php 
$page_title = 'Problem - ' . $_GET['pid'];
include_once('includes/header.html');
require('includes/config.inc.php');
if(isset($_GET['pid'])){
    require(MySQL);
    $pid = mysqli_real_escape_string($dbc,$_GET['pid']);

    $q = "select * from pro where pid={$_GET['pid']}";
    $r = mysqli_query($dbc,$q) or trigger_error("Query:$q\n<br />MySQL Error:" . mysqli_error($dbc));
    if(@mysqli_num_rows($r) == 1){
        #echo "获取成功";
        $_GET = mysqli_fetch_array($r,MYSQLI_ASSOC);
        mysqli_free_result($r);
        mysqli_close($dbc);
        #print_r($_GET);
    }
    else{
        $url = BASE_URL . 'index.php';
        header("Location:$url");
        exit();
    }
}
$info = array('title'=> $_GET['title'],
'description' => $_GET['description'],
'pinput' => $_GET['pinput'],
'poutput' => $_GET['poutput'],
'pinput' => $_GET['pinput'],
'psoutput' => $_GET['psoutput'],
'psinput' => $_GET['psinput']);

$order = array("\r\n","\n","\r");
$replace = '<br />';
foreach($info as $key => $value){
    $info[$key] = str_replace($order,$replace,$value);
}
?>
<style>
p.title{
    height: 38px;
    background: transparent url(panel-title.png) left bottom no-repeat;
    padding: 0 14px;
    color: #7CA9ED;
    font-size: 25px;
    font-family: Arial;
    font-weight: bold;
}
p.content{
    height: auto;
    background: url(panel-content.png) repeat-y;
    margin: 0;
    padding: 0 20px;
    font-size: 20px;
    font-family: Times New Roman;
    text-align: left;
}
h1.title{
    display: block;
    font-size: 2em;
    -webkit-margin-before: 0.67em;
    -webkit-margin-after: 0.67em;
    -webkit-margin-start: 0px;
    -webkit-margin-end: 0px;
    font-weight: bold;
}
</style>
<h1 class="title" style="text-align:center"><?php echo $info['title']; ?></h3>
<p class="title">Problem Description</p>
<p class="content"><?php echo $info['description']; ?></p>
<br />
<p class="title">Input</p>
<p class="content"><?php echo $info['pinput']; ?></p>
<br />
<p class="title">Output</p>
<p class="content"><?php echo $info['poutput']; ?></p>
<br />
<p class="title">Sample Input</p>
<p class="content"><?php echo $info['psinput']; ?></p>
<br />
<p class="title">Sample Output</p>
<p class="content"><?php echo $info['psoutput']; ?></p>
<?php include_once('submit2.php'); ?>
<?php include_once('includes/footer.html'); ?>
