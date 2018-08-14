<?php

/*
 * Бинарный поиск по ключу.
 */
function findRaw($searchKey, $filename = 'hashes.txt') {
  $totalBytes = filesize($filename);

  $low = 0;
  $high = $totalBytes - 1;

  $result = 'undefined';
  $cursor = 0;

  $stream = fopen($filename, 'r');

  while ($low < $high) {
    $mid = floor(($low + $high) / 2);
    $ln = null;

    $cursor = $mid;

    // Декремент курсора пока не найдет \n или начало файла.
    while (true) {
      if ($cursor < 0) break;

      fseek($stream, $cursor);
      $symbol = fread($stream, 1);

      // Разделитель \n или начало строки
      if ($symbol === "\n") {
        break;
      } elseif($cursor == 0) {
        fseek($stream, 0);
        break;
      }

      $cursor--; 
    }

    // Получаем ключ => значение
    $line = fgets($stream);
    $lineSplit = explode("\t", $line);

    $key = $lineSplit[0];
    $value = $lineSplit[1];

    // Проверяем совпадает ли ключ
    if ($key === $searchKey) {
      $result = $value;
      break;
    } else {
      if ($searchKey < $key) {
        fseek($stream, $cursor); // Курсор назад на 1 строку
        $high = $mid;
      } else {
        $low = $mid + 1;
      }
    }
  }

  fclose($stream);

  return $result;
}

$timeStart = microtime(true); 
echo findRaw('key', 'hashes.txt');
$timeEnd = microtime(true);

$seconds = ($timeEnd - $timeStart) / 60;
echo 'Время выполнения: ' . number_format($seconds, 10, '.', '');
