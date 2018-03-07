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
    // Всё нормально, xml распарсился

    echo $xml->attributes()->PurchaseOrderNumber->__toString() . '<br>';
    echo $xml->attributes()->OrderDate->__toString() . '<br>';

    echo $xml->Address->attributes()->Type->__toString() . '<br>';
    echo $xml->Address->Name->__toString() . '<br>';


}