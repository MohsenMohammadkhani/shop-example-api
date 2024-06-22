<?php

use Symfony\Component\VarDumper\VarDumper;

function ddCors(...$args)
{
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: *');
    header('Access-Control-Allow-Headers: *');
    http_response_code(500);
    foreach ($args as $x) {
        (new  VarDumper)->dump($x);
    }

    die(1);
}
