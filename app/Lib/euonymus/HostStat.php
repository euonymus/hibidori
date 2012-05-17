<?php
/*
 * HostStat: Host Status Detection
 *
 */
config('host');

class HostStat extends Object {
  
  private static $instance = NULL;

  const hostHonban       = 1;
  const hostHonbanBatch  = 8;
  const hostLocal        = 99;

  // host symbols
  const HOST_PC = 'PC';
  const HOST_BATCH = 'Batch';
  const HOST_LOCALHOST = 'Localhost';

  private static $env_list = array(
    self::hostHonban       => 'Honban',
    self::hostHonbanBatch  => 'HonbanBatch',
    self::hostLocal        => 'Local');

  private $domain_list = array();

  public static function getInstance() {
    if (!self::$instance) {
      self::$instance = new HostStat();
      self::$instance->_setDomainList();
    }

    return self::$instance;
  }

  function _setDomainList(){
    $this->domain_list = array(
      self::$env_list[self::hostHonban]      => 'hibidori.euonymus.info',
      self::$env_list[self::hostLocal]       => 'hibidori.localhost');
  }

  public static function init() {
    self::$instance = NULL;
  }

  public static function getHttpHost() {
    return self::getInstance()->_getHttpHost();
  }

  public static function getHostName() {
    return self::getInstance()->_getHostName();
  }

  public static function getDomain($flg = false) {
    return self::getInstance()->_getDomain($flg);
  }

  public static function getEnv($flg = false) {
    return self::getInstance()->_getEnv($flg);
  }

  public static function isHonbanOrPreview() {
    return self::getInstance()->_isHonbanOrPreview();
  }

  public static function isHonban() {
    return self::getInstance()->_isHonban();
  }

  public static function isHonbanBatch() {
    return self::getInstance()->_isHonbanBatch();
  }

  public static function isLocal() {
    return self::getInstance()->_isLocal();
  }

  // instance methods
  function __construct() {
    $this->HTTP_HOST = env('HTTP_HOST');
    $this->hostname = php_uname('n');
    $this->host = Configure::read('Hibidori.host');
  }

  function _getHttpHost() {
    return $this->HTTP_HOST;
  }

  function _getHostName() {
    return $this->hostname;
  }

  function _getDomain($flg = false) {
    $current_env = $this->_getEnv($flg);
    switch ($current_env) {
      case self::$env_list[self::hostHonbanBatch]:
            return false;
      case self::$env_list[self::hostLocal]:
            return $this->HTTP_HOST;
    }

    if(!$current_env) return false;
    if(!array_key_exists($current_env, $this->domain_list)) return false;

    return $this->domain_list[$current_env];
  }

  function _getEnv($virtualHost = false) {
    if($this->_isHonban()) return self::$env_list[self::hostHonban];
    if($this->_isLocal()) return self::$env_list[self::hostLocal];

    return false;
  }

  function _isHonbanOrPreview() {
    return $this->_isHonban();
  }

  function _isHonban() {
    return (env('PROD') )
      || ($this->host === self::HOST_PC && !$this->_isPreview());
  }

  function _isHonbanBatch() {
    return ($this->host === self::HOST_BATCH);
  }

  function _isLocal() {
    if (env('LOCAL')) {
      return true;
    } elseif (!empty($this->HTTP_HOST)) {
      $pos = stripos($this->HTTP_HOST, 'localhost');
      if ($pos !== false) return true;
    } elseif (empty($this->host) || ($this->host === self::HOST_LOCALHOST)) {
      return true;
    }

    return false;
  }
}
