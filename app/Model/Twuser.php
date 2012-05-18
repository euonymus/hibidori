<?php /* -*- coding: utf-8 -*- */
/**
 * Description: model for the table "twusers"
 */
App::uses('TwitterWithOauth', 'euonymus');
App::uses('Twitter', 'euonymus');
class Twuser extends AppModel {

//  function beforeSave($options) {
//    return $options;
//  }

  function saveAndGetId($tw_user, $ac_token = null) {
    if($this->updateTwuser( null, $tw_user, $ac_token )) $ret = $tw_user['id'];
    else $ret = false;
    return $ret;
  }

  function updateTwuser( $id = null, $tw_user, $ac_token = null ){
    $savedata = $this->convertArray($tw_user, $ac_token);
    $saved  = $this->save($savedata);
    if(empty($saved)) $ret = false;
    else $ret = true;
    return $ret;
  }

  // This convert Twitter API array to Twuser table array
  function convertArray( $tw_user, $ac_token = null ){

    $tw_user['profile_image_url'] = Twitter::convertImgToBigger($tw_user['profile_image_url']);
    $savedata = array(
      'id' => $tw_user['id'],
      'screen_name' => $tw_user['screen_name'],
      'name' => $tw_user['name'],
      'description' => $tw_user['description'],
      'followers_count' => $tw_user['followers_count'],
      'friends_count' => $tw_user['friends_count'],
      'url' => $tw_user['url'],
      'lang' => $tw_user['lang'],
      'location' => $tw_user['location'],
      'time_zone' => $tw_user['time_zone'],
      'utc_offset' => $tw_user['utc_offset'],
      'profile_image_url' => $tw_user['profile_image_url'],
      'profile_image_url_https' => $tw_user['profile_image_url_https'],
      'protected' => $tw_user['protected'],
      'verified' => empty($tw_user['verified']) ? 0 : 1
    );
    if(!is_null($ac_token)){
      $savedata_actoken = array(
        'accesskey' => $ac_token->key,
        'accesssecret' => $ac_token->secret
      );
      $savedata = am($savedata, $savedata_actoken);
    }
    return $savedata;
  }
}
