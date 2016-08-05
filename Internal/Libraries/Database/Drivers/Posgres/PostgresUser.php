<?php
namespace ZN\Database\Drivers;

use ZN\Database\DriverUser;

class PostgresUser extends DriverUser
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
	// Protected Postgre Quote Options
	//----------------------------------------------------------------------------------------------------
	// 
	// @var array
	//
	//----------------------------------------------------------------------------------------------------
	protected $postgreQuoteOptions = array
	(
		'PASSWORD',
		'VALID UNTIL'
	);
	
	//----------------------------------------------------------------------------------------------------
	// name()
	//----------------------------------------------------------------------------------------------------
	// 
	// @param string $name: USER()
	//
	//----------------------------------------------------------------------------------------------------
	public function name($name)
	{
		$this->name = $name;
	}
	
	//----------------------------------------------------------------------------------------------------
	// option()
	//----------------------------------------------------------------------------------------------------
	// 
	// @param string $name
	// @param string $value
	//
	//----------------------------------------------------------------------------------------------------
	public function option($option, $value)
	{
		if( ! empty($this->postgreQuoteOptions[strtoupper($option)]) )
		{
			$value = presuffix($value, '\'');	
		}
		
		$this->parameters[1] = $option.' '.$value;
	}
	
	//----------------------------------------------------------------------------------------------------
	// create()
	//----------------------------------------------------------------------------------------------------
	// 
	// @param string $user
	// @param array  $parameters
	//
	//----------------------------------------------------------------------------------------------------
	public function create($user, $parameters)
	{
		$query = 'CREATE USER '.
		         $user.
			     ( ! empty($parameters[0]) ? ' '.$parameters[0] : '' ).
				 ( ! empty($parameters[1]) ? ' '.$parameters[1] : '' );

		$this->_resetQuery();

		return $query;
	}
	
	//----------------------------------------------------------------------------------------------------
	// drop()
	//----------------------------------------------------------------------------------------------------
	// 
	// @param string $user
	//
	//----------------------------------------------------------------------------------------------------
	public function drop($user)
	{
		$query = 'DROP USER '.$user;

		$this->_resetQuery();

		return $query;
	}
	
	//----------------------------------------------------------------------------------------------------
	// alter()
	//----------------------------------------------------------------------------------------------------
	// 
	// @param string $user
	// @param array  $parameters
	//
	//----------------------------------------------------------------------------------------------------
	public function alter($user, $parameters)
	{
		$query = 'ALTER USER '.
		         $user.
				 ( ! empty($parameters[0]) ? ' '.$parameters[0] : '' ).
				 ( ! empty($parameters[1]) ? ' '.$parameters[1] : '' );

		$this->_resetQuery();

		return $query;
	}
}