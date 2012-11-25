<?php
/**
 * http_request
 *
 * @version 1.2 - 25.11.2012
 * @author Roland 'rosali' Liebl
 * @website http://myroundcube.googlecode.com
 * 
 **/
 
/**
 *
 * Usage: http://mail4us.net/myroundcube/
 *
 **/    
 
class http_request extends rcube_plugin{

  static private $plugin = 'http_request';
  static private $author = 'myroundcube@mail4us.net';
  static private $authors_comments = null;
  static private $download = 'http://myroundcube.googlecode.com';
  static private $version = '1.2';
  static private $date = '25-11-2012';
  static private $licence = 'GPL';
  static private $requirements = array(
    'Roundcube' => '0.7.1',
    'PHP' => '5.2.1'
  );
  
  static public $http;
  
  function init(){
    if(!class_exists('Http')){
      require_once('class.http.php');
      self::$http = new MyRCHttp();
    }
  }
  
  static public function about($keys = false){
    $requirements = self::$requirements;
    foreach(array('required_', 'recommended_') as $prefix){
      if(is_array($requirements[$prefix.'plugins'])){
        foreach($requirements[$prefix.'plugins'] as $plugin => $method){
          if(class_exists($plugin) && method_exists($plugin, 'about')){
            /* PHP 5.2.x workaround for $plugin::about() */
            $class = new $plugin(false);
            $requirements[$prefix.'plugins'][$plugin] = array(
              'method' => $method,
              'plugin' => $class->about($keys),
            );
          }
          else{
             $requirements[$prefix.'plugins'][$plugin] = array(
               'method' => $method,
               'plugin' => $plugin,
             );
          }
        }
      }
    }
    $ret = array(
      'plugin' => self::$plugin,
      'version' => self::$version,
      'date' => self::$date,
      'author' => self::$author,
      'comments' => self::$authors_comments,
      'licence' => self::$licence,
      'download' => self::$download,
      'requirements' => $requirements,
    );
    if(is_array($keys)){
      $return = array('plugin' => self::$plugin);
      foreach($keys as $key){
        $return[$key] = $ret[$key];
      }
      return $return;
    }
    else{
      return $ret;
    }
  }
}
?>