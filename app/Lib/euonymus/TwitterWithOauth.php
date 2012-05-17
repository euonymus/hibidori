<?php
/**
 * Twitter wrapper class
 *
 */

App::uses('OauthConsumerComponent', 'Controller/Component');
App::uses('BitlyApi', 'euonymus');
class TwitterWithOauth extends Object {
  var $consumer = 'Hibidori';
  var $oauth = null;
  var $bitly_api = null;
  var $bot_list = array('Hibidori');
  var $exec_type = 'user';
  static $WordPattern;

//  static $pattern = '/(http|https):\/\/([\w-]+\.)+[\w-]{2,4}(:\d+)?(\/[\w%=@&~,:+!{}`_\-\.\/\?\[\]]*)?/';
  static $pattern = '/(http|https):\/\/([\w-]+\.)+[\w-]{2,9}(:\d+)?(\/[\w%=@&~,:+!{}`_\-\.\/\?\[\]]*)?/';

  /* It's access_token for @euonymus_trend2   */
  /* @euonymus_trend2                         */
  var $default_key = '217985751-31fT1MoZ4suTbgeIhtl7ZgWX68QqRmvNNheZdidb';
  var $default_secret = 'xZfaWsjMVOpxf9B0XaG0yOTTz5cWFZ3L1KcL0mFcaU';

  private static $instance = NULL;

  public static function getInstance() {
    if (!self::$instance) {
      self::$instance = new TwitterWithOauth();
    }
    return self::$instance;
  }

  public static function init() {
    self::$instance = NULL;
  }

  protected static function setInstance($instance) {
    self::$instance = $instance;
  }

  function getPattern() {
    return self::$pattern;
  }


  function verifyCredentials($ac_token) {
    return self::getInstance()->_verifyCredentials($ac_token);
  }

//  function showUserTimeline($ac_token, $screen_name, $page = 1, $count = 15, $include_entities = false) {
  function showUserTimeline($ac_token, $screen_name, $count = 15, $max_id = false, $since_id = false) {
    return self::getInstance()->_showUserTimeline($ac_token, $screen_name, $count, $max_id, $since_id);
  }

  function updateTwStatus($ac_token, $new_status, $strict_length = false) {
    return self::getInstance()->_updateTwStatus($ac_token, $new_status, $strict_length);
  }

  function retweet($ac_token, $id) {
    return self::getInstance()->_retweet($ac_token, $id);
  }

  function showFriendship($ac_token, $screen_name) {
    return self::getInstance()->_showFriendship($ac_token, $screen_name);
  }

  function createFriendship($ac_token, $screen_name) {
    return self::getInstance()->_createFriendship($ac_token, $screen_name);
  }

  function getUsersLookup($ac_token, $screen_names) {
    return self::getInstance()->_getUsersLookup($ac_token, $screen_names);
  }

  function getUsersLookupWithID($ac_token, $twitter_id) {
    return self::getInstance()->_getUsersLookupWithID($ac_token, $twitter_id);
  }

  function getUserLists($ac_token, $screen_name, $cursor = -1) {
    return self::getInstance()->_getUserLists($ac_token, $screen_name, $cursor);
  }

  /* [important] only screen_name */
  function getUserList($ac_token, $screen_name, $slug) {
    return self::getInstance()->_getUserList($ac_token, $screen_name, $slug);
  }

  /* [important] only twitter_id */
  function getUserListWithID($ac_token, $twitter_id, $slug) {
    return self::getInstance()->_getUserListWithID($ac_token, $twitter_id, $slug);
  }

  /* [important] twitter_id can be set to $screen_name arg as well */
  function postUserList($ac_token, $list_name, $description = '', $private = false) {
    return self::getInstance()->_postUserList($ac_token, $list_name, $description, $private);
  }

  /* [important] only screen_name */
//  function showListTimeline($ac_token, $screen_name, $slug, $page = 1, $per_page = 15) {
  function showListTimeline($ac_token, $screen_name, $slug, $per_page = 15, $max_id = false, $since_id = false) {
    return self::getInstance()->_showListTimeline($ac_token, $screen_name, $slug, $per_page, $max_id, $since_id);
  }

  /* [important] only screen_name */
  function getListMembers($ac_token, $screen_name, $slug, $cursor = -1) {
    return self::getInstance()->_getListMembers($ac_token, $screen_name, $slug, $cursor);
  }

  /* [important] twitter_id can be set to $owner_screen_name arg as well */
  function postListMembers($ac_token, $owner_screen_name, $slug, $user_id) {
    return self::getInstance()->_postListMembers($ac_token, $owner_screen_name, $slug, $user_id);
  }

  /* [important] twitter_id can be set to $owner_screen_name arg as well */
  function deleteListMembers($ac_token, $owner_screen_name, $slug, $user_id) {
    return self::getInstance()->_deleteListMembers($ac_token, $owner_screen_name, $slug, $user_id);
  }

//  function searchWords($ac_token, $search_words, $page = 1, $rpp = 15, $lang = 'ja') {
  function searchWords($ac_token, $search_words, $rpp = 15, $lang = 'ja', $max_id = false, $since_id = false) {
    return self::getInstance()->_searchWords($ac_token, $search_words, $rpp, $lang, $max_id, $since_id);
  }

  function getRequestToken($callback) {
    return self::getInstance()->_getRequestToken($callback);
  }

  function getAccessTokenXauth($screen_name, $password) {
    return self::getInstance()->_getAccessTokenXauth($screen_name, $password);
  }

  function getAccessTokenOauth($requestToken) {
    return self::getInstance()->_getAccessTokenOauth($requestToken);
  }

  function getUsersShow($ac_token, $screen_name) {
    return self::getInstance()->_getUsersShow($ac_token, $screen_name);
  }
  
  function getUsersShowWithID($ac_token, $user_id) {
    return self::getInstance()->_getUsersShowWithID($ac_token, $user_id);
  }
  
  /*********************************************************/
  /* Calling Twitter APIs functions                        */
  /*********************************************************/
  function _verifyCredentials($ac_token) {
    $api = 'https://api.twitter.com/1/account/verify_credentials.json';
    return $this->_execTwApi($ac_token, $api, array(), 'get');
  }

//  function _showUserTimeline($ac_token, $screen_name, $page = 1, $count = 15, $include_entities = false) {
  function _showUserTimeline($ac_token, $screen_name, $count = 15, $max_id = false, $since_id = false) {
    $api = 'https://api.twitter.com/1/statuses/user_timeline.json';
    $data = array('screen_name' => $screen_name, 'count' => $count, 'include_entities' => 'true');
    if ($max_id) {
      $data['max_id'] = $max_id;
    }
    if ($since_id) {
      $data['since_id'] = $since_id;
    }
    return $this->_execTwApi($ac_token, $api, $data, 'get');
  }

  function _updateTwStatus($ac_token, $new_status, $strict_length = false) {
    // From Au, sometimes encodes Japanese characters as S-jis.
    // So this logic makes sure the keywords encoded as UTF-8
    mb_language("Japanese");
    if (mb_detect_encoding($new_status,"auto") != "UTF-8") $new_status = mb_convert_encoding($new_status, "UTF-8","auto");

    $api = 'https://api.twitter.com/1/statuses/update.json';

    $new_status = $this->shorten($new_status);
    if( $strict_length && (mb_strlen($new_status) > 140) ) return array('error' => 'Status is over 140 characters.');
    $data = array('status' => $new_status);
    return $this->_execTwApi($ac_token, $api, $data);
  }

  function _retweet($ac_token, $id) {
    $api = 'https://api.twitter.com/1/statuses/retweet/'.$id.'.json';
    return $this->_execTwApi($ac_token, $api, array());
  }

  function _showFriendship($ac_token, $screen_name) {
    $api = 'https://api.twitter.com/1/friendships/show.json';
    $data = array('target_screen_name' => $screen_name);
    return $this->_execTwApi($ac_token, $api, $data, 'get');
  }

  function _createFriendship($ac_token, $screen_name) {
    $api = 'https://api.twitter.com/1/friendships/create.json';
    $data = array('screen_name' => $screen_name);
    return $this->_execTwApi($ac_token, $api, $data);
  }

  function _getUsersLookup($ac_token, $screen_names) {
    $api = 'https://api.twitter.com/1/users/lookup.json';
    $data = array('screen_name' => implode(',', $screen_names));
    return $this->_execTwApi($ac_token, $api, $data, 'post');
  }

  function _getUsersLookupWithID($ac_token, $twitter_id) {
    $api = 'https://api.twitter.com/1/users/lookup.json';
    $data = array('user_id' => implode(',', $twitter_id));
    return $this->_execTwApi($ac_token, $api, $data, 'post');
  }

/******* ↓↓↓この関数は未テスト↓↓↓ *********/
  function _getUserLists($ac_token, $screen_name, $cursor = -1) {
    $api = 'https://api.twitter.com/1/lists.json';
    $data = array('cursor' => $cursor, 'screen_name' => $screen_name);
    return $this->_execTwApi($ac_token, $api, $data, 'get');
  }
/******* ↑↑↑この関数は未テスト↑↑↑ *********/

  /* [important] only screen_name */
  function _getUserList($ac_token, $screen_name, $slug) {
    $api = 'https://api.twitter.com/1/lists/show.json';
    $data = array('slug' => $slug, 'owner_screen_name' => $screen_name);
    return $this->_execTwApi($ac_token, $api, $data, 'get');
  }

  /* [important] only twitter_id */
  function _getUserListWithID($ac_token, $twitter_id, $slug) {
    $api = 'https://api.twitter.com/1/lists/show.json';
    $data = array('slug' => $slug, 'owner_id' => $twitter_id);
    return $this->_execTwApi($ac_token, $api, $data, 'get');
  }

  /* [important] twitter_id can be set to $screen_name arg as well */
  function _postUserList($ac_token, $list_name, $description = '', $private = false) {
    $api = 'https://api.twitter.com/1/lists/create.json';
    $data = array('name' => $list_name,
                  'description' => $description,
                  'mode' => ($private) ? 'private' : 'public');
    return $this->_execTwApi($ac_token, $api, $data, 'post');
  }

  /* [important] only screen_name */
//  function _showListTimeline($ac_token, $screen_name, $slug, $page = 1, $per_page = 15) {
  function _showListTimeline($ac_token, $screen_name, $slug, $per_page = 15, $max_id = false, $since_id = false) {
    $api = 'https://api.twitter.com/1/lists/statuses.json';
    $data = array('per_page' => $per_page, 'slug' => $slug, 'owner_screen_name' => $screen_name);
    if ($max_id) {
      $data['max_id'] = $max_id;
    }
    if ($since_id) {
      $data['since_id'] = $since_id;
    }
    return $this->_execTwApi($ac_token, $api, $data, 'get');
  }

  /* [important] only screen_name */
  function _getListMembers($ac_token, $screen_name, $slug, $cursor = -1) {
    $api = 'https://api.twitter.com/1/lists/members.json';
    $data = array('cursor' => $cursor, 'slug' => $slug, 'owner_screen_name' => $screen_name);
    return $this->_execTwApi($ac_token, $api, $data, 'get');
  }

  /* [important] twitter_id can be set to $owner_screen_name arg as well */
  function _postListMembers($ac_token, $owner_screen_name, $slug, $user_id) {
    $api = 'https://api.twitter.com/1/lists/members/create.json';
    $data = array('user_id' => $user_id, 'slug' => $slug, 'owner_screen_name' => $owner_screen_name);
    return $this->_execTwApi($ac_token, $api, $data, 'post');
  }

  /* [important] twitter_id can be set to $owner_screen_name arg as well */
  function _deleteListMembers($ac_token, $owner_screen_name, $slug, $user_id) {
    $api = 'https://api.twitter.com/1/lists/members/destroy.json';
    $data = array('user_id' => $user_id, 'slug' => $slug, 'owner_screen_name' => $owner_screen_name);
    return $this->_execTwApi($ac_token, $api, $data, 'post');
  }

//  function _searchWords($ac_token, $search_words, $page = 1, $rpp = 15, $lang = 'ja') {
  function _searchWords($ac_token, $search_words, $rpp = 15, $lang = 'ja', $max_id = false, $since_id = false) {
    // From Au, sometimes encodes Japanese characters as S-jis.
    // So this logic makes sure the keywords encoded as UTF-8
    mb_language("Japanese");
    if (mb_detect_encoding($search_words,"auto") != "UTF-8"){
      $search_words = mb_convert_encoding($search_words, "UTF-8","auto");
    }

    $api = 'https://search.twitter.com/search.json';
    $data = array('q' => $search_words, 'rpp' => $rpp, 'lang' => $lang);
    if ($max_id) {
      $data['max_id'] = $max_id;
    }
    if ($since_id) {
      $data['since_id'] = $since_id;
    }
    return $this->_execTwApi($ac_token, $api, $data, 'get');
  }

  function _getRequestToken($callback) {
    if(is_null($this->oauth)) $this->oauth = new OauthConsumerComponent(new ComponentCollection());
    $requestToken = $this->oauth->getRequestToken($this->consumer, 'https://api.twitter.com/oauth/request_token', $callback);
    if(empty($requestToken)) {
      $this->log("TWITTER OAUTH FAILURE: couldn't get request_token. USER AGENT: ".env('HTTP_USER_AGENT'), LOG_DEBUG);
      return false;
    }
    return $requestToken;
  }

  function _getAccessTokenXauth($screen_name, $password) {
    if(is_null($this->oauth)) $this->oauth = new OauthConsumerComponent(new ComponentCollection());
    $requestIdPw = array('Id' => $screen_name, 'Pw' => $password);
    $accessToken = $this->oauth->getAccessTokenXauth($this->consumer, 'https://api.twitter.com/oauth/access_token', $requestIdPw, 'POST');
    if(empty($accessToken)) {
      $this->log("LOGIN FAILURE: xAuth access was not accepted by Twitter. ID: ".$screen_name.". USER AGENT: ".env('HTTP_USER_AGENT'), LOG_DEBUG);
      return false;
    }
    return $accessToken;
  }

  function _getAccessTokenOauth($requestToken) {
    if(is_null($this->oauth)) $this->oauth = new OauthConsumerComponent(new ComponentCollection());
    $accessToken = $this->oauth->getAccessToken($this->consumer, 'https://api.twitter.com/oauth/access_token', $requestToken);
    if(empty($accessToken)) {
      $this->log("LOGIN FAILURE: OAuth access was not accepted by Twitter. USER AGENT: ".env('HTTP_USER_AGENT'), LOG_DEBUG);
      return false;
    }
    return $accessToken;
  }

  function _getUsersShow($ac_token, $screen_name) {
    $api = 'https://api.twitter.com/1/users/show.json';
    $data = array('screen_name' => $screen_name);
    return $this->_execTwApi($ac_token, $api, $data, 'GET');
  }
  
  function _getUsersShowWithID($ac_token, $user_id) {
    $api = 'https://api.twitter.com/1/users/show.json';
    $data = array('user_id' => $user_id);
    return $this->_execTwApi($ac_token, $api, $data, 'GET');
  }
  
  
  /*********************************************************/
  /* Followings are primitive functions                    */
  /*********************************************************/
  function _execTwApi($ac_token, $api, $data, $method = 'post') {
    if(!$this->_setExecType($ac_token)) return array('error' => 'Unexpected consumer type.');

    if($this->exec_type == 'user') $ret = $this->_execTwApiUser($ac_token, $api, $data, $method);
    elseif($this->exec_type == 'bot') $ret = $this->_execTwApiBot($ac_token, $api, $data, $method);
    else $ret = array('request' => 'NA', 'error' => 'Fatal error. exec_type is wrong.');
    if(array_key_exists('error', $ret)) {
      if(isset($ret['request'])) $request = $ret['request'];
      else $request = 'NA';
      $this->log("TWITTER API FAILURE: Request: ".$request.". Message: ".$ret['error'], 'twitter_api_call');
    } elseif(array_key_exists('errors', $ret)) {
      $ret['error'] = $ret['errors'];
      if(isset($ret['request'])) $request = $ret['request'];
      else $request = 'NA';
      $this->log("TWITTER API FAILURE: Request: ".$request.". Message: ".$ret['error'], 'twitter_api_call');
    }

    // Set id_str to id, if it exists
    if(array_key_exists(0, $ret)) {
      for($i=0;$i<count($ret);$i++){
        $ret[$i] = $this->_setIdStr($ret[$i]);
      }
    } else {
      $ret = $this->_setIdStr($ret);
    }

    return $ret;
  }

  function _execTwApiUser(&$ac_token, $api, $data, $method = 'post') {
    // Follow the campaign owner account
    if(is_null($this->oauth)) $this->oauth = new OauthConsumerComponent(new ComponentCollection());
    if($method == 'post') $json_data = $this->oauth->post($this->consumer, $ac_token->key, $ac_token->secret, $api, $data);
    else $json_data = $this->oauth->get($this->consumer, $ac_token->key, $ac_token->secret, $api, $data);
    $result = json_decode($json_data, true);
    if(!is_array($result)) $result = array('request' => 'Network problem', 'error' => 'Fatal error');
    return $result;
  }

  function _execTwApiBot($bot_consumer, $api, $data, $method = 'post') {
    // Follow the campaign owner account
    if(is_null($this->oauth)) $this->oauth = new OauthConsumerComponent(new ComponentCollection());
    if($method == 'post') $json_data = $this->oauth->post2($bot_consumer, $api, $data);
    else $json_data = $this->oauth->get2($bot_consumer, $api, $data);
    $result = json_decode($json_data, true);
    if(!is_array($result)) $result = array('request' => 'Network problem', 'error' => 'Fatal error');
    return $result;
  }

  function shorten($new_status) {
    preg_match_all(self::$pattern , $new_status , $matches, PREG_SET_ORDER);
    if(is_null($this->bitly_api)) $this->bitly_api = new BitlyApi();
    foreach($matches as $match) {
      $shortened = $this->bitly_api->shorten($match[0]);
      $new_status = str_replace($match[0], $shortened, $new_status);
    }
    return $new_status;
  }

  function _setExecType($ac_token) {
    $this->exec_type = 'user';
    if(is_string($ac_token)) {
      if(!in_array($ac_token, $this->bot_list)) return false;
      $this->exec_type = 'bot';
    }
    return true;
  }

  function _setIdStr($data){
    if(array_key_exists('id_str', $data)) $data['id'] = $data['id_str'];
    if(array_key_exists('since_id_str', $data)) $data['since_id'] = $data['since_id_str'];
    if(array_key_exists('max_id_str', $data)) $data['max_id'] = $data['max_id_str'];
    if(array_key_exists('next_cursor_str', $data)) $data['next_cursor'] = $data['next_cursor_str'];
    if(array_key_exists('previous_cursor_str', $data)) $data['previous_cursor'] = $data['previous_cursor_str'];

    if(array_key_exists('status', $data)) {
      if(array_key_exists('id_str', $data['status'])) $data['status']['id'] = $data['status']['id_str'];
    }

    if(array_key_exists('user', $data)) {
      if(array_key_exists('id_str', $data['user'])) $data['user']['id'] = $data['user']['id_str'];
    }
    if(array_key_exists('users', $data)) {
      for($i=0;$i<count($data['users']);$i++){
        if(array_key_exists('id_str', $data['users'][$i])) $data['users'][$i]['id'] = $data['users'][$i]['id_str'];
      }
    }

    if(array_key_exists('results', $data)) {
/*
      for($i=0;$i<count($data['results']);$i++){
        if(array_key_exists('id_str', $data['results'][$i])) $data['results'][$i]['id'] = $data['results'][$i]['id_str'];
        if(array_key_exists('from_user_id_str', $data['results'][$i])) $data['results'][$i]['from_user_id'] = $data['results'][$i]['from_user_id_str'];
        if(array_key_exists('to_user_id_str', $data['results'][$i])) $data['results'][$i]['to_user_id'] = $data['results'][$i]['to_user_id_str'];
      }
*/
      $tmp_arr = $data['results'];
      $data['results'] = array();
      foreach($tmp_arr as $key => $val) {
        if(array_key_exists('id_str', $val)) $tmp_arr[$key]['id'] = $val['id_str'];
        if(array_key_exists('from_user_id_str', $val)) $tmp_arr[$key]['from_user_id'] = $val['from_user_id_str'];
        if(array_key_exists('to_user_id_str', $val)) $tmp_arr[$key]['to_user_id'] = $val['to_user_id_str'];

      //  if (!preg_match('/オールスターズ/', $val['text'])) $data['results'][] = $val;

        if($this->isOk($val['text'])) $data['results'][] = $val;
      }
    }

    return $data;
  }

  function isOk($tag) {
    return !$this->isNg($tag);
  }

  function isNg($tag) {
    if (!self::$WordPattern) {
      self::$WordPattern =& ClassRegistry::init('WordPattern');
    }

    return self::$WordPattern->isNg($tag);
  }
}