<?php
//定义跳转函数，传入当前页面的page和总的页面数目
function showPage($page,$total_page)
{
    $html = '<a href="?page=1">【首页】</a>';

    $pre_page = $page - 1 <= 0 ? $page : $page - 1;
    $html .= '<a href="?page='.$pre_page.'">【上一页】</a>';

    $next_page = $page + 1 > $total_page ? $page : ($page +1);
    $html .= '<a href="?page='.$next_page.'">【下一页】</a>';

    $html .= '<a href="?page='.$total_page.'">【尾页】</a>';

    return $html;
}
