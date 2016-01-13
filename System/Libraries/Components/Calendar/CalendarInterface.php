<?php
interface CalendarInterface
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
	// Url
	//----------------------------------------------------------------------------------------------------
	// 
	// Takvimin bağlantı kurucağı url adresi.
	// 
	// @param  string $url
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function url($url);

	//----------------------------------------------------------------------------------------------------
	// Name Type
	//----------------------------------------------------------------------------------------------------
	// 
	// Ay ve günler için normal isimlerini mi yoksa kısaltılmış isimlerin mi	
	// kullanılacağını belirlemek için kullanılır.
	// 
	// @param  string $day
	// @param  string $month
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function nameType($day, $month);
	
	//----------------------------------------------------------------------------------------------------
	// Css
	//----------------------------------------------------------------------------------------------------
	// 
	// Takvime css sınıfları uygulamak için kullanılır.
	// 
	// @param  array $css
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function css($css);
	
	//----------------------------------------------------------------------------------------------------
	// Style
	//----------------------------------------------------------------------------------------------------
	// 
	// Takvime stiller uygulamak için kullanılır.
	// 
	// @param  array $style
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function style($style);
	
	//----------------------------------------------------------------------------------------------------
	// Type
	//----------------------------------------------------------------------------------------------------
	// 
	// Takvimin kullanım türünü belirlemek içindir.
	// 
	// @param  string $type
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function type($type);
	
	//----------------------------------------------------------------------------------------------------
	// Link Names
	//----------------------------------------------------------------------------------------------------
	// 
	// Takvimde yer alan iler ve geri butonu linklerinin isimlerini			 
	// değiştirmek için kulanılır.
	// 
	// @param  string $prev
	// @param  string $next
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function linkNames($prev, $next);
	
	//----------------------------------------------------------------------------------------------------
	// Create
	//----------------------------------------------------------------------------------------------------
	// 
	// Takvimin oluşturulması için kullanılan son yöntemdir.
	// 
	// @param  numeric $year
	// @param  numeric $month
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	public function create($year, $month);
}