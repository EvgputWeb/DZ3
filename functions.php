<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


function task1()
{
    $xmlFileName = __DIR__ . DIRECTORY_SEPARATOR . 'data.xml';
    $xml = simplexml_load_file($xmlFileName);
    if ($xml === false) {
        return null;
    }
    // Сюда попали - значит xml распарсился
    // Подключаем...
    include 'order_blank.php';
}
