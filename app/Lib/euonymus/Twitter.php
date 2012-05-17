<?php
/**
 * Twitter wrapper class
 *
 */

class Twitter {
  function convertImgToBigger($originalpath){
    $extension = substr($originalpath, strrpos($originalpath, '.'));

    // if the image is on the web
    if(strncmp($originalpath, 'http', 4) == 0) {
      // Separate the image url into 2, front and extention.
      $ahead = substr($originalpath, 0, strrpos($originalpath, '.'));

      // generate default 2 parts
      if (preg_match('/_bigger$/', $ahead)) {
        $ahead = preg_replace('/_bigger$/', '', $ahead);
      }
      elseif (preg_match('/_normal$/', $ahead)) {
        $ahead = preg_replace('/_normal$/', '', $ahead);
      }
      elseif (preg_match('/_mini$/', $ahead)) {
        $ahead = preg_replace('/_mini$/', '', $ahead);
      }

      // check which image is the biggest
      $type = '_bigger';
      if(@fopen($ahead.'_bigger'.$extension,'r')) $type = '_bigger';
      else if(@fopen($ahead.$extension,'r')) $type = '';
      else if(@fopen($ahead.'_normal'.$extension,'r')) $type = '_normal';
      else if(@fopen($ahead.'_mini'.$extension,'r')) $type = '_mini';
      $biggest = $ahead.$type.$extension;
    } else {
      $biggest = $originalpath;
    }
    return $biggest;
  }
}
