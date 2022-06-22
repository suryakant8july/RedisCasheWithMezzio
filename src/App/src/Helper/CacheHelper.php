<?php

declare(strict_types=1);

namespace App\Helper;

use Exception;
use Laminas\Cache\Storage\Adapter\Redis;
use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\ServiceManager;
//use Laminas\Cache\Storage\Adapter\Memcache;

class CacheHelper
{
    /**
     * Class property
     *
     * @var [type]
     */
    private $redis;
    private $config;  
    private $type;          
    
    /**
     * constructor
     */
    public function __construct()
    { 
        try{
            $this->config = $this->getConfig();      
            $this->init();
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    } 

    public function __invoke() {
            
    }
    /**
     * get the cache type and save data in cache
     *
     * @return void
     */
    private function init(){
    try{
       $cacheDetails = $this->activeConf();
       if(!$cacheDetails) return false;
     
       $this->type = $cacheDetails['type']?? ''; 
       $this->option = $cacheDetails['cacheConf']?? [];        

        switch($this->type){
            case 'redis':                             
                 $this->redis = new Redis($this->option);                
                 return $this;
                break;
                
            case 'memcache':
               // $option = $this->getConfig()['memcache-cache']['option'];
               break;
            default:
              return false;
            break;
        }  
    }catch(Exception $e){
        throw new Exception($e->getMessage());
    } 
              
    }
    /**
     * Set item in cache
     *
     * @param String $key
     * @param String $value
     * @return void
     */
    public function setItem(String $key,String $value): void
    {
        $this->redis->setItem($key, $value);       
    }
    /**
     * get cache saved items
     *
     * @param [type] $key
     * @return void
     */
    public function getItem($key)
    {
       return $this->redis->getItem($key);
        
    }
    
    /**
     * Get the Configuration details
     *
     * @return array
     */
    private function getConfig(): array
    {         
        return (require __DIR__ . '/../../../../config/config.php');
    }
    /**
     * Only First active configuration will be takencare
     *
     * @return array
     */
    private function activeConf():array
    {
        if(!isset($this->config['cache'])){
            throw new Exception("Are you sure you have provided the cache configuration in cache.global.php.");
        }
        foreach($this->config['cache'] as $key=>$val){
            if($val['status']==1){
                return ['type'=>$key, 'cacheConf'=>$val['options']];
            }
        }  
        return false;      
    }
  
}
