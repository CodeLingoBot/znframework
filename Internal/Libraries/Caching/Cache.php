<?php
namespace ZN\Caching;

class InternalCache implements CacheInterface
{
	//----------------------------------------------------------------------------------------------------
	//
	// Yazar      : Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	// Site       : www.zntr.net
	// Lisans     : The MIT License
	// Telif Hakkı: Copyright (c) 2012-2016, zntr.net
	//
	//----------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------
	// Protected Cache
	//----------------------------------------------------------------------------------------------------
	//
	// Sürücü bilgisi 
	//
	// @var  string
	//
	//----------------------------------------------------------------------------------------------------
	protected $cache;
	
	//----------------------------------------------------------------------------------------------------
	// Construct
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string $driver
	// @return bool
	//
	//----------------------------------------------------------------------------------------------------
	public function __construct($driver = '')
	{
		$this->cache  = \Driver::run('Cache', $driver);
	}
	
	//----------------------------------------------------------------------------------------------------
	// Call Method
	//----------------------------------------------------------------------------------------------------
	// 
	// __call()
	//
	//----------------------------------------------------------------------------------------------------
	use \CallUndefinedMethodTrait;
	
	//----------------------------------------------------------------------------------------------------
	// Driver Method
	//----------------------------------------------------------------------------------------------------
	// 
	// driver()
	//
	//----------------------------------------------------------------------------------------------------
	use \DriverMethodTrait;
	
	//----------------------------------------------------------------------------------------------------
	// Error Control
	//----------------------------------------------------------------------------------------------------
	// 
	// $error
	// $success
	//
	// error()
	// success()
	//
	//----------------------------------------------------------------------------------------------------
	use \ErrorControlTrait;
	
	//----------------------------------------------------------------------------------------------------
	// Data Manipulation Methods Başlangıç
	//----------------------------------------------------------------------------------------------------

	//----------------------------------------------------------------------------------------------------
	// Select
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string $key
	// @param  mixed $expressed
	// @return mixed
	//
	//----------------------------------------------------------------------------------------------------
	public function select($key = NULL, $compressed = false)
	{
        \Errors::typeHint(['string' => $key]);

		return $this->cache->select($key, $compressed);
	}
	
	//----------------------------------------------------------------------------------------------------
	// Insert
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string $key
	// @param  variable $var
	// @param  numeric $time
	// @param  mixed $compressed
	// @return bool
	//
	//----------------------------------------------------------------------------------------------------
	public function insert($key = NULL, $var = '', $time = 60, $compressed = false)
	{
        \Errors::typeHint(['string' => $key, '', 'numeric' => $time]);

		return $this->cache->insert($key, $var, $time, $compressed);
	}
	
	//----------------------------------------------------------------------------------------------------
	// Delete
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string $key
	// @return mixed
	//
	//----------------------------------------------------------------------------------------------------
	public function delete($key = NULL)
	{
        \Errors::typeHint(['string' => $key]);

		return $this->cache->delete($key);
	}
	
	//----------------------------------------------------------------------------------------------------
	// Data Manipulation Methods Bitiş
	//----------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------
	// Increment Methods Başlangıç
	//----------------------------------------------------------------------------------------------------

	//----------------------------------------------------------------------------------------------------
	// Increment
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string  $key
	// @param  numeric $increment
	// @return void
	//
	//----------------------------------------------------------------------------------------------------
	public function increment($key = NULL, $increment = 1)
	{
        \Errors::typeHint(['string' => $key, 'numeric' => $increment]);

		return $this->cache->increment($key, $increment);
	}
	
	//----------------------------------------------------------------------------------------------------
	// Deccrement
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string  $key
	// @param  numeric $decrement
	// @return void
	//
	//----------------------------------------------------------------------------------------------------
	public function decrement($key = NULL, $decrement = 1)
	{
        \Errors::typeHint(['string' => $key, 'numeric' => $decrement]);

		return $this->cache->decrement($key, $decrement);
	}
	
	//----------------------------------------------------------------------------------------------------
	// Increment Methods Bitiş
	//----------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------
	// Info Methods Başlangıç
	//----------------------------------------------------------------------------------------------------

	//----------------------------------------------------------------------------------------------------
	// Info
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  mixed  $info
	// @return mixed
	//
	//----------------------------------------------------------------------------------------------------
	public function info($type = NULL)
	{
		return $this->cache->info($type);
	}
	
	//----------------------------------------------------------------------------------------------------
	// Get Meta Data
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string  $key
	// @return mixed
	//
	//----------------------------------------------------------------------------------------------------
	public function getMetaData($key = '')
	{
        \Errors::typeHint(['string' => $key]);

		return $this->cache->getMetaData($key);
	}
	
	//----------------------------------------------------------------------------------------------------
	// Is Supported
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  void
	// @return bool
	//
	//----------------------------------------------------------------------------------------------------
	public function isSupported()
	{
		return $this->cache->isSupported();
	}
	
	//----------------------------------------------------------------------------------------------------
	// Clean
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  void
	// @return void
	//
	//----------------------------------------------------------------------------------------------------
	public function clean()
	{
		return $this->cache->clean();
	}	
	
	//----------------------------------------------------------------------------------------------------
	// Info Methods Bitiş
	//----------------------------------------------------------------------------------------------------
}