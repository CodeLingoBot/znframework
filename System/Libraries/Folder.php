<?php
/************************************************************/
/*                     CLASS  FOLDER                        */
/************************************************************/
/*

Author: Ozan UYKUN
Site: http://www.zntr.net
Copyright 2012-2015 zntr.net - Tüm hakları saklıdır.

*/
/******************************************************************************************
* FOLDER                                                                            	  *
*******************************************************************************************
| Sınıfı Kullanırken      :	Folder:: , $this->folder , uselib('folder') , zn::$use->folder|
| 																						  |
| Kütüphanelerin kısa isimlendirmelerle kullanımı için. Config/Namespace.php bakınız.     |
******************************************************************************************/
class Folder
{
	/* Error Değişkeni
	 *  
	 * Dosya işlemlerinde oluşan hata bilgilerini
	 * tutması için oluşturulmuştur.
	 *
	 */
	private static $error;
	
	/******************************************************************************************
	* CREATE                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Dizin oluşturmak için kullanılır.    				     			      |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @name => Oluşturulacak dizinin adı veya yolu.							  |
	| 2. string var @permission => Oluşturulacak dizinin yetki kodu							  |
	|          											  									  |
	| Örnek Kullanım: create('dizin/yeniDizin');        						              |
	|          																				  |
	******************************************************************************************/
	public static function create($name = '', $permission = 0755)
	{		
		if( ! is_string($name) ) 
		{
			$name = '';
		}
		if( ! is_numeric($name) ) 
		{
			$permission = 0755;
		}
		
		if( ! file_exists($name) && ! is_file($name) )
		{
			mkdir($name,$permission);
		}
		else
		{
			self::$error =  getMessage('Folder', 'alreadyFileError', $name);
			report('Error', self::$error, 'FolderLibrary');
		}
	}
	
	/******************************************************************************************
	* CHANGE                                                                           		  *
	*******************************************************************************************
	| Genel Kullanım: Çalışma dizini değiştirmek için kullanılır.    	 		     		  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @name => Değiştirilecek çalışma dizininin adı veya yolu.				  |
	|          											  									  |
	| Örnek Kullanım: $veri = changer('dizin/yeniDizin');        					          |
	|          																				  |
	******************************************************************************************/	
	public static function change($name = '')
	{		
		if( ! is_string($name) ) 
		{
			$name = '';
		}
		
		if( file_exists($name) && is_dir($name) )
		{
			chdir($name);
		}
		else
		{
			self::$error =  getMessage('Folder', 'alreadyFileError', $name);
			report('Error', self::$error, 'FolderLibrary');
			return false;
		}
	}
	
	/******************************************************************************************
	* RENAME                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Dizinin adını değiştirmek için kullanılır.    				     	  |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @oldname => Dizinin eski ismi.							  				  |
	| 2. string var @newname => Dizinin yeni ismi.							  				  |
	|          											  									  |
	| Örnek Kullanım: rename('dizin/eskiIsim', 'dizin/yeniIsim');        				      |
	|          																				  |
	******************************************************************************************/
	public static function rename($oldName = '', $newName = '')
	{		
		if( ! is_string($oldName) ) 
		{
			$oldName = '';
		}
		if( ! is_string($newName) ) 
		{
			$newName = '';
		}
		
		if( file_exists($oldName) )
		{
			rename($oldName, $newName);
		}
		else
		{
			self::$error =  getMessage('Folder', 'alreadyFileError', $name);
			report('Error', self::$error, 'FolderLibrary');
			return false;
		}
	}
	
	/******************************************************************************************
	* DELETE EMPTY                                                                            *
	*******************************************************************************************
	| Genel Kullanım: İçi boş dizini silmek için kullanılır.    	 			     		  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @name => Silinecek boş dizinin adı veya yolu.							  |
	|          											  									  |
	| Örnek Kullanım: $veri = deleteEmpty('dizin/yeniDizin');        					      |
	|          																				  |
	******************************************************************************************/
	public static function deleteEmpty($name = '')
	{
		if( ! is_string($name) ) 
		{
			$name = '';
		}
		
		if( isDirExists($name) ) 
		{
			rmdir($name);
		}
		else
		{
			self::$error = getMessage('Folder', 'notFoundError', $name);
			report('Error', self::$error, 'FolderLibrary');
		}
	}
	
	/******************************************************************************************
	* COPY                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: İçi boş veya dolu bir dizini kopyalamak için kullanılır.    	 		  |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @source => Hangi dizinin kopyalanacağını belirtir.			  		      |
	| 2. string var @target => Kopyalanan dizinin hangi yola yapıştırılacağı belirtir.        |
	|          											  									  |
	| Örnek Kullanım: $veri = copy('dizin/kaynakDizin', 'dizin/hedefDizin');        		  |
	|          																				  |
	******************************************************************************************/
	public static function copy($source = '', $target = '')
	{
		// Parametre kontrolleri yapılıyor. -------------------------------------------
		if( ! is_string($source) ) 
		{
			return false;
		}
		if( ! is_string($target) )
		{
			return false;
		}
		
		if( ! file_exists($source) )
		{
			self::$error = getMessage('Folder', 'notFoundError', $source);
			report('Error', self::$error, 'FolderLibrary');
			return false;	
		}
		// ----------------------------------------------------------------------------
		
		// Bu bir dizinse
		if( is_dir($source) )
		{
			// Dizinin içinde mevcut dosya varsa
			if( ! self::files($source) )
			{
				@copy($source, $target);
			}
			else
			{			
				// Kopyalanacak dizin mevcut değilse oluştur.
				if( ! is_dir($target) && ! file_exists($target) )
				{
					self::create($target);
				}
				
				// Kopyalama işlemini başlat.
				if( is_array(self::files($source)) )foreach(self::files($source) as $val)
				{
					@copy($source."/".$val, $target."/".$val);
					self::copy($source."/".$val, $target."/".$val);
				}							
			}		
		}
		else
		{
			// Bu bir dosya ise
			@copy($source, $target);	
		}
	}
	
	/******************************************************************************************
	* DELETE	                                                                              *
	*******************************************************************************************
	| Genel Kullanım: İçi dolu veya boş dizini silmek için kullanılır.    	 			      |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @name => Silinecek dizinin adı veya yolu.							      |
	|          											  									  |
	| Örnek Kullanım: $veri = delete('dizin/yeniDizin');        					          |
	|          																				  |
	| Not: Bu yöntem bir dizinin içindeki diğer tüm verileride dizin ile birlikte silecektir. |
	|          																				  |
	******************************************************************************************/
	public static function delete($name = '')
	{
		// Parametre kontrolleri yapılıyor. -------------------------------------------
		if( ! is_string($name) ) 
		{
			return false;
		}
		if( ! file_exists($name) )
		{
			self::$error = getMessage('Folder', 'notFoundError', $name);
			report('Error', self::$error, 'FolderLibrary');
			return false;	
		}
		// ----------------------------------------------------------------------------

		// Bu bir dosya ise
		if( is_file($name) )
		{
			// dosyayı sil
			File::delete($name);	
		}
		else
		{
			// Bu bir dizinse
			
			// Dizin boş ise
			if( ! self::files($name) )
			{
				// Boş dizini sil
				self::deleteEmpty($name);
			}	
			else
			{			
				// Silme işlemini başlat
				for($i = 0; $i < count(self::files($name)); $i++)
				{
					foreach(self::files($name) as $val)
					{					
						self::delete($name."/".$val);
					}
				}
			}
			
			// İçeriği silinmiş olan hedef dizinide sil.
			self::deleteEmpty($name);
		}
	}
	
	/******************************************************************************************
	* FILES	                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Bir dizin içindeki dosya ve dizin listesini almak için kullanılır.      |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @path => Listesi alınacak dizinin adı veya yolu.						  |
	| 2. string var @extension => Listede hangi uzantılı dosyaların yer alacağıdır. Bu 		  |
	| parametre boş bırakılırsa tüm dosya ve dizinler listeye alınacaktır.         			  |
	|          											  									  |
	| Örnek Kullanım: $veri = files('dizin/', 'php'); // php uzantılı dosyaları listeler.     |
	| Örnek Kullanım: $veri = files('dizin/', 'dir'); // sadece dizinleri listeler.           |
	| Örnek Kullanım: $veri = files('dizin/'); // tüm dosya ve dizinleri listeler.            |
	|          																				  |
	******************************************************************************************/
	public static function files($path = '', $extension = '')
	{	
		// Parametre kontrolleri yapılıyor. -------------------------------------------	
		if( ! is_string($path) ) 
		{
			return false;	
		}
		if( ! is_string($extension) ) 
		{
			$extension = '';
		}		
		if( is_file($path) )
		{
			self::$error = getMessage('Folder', 'parameterError', $path);
			report('Error', self::$error, 'FolderLibrary');
			return false;		
		}
		// ----------------------------------------------------------------------------
		
		$files = array();
		
		// 1. Parametre boş ise bu parametreyi aktif dizin olarak belirle.
		if( empty($path) )
		{
			$path = '.';
		}
		
		// 1. parametre bir dizinse
		if( is_dir($path) )
		{	
			$dir = opendir($path);
			
			while($file = readdir($dir))
			{
				if( $file !== '.' && $file !== '..' )
				{				
					if( ! empty($extension) && $extension !== 'dir' )
					{
						if( extension($file) === $extension )
						{
							$files[] = $file;	
						}
					}
					else
					{
						if( $extension === 'dir' )
						{
							$extens = extension($file);
							
							if( empty($extens) )
							{
								$files[] = $file;	
							}
						}
						else
						{
							$files[] = $file;
						}
					}
				}
			}
			return $files;
		}
		else
		{
			// 1. parametre dizin değilse false değeri döndür.
			return false;	
		}
		
	}	
	
	/******************************************************************************************
	* FILE INFO	                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Bir dizinin içerisinde yer alan dosyalar hakkında bilgi edinmek için	  |
	| kullanılır.																			  |
	|															                              |
	******************************************************************************************/
	public static function fileInfo($dir = '', $extension = '')
	{
		// Parametre kontrolleri yapılıyor. -------------------------------------------	
		if( ! is_string($dir) ) 
		{
			return false;	
		}
		if( ! is_string($extension) ) 
		{
			$extension = '';
		}	
		// ----------------------------------------------------------------------------
		
		if( is_dir($dir) )
		{
			$files = self::files($dir, $extension);
			
			$dir = suffix($dir);
			
			$filesInfo = array();
			
			foreach($files as $file)
			{
				$filesInfo[$file]['basename'] 	= pathInfos($dir.$file, 'basename');
				$filesInfo[$file]['size'] 		= filesize($dir.$file);
				$filesInfo[$file]['date'] 		= filemtime($dir.$file);
				$filesInfo[$file]['readable'] 	= is_readable($dir.$file);
				$filesInfo[$file]['writable'] 	= is_writable($dir.$file);
				$filesInfo[$file]['executable'] = is_executable($dir.$file);
				$filesInfo[$file]['permission'] = fileperms($dir.$file);
			}
			
			return $filesInfo;
		}
		elseif( is_file($dir) )
		{
			$fileinfo = File::info($dir);
			return (array)$fileinfo;
		}
		else
		{
			return false;
		}	
	}
	
	/******************************************************************************************
	* ALL FILES	                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Bir dizin içindeki dosya ve dizin listesini almak için kullanılır.      |
	| Bu yöntemin files() yönteminden farkı herhangi bir uzantı parametresinin olmamasıdır.	  |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @pattern => Listesi alınacak dizinin adı veya yolu.	Varsayılan:*		  |
	|          											  									  |
	| Örnek Kullanım: $veri = allFiles('dizin/'); // tüm dosya ve dizinleri listeler.        |
	|          																				  |
	******************************************************************************************/
	public static function allFiles($pattern = "*", $allFiles = false)
	{
		// Parametre kontrolü yapılıyor.
		if( ! is_string($pattern) ) 
		{
			return false;	
		}
		
		if( $allFiles === true )
		{
			static $classes;
		
			$directory = suffix($pattern); 
			
			$files = glob($directory.'*');
		
			if( ! empty($files) ) foreach($files as $v)
			{
				if( is_file($v) )
				{
					$classEx = explode('/', $v);

					$classes[] = $v;
				}
				elseif( is_dir($v) )
				{
					self::allFiles($v, $allFiles);
				}
			}	
			
			return $classes;
		}
		
		// Parametrede / eki var ve yıldız yoksa /* formuna dönüştür.
		if( strstr($pattern, '/') != "" && strstr($pattern, '*') == "" ) 
		{
			$pattern .= "*";
		}
		
		// Parametrede / eki yoksa ve yıldız yoksa /* formuna dönüştür.
		if( strstr($pattern, '/') == "" && strstr($pattern, '*') == "" ) 
		{
			$pattern .= "/*";
		}
		
		// Yukarıdaki kontrollerin amacı kullanıcıların
		// daha esnek parametre kullanabilmelerine
		// yardımcı olmak içindir.
		
		return glob($pattern);
	}	
	
	/******************************************************************************************
	* PERMISSION                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Dosya ve dizin yetkilerini düzenlemek için kullanılır.		     	  |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @name => Yetki verilecek dosyanın ismi veya yolu.						  |
	| 2. numeric var @name => Dosyaya verilecek yetki kodu. Varsayılan:0755  	     	      |
	|          																				  |
	| Örnek Kullanım: permission('dizin/dosya.txt', 0755);        							  |
	|          																				  |
	******************************************************************************************/
	public static function permission($name = '', $permission = 0755)
	{
		if( ! is_string($name) ) 
		{
			return false;
		}
		if( ! is_numeric($permission) ) 
		{
			$permission = 0755;
		}
		
		if( ! file_exists($name))
		{
			self::$error = getMessage('Folder', 'notFoundError', $name);
			report('Error', self::$error, 'FolderLibrary');
			return false;	
		}
		else
		{
			// Dosya veya dizini yetkilendir.
			chmod($name, $permission);
		}
	}
	
	/******************************************************************************************
	* ERROR                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Dizin işlemlerinde oluşan hata bilgilerini tutması için oluşturulmuştur.|
	|     														                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|     														                              |
	******************************************************************************************/
	public static function error()
	{
		if( isset(self::$error) )
		{
			return self::$error;
		}
		else
		{
			return false;
		}
	}
}