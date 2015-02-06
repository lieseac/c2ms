<?php

/**
 * Builds a url relative to the current path
 * @param type $path
 */
function url($path = "", $relative = false)
{
    $path = ltrim($path, '/');
    
    if ($relative) {
        return BASE_URL . CURRENT_URL . '/' . $path;
    }else{
        return BASE_URL . $path;
    }
}

function image($path, $width = false, $height = false)
{
    $path = ltrim($path, '/');
    
    return BASE_URL . 'images/' . $path;
}

function format_date($format, $date)
{
    $time = new DateTime($date, UTC_TIME);
    $time->setTimezone(LOCAL_TIME);
    return $time->format($format);
}

function to_sql_date($date)
{
    $time = new DateTime($date, LOCAL_TIME);
    $time->setTimezone(UTC_TIME);
    return $time->format('Y-m-d H:i:s');
}