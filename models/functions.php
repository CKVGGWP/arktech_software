<?php

function show($param)
{
    echo "<pre>";
    print_r($param);
    echo "</pre>";
}

function read_date($str)
{
    if ($str)
        return date('F j, Y, g:i:s a', strtotime($str));
    else
        return null;
}

function read_time($str)
{
    if ($str)
        return date('g:i A', strtotime($str));
    else
        return null;
}

function make_date()
{
    return strftime("%Y-%m-%d %H:%M:%S", time());
}

function count_id()
{
    static $count = 1;
    return $count++;
}

function getTitle()
{

    $id = isset($_GET['id']) ? $_GET['id'] : '';

    $title = '';

    if (!empty($id)) :
        $title .= $id;
    else :
        $title .= 'Login | ArkTech Manufacturing';
    endif;

    return $title;
}
