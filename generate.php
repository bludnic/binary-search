<?php
ini_set('max_execution_time', 0);

/*
 * Генерирует n хешей и записывает в файл.
 */
function writeHashes($length = 1000, $hashLength = 10, $filename = 'hashes1000.txt') {
  $prev = '';

  $stream = fopen($filename, 'a');

  for ($i = 0; $i < $length; $i++) {
    $key = generateHash($hashLength, $prev);
    $value = randomStr(rand(10, 30));

    $prev = $key;

    $raw = "$key\t$value\n";
    if ($i === $length - 1) {
      $raw = "$key\t$value";
    }
    
    fwrite($stream, $raw);
  };
  
  fclose($stream);

  return 'Записано в файл: ' . $filename;
}

function generateHash($length = 10, $prev = '') {
  $pointer = 0;
  $startChar = 48;
  $endChar = 90;

  // При первом вызове присваиваем $prev = '0000000000'
  if (empty($prev)) {
    for ($i = 0; $i < $length; $i++) {
      $prev .= chr($startChar);
    }
  } else { // Добавляем +1 к ASCII коду
    $lastSymbol = strlen($prev) - 1;
    $mind = 1;

    for ($i = $lastSymbol; $i >= 0; $i--) {
      $ord = ord($prev[$i]);

      if (($ord + $mind) > $endChar) { // > Z
        $prev[$i] = chr($startChar);
        $mind += $ord + $mind - $endChar;
      } else {
        $prev[$i] = chr($ord + $mind);
        $mind = 0;
      }
    }
  }

  return $prev;
}

function randomStr($length = 10) {
  $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $str = '';

  for ($i = 0; $i < $length; $i++) {
    $str .= $chars[rand(0, strlen($chars) - 1)];
  }

  return $str;
}

echo writeHashes(2684350, 4000, 'hashes.txt'); // 10GB (key length: 4000)
