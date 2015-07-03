<?php
/************************************************************/
/*                        CLASS  USER                       */
/************************************************************/
/*

Author: Ozan UYKUN
Site: http://www.zntr.net
Copyright 2012-2015 zntr.net - Tüm hakları saklıdır.

*/
/******************************************************************************************
* USER                                                                              	  *
*******************************************************************************************
| Sınıfı Kullanırken      :	user:: , $this->user , zn::$use->user , uselib('user')-> 	  |
| 																						  |
| Kütüphanelerin kısa isimlendirmelerle kullanımı için. Config/Libraries.php bakınız.     |
******************************************************************************************/
class User
{
	
	/* Username Değişkeni
	 *  
	 * Kullanıcı adı bilgisini
	 * tutması için oluşturulmuştur.
	 *
	 */
	private static $username;
	
	/* Password Değişkeni
	 *  
	 * Kullanıcı şifre bilgisini
	 * tutması için oluşturulmuştur.
	 *
	 */
	private static $password;
	
	/* Error Değişkeni
	 *  
	 * Kullanıcı işlemlerinde oluşan hata bilgilerini
	 * tutması için oluşturulmuştur.
	 *
	 */
	private static $error;
	
	/* Success Değişkeni
	 *  
	 * Kullanıcı işlemlerin bilgilerini
	 * bilgisini tutması için oluşturulmuştur.
	 *
	 */
	private static $success;
	
	/******************************************************************************************
	* REGISTER                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Kullanıcıyı kaydetmek için kullanılır.		        		          |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. array var @data => Kaydedilecek üye bilgileri anahtar değer çifti içeren bir dizi    |
	| içeriği ile kaydedilir. Dizideki anahtar ifadeler sütun isimlerini değer ifadeleri ise  |
	| bu sütuna kaydedilecek veriyi belirtir.											 	  |
	| 2. string/boolean var @autoLogin => Kayıttan sonra otomatik giriş olsun mu?		      |
	| True: Otomatik giriş olsun															  |
	| False: Otomatik giriş olmasın															  |
	| String Yol: Otomatik giriş olmasın ve belirtilen yola yönlendirilsin.					  |
	| 3. [ string var @activation_return_link ] => Aktivasyon yapılacaksa kayıt yapılırken    |
	| kullanıcıya gönderilen aktivasyon mailinin içerisindeki linke tıkladığında gidilecek	  |
	| sayfa belirtilir. Bu parametre isteğe bağlıdır.                                         |
	|          																				  |
	| Örnek Kullanım: register(array('user' => 'zntr', 'pass' => '1234'));       		      |
	|          																				  |
	******************************************************************************************/
	public static function register($data = array(), $autoLogin = false, $activationReturnLink = '')
	{
		if( ! is_array($data) ) 
		{
			return false;
		}
		if( ! is_string($activationReturnLink) ) 
		{
			$activationReturnLink = '';
		}
		
		// ------------------------------------------------------------------------------
		// CONFIG/USER.PHP AYARLARI
		// Config/User.php dosyasında belirtilmiş ayarlar alınıyor.
		// ------------------------------------------------------------------------------
		$userConfig		= Config::get("User");		
		$usernameColumn  	= $userConfig['usernameColumn'];
		$passwordColumn  	= $userConfig['passwordColumn'];
		$emailColumn  	    = $userConfig['emailColumn'];
		$tableName 			= $userConfig['tableName'];
		$activeColumn 		= $userConfig['activeColumn'];
		$activationColumn 	= $userConfig['activationColumn'];
		// ------------------------------------------------------------------------------
		
		// Kullanıcı adı veya şifre sütunu belirtilmemişse 
		// İşlemleri sonlandır.
		if( ! isset($data[$usernameColumn]) ||  ! isset($data[$passwordColumn]) ) 
		{
			return false;
		}
		
		$loginUsername  = $data[$usernameColumn];
		$loginPassword  = $data[$passwordColumn];	
		$encodePassword = Encode::super($loginPassword);	
		
		$db = uselib('DB');
		
		$usernameControl = $db->where($usernameColumn.' =',$loginUsername)
							  ->get($tableName)
							  ->totalRows();
		
		// Daha önce böyle bir kullanıcı
		// yoksa kullanıcı kaydetme işlemini başlat.
		if( empty($usernameControl) )
		{
			$data[$passwordColumn] = $encodePassword;
			
			if( $db->insert($tableName , $data) )
			{
				self::$error = false;
				self::$success = lang('User', 'registerSuccess');
				
				if( ! empty($activationColumn) )
				{
					if( ! isEmail($loginUsername) )
					{
						$email = $data[$emailColumn];
					}
					else
					{ 
						$email = '';
					}
					
					self::_activation($loginUsername, $encodePassword, $activationReturnLink, $email);				
				}
				else
				{
					if( $autoLogin === true )
					{
						self::login($loginUsername, $loginPassword);
					}
					elseif( is_string($autoLogin) )
					{
						redirect($autoLogin);	
					}
				}
				
				return true;
			}
			else
			{
				self::$error = lang('User', 'registerUnknownError');	
				return false;
			}
		}
		else
		{
			self::$error = lang('User', 'registerError');
			return false;
		}
		
	}
	
	/******************************************************************************************
	* ACTIVATION COMPLETE                                                                     *
	*******************************************************************************************
	| Genel Kullanım: Register() yönteminde belirtilen dönüş linkinin gösterdiği sayfada      |
	| kullanarak aktrivasyon işleminin tamamlanmasını sağlar.		        		          |
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|          																				  |
	| Örnek Kullanım: activationComplete(); 									              |
	| NOT: Aktivasyon dönüş linkinin belirtiği sayfada kullanılmalıdır                        |
	|          																				  |
	******************************************************************************************/
	public static function activationComplete()
	{
		// ------------------------------------------------------------------------------
		// CONFIG/USER.PHP AYARLARI
		// Config/User.php dosyasında belirtilmiş ayarlar alınıyor.
		// ------------------------------------------------------------------------------
		$userConfig			= Config::get("User");	
		$tableName 			= $userConfig['tableName'];
		$usernameColumn  	= $userConfig['usernameColumn'];
		$passwordColumn  	= $userConfig['passwordColumn'];
		$activationColumn 	= $userConfig['activationColumn'];
		// ------------------------------------------------------------------------------
		
		// Aktivasyon dönüş linkinde yer alan segmentler -------------------------------
		$user = Uri::get('user');
		$pass = Uri::get('pass');
		// ------------------------------------------------------------------------------
		
		if( ! empty($user) && ! empty($pass) )	
		{
			$db = uselib('DB');
			
			$row = $db->where($usernameColumn.' =', $user, 'and')
			          ->where($passwordColumn.' =', $pass)		
			          ->get($tableName)
					  ->row();	
				
			if( ! empty($row) )
			{
				$db->where($usernameColumn.' =', $user)
				   ->update($tableName, array($activationColumn => '1'));
				
				self::$success = lang('User', 'activationComplete');
				
				return true;
			}	
			else
			{
				self::$error = lang('User', 'activationCompleteError');
				return false;
			}				
		}
		else
		{
			self::$error = lang('User', 'activationCompleteError');
			return false;
		}
	}
	
	// Aktivasyon işlemi için
	private static function _activation($user = "", $pass = "", $activationReturnLink = '', $email = '')
	{
		if( ! isUrl($activationReturnLink) )
		{
			$url = baseUrl(suffix($activationReturnLink));
		}
		else
		{
			$url = suffix($activationReturnLink);
		}
		
		$message = "<a href='".$url."user/".$user."/pass/".$pass."'>".lang('User', 'activation')."</a>";	
		
		$user = ( ! empty($email) ) 
				? $email 
				: $user;
				
		$sendEmail = uselib('Email');
		
		$sendEmail->receiver($user, $user);
		$sendEmail->subject(lang('User', 'activationProcess'));
		$sendEmail->content($message);
		
		if( $sendEmail->send() )
		{
			self::$success = lang('User', 'activationEmail');
			return true;
		}
		else
		{	
			self::$success = false;
			self::$error = lang('User', 'emailError');
			return false;
		}
	}
	
	/******************************************************************************************
	* TOTAL ACTIVE USERS                                                                      *
	*******************************************************************************************
	| Genel Kullanım: Kullanıcılardan aktif olanların sayısını verir.		        		  |
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|          																				  |
	| Örnek Kullanım: totalActiveUsers(); 									              |
	|          																				  |
	******************************************************************************************/
	public static function totalActiveUsers()
	{
		$activeColumn 	= Config::get("User",'activeColumn');	
		$tableName 		= Config::get("User",'tableName');
		
		if( ! empty($activeColumn) )
		{
			$db = uselib('DB');
			
			$totalRows = $db->where($activeColumn.' =', 1)
							 ->get($tableName)
							 ->totalRows();
			
			if( ! empty($totalRows) )
			{
				return $totalRows;
			}
			else
			{
				return 0;		
			}
		}
		
		return false;
	}
	
	/******************************************************************************************
	* TOTAL BANNED USERS                                                                      *
	*******************************************************************************************
	| Genel Kullanım: Kullanıcılardan yasaklı olanların sayısını verir.		        		  |
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|          																				  |
	| Örnek Kullanım: totalBannedUsers(); 									              |
	|          																				  |
	******************************************************************************************/
	public static function totalBannedUsers()
	{
		$bannedColumn 	= Config::get("User",'bannedColumn');	
		$tableName 	= Config::get("User",'tableName');
		
		if( ! empty($bannedColumn) )
		{	
			$db = uselib('DB');
			
			$totalRows = $db->where($bannedColumn.' =', 1)
							 ->get($tableName)
						 	 ->totalRows();
			
			if( ! empty($totalRows) )
			{
				return $totalRows;
			}
			else
			{
				return 0;		
			}
		}
		
		return false;
	}
	
	/******************************************************************************************
	* TOTAL USERS                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Kullanıcıların toplam sayısını verir.		        		              |
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|          																				  |
	| Örnek Kullanım: totalBannedUsers(); 									              |
	|          																				  |
	******************************************************************************************/
	public static function totalUsers()
	{
		$tableName = Config::get("User",'tableName');
		
		$db = uselib('DB');
		
		$totalRows = $db->get($tableName)->totalRows();
		
		if( ! empty($totalRows) )
		{
			return $totalRows;
		}
		else
		{
			return 0;		
		}
	}
	
	/******************************************************************************************
	* LOGIN                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Kullanıcı girişi yapmak için kullanılır.		        		          |
	|															                              |
	| Parametreler: 3 parametresi vardır.                                                     |
	| 1. string var @username => Kullanıcı adı parametresi.								      |
	| 2. string var @password => Kullanıcı şifre parametresi.								  |
	| 3. boolean var @remember_me => Kullanıcı adı ve şifresi hatırlansın mı?.				  |
	|          																				  |
	| Örnek Kullanım: login('zntr', '1234', true);       		                              |
	|          																				  |
	******************************************************************************************/	
	public static function login($un = 'username', $pw = 'password', $rememberMe = false)
	{
		if( ! is_string($un) ) 
		{
			return false;
		}
		
		if( ! is_string($pw) ) 
		{
			return false;
		}
		
		if( ! isValue($rememberMe) ) 
		{
			$rememberMe = false;
		}

		$username = $un;
		$password = Encode::super($pw);
		
		// ------------------------------------------------------------------------------
		// CONFIG/USER.PHP AYARLARI
		// Config/User.php dosyasında belirtilmiş ayarlar alınıyor.
		// ------------------------------------------------------------------------------
		$userConfig			= Config::get("User");	
		$passwordColumn  	= $userConfig['passwordColumn'];
		$usernameColumn  	= $userConfig['usernameColumn'];
		$emailColumn  		= $userConfig['emailColumn'];
		$tableName 			= $userConfig['tableName'];
		$bannedColumn 		= $userConfig['bannedColumn'];
		$activeColumn 		= $userConfig['activeColumn'];
		$activationColumn 	= $userConfig['activationColumn'];
		// ------------------------------------------------------------------------------
		
		$db = uselib('DB');
		
		$r = $db->where($usernameColumn.' =',$username)
			    ->get($tableName)
				->row();
			
		$passwordControl   = $r->$passwordColumn;
		$bannedControl     = '';
		$activationControl = '';
		
		if( ! empty($bannedColumn) )
		{
			$banned = $bannedColumn ;
			$bannedControl = $r->$banned ;
		}
		
		if( ! empty($activationColumn) )
		{
			$activationControl = $r->$activationColumn ;			
		}
		
		if( ! empty($r->$usernameColumn) && $passwordControl == $password )
		{
			if( ! empty($bannedColumn) && ! empty($bannedControl) )
			{
				self::$error = lang('User', 'bannedError');	
				return false;
			}
			
			if( ! empty($activationColumn) && empty($activationControl) )
			{
				self::$error = lang('User', 'activationError');	
				return false;
			}
			
			if( ! isset($_SESSION) ) 
			{
				session_start();
			}
			
			$_SESSION[md5($usernameColumn)] = $username; 
			
			session_regenerate_id();
			
			if( Method::post($rememberMe) || ! empty($rememberMe) )
			{
				if( Cookie::select(md5($usernameColumn)) != $username )
				{					
					Cookie::insert(md5($usernameColumn), $username);
					Cookie::insert(md5($passwordColumn), $password);
				}
			}
			
			if( ! empty($activeColumn) )
			{		
				$db->where($usernameColumn.' =', $username)->update($tableName, array($activeColumn  => 1));
			}
			
			self::$error = false;
			self::$success = lang('User', 'loginSuccess');
			return true;
		}
		else
		{
			self::$error = lang('User', 'loginError');	
			return false;
		}
	}
	
	/******************************************************************************************
	* FORGOT PASSWORD                                                                         *
	*******************************************************************************************
	| Genel Kullanım: Şifremi unuttum uygulamasıdır.		        		         		  |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @email => Kullanıcı e-posta adresi veya kullanıcı adı.					  |
	| 2. string var @return_link_path => e-postaya gönderilen linkin dönüş sayfası.			  |
	|          																				  |
	| Örnek Kullanım: forgotPassword('bilgi@zntr.net', 'kullanici/giris');       		      |
	|          																				  |
	******************************************************************************************/	
	public static function forgotPassword($email = "", $returnLinkPath = "")
	{
		if( ! is_string($email) ) 
		{
			return false;
		}
		
		if( ! is_string($returnLinkPath) ) 
		{
			$returnLinkPath = '';
		}

		// ------------------------------------------------------------------------------
		// CONFIG/USER.PHP AYARLARI
		// Config/User.php dosyasında belirtilmiş ayarlar alınıyor.
		// ------------------------------------------------------------------------------
		$userConfig		= Config::get("User");	
		$usernameColumn = $userConfig['usernameColumn'];
		$passwordColumn = $userConfig['passwordColumn'];				
		$emailColumn  	= $userConfig['emailColumn'];		
		$tableName 		= $userConfig['tableName'];	
		// ------------------------------------------------------------------------------
		
		$db = uselib('DB');
		
		if( ! empty($emailColumn) )
		{
			$db->where($emailColumn.' =', $email);
		}
		else
		{
			$db->where($usernameColumn.' =', $email);
		}
		
		$row = $db->get($tableName)->row();
		
		$result = "";
		
		if( isset($row->$usernameColumn) ) 
		{
			
			if( ! isUrl($returnLinkPath) ) 
			{
				$returnLinkPath = siteUrl($returnLinkPath);
			}
			
			$newPassword    = Encode::create(10);
			$encodePassword = Encode::super($newPassword);
			$message = "
			<pre>
				".lang('User', 'username').": ".$row->$usernameColumn."

				".lang('User', 'password').": ".$newPassword."
				
				<a href='".$returnLinkPath."'>".lang('User', 'learnNewPassword')."</a>
			</pre>
			";
			
			$sendEmail = uselib('Email');
			
			$sendEmail->receiver($email, $email);
			$sendEmail->subject(lang('User', 'newYourPassword'));
			$sendEmail->content($message);
			
			if( $sendEmail->send() )
			{
				if( ! empty($emailColumn) )
				{
					$db->where($emailColumn.' =', $email);
				}
				else
				{
					$db->where($usernameColumn.' =', $email);
				}
				
				$db->update($tableName, array($passwordColumn => $encodePassword));

				self::$error = true;	
				self::$success = lang('User', 'forgotPasswordSuccess');
				return false;
			}
			else
			{	
				self::$success = false;
				self::$error = lang('User', 'emailError');
				return false;
			}
		}
		else
		{
			self::$success = false;
			self::$error = lang('User', 'forgotPasswordError');	
			return false;
		}
	}
	
	/******************************************************************************************
	* UPDATE                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Kullanıcı bilgilerinin güncellenmesi için kullanılır.		        	  |
	|															                              |
	| Parametreler: 4 parametresi vardır.                                                     |
	| 1. string var @old => Kullanıcının eski şifresi.                   					  |
	| 2. string var @new => Kullanıcının yeni şifresi.                   					  |
	| 3. [ string var @new_again ] => Kullanıcının eski şifresi tekrar. Zorunlu değildir.     |
	| 4. array var @data => Kullanıcının güncellenecek bilgileri.                             |
	|          																				  |
	| Örnek Kullanım: update('eski1234', 'yeni1234', NULL, array('telefon' => 'xxxxx'));      |
	|          																				  |
	******************************************************************************************/	
	public static function update($old = '', $new = '', $newAgain = '', $data = array())
	{
		// Bu işlem için kullanıcının
		// oturum açmıl olması gerelidir.
		if( self::isLogin() )
		{
			// Parametreler kontrol ediliyor.--------------------------------------------------
			if( ! is_string($old) || ! is_string($new) || ! is_array($data) ) 
			{
				return false;
			}
				
			if( empty($old) || empty($new) || empty($data) ) 
			{
				return false;
			}
	
			if( ! is_string($newAgain) ) 
			{
				$newAgain = '';
			}
			// --------------------------------------------------------------------------------
			
				
			// Şifre tekrar parametresi boş ise
			// Şifre tekrar parametresini doğru kabul et.
			if( empty($newAgain) ) 
			{
				$newAgain = $new;
			}
	
			$userConfig = Config::get("User");	
			$pc = $userConfig['passwordColumn'];
			$uc = $userConfig['usernameColumn'];	
			$tn = $userConfig['tableName'];
			
			$oldPassword = Encode::super($old);
			$newPassword = Encode::super($new);
			$newPasswordAgain = Encode::super($newAgain);
			
			$username 	  = user::data()->$uc;
			$password 	  = user::data()->$pc;
			$row = "";
					
			if( $oldPassword != $password )
			{
				self::$error = lang('User', 'oldPasswordError');
				return false;	
			}
			elseif( $newPassword != $newPasswordAgain )
			{
				self::$error = lang('User', 'passwordNotMatchError');
				return false;
			}
			else
			{
				$data[$pc] = $newPassword;
				$data[$uc] = $username;
				
				$db = uselib('DB');
				
				$db->where($uc.' =', $username);
				
				if( $db->update($tn, $data) )
				{
					self::$error = false;
					self::$success = lang('User', 'updateProcessSuccess');
					return true;
				}
				else
				{
					self::$error = lang('User', 'registerUnknownError');	
					return false;
				}		
			}
			
		}
		else 
		{
			return false;		
		}
	}
	
	/******************************************************************************************
	* IS LOGIN                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Kullanıcının oturum açıp açmadığını kontrol etmek için kullanılır.	  |
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|          																				  |
	| Örnek Kullanım: isLogin();      														  |
	|          																				  |
	******************************************************************************************/	
	public static function isLogin()
	{
		$cUsername = Cookie::select(md5(Config::get("User",'usernameColumn')));
		$cPassword = Cookie::select(md5(Config::get("User",'passwordColumn')));
		
		$result = '';
		
		if( ! empty($cUsername) && ! empty($cPassword) )
		{
			$db = uselib('DB');
			$result = $db->where(Config::get("User",'usernameColumn').' =', $cUsername, 'and')
						 ->where(Config::get("User",'passwordColumn').' =', $cPassword)
						 ->get(Config::get("User",'tableName'))
						 ->totalRows();
		}
		
		$username = Config::get("User",'usernameColumn');
		
		if( isset(self::data()->$username) )
		{
			$isLogin = true;
		}
		elseif( ! empty($result) )
		{
			if( ! isset($_SESSION) ) 
			{
				session_start();
			}
			
			$_SESSION[md5(Config::get("User",'usernameColumn'))] = $cUsername;
			$isLogin = true;	
		}
		else
		{
			$isLogin = false;	
		}
				
		return $isLogin;
	}
	
	/******************************************************************************************
	* DATA                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Oturum açmış kullanıcın veritabanı bilgilerine erişimek için kullanılır.|
	| Çıktı olarak object türünde veri dizisi döndürür.										  |
	|          																				  |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|          																				  |
	| Örnek Kullanım: $data = data();      													  |
	|          																				  |
	| $data->sutun_adi          															  |
	|          																				  |
	******************************************************************************************/	
	public static function data()
	{
		if( ! isset($_SESSION) ) 
		{
			session_start();
		}

		if( isset($_SESSION[md5(Config::get("User",'usernameColumn'))]) )
		{
			$data = array();
			self::$username = $_SESSION[md5(Config::get("User",'usernameColumn'))];
			
			$db = uselib('DB');
			
			$r = $db->where(Config::get("User",'usernameColumn').' =',self::$username)
				    ->get(Config::get("User",'tableName'))
					->row();
			
			return (object)$r;
		}
		else return false;
	}
	
	/******************************************************************************************
	* LOGOUT                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Oturumu sonlandırmak için kullanılır.									  |
	|          																				  |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @redirect_url => Çıkış sonrası yönlendirilecek sayfa.                     |
	| 1. numeric var @time => çıkış yapıldıktan sonra yönlendirme için bekleme süresi.        |
	|          																				  |
	| Örnek Kullanım: logout('kullanici/giris');      									      |
	|          																				  |
	******************************************************************************************/
	public static function logout($redirectUrl = '', $time = 0)
	{	
		if( ! is_string($redirectUrl) ) 
		{
			$redirectUrl = '';
		}
		
		if( ! is_numeric($time) ) 
		{
			$time = 0;
		}

		$username = Config::get("User",'usernameColumn');
		
		if( isset(self::data()->$username) )
		{
			if( ! isset($_SESSION) ) 
			{
				session_start();
			}
			
			if( Config::get("User",'activeColumn') )
			{	
				$db = uselib('DB');
				
				$db->where(Config::get("User",'usernameColumn').' =', self::data()->$username)
				   ->update(Config::get("User",'tableName'), array(Config::get("User",'activeColumn') => 0));
			}
			
			Cookie::delete(md5(Config::get("User",'usernameColumn')));
			Cookie::delete(md5(Config::get("User",'passwordColumn')));	
			
			if( isset($_SESSION[md5(Config::get("User",'usernameColumn'))]) ) 
			{
				unset($_SESSION[md5(Config::get("User",'usernameColumn'))]);
			}
			
			redirect($redirectUrl, $time);
		}
		
	}
	
	/******************************************************************************************
	* ERROR                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Kullanıcı işlemlerinde oluşan hata bilgilerini tutması içindir.         |
	|     														                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|     														                              |
	******************************************************************************************/
	public static function error()
	{
		if( ! empty(self::$error) ) 
		{
			return self::$error; 
		}
		else 
		{
			return false;	
		}
	}
	
	/******************************************************************************************
	* SUCCESS                                                                                 *
	*******************************************************************************************
	| Genel Kullanım: Kullanıcı işlemlerinde başarı bilgilerini tutması içindir.              |
	|     														                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|     														                              |
	******************************************************************************************/
	public static function success()
	{
		if( ! empty(self::$success) ) 
		{
			return self::$success; 
		}
		else 
		{
			return false;
		}
	}
}