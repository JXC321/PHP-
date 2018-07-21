<?php

require('config.inc.php');
require(MySQL);
include('page.php');

$q = "select count(*) from pro";
$r = mysqli_query($dbc,$q) or trigger_error("Query:$q/n<br /> MySQL Error:" . mysqli_error($dbc));

$total_num = mysqli_fetch_array($r)[0];
$perpage = 10;  //每页显示的信息数
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; //获取当前页
$total_page = ceil($total_num/$perpage);  //获取总页数
//当前页的一些合理化
$page = max($page,1);
$page = min($page,$total_page);

$start_index = $perpage * ($page -1) + 1; //每页开始
$end_index = $perpage * $page; //每页结束
$end_index = min($end_index,$total_num);

$q1 = "select pid,title from pro where pid between $start_index and $end_index";
#print($q1);
$r1 = mysqli_query($dbc,$q1) or trigger_error("Query:$q/n<br /> MySQL Error:" . mysqli_error($dbc));
?>

<link rel="stylesheet" type="text/css" href="styles/qu_list.css">
<table class="table">
<tr><th>ID</th><th>Title</th><th>Ratio(AC/Submit)</th></tr>
<?php while($rows = mysqli_fetch_array($r1,MYSQL_ASSOC)) { ?>
<tr>
    <td><?php echo $rows['pid']; ?></td>
    <td class="title"><a href=<?php echo "showproblem.php?pid=" . $rows['pid'];?> ><?php echo $rows['title']; ?></a></td>
</tr>
<?php } ?>
</table>
<div style="text-align:center;"> <?php echo showPage($page,$total_page); ?> </div>
