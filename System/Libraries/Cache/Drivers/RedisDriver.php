<?php
/************************************************************/
/*                  REDIS DRIVER LIBRARY                    */
/************************************************************/
/*

Author: Ozan UYKUN
Site: http://www.zntr.net
Copyright 2012-2015 zntr.net - Tüm hakları saklıdır.

*/
/******************************************************************************************
* REDIS DRIVER		                                                                      *
*******************************************************************************************
| Dahil(Import) Edilirken : Dahil Edilemez.  							                  |
| Sınıfı Kullanırken      :	Kullanılamaz.												  |
| 																						  |
| NOT: Ön bellekleme kütüphanesi için oluşturulmuş yardımcı sınıftır.                     |
******************************************************************************************/	
class RedisDriver
{
	/* Redis Değişkeni
	 *  
	 * Redis sınıfı bilgisini
	 * barındırmak için oluşturulmuştur.
	 *
	 */
	 
	protected $redis;
	
	/* Serialized Değişkeni
	 *  
	 * Ön bellekleme bilgilerini
	 * barındırmak için oluşturulmuştur.
	 *
	 */
	protected $serialized = array();
	
	/******************************************************************************************
	* CONNECT                                                                                 *
	*******************************************************************************************
	| Genel Kullanım: Nesne tanımlaması ve ön bellek ayarları çalıştırılıyor.				  |
	|          																				  |
	******************************************************************************************/
	public function connect($settings = array())
	{
		if( $this->is_supported() === false )
		{
			return getMessage('Cache', 'unsupported', 'Redis');
		}
		
		$config = Config::get('Cache', 'driverSettings');
		
		$config = ! empty($settings)
				  ? $settings
				  : $config['redis'];	
		
		$this->redis = new Redis();
		
		try
		{
			if( $config['socketType'] === 'unix' )
			{
				$success = $this->redis->connect($config['socket']);
			}
			else 
			{
				$success = $this->redis->connect($config['host'], $config['port'], $config['timeout']);
			}
			if ( empty($success) )
			{
				die(getMessage('Cache', 'connectionRefused', 'Connection'));
			}
		}
		catch( RedisException $e )
		{
			die(getMessage('Cache', 'connectionRefused', $e->getMessage()));
		}
		
		if( isset($config['password']) )
		{
			if ( ! $this->redis->auth($config['password']))
			{
				die(getMessage('Cache', 'authenticationFailed'));
			}
		}

		$serialized = $this->redis->sMembers('ZNRedisSerialized');
		
		if ( ! empty($serialized) )
		{
			$this->serialized = array_flip($serialized);
		}
		
		return true;
	}
	
	/******************************************************************************************
	* SELECT                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Önbelleğe alınmış nesneyi çağırmak için kullanılır.				      |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @key => Nesne anahtarı.							 	 			    	  |
	|          																				  |
	| Örnek Kullanım: ->get('nesne');			        									  |
	|          																				  |
	******************************************************************************************/
	public function select($key)
	{
		if( $this->is_supported() === false )
		{
			return getMessage('Cache', 'unsupported', 'Redis');
		}
		
		$value = $this->redis->get($key);
		
		if( $value !== false && isset($this->serialized[$key]) )
		{
			return unserialize($value);
		}
		return $value;
	}
	
	/******************************************************************************************
	* INSERT                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Ön bellekte değişken saklamak için kullanılır.					      |
	|															                              |
	| Parametreler: 4 parametresi vardır.                                                     |
	| 1. string var @key => Nesne anahtarı.							 	 			    	  |
	| 2. variable var @data => Nesne.							 	 			    	 	  |
	| 3. numeric var @time => Saklanacağı zaman.							 	 			  |
	| 4. mixed var @compressed => Sıkıştırma.							 	 			  	  |
	|          																				  |
	| Örnek Kullanım: ->get('nesne');			        									  |
	|          																				  |
	******************************************************************************************/
	public function insert($key, $data, $time = 60, $compressed = false)
	{
		if( $this->is_supported() === false )
		{
			return getMessage('Cache', 'unsupported', 'Redis');
		}
		
		if( is_array($data) OR is_object($data) )
		{
			if( ! $this->redis->sIsMember('ZNRedisSerialized', $key) && ! $this->redis->sAdd('ZNRedisSerialized', $key) )
			{
				return false;
			}
			
			if( ! isset($this->serialized[$key]) )
			{
				$this->serialized[$key] = true;	
			}
			
			$data = serialize($data);
		}
		elseif( isset($this->serialized[$key]) )
		{
			$this->serialized[$key] = NULL;
			
			$this->redis->sRemove('ZNRedisSerialized', $key);
		}
		return $this->redis->set($key, $data, $time);
	}
	
	/******************************************************************************************
	* DELETE                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Ön bellekten nesneyi silmek için kullanılır.					          |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @key => Nesne anahtarı.							 	 			    	  |
	|																						  |
	| Örnek Kullanım: ->delete('nesne');			        							      |
	|          																				  |
	******************************************************************************************/
	public function delete($key)
	{
		if( $this->is_supported() === false )
		{
			return getMessage('Cache', 'unsupported', 'Redis');
		}
		
		if( $this->redis->delete($key) !== 1 )
		{
			return false;
		}
		if( isset($this->serialized[$key]) )
		{
			$this->serialized[$key] = NULL;
			
			$this->redis->sRemove('ZNRedisSerialized', $key);
		}
		return TRUE;
	}
	
	/******************************************************************************************
	* INCREMENT                                                                               *
	*******************************************************************************************
	| Genel Kullanım: Nesnenin değerini artımak için kullanılır.				              |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @key => Nesne anahtarı.							 	 			    	  |
	| 2. numeric var @increment => Artırım miktarı.  				 	 			    	  |
	|																						  |
	| Örnek Kullanım: ->increment('nesne', 1);			        							  |
	|          																				  |
	******************************************************************************************/
	public function increment($key, $increment = 1)
	{
		if( $this->is_supported() === false )
		{
			return getMessage('Cache', 'unsupported', 'Redis');
		}
		
		return $this->redis->incr($key, $increment);
	}
	
	/******************************************************************************************
	* DECREMENT                                                                               *
	*******************************************************************************************
	| Genel Kullanım: Nesnenin değerini azaltmak için kullanılır.					          |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @key => Nesne anahtarı.							 	 			    	  |
	| 2. numeric var @decrement => Azaltım miktarı.  				 	 			    	  |
	|																						  |
	| Örnek Kullanım: ->decrement('nesne', 1);			        							  |
	|          																				  |
	******************************************************************************************/
	public function decrement($key, $decrement = 1)
	{
		if( $this->is_supported() === false )
		{
			return getMessage('Cache', 'unsupported', 'Redis');
		}
		
		return $this->redis->decr($key, $decrement);
	}
	
	/******************************************************************************************
	* CLEAN                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Tüm önbelleği silmek için kullanılır.					                  |
	|          																				  |
	******************************************************************************************/
	public function clean()
	{
		if( $this->is_supported() === false )
		{
			return getMessage('Cache', 'unsupported', 'Redis');
		}
		
		return $this->redis->flushDB();
	}
	
	/******************************************************************************************
	* INFO                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Ön bellekleme hakkında bilgi edinmek için kullanılır. 		          |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @type => Bilgi alınacak kullanıcı türü.							 	 	  |
	|																						  |
	| Örnek Kullanım: ->info('user');			        		     					      |
	|          																				  |
	******************************************************************************************/
	public function info()
 	{
		if( $this->is_supported() === false )
		{
			return getMessage('Cache', 'unsupported', 'Redis');
		}
		
		return $this->redis->info();
 	}
	
	/******************************************************************************************
	* GET METADATA                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Ön bellekteki nesne hakkında bilgi almak için kullanılır. 		      |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @key => Bilgi alınacak nesne.							 	 			  |
	|																						  |
	| Örnek Kullanım: ->get_metadata('nesne');			        		     				  |
	|          																				  |
	******************************************************************************************/
	public function getMetaData($key)
	{
		if( $this->is_supported() === false )
		{
			return getMessage('Cache', 'unsupported', 'Redis');
		}
		
		$data = $this->select($key);
		
		if( $data !== false )
		{
			return array
			(
				'expire' => time() + $this->redis->ttl($key),
				'data' 	 => $data
			);
		}
		
		return false;
	}
	
	/******************************************************************************************
	* IS SUPPORTED                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Sürücünün desteklenip desklenmediğini öğrenmek için kullanılır.         |
	|          																				  |
	******************************************************************************************/
	public function isSupported()
	{
		if( ! extension_loaded('redis') )
		{
			$report = getMessage('Cache', 'unsupported', 'Redis');
			report('CacheUnsupported', $report, 'CacheLibary');
			
			return false;
		}
		
		return $this->connect();
	}
	
	/******************************************************************************************
	* DESTRUCT                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Nesne tanımlaması kapatılıyor.						 				  |
	|          																				  |
	******************************************************************************************/
	public function __destruct()
	{
		if( ! empty($this->redis) )
		{
			$this->redis->close();
		}
	}
}