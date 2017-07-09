<?php
require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.php');

function url($path)
{
    return BASE_URL . $path;
}
function asset($path)
{
    return url('asset'.DIRECTORY_SEPARATOR. $path);
}

