<?php
/**
 * Created by PhpStorm.
 * User: Яяя
 * Date: 11.05.2019
 * Time: 18:33
 * @param array $variables
 */

function dd(... $variables)
{
    echo "<pre>";

    foreach ($variables as $var)
        var_dump($var);

    die;
}

function dump(... $variables)
{
    echo "<pre>";

    foreach ($variables as $var)
        var_dump($var);
}

function dateFormat($date, $format = 'd.m.Y')
{
    return filled($date) ? date($format, strtotime($date)) : null;
}

function filled(...$values)
{
    foreach ($values as $value)
        if ($value === null || $value === [] || $value === '')
            return false; return true;
}

function combine_key_values(array $db_result, $keys)
{
    foreach ($db_result as &$record)
        $record = array_combine($keys, $record);

    return $db_result;
}