<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distance extends CI_Controller {
	
	private $gu = 0;
	private $insert_data = array();

	public function __construct()
    {
        parent::__construct();
		$this->load->model('default_model');	
    }
	private function _log($log)
	{
		if(!empty($log)){
			print date('d.m H:i:s').' - '.$log.PHP_EOL;
		} else {
			print PHP_EOL;	
		}
	}
	
	private function _google_search($data,$lat,$lng,$from_type,$from_id)
	{
		
		   $data   = array_chunk($data, 10);
		   $orgins = $lat.','.$lng;
		
		  $insert = array();
		  $this->_log('');		
		  $this->_log("Google'dan mesafeler sorgulanıyor...");	
		  for($m=0; $m<count($data); $m++)
		  {
		  
			  for($s=0; $s<count($data[$m]); $s++)
			  {
				  $cords[$m][] = $data[$m][$s]['lat'].','.$data[$m][$s]['lng'];	
			  }
			  
		  
		  
			 $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$orgins.'&destinations='.implode("|", $cords[$m]).'&key='.$this->config->item('google_key');

		 	 $ht      = file_get_contents($url);
		 	 $result  = json_decode($ht,TRUE);
		
			  if($result['status'] == 'OK')
			  {
				  for($h=0; $h<count($result['rows'][0]['elements']); $h++)
				  {
					  if($result['rows'][0]['elements'][$h]['status'] == 'OK')
					  {
						  if($result['rows'][0]['elements'][$h]['distance']['value']>0 && !empty( $data[$m][$h]['item']) && !empty($data[$m][$h]['id'])){
						  $this->insert_data[$this->gu]['from_type']   = $from_type;
						  $this->insert_data[$this->gu]['from_id']     = $from_id;
						  $this->insert_data[$this->gu]['to_type']     = $data[$m][$h]['item'];
						  $this->insert_data[$this->gu]['to_id']       = $data[$m][$h]['id'];
						  $this->insert_data[$this->gu]['distance']    = $result['rows'][0]['elements'][$h]['distance']['value'];
						  $this->insert_data[$this->gu]['duration']    = $result['rows'][0]['elements'][$h]['duration']['value'];
						  
						  
						  $this->gu++;			
						  }
					  }
					  
				  }
			  }
			  
		  }
						
		return $this->insert_data;
	}
	
	private function _save($datas)
	{
		$insert = array_values($datas);
		 $this->_log('');	
		$this->_log("Toplam ".count($insert)." veri kaydedilmeye hazırlanıyor...");	
		
		if(count($insert)>700)
		{
			$save_data = array_chunk($insert, 500);
			
			for($o=0; $o<count($save_data); $o++)
			{
				$vv = $o+1;
				if(!empty($insert[$o][0]['from_id'])){		
					$this->_log("".$vv.". aşama ".count($insert[$o])." veri kaydediliyor...");	
					$this->db->insert_batch('distance', $insert[$o]); 
				}
			}
		} else {
			if(!empty($insert[0]['from_id'])){		
				$this->_log("Toplam ".count($insert)." veri kaydediliyor...");	
				$this->db->insert_batch('distance', $insert); 
			}
		}
		$this->_log("İşlem tamamlandı.");	
	}
	
	private function _array_searching($parents, $searched) 
	{ 
	
	  if (empty($searched) || empty($parents)) { 
		return false; 
	  } 
	
	  foreach ($parents as $key => $value) { 
	
		$exists = true; 
		foreach ($searched as $skey => $svalue) { 
			if(isset($parents[$key][$skey]) && ($parents[$key][$skey] == $svalue))
			{
				return $key;
			}
		  $exists = ($exists && isset($parents[$key][$skey]) && $parents[$key][$skey] == $svalue); 
		} 
		if($exists){  return $key; } 
	  } 
	
	  return false; 
	}
	
	
	private function _landmarks($lat,$lng,$radius,$distances,$org_type,$org_id)
	{
		    $uz = $radius/1000;
			//landmarks
			$landmarks = $this->default_model->landmark_search($lat,$lng,$radius);
			
			if(empty($landmarks[0]['id']))
			{
				$this->_log("".$uz." km. içinde hiçbir landmark bulunamadı!");	
			} else {
				
				
				for($c=0; $c<count($landmarks); $c++)
				{
					$landmarks[$c]['item'] = 'landmark';
				}
				
			
			
				if(!empty($distances[0]['id']))
				{
					for($l=0; $l<count($landmarks); $l++)
					{
						for($d=0; $d<count($distances); $d++)
						{
							
						
							if( (($distances[$d]['from_type'] == $landmarks[$l]['item']) && ($distances[$d]['from_id'] == $landmarks[$l]['id']) && ($distances[$d]['to_type'] == $org_type) && ($distances[$d]['to_id'] == $org_id)) || (($distances[$d]['to_type'] == $landmarks[$l]['item']) && ($distances[$d]['to_id'] == $landmarks[$l]['id']) && ($distances[$d]['from_type'] == $org_type) && ($distances[$d]['from_id'] == $org_id)) )	
							{
								unset($landmarks[$l]);
								break;	
							}
							
						}
					}
				}
				
				$landmarks = array_values($landmarks);	
				$this->_log("".$uz." km. içinde ".count($landmarks)." landmark bulundu! [".$org_type.'/'.$org_id."]");	
				
				
				
				print_r($distances);
				print_r($landmarks);
				exit();
				
				
			}
		
		
			return $landmarks;
			
			//landmarks	
		
	}
	
	private function _destinations($lat,$lng,$radius,$distances)
	{
		    $uz = $radius/1000;
			
			//landmarks
			$destinations = $this->default_model->destination_search($lat,$lng,$radius);
			
			if(empty($destinations[0]['id']))
			{

				$this->_log("".$uz." km. içinde hiçbir destinasyon bulunamadı!");	

			} else {

				

				for($c=0; $c<count($destinations); $c++)
				{
					$destinations[$c]['item'] = $destinations[$c]['type'];
				}

			
				//olanlar siliniyor
				if(!empty($distances[0]['id']))
				{
					for($d=0; $d<count($distances); $d++)
					{
						if($distances[$d]['from_type'] == 'country' || $distances[$d]['from_type'] == 'city' || $distances[$d]['from_type'] == 'district' || $distances[$d]['from_type'] == 'town')
						{ 
							$level2 = $this->_array_searching($destinations, array('id'=>$distances[$d]['from_id']));
							if(is_numeric($level2))
							{
								unset($destinations[$level2]);
							}
						}
						
						if($distances[$d]['to_type'] == 'country' || $distances[$d]['to_type'] == 'city' || $distances[$d]['to_type'] == 'district' || $distances[$d]['to_type'] == 'town')
						{ 
							$level1 = $this->_array_searching($destinations, array('id'=>$distances[$d]['to_id']));
							if(is_numeric($level1))
							{
								unset($destinations[$level1]);
							}
						}
						
						
					}
					$this->_log("".$uz." km. içinde ".count($destinations)." destinasyon bulundu!");	
				}
				//olanlar siliniyor
					
				$destinations = array_values($destinations);	
			}
			
			
			return $destinations;
			
			//landmarks	
		
	}
	
	private function _hotels($lat,$lng,$radius,$distances)
	{
		 
		    $uz = $radius/1000;
			unset($hotels);
			//landmarks
			$hotels = $this->default_model->hotel_search($lat,$lng,$radius);
		
	
			
			if(empty($hotels[0]['id']))
			{
				$this->_log("".$uz." km. içinde hiçbir otel bulunamadı!");	
			} else {
				
			
				for($c=0; $c<count($hotels); $c++)
				{
					$hotels[$c]['item'] = 'hotel';
				}
			
			
				

					
				//olanlar siliniyor
				if(!empty($distances[0]['id']))
				{
					for($d=0; $d<count($distances); $d++)
					{
						if($distances[$d]['from_type'] == 'hotel')
						{ 
							$level2 = $this->_array_searching($hotels, array('id'=>$distances[$d]['from_id']));
							if(is_numeric($level2))
							{
								unset($hotels[$level2]);
							}
						}
						
						if($distances[$d]['to_type'] == 'hotel')
						{ 
							$level1 = $this->_array_searching($hotels, array('id'=>$distances[$d]['to_id']));
							if(is_numeric($level1))
							{
								unset($hotels[$level1]);
							}
						}
						
						
					}
					
				}
				//olanlar siliniyor
					
					
				
				
				
				$hotels = array_values($hotels);
	
				
				$this->_log("".$uz." km. içinde ".count($hotels)." otel bulundu!");	
					
			}
			
			
			return $hotels;
			
			//landmarks	
		
	}

	public function destination()
	{
			
			
			$dests = $this->default_model->destination_list();
			$insert = array();
		
			
			for($i=0; $i<count($dests); $i++)
			{
				unset($distances);
				
				$my_type = $dests[$i]['destination_type'];
				
				if(!empty($dests[$i]['lat']) && !empty($dests[$i]['lng'])  && !empty($dests[$i]['radius']))
				{
				
					$distances = $this->default_model->distance_find($my_type, $dests[$i]['destination_id']); 
				
				
					$lat 	= $dests[$i]['lat'];	
					$lng 	= $dests[$i]['lng'];	
					$radius = $dests[$i]['radius'];	
					$this->_log("");
					$this->_log("");
					$this->_log("Bölge ".$dests[$i]['destination_type']." - ".$dests[$i]['destination_id']." sorgulanıyor...");	
					
					$landmarks    = $this->_landmarks($lat,$lng,$radius,$distances);
					$destinations = $this->_destinations($lat,$lng,$radius,$distances);
					$hotels 	  = $this->_hotels($lat,$lng,$radius,$distances);
			
					$data = array();
					$z = 0;
					$cords = array();
					
					
					if(!empty($landmarks[0]['id']))
					{
						for($b=0; $b<count($landmarks); $b++)
						{
							$data[$z] = $landmarks[$b];	
							$z++;
						}
					}
					if(!empty($destinations[0]['id']))
					{
						for($b=0; $b<count($destinations); $b++)
						{
							$data[$z] = $destinations[$b];	
							$z++;
						}
							
					}
					if(!empty($hotels[0]['id']))
					{
						for($b=0; $b<count($hotels); $b++)
						{
							$data[$z] = $hotels[$b];
							$z++;		
						}
						
					}
					
				    $this->_google_search($data,$dests[$i]['lat'],$dests[$i]['lng'],$dests[$i]['destination_type'],$dests[$i]['destination_id']);
				
				} 
		
			}
			
		
					
					$keys = array();
					$insert2 = array();
					$this->_log("Veriler analiz ediliyor...");
					$insert = $this->insert_data;
					for($m=0; $m<count($insert); $m++)
					{
						unset($keys);
						$keys = array($insert[$m]['from_id'],$insert[$m]['to_id'],$insert[$m]['from_type'],$insert[$m]['to_type']);
						sort($keys);
						$key = implode('-',$keys);
						
						$insert2[$key]['from_id'] = $insert[$m]['from_id'];
						$insert2[$key]['to_id'] = $insert[$m]['to_id'];
						$insert2[$key]['from_type'] = $insert[$m]['from_type'];
						$insert2[$key]['to_type'] = $insert[$m]['to_type'];
						$insert2[$key]['distance'] = $insert[$m]['distance'];
						$insert2[$key]['duration'] = $insert[$m]['duration'];
					}
					
					$this->_save($insert2);	
			
	
		
	}
	
	public function landmark()
	{
			
			$dests = $this->default_model->landmark_list();
			$gu =0;
			$insert = array();
			
			
		
			
			for($i=0; $i<count($dests); $i++)
			{
				unset($distances);
				
				$my_type = 'landmark';
				
				if(!empty($dests[$i]['lat']) && !empty($dests[$i]['lng'])  && !empty($dests[$i]['radius']))
				{
				
					$distances = $this->default_model->distance_find($my_type, $dests[$i]['id']); 
				
					
				
					$lat 	= $dests[$i]['lat'];	
					$lng 	= $dests[$i]['lng'];	
					$radius = $dests[$i]['radius'];	
					$this->_log("");
					$this->_log("");
					$this->_log("Landmark ".$dests[$i]['landmark']." - ".$dests[$i]['type']." sorgulanıyor...");	
					
					$landmarks    = $this->_landmarks($lat,$lng,$radius,$distances,$my_type,$dests[$i]['id']);	
					$destinations = $this->_destinations($lat,$lng,$radius,$distances,$my_type,$dests[$i]['id']);
					$hotels 	  = $this->_hotels($lat,$lng,$radius,$distances,$my_type,$dests[$i]['id']);
			
					$data = array();
					$z = 0;
					$cords = array();
					
					
					if(!empty($landmarks[0]['id']))
					{
						for($b=0; $b<count($landmarks); $b++)
						{
							$data[$z] = $landmarks[$b];	
							$z++;
						}
					}
					if(!empty($destinations[0]['id']))
					{
						for($b=0; $b<count($destinations); $b++)
						{
							$data[$z] = $destinations[$b];	
							$z++;
						}
							
					}
					if(!empty($hotels[0]['id']))
					{
						for($b=0; $b<count($hotels); $b++)
						{
							$data[$z] = $hotels[$b];
							$z++;		
						}
						
					}
					
			
					$this->_google_search($data,$lat,$lng,$my_type,$dests[$i]['id']);
					
					
				
				} 
		
			}
			
		
					
					$keys = array();
					$insert2 = array();
					$insert = $this->insert_data;
					$this->_log("Veriler analiz ediliyor...");
					for($m=0; $m<count($insert); $m++)
					{
						unset($keys);
						$keys = array($insert[$m]['from_id'],$insert[$m]['to_id'],$insert[$m]['from_type'],$insert[$m]['to_type']);
						sort($keys);
						$key = implode('-',$keys);
						
						$insert2[$key]['from_id'] = $insert[$m]['from_id'];
						$insert2[$key]['to_id'] = $insert[$m]['to_id'];
						$insert2[$key]['from_type'] = $insert[$m]['from_type'];
						$insert2[$key]['to_type'] = $insert[$m]['to_type'];
						$insert2[$key]['distance'] = $insert[$m]['distance'];
						$insert2[$key]['duration'] = $insert[$m]['duration'];
					}
					
					
					$this->_save($insert2);
					
		
	}
	
	public function hotel()
	{
			
			$dests = $this->default_model->hotel_list();
			$gu =0;
			$insert = array();
			
	
			
			for($i=0; $i<count($dests); $i++)
			{
				unset($distances);
				
				$my_type = 'hotel';
				
				if(!empty($dests[$i]['lat']) && !empty($dests[$i]['lng']))
				{
				
					$distances = $this->default_model->distance_find($my_type, $dests[$i]['id']); 
				
					$lat 	= $dests[$i]['lat'];	
					$lng 	= $dests[$i]['lng'];	
					$radius = '30000';	
					$this->_log("");
					$this->_log("");
					$this->_log("Hotel ".$dests[$i]['name']." sorgulanıyor...");	
					
					$landmarks    = $this->_landmarks($lat,$lng,$radius,$distances);
					$destinations = $this->_destinations($lat,$lng,$radius,$distances);
					$hotels 	  = $this->_hotels($lat,$lng,$radius,$distances);
			
					$data = array();
					$z = 0;
					$cords = array();
					
					if(!empty($landmarks[0]['id']))
					{
						for($b=0; $b<count($landmarks); $b++)
						{
							$data[$z] = $landmarks[$b];	
							$z++;
						}
					}
					if(!empty($destinations[0]['id']))
					{
						for($b=0; $b<count($destinations); $b++)
						{
							$data[$z] = $destinations[$b];	
							$z++;
						}
							
					}
					if(!empty($hotels[0]['id']))
					{
						for($b=0; $b<count($hotels); $b++)
						{
							if($hotels[$b]['id'] != $dests[$i]['id'])
							{
								$data[$z] = $hotels[$b];
								$z++;		
							}
						}
						
					}
					
					
					
					$data   = array_chunk($data, 10);
					$orgins = $lat.','.$lng;
					
					
					$this->_google_search($data,$lat,$lng,$my_type, $dests[$i]['id']);
				
				} 
						
		
			}
			
		
				$keys = array();
				$insert2 = array();
				$insert = $this->insert_data;
				$this->_log("Veriler analiz ediliyor...");
					
						
				
				if(!empty($insert[0]['from_id']))
				{	
					for($m=0; $m<count($insert); $m++)
					{
						unset($keys);
						$keys = array($insert[$m]['from_id'],$insert[$m]['to_id'],$insert[$m]['from_type'],$insert[$m]['to_type']);
						sort($keys);
						$key = implode('-',$keys);
						
						$insert2[$key]['from_id'] = $insert[$m]['from_id'];
						$insert2[$key]['to_id'] = $insert[$m]['to_id'];
						$insert2[$key]['from_type'] = $insert[$m]['from_type'];
						$insert2[$key]['to_type'] = $insert[$m]['to_type'];
						$insert2[$key]['distance'] = $insert[$m]['distance'];
						$insert2[$key]['duration'] = $insert[$m]['duration'];
					}
					
				}
				
					
				$this->_save($insert2);	
				
	
		
	}

	
	
	
}
