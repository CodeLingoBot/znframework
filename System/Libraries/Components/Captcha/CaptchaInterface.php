<?php
interface CaptchaInterface
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
	// Width
	//----------------------------------------------------------------------------------------------------
	//
	// Güvenlik kodu nesnesinin genişlik değeri belirtilir.
	//
	// @param  numeric $param
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function width($param);
	
	//----------------------------------------------------------------------------------------------------
	// Height
	//----------------------------------------------------------------------------------------------------
	//
	// Güvenlik kodu nesnesinin yükseklik değeri belirtilir.
	//
	// @param  numeric $param
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function height($param);
	
	//----------------------------------------------------------------------------------------------------
	// Size
	//----------------------------------------------------------------------------------------------------
	//
	// Güvenlik kodu nesnesinin genişlikk ve yükseklik değeri belirtilir.
	//
	// @param  numeric $width
	// @param  numeric $height
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function size($width, $height);
	
	//----------------------------------------------------------------------------------------------------
	// Length
	//----------------------------------------------------------------------------------------------------
	//
	// Güvenlik kodu nesnesinin kaç karakterden olacağı belirtilir.
	//
	// @param  numeric $param
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function length($param);
	
	//----------------------------------------------------------------------------------------------------
	// Border
	//----------------------------------------------------------------------------------------------------
	//
	// Güvenlik kodu nesnesinin çerçevesinin olup olmayacağı olacaksa da hangi.		      
	// hangi renkte olacağı belirtilir.
	//
	// @param  boolean $is
	// @param  string  $color
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function border($is, $color);
	
	//----------------------------------------------------------------------------------------------------
	// Border Color
	//----------------------------------------------------------------------------------------------------
	//
	// Güvenlik kodu çerçeve rengini ayarlamak için kullanılır.
	//
	// @param  string $color
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function borderColor($color);
	
	//----------------------------------------------------------------------------------------------------
	// Bg Color
	//----------------------------------------------------------------------------------------------------
	//
	// Güvenlik kodu arkaplan rengini ayarlamak için kullanılır.
	//
	// @param  string $color
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function bgColor($color);
	
	//----------------------------------------------------------------------------------------------------
	// Background Color
	//----------------------------------------------------------------------------------------------------
	//
	// Güvenlik kodu arkaplan resimleri ayarlamak için kullanılır.
	//
	// @param  mixed $image
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function bgImage($image);
	
	//----------------------------------------------------------------------------------------------------
	// Background
	//----------------------------------------------------------------------------------------------------
	//
	// Güvenlik kodu arkaplan rengini veya resimlerini ayarlamak için 		 
	// kullanılır. Bgimage ve bgcolor yöntemlerinin alternatifidir.
	//
	// @param  mixed $background
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function background($background);
	
	//----------------------------------------------------------------------------------------------------
	// Text Size
	//----------------------------------------------------------------------------------------------------
	//
	// Güvenlik kodu metninin boyutunu ayarlamak içindir.
	//
	// @param  numeric $size
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function textSize($size);
		
	//----------------------------------------------------------------------------------------------------
	// Text Coordinate
	//----------------------------------------------------------------------------------------------------
	//
	// Güvenlik kodu metninin boyutunu ayarlamak içindir.
	//
	// @param  numeric $x
	// @param  numeric $y
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function textCoordinate($x, $y);
	
	//----------------------------------------------------------------------------------------------------
	// Text Color
	//----------------------------------------------------------------------------------------------------
	//
	// Güvenlik kodu metninin rengini ayarlamak için kullanılır.
	//
	// @param  string $color
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function textColor($color);
	
	//----------------------------------------------------------------------------------------------------
	// Text
	//----------------------------------------------------------------------------------------------------
	//
	// Güvenlik kodu metninin boyutu x ve ye değerlerini ayarlamak içindir.
	//
	// @param  numeric $size
	// @param  numeric $x
	// @param  numeric $y
	// @param  string  $color
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function text($size, $x, $y, $color);
	
	//----------------------------------------------------------------------------------------------------
	// Grid
	//----------------------------------------------------------------------------------------------------
	//
	// Güvenlik kodu nesnesinin ızgarasının olup olmayacağı olacaksa da hangi. 	      
	// hangi renkte olacağı belirtilir.
	//
	// @param  boolean $is
	// @param  string  $color
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function grid($is, $color);
	
	//----------------------------------------------------------------------------------------------------
	// Grid Color
	//----------------------------------------------------------------------------------------------------
	//
	// Güvenlik kodu ızgara rengini ayarlamak için kullanılır.	      
	//
	// @param  string $color
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function gridColor($color);
	
	//----------------------------------------------------------------------------------------------------
	// Grid Space
	//----------------------------------------------------------------------------------------------------
	//
	// Güvenlik kodu ızgara boşluklarını ayarlamak için kullanılır.	      
	//
	// @param  numeric $x
	// @param  numeric $y
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function gridSpace($X, $y);
	
	//----------------------------------------------------------------------------------------------------
	// Create
	//----------------------------------------------------------------------------------------------------
	//
	// Güvenlik kodu ızgara boşluklarını ayarlamak için kullanılır.	      
	//
	// @param  boolean $img
	// @param  array   $configs
	// @return midex
	//
	//----------------------------------------------------------------------------------------------------
	public function create($img, $configs);
	
	//----------------------------------------------------------------------------------------------------
	// Get Code
	//----------------------------------------------------------------------------------------------------
	//
	// Daha önce oluşturulan güvenlik uygulamasının kod bilgini verir.       
	//
	// @param  void
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	public function getCode();
}