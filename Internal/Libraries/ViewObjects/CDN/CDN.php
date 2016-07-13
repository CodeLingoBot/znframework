<?php
namespace ZN\ViewObjects;

class InternalCDN implements CDNInterface
{
	//----------------------------------------------------------------------------------------------------
	//
	// Yazar      : Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	// Site       : www.zntr.net
	// Lisans     : The MIT License
	// Telif Hakkı: Copyright (c) 2012-2016, zntr.net
	//
	//----------------------------------------------------------------------------------------------------
	
	use \CallUndefinedMethodTrait;
	
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
	// Image
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $name
	//
	//----------------------------------------------------------------------------------------------------
	public function get($configName = '', $name = '')
	{
		if( ! is_string($name) ) 
		{
			return \Errors::set('Error', 'stringParameter', 'symbolName');
		}
		
		$config = \Config::get('ViewObjects', 'cdn');
		
		$configData = ! empty($config[$configName]) ? $config[$configName] : '';
		
		if( empty($configData) )
		{
			return false;	
		}
		
		$data = array_change_key_case($configData);
		
		$name = strtolower($name);

		if( isset($data[$name]) )
		{ 
			return $data[$name]; 
		}
		else
		{ 
			return $data;
		}
	}
	
	//----------------------------------------------------------------------------------------------------
	// Image
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $name
	//
	//----------------------------------------------------------------------------------------------------
	public function image($name = '')
	{
		return $this->get('images', $name);
	}	
	
	//----------------------------------------------------------------------------------------------------
	// Style
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $name
	//
	//----------------------------------------------------------------------------------------------------
	public function style($name = '')
	{
		return $this->get('styles', $name);
	}
	
	//----------------------------------------------------------------------------------------------------
	// Script
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $name
	//
	//----------------------------------------------------------------------------------------------------
	public function script($name = '')
	{
		return $this->get('scripts', $name);
	}	
	
	//----------------------------------------------------------------------------------------------------
	// Font
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $name
	//
	//----------------------------------------------------------------------------------------------------
	public function font($name = '')
	{
		return $this->get('fonts', $name);
	}
	
	//----------------------------------------------------------------------------------------------------
	// File
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $name
	//
	//----------------------------------------------------------------------------------------------------
	public function file($name = '')
	{
		return $this->get('files', $name);
	}
}