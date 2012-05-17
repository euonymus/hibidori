<?php

class Crypt extends Object {

  const ENCODE_FRAGMENTS = 4;
  const SEPARATOR = ';';

  function encrypt($string) {
    $salt = md5(mt_rand());
    $len = strlen($salt);
    $partLen = $len / 4;
    $front = substr($salt, 0, mt_rand(1, $partLen));
    $rear = substr($salt, mt_rand($partLen, $len - 1));
    $string =
      $front . self::SEPARATOR . $string . self::SEPARATOR . $rear;

    $base = base64_encode($string);
    $base = str_replace('=', '*', $base);

    $fragments = array();
    for ($i = 0; $i < self::ENCODE_FRAGMENTS; ++$i) {
      $fragments[] = array();
    }

    $length = strlen($base);
    for ($i = 0; $i < $length; ++$i) {
      $fragments[$i % self::ENCODE_FRAGMENTS][] = $base[$i];
    }

    $result = '';
    for ($i = 0; $i < self::ENCODE_FRAGMENTS; ++$i) {
      $result .= implode('', $fragments[$i]);
    }

    return $result;
  }

  function decrypt($string) {
    $length = strlen($string);
    $fragmentLength = ceil(strlen($string) / self::ENCODE_FRAGMENTS);

    $fragments = array();
    for ($i = 0; $i < $fragmentLength; ++$i) {
      $fragments[] = array();
    }

    for ($i = 0; $i < $length; ++$i) {
      $fragments[$i % $fragmentLength][] = $string[$i];
    }

    $result = '';
    for ($i = 0; $i < $fragmentLength; ++$i) {
      $result .= implode('', $fragments[$i]);
    }

    $result = str_replace('*', '=', $result);
    $result = base64_decode($result);
    $front = strpos($result, self::SEPARATOR);
    $rear = strrpos($result, self::SEPARATOR);

    if ($front === FALSE || $rear == FALSE) {
      return '';
    }

    return substr($result, $front + 1, $rear - $front - 1);
  }

}