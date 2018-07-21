<?php
include(MySQL);
$userid = $_SESSION['id'];
$username = $_SESSION['username'];
$pid = $_GET['pid'];
$status = $verdict;
$t = time();

$q = "insert into submissions values(NULL,$userid,$pid,$status,$t)";
$r = mysqli_query($dbc,$q) or trigger_error("Query:$q\n<br />MySQL Error:" . mysqli_error($dbc));

?>

<style>
.table{
width:100%;
text-align:center;
}
</style>
<table name="show_status" class="table">
<tbody class="table">
<tr><th>问题ID</th><th>用户名</th><th>提交状态</th><th>提交时间</th></tr>
<tr>
<td><?php echo $pid; ?></td>
<td><?php echo $username; ?></td>
<td><?php echo $result[$verdict]; ?></td>
<td><?php echo date('Y-m-d H:i:s',$t); ?></td>
</tr>
</tbody>
</table>
