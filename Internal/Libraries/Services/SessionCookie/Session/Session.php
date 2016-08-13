<?php namespace ZN\Services;

class InternalSession extends \Requirements implements SessionInterface, SessionCookieCommonInterface
{
	/***********************************************************************************/
	/* SESSION COMPONENT	   	     		                   	                       */
	/***********************************************************************************/
	/* Yazar: Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	/* Site: www.zntr.net
	/* Lisans: The MIT License
	/* Telif Hakkı: Copyright (c) 2012-2016, zntr.net
	/*
	/* Sınıf Adı: Session
	/* Versiyon: 1.2
	/* Tanımlanma: Dinamik
	/* Dahil Edilme: Gerektirmez
	/* Erişim: Session:: $this->Session, zn::$use->Session, uselib('Session')
	/* Not: Büyük-küçük harf duyarlılığı yoktur.
	/***********************************************************************************/
	
	//----------------------------------------------------------------------------------------------------
	// const config
	//----------------------------------------------------------------------------------------------------
	// 
	// @const string
	//
	//----------------------------------------------------------------------------------------------------
	const config  = 'Services:session';
	
	//----------------------------------------------------------------------------------------------------
	// Session Cookie Common
	//----------------------------------------------------------------------------------------------------
	// 
	// methods
	//
	//----------------------------------------------------------------------------------------------------
	use SessionCookieCommonTrait;
	
	//----------------------------------------------------------------------------------------------------
	// Construct
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  void
	// @return bool
	//
	//----------------------------------------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		
		\Config::iniSet(\Config::get('Htaccess', 'session')['settings']);
		
		$this->start();
	}
	
	//----------------------------------------------------------------------------------------------------
	// Insert
	//----------------------------------------------------------------------------------------------------
	// 
	// @param string $name
	// @param mixed  $value
	//
	//----------------------------------------------------------------------------------------------------
	public function insert(String $name, $value) : Bool
	{
		if( ! empty($this->encode) )
		{
			if( isset($this->encode['name']) )
			{
				if( isHash($this->encode['name']) )
				{
					$name = hash($this->encode['name'], $name);		
				}		
			}
			
			if( isset($this->encode['value']) )
			{
				if( isHash($this->encode['value']) )
				{
					$value = hash($this->encode['value'], $value);	
				}
			}
		}
		
		$sessionConfig = $this->config;
	
		if( ! isset($this->encode['name']))
		{
			$encode = $sessionConfig["encode"];
			
			if( $encode === true )
			{
				$name = md5($name);
			}
			elseif( is_string($encode) )
			{
				if( isHash($encode) )
				{
					$name = hash($encode, $name);		
				}	
			}
		}
		
		$_SESSION[$name] = $value;
		
		if( $_SESSION[$name] )
		{
			if( $this->regenerate === true )
			{
				session_regenerate_id();	
			}
			
			$this->defaultVariable();
			
			return true;	
		}
		else
		{
			return false;
		}
	} 
	
	//----------------------------------------------------------------------------------------------------
	// Select
	//----------------------------------------------------------------------------------------------------
	// 
	// @param string $name
	//
	//----------------------------------------------------------------------------------------------------
	public function select(String $name)
	{
		if( isset($this->encode['name']) )
		{
			if( isHash($this->encode['name']) )
			{
				$name = hash($this->encode['name'], $name);		
				$this->encode = [];	
			}		
		}
		else
		{
			$encode = $this->config['encode'];
			
			if( $encode === true )
			{
				$name = md5($name);
			}
			elseif( is_string($encode) )
			{
				if( isHash($encode) )
				{
					$name = hash($encode, $name);		
				}	
			}
		}
		
		if( isset($_SESSION[$name]) )
		{
			return $_SESSION[$name];
		}
		else
		{
			return false;	
		}
	}
	
	//----------------------------------------------------------------------------------------------------
	// Select All
	//----------------------------------------------------------------------------------------------------
	// 
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function selectAll() : Array
	{
		return $_SESSION;	
	}
	
	//----------------------------------------------------------------------------------------------------
	// Start
	//----------------------------------------------------------------------------------------------------
	// 
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function start()
	{
		if( ! isset($_SESSION) ) 
		{
			session_start();
		}
	}
	
	//----------------------------------------------------------------------------------------------------
	// Delete
	//----------------------------------------------------------------------------------------------------
	// 
	// @param string $name
	//
	//----------------------------------------------------------------------------------------------------
	public function delete(String $name) : Bool
	{
		$sessionConfig = $this->config;
		
		if( isset($this->encode['name']) )
		{
			if( isHash($this->encode['name']) )
			{
				$name = hash($this->encode['name'], $name);	
				$this->encode = [];	
			}		
		}
		else
		{
			$encode = $sessionConfig["encode"];
			
			if( $encode === true )
			{
				$name = md5($name);
			}
			elseif( is_string($encode) )
			{
				if( isHash($encode) )
				{
					$name = hash($encode, $name);		
				}	
			}
		}
		
		if( isset($_SESSION[$name]) )
		{ 	
			unset($_SESSION[$name]);

			return true;
		}
		else
		{ 
			return false;		
		}
	}
	
	//----------------------------------------------------------------------------------------------------
	// Delete All
	//----------------------------------------------------------------------------------------------------
	// 
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function deleteAll() : Bool
	{
		return session_destroy();
	}
}