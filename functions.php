<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


//###############################################################################
//###############################################################################

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


//###############################################################################
//###############################################################################

function task2()
{
    $persons1 = [
        1 => [
            'name' => 'Василий',
            'surname' => 'Кузнецов',
            'age' => 33,
            'married' => true,
            'children' => [1 => 'Коля', 2 => 'Маша', 3 => 'Даша']
        ],
        2 => [
            'name' => 'Марина',
            'surname' => 'Перепелкина',
            'age' => 38,
            'married' => false,
            'children' => []
        ],
        3 => [
            'name' => 'Светлана',
            'surname' => 'Косичкина',
            'age' => 31,
            'married' => true,
            'children' => [1 => 'Ваня']
        ]
    ];

    $json = json_encode($persons1, JSON_UNESCAPED_UNICODE);
    file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . 'output.json', $json);

    // Берём данные из другого (изменённого) файла
    $str = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'output2.json');
    $persons2 = json_decode($str, true);

    // Поиск различий
    echo '<br><br>';
    for ($i = 1; $i <= count($persons1); $i++) {
        $persdata1 = $persons1[$i];
        $persdata2 = $persons2[$i];
        foreach ($persdata1 as $key => $value) {
            if (is_array($value)) {
                $str1 = '[' . implode(', ', $value) . ']';
                $str2 = '[' . implode(', ', $persdata2[$key]) . ']';
            } else {
                $str1 = var_export($value, true);
                $str2 = var_export($persdata2[$key], true);
            }
            // Сравниваем
            if ($str1 != $str2) {
                echo "Было :&nbsp; $key = " . $str1 . '<br>';
                echo "Стало:&nbsp; $key = " . $str2 . '<br><br>';
            }
        }
    }
}


//###############################################################################
//###############################################################################

define('ARR_SIZE', 77);

function task3()
{
    $arrRand = [];
    for ($i = 0; $i < ARR_SIZE; $i++) {
        $arrRand[] = rand(1, 100);
    }

    $csvFileName = __DIR__ . DIRECTORY_SEPARATOR . 'random_numbers.csv';

    // Пишем данные в csv-файл
    $csvFile = fopen($csvFileName, 'wb');
    fputcsv($csvFile, $arrRand, ';');
    fclose($csvFile);

    // Читаем данные из csv-файла
    $csvFile = fopen($csvFileName, 'rb');
    if ($csvFile === false) {
        return null;
    }
    $arrRandNums = fgetcsv($csvFile, 0, ';');
    fclose($csvFile);

    // Считаем сумму чётных чисел
    $sum = 0;
    foreach ($arrRandNums as $num) {
        if ($num % 2 == 0) {
            $sum += $num;
        }
    }

    echo '<br><br>';
    echo 'Сумма чётных чисел = ' . $sum;
    echo '<br><br>';
}


//###############################################################################
//###############################################################################

// рекурсивная функция поиска элемента по ключу в многомерном массиве
function find_value($arr, $key)
{
    foreach ($arr as $k => $v) {
        if ($k === $key) {
            return $v; // нашли - выходим из рекурсии
        } else {
            if (is_array($v)) {
                return find_value($v, $key);
            }
        }
    }
    return null; // не нашли
}


function task4()
{
    // Получаем json по ссылке
    $link = "https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&rvprop=content&format=json";
    $json = file_get_contents($link);

    // Декодируем json в массив
    $data = json_decode($json, true);

    echo '<br>';

    // Ищем в массиве значение по ключу 'title'
    $title = find_value($data, 'title');
    if (!empty($title)) {
        echo 'title = ' . $title . '<br>';
    }

    // Ищем в массиве значение по ключу 'pageid'
    $pageid = find_value($data, 'pageid');
    if (!empty($pageid)) {
        echo 'pageid = ' . $pageid . '<br>';
    }
}
