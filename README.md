# Redis With Mezzio#
## 1)	Prerequisites for the Redis

    `a.` Redis Server 
    
    `b.` RedisPhp php extension https://github.com/phpredis/phpredis

	Note: Docker Configuration has already installed, so no need to configure it again .

## 2)	Laminas required dependency

`https://github.com/laminas/laminas-cache-storage-adapter-redis`



    Run the following to install this library: 

    ```sh
    $ composer require laminas/laminas-cache
    $ composer require laminas/laminas-cache-storage-adapter-redis
    $ composer update
    ```

## 3)	Configuration Files
```sh
 
/**
  * #Config/Autoload/cache.global.php#
  * ttl => Time to Live
  * Server => [host, post] @Host: Default (127.0.0.1 or localhost), For docker it is the name of connected "link" 
  * @Port: Default (6378), For docker use <external port>: <internal port> use internal port
  */
return [ 
    'cache'=> [   
        'redis' => [ 
            'status' => '1', // Status 1 For the Active         
            'options' => [
                            'ttl' => 7200, // Time to live duration of cache
                            'server'=>[
                                    'redis', // Server Host “localhost”
                                      6379   // Server Port default is 6379 
                                ]                
                        ],
        ],
    ]
];
```

**Note:** `Status =1` means the Redis cache is enabled for the caching, in the case of multiple cache setting, only first active cache is used for the cashed storage to avoid any confusion, even more than one active cache are listed in the configuration

## 4)	Deploy Helper method to use the configuration
Please store it in the 
```sh
    /src/App/src/Helper/CacheHelper.php   
```

## 5)	How to use the Redis 

Include the name space –
```sh  
 use App\Helper\CacheHelper;
 ```


Example to store and retrieve the data from cache 
 
 ```sh
 $cache= new CacheHelper();      
        
 // To set the data in the Redis cache 
 $cache->setItem("<any_unique_key>","<Any string value>");
 // To get the data from the Redis cache 
 $cache->getItem("<any_unique_key >"); 
 ```


