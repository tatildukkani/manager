<?php
function satirSay($yol, $uzantilar=array('php'))
		{
			$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($yol));
			//$rii ile belirtilen yoldaki klasörlerin isimlerini kaydeden bir dizidir. 
			//Bu sayede, acaba iç içe kaç klasör var, uğraşmıyoruz.
			$dosyalar = array(); //dosya isimlerini ve satır sayılarını bu dizi içinde tutacağız.
			//başlıyoruz... Her bir klasördeki her bir dosya için aşağıdaki işlemleri tekrarlatıyoruz.
			foreach ($rii as $dosya) {
				if ($dosya->isDir()){ 
					continue;
				}
				$parcala = explode('.', $dosya->getFilename()); 
				$uzanti = end($parcala);
				if (in_array($uzanti, $uzantilar)) {
					$dosyalar[$dosya->getPathname()] = count(file($dosya->getPathname())); 
					//$dosyalar dizisine o dosyanın yolunu anahtar(key), satır sayısını da değer (value) olarak kaydediyoruz.
				}
			}
			return $dosyalar;
			//İşlem bittikten sonra fonksiyonun çağrıldığı satıra sonuçları geri döndürüyoruz.
		}
		function date_convert($date,$type = 'd.m.Y')
		{
			
			if(empty($date) || $date == '0000-00-00' || $date == '0000-00-00 00:00:00' || $date == '01.01.1970' || $date == '1970-01-01')
			{
			return;	
			}
			
			if($type == 'nice')
			{
				return nice_date(strtotime($date));
			} else {
				return date($type, strtotime($date));
			}
		}
		
		function order_id($length = 24) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}
		
		function valid_url($url)
		{
			if(!filter_var($url, FILTER_VALIDATE_URL))
			{
				return FALSE;
			}
	
			return TRUE;
			
		}
		
		function pnr()
		{
			$data = array('X','W','Q','P','G','U','K','L','F','T','1','2','3','4','5','6','7','8','9','M','N','C','E','A','V','R');	
			$key = array_rand($data, 6);
			$code = $data[$key[0]].$data[$key[1]].$data[$key[2]].$data[$key[3]].$data[$key[4]].$data[$key[5]];
			return $code;
			
		}

		function coupon_code()
		{
			$data = array('X','W','Q','P','I','P','B','F','T','1','2','3','4','5','6','7','8','9','M','N','C','E','A','V','R');	
			$key = array_rand($data, 8);
			$code = $data[$key[0]].$data[$key[1]].$data[$key[2]].$data[$key[3]].$data[$key[4]].$data[$key[5]].$data[$key[6]].$data[$key[7]];
			return $code;
			
		}

		function seo_url($url,$ops='-'){
			$url = trim($url);
			$find = array('<b>', '</b>');
			$url = str_replace ($find, '', $url);
			$url = preg_replace('/<(\/{0,1})img(.*?)(\/{0,1})\>/', 'image', $url);
			$find = array(' ', '&amp;amp;amp;quot;', '&amp;amp;amp;amp;', '&amp;amp;amp;', '\r\n', '\n', '/', '\\', '+', '<', '>');
			$url = str_replace ($find, '-', $url);
			$find = array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ë', 'Ê');
			$url = str_replace ($find, 'e', $url);
			$find = array('í', 'ý', 'ì', 'î', 'ï', 'I', 'Ý', 'Í', 'Ì', 'Î', 'Ï','İ','ı');
			$url = str_replace ($find, 'i', $url);
			$find = array('ó', 'ö', 'Ö', 'ò', 'ô', 'Ó', 'Ò', 'Ô');
			$url = str_replace ($find, 'o', $url);
			$find = array('á', 'ä', 'â', 'à', 'â', 'Ä', 'Â', 'Á', 'À', 'Â');
			$url = str_replace ($find, 'a', $url);
			$find = array('ú', 'ü', 'Ü', 'ù', 'û', 'Ú', 'Ù', 'Û');
			$url = str_replace ($find, 'u', $url);
			$find = array('ç', 'Ç');
			$url = str_replace ($find, 'c', $url);
			$find = array('þ', 'Þ','ş','Ş');
			$url = str_replace ($find, 's', $url);
			$find = array('ð', 'Ð','ğ','Ğ');
			$url = str_replace ($find, 'g', $url);
			$find = array('/[^A-Za-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
			$repl = array('', $ops, '');
			$url = preg_replace ($find, $repl, $url);
			$url = str_replace ('--', $ops, $url);
			$url = strtolower($url);
			return $url;
		}
	
	
		function tr($deger)
         {
			 $deger = str_replace("Ç","C",$deger);
			 $deger = str_replace("Ğ","G",$deger);
			 $deger = str_replace("İ","I",$deger);
			 $deger = str_replace("Ö","O",$deger);
			 $deger = str_replace("Ü","U",$deger);
			 $deger = str_replace("Ş","S",$deger);
			 
			 $deger = str_replace("ç","c",$deger);
			 $deger = str_replace("ğ","g",$deger);
			 $deger = str_replace("ı","i",$deger);
			 $deger = str_replace("ö","o",$deger);
			 $deger = str_replace("ü","u",$deger);
			 $deger = str_replace("ş","s",$deger);
			 
			 $deger = strtoupper($deger);
			 $deger = trim($deger);
			 return $deger;
         }
	
		 function upper($deger)
         {
			 $deger = str_replace("ç","Ç",$deger);
			 $deger = str_replace("ğ","Ğ",$deger);
			 $deger = str_replace("ı","I",$deger);
			 $deger = str_replace("i","İ",$deger);
			 $deger = str_replace("ö","Ö",$deger);
			 $deger = str_replace("ü","Ü",$deger);
			 $deger = str_replace("ş","Ş",$deger);
			 $deger = strtoupper($deger);
			 $deger = trim($deger);
			 return $deger;
         }
		 
		 function lower($deger)
         {
			 $deger = str_replace("Ç","ç",$deger);
			 $deger = str_replace("Ğ","ğ",$deger);
			 $deger = str_replace("I","ı",$deger);
			 $deger = str_replace("İ","i",$deger);
			 $deger = str_replace("Ö","ö",$deger);
			 $deger = str_replace("Ü","ü",$deger);
			 $deger = str_replace("Ş","ş",$deger);
			 $deger = strtolower($deger);
			 $deger = trim($deger);
			 return $deger;
         } 
		 
 		 function ucwords_tr($string)
         {
			$value = '';
			$str = explode(' ',$string);
			for($i=0; $i<count($str); $i++){
				
				$first = mb_substr($str[$i],0,1,'UTF-8');
             	$last  = mb_substr($str[$i],1,100,'UTF-8');
				$value .= upper($first).lower($last).' ';
            
			}
			return trim($value);
         }

		 function price($price,$dec = 2)
		 {
			 return number_format($price,$dec,',','.');
		 }
		 
		 
		 function mask_cc($number) {
			return substr($number, 0, 4) . str_repeat("X", strlen($number) - 8) . substr($number, -4);
		}
		 function convert_utf8($string) {

			$encoding = mb_detect_encoding($string, "UTF-8,ISO-8859-1,WINDOWS-1252,ISO-8859-9");
			if ($encoding != 'UTF-8') {
				return iconv($encoding, 'UTF-8//TRANSLIT', $string);
			} else {
				return $string;
			}
			
		}
		
		function tckimlik($tckimlik){ 
			$olmaz=array('11111111110','22222222220','33333333330','44444444440','55555555550','66666666660','7777777770','88888888880','99999999990'); 
			if($tckimlik[0]==0 or !ctype_digit($tckimlik) or strlen($tckimlik)!=11){ return false;  } 
			else{ 
				for($a=0;$a<9;$a=$a+2){ $ilkt=$ilkt+$tckimlik[$a]; } 
				for($a=1;$a<9;$a=$a+2){ $sont=$sont+$tckimlik[$a]; } 
				for($a=0;$a<10;$a=$a+1){ $tumt=$tumt+$tckimlik[$a]; } 
				if(($ilkt*7-$sont)%10!=$tckimlik[9] or $tumt%10!=$tckimlik[10]){ return false; } 
				else{  
					foreach($olmaz as $olurmu){ if($tckimlik==$olurmu){ return false; } } 
					return true; 
				} 
			} 
		} 
		
		
		
		function money($money='0.00') {
        $money = explode('.',$money);

        if(count($money)!=2) return false;
        $money_left  = $money['0'];
        $money_right = $money['1'];
        //DOKUZLAR
        if(strlen($money_left)==9){
            $i = (int) floor($money_left/100000000);
            if($i==1) $l9="YÜZ";
            if($i==2) $l9="İKİ YÜZ";
            if($i==3) $l9="ÜÇ YÜZ";
            if($i==4) $l9="DÖRT YÜZ";
            if($i==5) $l9="BEŞ YÜZ";
            if($i==6) $l9="ALTI YÜZ";
            if($i==7) $l9="YEDİ YÜZ";
            if($i==8) $l9="SEKİZ YÜZ";
            if($i==9) $l9="DOKUZ YÜZ";
            if($i==0) $l9="";
            $money_left = substr($money_left,1,strlen($money_left)-1);
        }

        //SEKİZLER
        if(strlen($money_left)==8){
            $i = (int) floor($money_left/10000000);
            if($i==1) $l8="ON";
            if($i==2) $l8="YİRMİ";
            if($i==3) $l8="OTUZ";
            if($i==4) $l8="KIRK";
            if($i==5) $l8="ELLİ";
            if($i==6) $l8="ALTMIŞ";
            if($i==7) $l8="YETMİŞ";
            if($i==8) $l8="SEKSEN";
            if($i==9) $l8="DOKSAN";
            if($i==0) $l8="";
            $money_left=substr($money_left,1,strlen($money_left)-1);
        }

        //YEDİLER
        if(strlen($money_left)==7){
            $i = (int) floor($money_left/1000000);
            if($i==1){
                if($i!="NULL"){
                    $l7 = "BİR MİLYON";
                }else{
                    $l7 = "MİLYON";
                }
            }
            if($i==2) $l7="İKİ MİLYON";
            if($i==3) $l7="ÜÇ MİLYON";
            if($i==4) $l7="DÖRT MİLYON";
            if($i==5) $l7="BEŞ MİLYON";
            if($i==6) $l7="ALTI MİLYON";
            if($i==7) $l7="YEDİ MİLYON";
            if($i==8) $l7="SEKİZ MİLYON";
            if($i==9) $l7="DOKUZ MİLYON";
            if($i==0){
                if($i!="NULL"){
                    $l7="MİLYON";
                }else{
                    $l7="";
                }
            }
            $money_left=substr($money_left,1,strlen($money_left)-1);
        }

        //ALTILAR
        if(strlen($money_left)==6){
            $i = (int) floor($money_left/100000);
            if($i==1) $l6="YÜZ";
            if($i==2) $l6="İKİ YÜZ";
            if($i==3) $l6="ÜÇ YÜZ";
            if($i==4) $l6="DÖRT YÜZ";
            if($i==5) $l6="BEŞ YÜZ";
            if($i==6) $l6="ALTI YÜZ";
            if($i==7) $l6="YEDİ YÜZ";
            if($i==8) $l6="SEKİZ YÜZ";
            if($i==9) $l6="DOKUZ YÜZ";
            if($i==0) $l6="";
            $money_left = substr($money_left,1,strlen($money_left)-1);
        }

        //BEŞLER
        if(strlen($money_left)==5){
            $i = (int) floor($money_left/10000);
            if($i==1) $l5="ON";
            if($i==2) $l5="YİRMİ";
            if($i==3) $l5="OTUZ";
            if($i==4) $l5="KIRK";
            if($i==5) $l5="ELLİ";
            if($i==6) $l5="ALTMIŞ";
            if($i==7) $l5="YETMİŞ";
            if($i==8) $l5="SEKSEN";
            if($i==9) $l5="DOKSAN";
            if($i==0) $l5="";
            $money_left=substr($money_left,1,strlen($money_left)-1);
        }

        //DÖRTLER
        if(strlen($money_left)==4){
            $i = (int) floor($money_left/1000);
            if($i==1){
                if($i != ""){
                    $l4 = "BİN";
                }else{
                    $l4 = "BİN";
                }
            }
            if($i==2) $l4="İKİ BİN";
            if($i==3) $l4="ÜÇ BİN";
            if($i==4) $l4="DÖRT BİN";
            if($i==5) $l4="BEŞ BİN";
            if($i==6) $l4="ALTI BİN";
            if($i==7) $l4="YEDİ BİN";
            if($i==8) $l4="SEKİZ BİN";
            if($i==9) $l4="DOKUZ BİN";
            if($i==0){
                if($i!=""){
                    $l4="BİN";
                }else{
                    $l4="";
                }
            }
            $money_left=substr($money_left,1,strlen($money_left)-1);
        }

        //ÜÇLER
        if(strlen($money_left)==3){
            $i = (int) floor($money_left/100);
            if($i==1) $l3="YÜZ";
            if($i==2) $l3="İKİYÜZ";
            if($i==3) $l3="ÜÇYÜZ";
            if($i==4) $l3="DÖRTYÜZ";
            if($i==5) $l3="BEŞYÜZ";
            if($i==6) $l3="ALTIYÜZ";
            if($i==7) $l3="YEDİYÜZ";
            if($i==8) $l3="SEKİZYÜZ";
            if($i==9) $l3="DOKUZYÜZ";
            if($i==0) $l3="";
            $money_left=substr($money_left,1,strlen($money_left)-1);
        }

        //İKİLER
        if(strlen($money_left)==2){
            $i = (int) floor($money_left/10);
            if($i==1) $l2="ON";
            if($i==2) $l2="YİRMİ";
            if($i==3) $l2="OTUZ";
            if($i==4) $l2="KIRK";
            if($i==5) $l2="ELLİ";
            if($i==6) $l2="ALTMIŞ";
            if($i==7) $l2="YETMİŞ";
            if($i==8) $l2="SEKSEN";
            if($i==9) $l2="DOKSAN";
            if($i==0) $l2="";
            $money_left=substr($money_left,1,strlen($money_left)-1);
        }

        //BİRLER
        if(strlen($money_left)==1){
            $i = (int) floor($money_left/1);
            if($i==1) $l1="BİR";
            if($i==2) $l1="İKİ";
            if($i==3) $l1="ÜÇ";
            if($i==4) $l1="DÖRT";
            if($i==5) $l1="BEŞ";
            if($i==6) $l1="ALTI";
            if($i==7) $l1="YEDİ";
            if($i==8) $l1="SEKİZ";
            if($i==9) $l1="DOKUZ";
            if($i==0) $l1="";
            $money_left=substr($money_left,1,strlen($money_left)-1);
        }

        //SAĞ İKİ
        if(strlen($money_right)==2){
            $i = (int) floor($money_right/10);
            if($i==1) $r2="ON";
            if($i==2) $r2="YİRMİ";
            if($i==3) $r2="OTUZ";
            if($i==4) $r2="KIRK";
            if($i==5) $r2="ELLİ";
            if($i==6) $r2="ALTMIŞ";
            if($i==7) $r2="YETMİŞ";
            if($i==8) $r2="SEKSEN";
            if($i==9) $r2="DOKSAN";
            if($i==0) $r2="";
            $money_right=substr($money_right,1,strlen($money_right)-1);
        }

        //SAĞ BİR
        if(strlen($money_right)==1){
            $i = (int) floor($money_right/1);
            if($i==1) $r1="BİR";
            if($i==2) $r1="İKİ";
            if($i==3) $r1="ÜÇ";
            if($i==4) $r1="DÖRT";
            if($i==5) $r1="BEŞ";
            if($i==6) $r1="ALTI";
            if($i==7) $r1="YEDİ";
            if($i==8) $r1="SEKİZ";
            if($i==9) $r1="DOKUZ";
            if($i==0) $r1="";
            $money_right=substr($money_right,1,strlen($money_right)-1);
        }
		$d = '';
		if(!empty($l9))
		{
			$d .= $l9.' ';	
		}
		if(!empty($l8))
		{
			$d .= $l8.' ';	
		}
		if(!empty($l7))
		{
			$d .= $l7.' ';	
		}
		if(!empty($l6))
		{
			$d .= $l6.' ';	
		}
		if(!empty($l5))
		{
			$d .= $l5.' ';	
		}
		if(!empty($l4))
		{
			$d .= $l4.' ';	
		}
		if(!empty($l3))
		{
			$d .= $l3.' ';	
		}
		if(!empty($l2))
		{
			$d .= $l2.' ';	
		}
		if(!empty($l1))
		{
			$d .= $l1.' ';	
		}
		$d .= "TÜRK LİRASI ";
		if(!empty($r2))
		{
			$d .= $r2.' ';	
		}
		if(!empty($r1))
		{
			$d .= $r1.' ';	
		}
		if(!empty($r1)||!empty($r2))
		{
			$d .= 'KURUŞ';	
		}
        return $d;
    } 