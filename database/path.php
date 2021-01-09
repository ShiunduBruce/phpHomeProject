<?php
function path($filename)
{
    return realpath(dirname(__FILE__)) . "\\" . $filename;
}
