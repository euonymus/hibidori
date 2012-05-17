<?php
class BitlyApi extends Object {
  var $bitly_login = 'euonymus';
  var $bitly_key = 'R_cb8dc50d8b08a9af60d7180aea960d31';
  const bitly_url_genexp = '/^(http|https):\/\/bit\.ly($|\/)/';

  function shorten($longUrl, $strict = false) {
    // 引数のURLが元々bit.ly化されていない場合のみ処理する。
    if(preg_match(self::bitly_url_genexp, $longUrl)) {
      return $longUrl;
    } else {

      $encodedUrl = urlencode($longUrl);
      $bitlyUrl = 'http://api.bit.ly/v3/shorten?login='.$this->bitly_login.'&apiKey='.$this->bitly_key.'&longUrl='.$encodedUrl.'&format=xml';
      $shortUrl =  simplexml_load_file($bitlyUrl);
  
      /* Sample below
      SimpleXMLElement Object
      (
          [status_code] => 200
          [status_txt] => OK
          [data] => SimpleXMLElement Object
              (
                  [url] => http://bit.ly/9efFMC
                  [hash] => 9efFMC
                  [global_hash] => daoZgp
                  [long_url] => http://euonymus.info/
                  [new_hash] => 1
              )
  
      )
      */
  
      if($shortUrl->status_code != 200) {
        $this->log("BITLY API FAILURE: URL: ".$longUrl.". Status_code: ".$shortUrl->status_code.". Status: ".$shortUrl->status_txt);

        if($strict) {
          return false;
        } else {
          return $longUrl;
        }
      } else {
        return (string)$shortUrl->data->url;
      }
    }
  }
}
