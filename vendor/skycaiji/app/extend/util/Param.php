<?php
/*
 |--------------------------------------------------------------------------
 | SkyCaiji (蓝天采集器)
 |--------------------------------------------------------------------------
 | Copyright (c) 2018 https://www.skycaiji.com All rights reserved.
 |--------------------------------------------------------------------------
 | 使用协议  https://www.skycaiji.com/licenses
 |--------------------------------------------------------------------------
 */
 
/*全局参数，集中管理*/
namespace util;

use think\Cache;

class Param{
    private static function set_define($name){
        if(!defined($name)){
            define($name,1);
        }
    }
    private static function defined($name){
        return defined($name)?true:false;
    }
    
    public static function set_task_close_echo(){
        self::set_define('TASK_CLOSE_ECHO');
	}
	public static function is_task_close_echo(){
	    return self::defined('TASK_CLOSE_ECHO');
	}
	
	public static function set_collector_collecting(){
	    self::set_define('COLLECTOR_COLLECTING');
	}
	public static function is_collector_collecting(){
	    return self::defined('COLLECTOR_COLLECTING');
	}
	
	public static function set_task_api_response(){
	    self::set_define('TASK_API_RESPONSE_JSON');
	}
	public static function is_task_api_response(){
	    return self::defined('TASK_API_RESPONSE_JSON');
	}
	
	public static function set_auto_backstage_key(){
	    $key=\util\Funcs::uniqid('collect_auto_backstage_key');
	    \skycaiji\admin\model\CacheModel::getInstance()->setCache('collect_auto_backstage_key', $key);
	    return $key;
	}
	
	public static function get_auto_backstage_key(){
	    return \skycaiji\admin\model\CacheModel::getInstance()->getCache('collect_auto_backstage_key', 'data');
	}
	
	public static function set_proc_open_exec_key(){
	    $key=\util\Funcs::uniqid('proc_open_exec_key');
	    \skycaiji\admin\model\CacheModel::getInstance()->setCache('proc_open_exec_key', $key);
	    return $key;
	}
	
	public static function get_proc_open_exec_key(){
	    return \skycaiji\admin\model\CacheModel::getInstance()->getCache('proc_open_exec_key', 'data');
	}
	
	public static function set_cache_key($prefix=null){
	    $key=\util\Funcs::uniqid($prefix);
	    Cache::set('key_'.$key, '1');
	    return $key;
	}
	
	public static function exist_cache_key($key){
	    $exist=false;
	    if($key){
	        $val=Cache::pull('key_'.$key);
	        if(!empty($val)){
	            $exist=true;
	        }
	    }
	    return $exist;
	}
	
	public static function set_cache_action_order_by($cacheKey,&$order,&$sort){
	    
	    if(!$order||!$sort){
	        
	        $cacheData=cache($cacheKey);
	        $cacheData=is_array($cacheData)?$cacheData:array();
	        if(!$order){
	            $order=$cacheData['order'];
	        }
	        if(!$sort){
	            $sort=$cacheData['sort'];
	        }
	    }else{
	        
	        cache($cacheKey,array('order'=>$order,'sort'=>$sort));
	    }
	}
	
	public static function key_gsc_use_cookie($type=''){
	    $key='collector_use_cookie';
	    if($type){
	        $type=strtolower($type);
	        $key.='_'.$type;
	    }
	    return $key;
	}
	public static function set_gsc_use_cookie($type,$val){
	    set_g_sc(self::key_gsc_use_cookie($type),$val);
	}
	public static function get_gsc_use_cookie($type='',$convert2str=false){
	    $data=g_sc(self::key_gsc_use_cookie($type));
	    init_array($data);
	    if($convert2str){
	        
	        $cookie=array();
            foreach ($data as $k=>$v){
                $cookie[]=$k.'='.$v;
            }
	        $cookie=implode(';', $cookie);
	        $data=$cookie;
	    }
	    return $data;
	}
}

?>