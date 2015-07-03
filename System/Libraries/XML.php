<?php
/************************************************************/
/*                       CLASS XML                          */
/************************************************************/
/*

Author: Ozan UYKUN
Site: http://www.zntr.net
Copyright 2012-2015 zntr.net - Tüm hakları saklıdır.

*/
/******************************************************************************************
* XML                                                                                	  *
*******************************************************************************************
| Sınıfı Kullanırken      :	XML::   												      |
| 																						  |
| Kütüphanelerin kısa isimlendirmelerle kullanımı için. Config/Namespace.php bakınız.     |
******************************************************************************************/
class XML
{
	/* Xpath Değişkeni
	 *  
	 * Xml belgesinin yol bilgisini
	 * tutması için oluşturulmuştur.
	 *
	 */
	private static $xpath;
	
	/* Xml Url Değişkeni
	 *  
	 * Xml belgesinin url bilgisini
	 * tutması için oluşturulmuştur.
	 *
	 */
	private static $xmlUrl;
	
	/* Dom Değişkeni
	 *  
	 * Dom nesnesinin referansını
	 * tutması için oluşturulmuştur.
	 *
	 */
	private static $dom;
	
	/******************************************************************************************
	* LOAD                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Herhangi bir adresten xml belgesi yüklemek için kullanılır.		      |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @path => Yüklenecek xml belgesinin yolu.                                  |
	| 2. string var @type => Yüklenecek xml belgesinin tipi. Varsayılan:file. file, string.   |
	|          																				  |
	| 2. Parametre 2 farklı değer alır: file, string         								  |
	| Yüklenecek belge string içerikli bir veri ise string parametresi kullanılır.            |
	|          																				  |
	| Örnek Kullanım: load('dizin/xml.xml');                                                  |
	|          																				  |
	******************************************************************************************/
	public static function load($path = '', $type = 'file')
	{
		if( ! is_string($path) ) 
		{
			return false;
		}
		
		if( ! is_string($type) ) 
		{
			$type = 'file';
		}
		
		if( $type === 'file' )
		{
			self::$xpath = simplexml_load_file(suffix($path, '.xml'));
			self::$xmlUrl = $path;
		}
		else
		{
			self::$xpath = simplexml_load_string($path);
		}
		
		return self::$xpath;
	}
	
	/******************************************************************************************
	* PATH                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Xml yapısındaki xpath kullanımıdır.                        		      |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @path => Yüklenen xml belgesindeki istenilen elemanın bilgisi.            |
	|          																				  |	         																				
	| Örnek Kullanım: 																		  |
	| $string = '<a><b><c>birinci</c><c>ikinci</c></b><d><c>ücüncü</c></d></a>';			  |
	|																						  |
	| $xml = xml::load($string, 'string');													  |
	|																						  |
	| $xml = xml::path('c');																  |
	|																				          |
	| echo $xml[0].$xml[1]; // Çıktı: birinci ikinci                                          | 
	|          																				  |
	******************************************************************************************/
	public static function path($path = '')
	{
		if( ! is_string($path) ) 
		{
			return false;
		}
		
		$path = str_replace("/","//",$path);
		
		return self::$xpath->xpath("//".$path);	
	}
	
	/******************************************************************************************
	* CREATE                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Bir xml verisini oluşturmak için kullanılan yöntemdir.                  |
	|															                              |
	| Parametreler: 3 parametresi vardır.                                                     |
	| 1. string var @versiyon => Xml belgesinin sürümü. Varsayılan:1.0                        |
	| 2. string var @charset => Xml belgesinin karakter seti. Varsayılan:iso-8859-8           |
	| 3. string var @output => Düzenli çıktı oluşturulsun mu? Varsayılan:true                 |
	|          																				  |	         																				
	| Örnek Kullanım: create();																  |
	|          																				  |
	******************************************************************************************/
	public static function create($version = "1.0", $charset = "iso-8859-8", $output = true)
	{
		if( ! is_string($version) || empty($version) ) 
		{
			$version = "1.0";
		}
		
		if( ! is_string($charset) || empty($charset)) 
		{
			$charset = "iso-8859-8";
		}
		
		if( ! is_bool($output) ) 
		{
			$output = true;
		}
		
		self::$dom = new DOMDocument($version, $charset);
		
		self::$dom->formatOutput = $output;
		
		return self::$dom;
	}
	
	/******************************************************************************************
	* ADD ELEMENT                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Xml belgesine eleman eklemek için kullanılır.                           |      
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @add => Eklenecek elemanın adı.                            				  |
	| 2. [ object var @to ] => Bu elamanın içerisine eklenecek nesne.                         |
	|          																				  |	         																				
	| Örnek Kullanım:															              |
	| $medya = xml::addElement('medya');  // medya isminde kök element oluşturuluyor.        |
    | $vidyo = xml::addElement('vidyo', $medya);  // 										  |
	|          																				  |
	******************************************************************************************/
	public static function addElement($add = '', $to = '')
	{
		if( ! is_string($add) || empty($add) ) 
		{
			return false;
		}
		
		if( ! is_object($to) ) 
		{
			$to = '';
		}
		
		$add = self::$dom->createElement($add);
		
		if( empty($to) ) 
		{
			self::$dom->appendChild($add); 
		}
		else 
		{
			$to->appendChild($add); 
			
			return $add;
		}
		
		return $add;
	}
	
	/******************************************************************************************
	* REMOVE ELEMENT                                                                          *
	*******************************************************************************************
	| Genel Kullanım: Xml belgesinden eleman silmek için kullanılır.                          |      
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @add => Eklenecek elemanın adı.                            				  |
	| 2. array/object var @to  => Bu elamanın içerisinden silinecek nesne veya nesneler.      |
	|          																				  |	         																				
	| Örnek Kullanım:															              |
	| $medya = xml::addElement('medya');													  |
	| $muzik = xml::addElement('muzik', $medya);										      |
	| $resim = xml::addElement('resim', $medya);											  |
    |																						  |
	| xml::removeElement($medya, $muzik); // Tek nesne silmek için.						  |
	| xml::removeElement($medya, array($muzik, $resim)); // Çoklu nesne silmek için.		  |
	|          																				  |
	******************************************************************************************/
	public static function removeElement($add = '', $to = '')
	{
		if( ! is_object($add) || empty($add) )
		{
			return false;
		}
		
		if( ! is_array($to) )
		{
			if( ! is_object($to) ) 
			{
				return false;
			}
			
			if( $add->hasChildNodes() <= $to->hasChildNodes() ) 
			{
				return false;
			}
			
			$add->removeChild($to); 
		}
		else
		{
			foreach($to as $e)
			{
				if( is_object($e) )
				{
					if( $add->hasChildNodes() > $e->hasChildNodes() ) 
					{
						$add->removeChild($e); 
					}
				}
			}
		}
	}
	
	/******************************************************************************************
	* ADD CONTENT                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Elamana içerik eklemek için kullanılır.                                 |      
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. object var @to => İçerik eklenecek eleman.                            				  |
	| 2. string var @text => Bu elamanın içerisine eklenecek veri.                            |
	|          																				  |	         																				
	| Örnek Kullanım: addContent($vidyo, "Burası vidyo bölümüdür.");						  |
	|          																				  |
	******************************************************************************************/
	public static function addContent($to = "", $text = "")
	{
		if( ! is_object($to) )
		{
			return false;
		}
		
		if( ! isChar($text) ) 
		{
			$text = '';
		}
		
		$text = self::$dom->createTextNode($text);
		
		if( empty($to) ) 
		{
			$to = self::$dom;
		}
		
		$to->appendChild($text);
	}	
	
	/******************************************************************************************
	* ADD ATTRIBUTES                                                                          *
	*******************************************************************************************
	| Genel Kullanım: Elamana özellik eklemek için kullanılır.                                |      
	|															                              |
	| Parametreler: 3 parametresi vardır.                                                     |
	| 1. object var @element => İçerik eklenecek eleman.                            		  |
	| 2. string/array var @name => Bu elamanın içerisine eklenecek ozellik.                   |
	| 3. string var @value => Bu elamanın içerisine eklenecek ozellik.                        |
	|          																				  |	         																				
	| Örnek Kullanım: 																		  |
	| addAttr($vidyo, 'id', 'vidyo'); // Tek bir özellik eklenecekse		                  |
	| addAttr($vidyo, array('id' => 'vidyo', 'name' => 'vidyo')); // Çoklu özellik ekleme	  |
	|          																				  |
	******************************************************************************************/
	public static function addAttr($element = '', $name = '', $value = '')
	{
		if( ! is_object($element) || empty($element) ) 
		{
			return false;
		}
		
		if( ! is_array($name) )
		{
			if( ! is_string($value) ) 
			{
				$value = '';
			}
			
			$element->setAttribute($name , $value);
		}
		else
		{
			foreach($name as $n => $v)
			{
				$element->setAttribute($n , $v);
			}
		}
	}
	
	/******************************************************************************************
	* REMOVE ATTRIBUTES                                                                       *
	*******************************************************************************************
	| Genel Kullanım: Elamandan özellik silmek için kullanılır.                               |      
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. object var @element => İçerik silinecek eleman.                            		  |
	| 2. string/array var @name => Bu elamanın içerisinden silinecek ozellik.                 |
	|          																				  |	         																				
	| Örnek Kullanım: 																		  |
	| removeAttr($vidyo, 'id'); // Tek bir özellik eklenecekse		                          | 
	| removeAttr($vidyo, array('id', 'name')); // Çoklu özellik silme  					  |
	|          																				  |
	******************************************************************************************/
	public static function removeAttr($element = '', $name = '')
	{
		if( ! is_object($element) || empty($element) ) 
		{
			return false;
		}
		
		if( ! isChar($name) )
		{
			$name = '';
		}
			
		if( ! is_array($name) )
		{
			$element->removeAttribute($name);
		}
		else
		{
			foreach($name as $n)
			{
				$element->removeAttribute($n);
			}
		}
	}
	
	/******************************************************************************************
	* GET ATTRIBUTES                                                                          *
	*******************************************************************************************
	| Genel Kullanım: Elamandan özelliklerini öğrenmek için.                                  |      
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. object var @element => Özellikleri istenen eleman.                            		  |
	| 2. string/array var @name => Öğrenilmek istenen elemana ait özellikler.                 |
	|          																				  |	         																				
	| Örnek Kullanım: 																		  |
	| getAttr($vidyo, 'id'); // Tek bir özellik 		                                      | 
	| getAttr($vidyo, array('id', 'name')); // Çoklu özellik   					          |
	|          																				  |
	******************************************************************************************/
	public static function getAttr($element = '', $name = '')
	{
		if( ! is_object($element) || empty($element) ) 
		{
			return false;
		}
			
		if( ! is_array($name) )
		{
			if( ! is_string($value) ) 
			{
				$value = '';
			}
			
			return $element->getAttribute($name);
		}
		else
		{
			$attr = array();
			
			foreach($name as $n)
			{
				$attr[$n] = $element->getAttribute($n);
			}
			
			return $attr;
		}
	}
	
	/******************************************************************************************
	* GET CONTENTS BY NAME                                                                    *
	*******************************************************************************************
	| Genel Kullanım: İsme göre elemanın içeriğini almak.                                     |      
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @name => İçeriği istenen elemanın ismi.                            		  |
	|          																				  |	         																				
	| Örnek Kullanım: 																		  |
	| getContentsByName('vidyo'); // Burası vidyo bölümdür.	                              | 
	|          																				  |
	******************************************************************************************/
	public static function getContentsByName($name = '')
	{
		if( ! is_string($name) || empty($name) ) 
		{
			return false;
		}
		
		$all = '';
		
		$elements = self::$dom->getElementsByTagName($name);
		
		foreach($elements as $element)
		{
			$all[] = $element->textContent;
		}
		
		return $all;
	}
	
	/******************************************************************************************
	* GET CONTENT BY ID                                                                       *
	*******************************************************************************************
	| Genel Kullanım: İd bilgisine göre elemanın içeriğini almak.                             |      
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @name => İçeriği istenen elemanın id bilgisi.                             |
	|          																				  |	         																				
	| Örnek Kullanım: 																		  |
	| getContentById('vidyo'); // Burası vidyo bölümdür.	                                  | 
	|          																				  |
	******************************************************************************************/
	public static function getContentById($id = '')
	{
		if( ! is_string($id) || empty($id) ) 
		{
			return false;
		}
			
		$element = self::$dom->getElementById($id);
		
		return $element->textContent;
	}
	
	/******************************************************************************************
	* GET CONTENT                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Elemanın içeriğini almak.                                               |      
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. object var @name => İçeriği istenen eleman.                            			  |
	|          																				  |	         																				
	| Örnek Kullanım: 																		  |
	| getContentById($vidyo); // Burası vidyo bölümdür.	                                  | 
	|          																				  |
	******************************************************************************************/
	public static function getContent($name = '')
	{
		if( ! is_object($name) || empty($name) ) 
		{
			return false;
		}
			
		return $name->textContent;
	}
	
	
	/******************************************************************************************
	* SAVE                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Xml belgesininin oluşumunu tamamlar.                                    |      
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|          																				  |	         																				
	| Örnek Kullanım: 																		  |
	| xml::save();										                                      | 
	|          																				  |
	******************************************************************************************/
	public static function save()
	{
		$dom = self::$dom;
		
		if( isset(self::$dom) ) 		self::$dom = NULL;
		if( isset(self::$xmlUrl) )	 	self::$xmlUrl = NULL;
		if( isset(self::$xpath) ) 		self::$xpath = NULL;
		
		return $dom->saveXML();
	}
}