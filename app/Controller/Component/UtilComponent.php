<?php
class UtilComponent extends Object {
  var $components = array('Session');
  
  function startup(&$controller) {
  }

  function shutdown(&$controller) {
  }

  function beforeRedirect(&$controller) {
  }

  function beforeRender(&$controller) {
  }

  function initialize(&$controller, $settings = array()) {
  $this->Controller =& $controller;
  $this->_set($settings);
  }
  
  public function writeSession($name, $value) {
    $serialized = $this->serializer($value);
    $this->Controller->Session->write($name, $serialized);
  }
  
  public function readSession($name) {
    $serialized = $this->Controller->Session->read($name);
    $unserialized = $this->unserializer($serialized);
    return $unserialized;
  }
  
  public function serializer($value) {
    return base64_encode(serialize($value));
  }
  
  public function unserializer($value) {
    return unserialize(base64_decode($value));
  }
  
  public function getStringViewElement($params, $element_template=null, $layout=null) {
    $default_layout = 'blank';
    $viewClass = $this->Controller->view;
    if ($viewClass != 'View') {
      if (strpos($viewClass, '.') !== false) {
        list($plugin, $viewClass) = explode('.', $viewClass);
      }
      $viewClass = $viewClass . 'View';
      App::import('View', $this->Controller->view);
    }
    $View = new $viewClass($this->Controller, false);
    if (is_null($layout)) {
      $View->layout = $default_layout;
    } else {
      $View->layout = $layout;
    }
    // $element_template の例 $element_template = 'email' . DS . 'text' . DS . 'hoge';
    // $params の例 $params = array('content' => 'contentcontent...');
    $content = $View->element($element_template, $params, true);
    $content = $View->renderLayout($content);
    
    return $content;
  }
  
}