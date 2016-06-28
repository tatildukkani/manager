<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Destination extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('user_model');
		
        $uid = $this->session->userdata('uid');
		if(empty($uid))
		{
			redirect('login');
			die(); 
			exit();
		}
		 
		
    }

	public function index()
	{
		$data['title']  = 'Bölgeler';
		$uid 			= $this->session->userdata('uid');
		$data['member'] = $this->user_model->user_get($uid);
		$this->load->view('destination',$data);
	}
	
	public function location()
	{
		$did       = $this->input->get('did');
		$dtype     = $this->input->get('type');
		$q         = $this->input->get('q');
		$key = $dtype.$did;
		if(!empty($did)&&!empty($dtype))
		{
			class_exists('SphinxClient') or require_once(APPPATH.'libraries/sphinx/sphinxapi.php');
			$cl = new SphinxClient();
			$cl->SetSortMode(SPH_SORT_EXTENDED, "distance ASC");
			$cl->SetLimits(0,1000);
			$cl->AddQuery($key,"distance");
			$result = $cl->RunQueries();
			
			$results = array_values($result[0]['matches']);
			
			
			$districts = array();
			$landmarks = array();
			$hotels = array();
			$towns = array();
			$cities = array();
			
			
			//hotels
			$h = 0;
			for($i=0; $i<count($results); $i++)
			{
				if(($results[$i]['attrs']['from_key'] == $key && $results[$i]['attrs']['to_type'] == 'hotel') || ($results[$i]['attrs']['to_key'] == $key && $results[$i]['attrs']['from_type'] == 'hotel'))
				{
					if($results[$i]['attrs']['from_key'] != $key)
					{
						$hid = $results[$i]['attrs']['from_id'];	
					} else if($results[$i]['attrs']['to_key'] != $key){
						$hid = $results[$i]['attrs']['to_id'];	
					}
					
					$hotels[$h]['id'] = $hid;
					$hotels[$h]['distance'] = $results[$i]['attrs']['distance'];
					$hotels[$h]['duration'] = $results[$i]['attrs']['duration'];
					$h++;
				}
				
				
			}
			//hotels
			
			
			//landmarks
			$h = 0;
			for($i=0; $i<count($results); $i++)
			{
				if(($results[$i]['attrs']['from_key'] == $key && $results[$i]['attrs']['to_type'] == 'landmark') || ($results[$i]['attrs']['to_key'] == $key && $results[$i]['attrs']['from_type'] == 'landmark'))
				{
					if($results[$i]['attrs']['from_key'] != $key)
					{
						$lid = $results[$i]['attrs']['from_id'];	
					} else if($results[$i]['attrs']['to_key'] != $key){
						$lid = $results[$i]['attrs']['to_id'];	
					}
					
					$landmarks[$h]['id'] = $lid;
					$landmarks[$h]['distance'] = $results[$i]['attrs']['distance'];
					$landmarks[$h]['duration'] = $results[$i]['attrs']['duration'];
					$h++;
				}
				
				
			}
			//landmarks
			
			
			//districts
			$h = 0;
			$dkeys = array();
			for($i=0; $i<count($results); $i++)
			{
				if(($results[$i]['attrs']['from_key'] == $key && $results[$i]['attrs']['to_type'] == 'district') || ($results[$i]['attrs']['to_key'] == $key && $results[$i]['attrs']['from_type'] == 'district'))
				{
					if($results[$i]['attrs']['from_key'] != $key)
					{
						$did = $results[$i]['attrs']['from_id'];	
					} else if($results[$i]['attrs']['to_key'] != $key){
						$did = $results[$i]['attrs']['to_id'];	
					}
					$dkeys[] = 'district'.$did;	
					$districts[$h]['id']       = $did;
					$districts[$h]['distance'] = $results[$i]['attrs']['distance'];
					$districts[$h]['duration'] = $results[$i]['attrs']['duration'];
					$h++;
				}
				
				
			}
			//districts
			
			//cities
			$h = 0;
			$ckeys = array();
			for($i=0; $i<count($results); $i++)
			{
				if(($results[$i]['attrs']['from_key'] == $key && $results[$i]['attrs']['to_type'] == 'city') || ($results[$i]['attrs']['to_key'] == $key && $results[$i]['attrs']['from_type'] == 'city'))
				{
					if($results[$i]['attrs']['from_key'] != $key)
					{
						$cid = $results[$i]['attrs']['from_id'];	
					} else if($results[$i]['attrs']['to_key'] != $key){
						$cid = $results[$i]['attrs']['to_id'];	
					}
					$ckeys[] = 'city'.$tid;	
					$cities[$h]['id']       = $cid;
					$cities[$h]['distance'] = $results[$i]['attrs']['distance'];
					$cities[$h]['duration'] = $results[$i]['attrs']['duration'];
					$h++;
				}
				
				
			}
			//cities
			
			//towns
			$h = 0;
			$tkeys = array();
			for($i=0; $i<count($results); $i++)
			{
				if(($results[$i]['attrs']['from_key'] == $key && $results[$i]['attrs']['to_type'] == 'town') || ($results[$i]['attrs']['to_key'] == $key && $results[$i]['attrs']['from_type'] == 'town'))
				{
					if($results[$i]['attrs']['from_key'] != $key)
					{
						$tid = $results[$i]['attrs']['from_id'];	
					} else if($results[$i]['attrs']['to_key'] != $key){
						$tid = $results[$i]['attrs']['to_id'];	
					}
					$tkeys[] = $tid;		
					$towns[$h]['id'] = $tid;
					$towns[$h]['distance'] = $results[$i]['attrs']['distance'];
					$towns[$h]['duration'] = $results[$i]['attrs']['duration'];
					$h++;
				}
				
				
			}
			//towns
			
			//hotels
			for($i=0; $i<count($results); $i++)
			{
				if(($results[$i]['attrs']['from_key'] == $key && $results[$i]['attrs']['to_type'] == 'hotel') || ($results[$i]['attrs']['to_key'] == $key && $results[$i]['attrs']['from_type'] == 'hotel'))
				{
					if($results[$i]['attrs']['from_key'] != $key)
					{
						$hid = $results[$i]['attrs']['from_id'];	
					} else if($results[$i]['attrs']['to_key'] != $key){
						$hid = $results[$i]['attrs']['to_id'];	
					}
					$hkeys[] = $hid;		
					
				}
				
				
			}
			//hotels
			
			
			
			
			//towns data
			if(count($tkeys)>0){
			$cl2 = new SphinxClient();
			$cl2->SetLimits(0,1000);
			$cl2->setFilter('did',$tkeys);
			$cl2->setFilter('type_id',array(4));
			$cl2->AddQuery('',"destinations");
			$result = $cl2->RunQueries();
			$town_results = array_values($result[0]['matches']);
			for($i=0; $i<count($town_results); $i++)
			{
				$town_data[$i] = $town_results[$i]['attrs'];
			}
				for($i=0; $i<count($towns); $i++)
				{
					$town_key = array_search($towns[$i]['id'], array_column($town_data, 'did'));
					if(is_numeric($town_key))
					{
						$towns[$i]['data'] = $town_data[$town_key];	
					}
				}
			}
			//towns data
			
			//cities data
			if(count($ckeys)>0){
			$cl2 = new SphinxClient();
			$cl2->SetLimits(0,1000);
			$cl2->setFilter('did',$ckeys);
			$cl2->setFilter('type_id',array(2));
			$cl2->AddQuery('',"destinations");
			$result = $cl2->RunQueries();
			$city_results = array_values($result[0]['matches']);
			for($i=0; $i<count($city_results); $i++)
			{
				$city_data[$i] = $city_results[$i]['attrs'];
			}
				for($i=0; $i<count($cities); $i++)
				{
					$city_key = array_search($cities[$i]['id'], array_column($city_data, 'did'));
					if(is_numeric($city_key))
					{
						$cities[$i]['data'] = $city_data[$city_key];	
					}
				}
				
			}
			//cities data
			
			//district data
			if(count($dkeys)>0){
			$cl2 = new SphinxClient();
			$cl2->SetLimits(0,1000);
			$cl2->setFilter('did',$tkeys);
			$cl2->setFilter('type_id',array(3));
			$cl2->AddQuery('',"destinations");
			$result = $cl2->RunQueries();
			$district_results = array_values($result[0]['matches']);
			for($i=0; $i<count($district_results); $i++)
			{
				$district_data[$i] = $district_results[$i]['attrs'];
			}
				for($i=0; $i<count($districts); $i++)
				{
					$district_key = array_search($districts[$i]['id'], array_column($district_data, 'did'));
					if(is_numeric($district_key))
					{
						$districts[$i]['data'] = $district_data[$district_key];	
					}
				}
			}
			//district data
			
			//hotel data
			if(count($hkeys)>0){
				$cl2 = new SphinxClient();
				$cl2->SetLimits(0,1000);
				$cl2->setFilter('hid',$hkeys);
				$cl2->AddQuery('',"hotel_search");
				$result = $cl2->RunQueries();
				$hotel_results = array_values($result[0]['matches']);
				
				
			
			
			for($i=0; $i<count($hotel_results); $i++)
			{
				$hotel_data[$i] = $hotel_results[$i]['attrs'];
			}
				for($i=0; $i<count($hotels); $i++)
				{
					$hotel_key = array_search($hotels[$i]['id'], array_column($hotel_data, 'hid'));
					if(is_numeric($hotel_key))
					{
						$hotels[$i]['data'] = $hotel_data[$hotel_key];	
					} else {
						unset($hotels[$i]);	
					}
				}
			}
			//hotel data
			
			
			
			
			$data['districts']  = $districts;
			$data['towns']      = $towns;
			$data['cities']     = $cities;
			$data['hotels'] 	= $hotels;
			$data['landmarks']  = $landmarks;
			
			print_r($data);
			exit();
			
			print "<h1>DISTRICTS</h1>";
			print_r($districts);
			print "<h1>TOWNS</h1>";
			print_r($towns);
			print "<h1>LANDMARK</h1>";
			print_r($landmarks);
			print "<h1>HOTELS</h1>";
			print_r($hotels);
					//	$select .= ", IF(p_begin <= $currentTimestamp, 10, 0) + IF(p_end >= $currentTimestamp, 10, 0) AS datefilter";

			print $did;
		}
		
	}
	
	
	public function find()
	{
		
		$q = $this->input->get('q');
		if(!empty($q))
		{
			class_exists('SphinxClient') or require_once(APPPATH.'libraries/sphinx/sphinxapi.php');
			$cl = new SphinxClient();
			$cl->AddQuery ($q,"destinations");
			$result = $cl->RunQueries();
			if(!empty($result[0]['matches'])){
			$data['results'] = array_values($result[0]['matches']);
			} else {
			$data['results'] = array();	
			}
		
		}
	
		$this->load->view('destination_list',$data);
		
	}
	
	
	public function detail()
	{
		
		$id     = $this->input->get('id');
		$name   = $this->input->get('name');
		$ids  = explode('-',$id);
		$type = $ids[0];
		$id   = $ids[1];
		
		$this->load->model('default_model');
		
		if(!empty($id))
		{
			class_exists('SphinxClient') or require_once(APPPATH.'libraries/sphinx/sphinxapi.php');
			$cl = new SphinxClient();
			$cl->SetFilter('did' , array($id));
			$cl->AddQuery($name,"destinations");
			$result = $cl->RunQueries();
			if(!empty($result[0]['matches'])){
				$data['results'] = array_values($result[0]['matches']);
				$data['destination'] = $this->default_model->destination_get($data['results'][0]['attrs']['did'],$data['results'][0]['attrs']['type']);
			} else {
				$data['results'] = array();	
			}
		
		}
		
		
		
	
		$this->load->view('destination_detail',$data);
		
	}
	
	
	public function upload()
	{
	
		$imagePath = FCPATH."assets/data/tmp/";
		$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
		$temp = explode(".", $_FILES["img"]["name"]);
		$extension = end($temp);
	
		//Check write Access to Directory

		if(!is_writable($imagePath)){
			$response = Array(
				"status" => 'error',
				"message" => 'Can`t upload File; no write Access ->'.$imagePath
			);
			print json_encode($response);
			return;
		} 
	
		if ( in_array($extension, $allowedExts))
		{
		  if ($_FILES["img"]["error"] > 0)
			{
				 $response = array(
					"status" => 'error',
					"message" => 'ERROR Return Code: '. $_FILES["img"]["error"],
				);			
			} else {
				
			  $filename = $_FILES["img"]["tmp_name"];
			  list($width, $height) = getimagesize( $filename );
			  
			  $fname = 'dest_'.time().'_'.rand(10, 99);
	
			  move_uploaded_file($filename,  $imagePath . $fname);
	
			  $response = array(
				"status" => 'success',
				"url" => 'http://manage.tatildukkani.com/assets/data/tmp/'.$fname,
				"width" => $width,
				"height" => $height
			  );
			  
			}
		  }
		else
		  {
		   $response = array(
				"status" => 'error',
				"message" => 'something went wrong, most likely file is to large for upload. check upload_max_filesize, post_max_size and memory_limit in you php.ini',
			);
		  }
		  
		  print json_encode($response);	
			
	}
	
	
	public function pictures()
	{
		
		$this->load->model('default_model');
		
		$del   = $this->input->get('del'); 
		if(!empty($del))
		{
			$this->default_model->destination_picture_delete($del);	
			unlink(FCPATH."assets/data/destinations/".$del);
		}
		
		
		$did     = $this->input->get('did'); 
		$dtype   = $this->input->get('type');
		
		$head   = $this->input->get('head'); 
		if(!empty($head))
		{
			
			$dest = $this->default_model->destination_get($did,$dtype);
			$up3['picture'] = $head;
			$this->default_model->destination_update($dest['id'],$up3);	
			
			
			$up['default']  = 'Hayır';	
			$this->default_model->destination_picture_update_all($did,$dtype,$up);
				
			$up2['default'] = 'Evet';	
			$this->default_model->destination_picture_update($head,$up2);	
			
		}
		
		 
		
		
		$filter['destination_id'] = $did;
		$filter['destination_type'] = $dtype;
		$data['pictures'] = $this->default_model->destination_picture_list($filter);
		
		$this->load->view('destination_picture',$data); 
	}
	
	
	public function videos()
	{
		
		$this->load->model('default_model');
		
		$del   = $this->input->get('del'); 
		if(!empty($del))
		{
			$this->default_model->destination_video_delete($del);
		}
		
		
		$did     = $this->input->get('did'); 
		$dtype   = $this->input->get('type');
		
		$video   = $this->input->get('video'); 
		if(!empty($video))
		{
			$insert['destination_id'] = $did;
			$insert['destination_type'] = $dtype;
			$insert['video'] = $video;
			$this->default_model->destination_video_add($insert);
		}
		
		 
		
		$filter['destination_id'] = $did;
		$filter['destination_type'] = $dtype;
		$data['videos'] = $this->default_model->destination_video_list($filter);
	
		$this->load->view('destination_video',$data);
	}
	
	public function update()
	{
		
		$did   = $this->input->get('did'); 
		$dtype   = $this->input->get('type'); 
		$description = $this->input->post('description');	
		$visa = $this->input->post('visa');	
		$lat = $this->input->post('lat');	
		$lng = $this->input->post('lng');
		$radius = $this->input->post('radius');	
		
		$this->load->model('default_model');
		$filter['destination_id'] = $did;
		$filter['destination_type'] = $dtype;
		$dest = $this->default_model->destination_get($did,$dtype);
		
		
		$insert['destination_id'] = $did;
		$insert['destination_type'] = $dtype;
		if(!empty($lat) && is_numeric($lat))
		{
			$insert['lat'] = $lat;
			$insert['lng'] = $lng;
			$insert['radius'] = $radius;
		} else {
			$insert['lat'] = NULL;
			$insert['lng'] = NULL;
			$insert['radius'] = NULL;	
		}
		$insert['description'] = $description;
		$insert['visa'] = $visa;
		
		if(empty($dest['id']))
		{
			$this->default_model->destination_add($insert);
		} else {
			$this->default_model->destination_update($dest['id'],$insert);
		}
		
	}
	
	public function crop()
	{
		
		$did   = $this->input->get('did'); 
		$dtype   = $this->input->get('type'); 
		
		$imgUrl   = $this->input->post('imgUrl'); 
		// original sizes
		$imgInitW = $this->input->post('imgInitW');
		$imgInitH = $this->input->post('imgInitH'); 
		// resized sizes
		$imgW    = $this->input->post('imgW');
		$imgH    = $this->input->post('imgH');
		// offsets
		$imgY1 = $this->input->post('imgY1');
		$imgX1 = $this->input->post('imgX1');
		// crop box
		$cropW = $this->input->post('cropW');
		$cropH = $this->input->post('cropH');
		// rotation angle
		$angle = $this->input->post('rotation');
		
		
		$nn = basename($imgUrl);
		$nn = explode('.',$nn);
		$name = $nn[0];
	
		
		$jpeg_quality = 100;
		
		$output_filename = FCPATH."assets/data/destinations/".$name;
		
		// uncomment line below to save the cropped image in the same location as the original image.
		//$output_filename = ($imgUrl). "/croppedImg_".rand();
		
		$what = getimagesize($imgUrl);
		
		
		
		switch(strtolower($what['mime']))
		{
			case 'image/png':
				$img_r = imagecreatefrompng($imgUrl);
				$source_image = imagecreatefrompng($imgUrl);
				$type = '.png';
				break;
			case 'image/jpeg':
				$img_r = imagecreatefromjpeg($imgUrl);
				$source_image = imagecreatefromjpeg($imgUrl);
				error_log("jpg");
				$type = '.jpeg';
				break;
			case 'image/gif':
				$img_r = imagecreatefromgif($imgUrl);
				$source_image = imagecreatefromgif($imgUrl);
				$type = '.gif';
				break;
			default: die('image type not supported');
		}
		
	
		//Check write Access to Directory
		
		if(!is_writable(dirname($output_filename))){
			$response = Array(
				"status" => 'error',
				"message" => 'Can`t write cropped File ->'. $output_filename.' -> '.$imgUrl
			);	
		}else{
		
			// resize the original image to size of editor
			$resizedImage = imagecreatetruecolor($imgW, $imgH);
			imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
			// rotate the rezized image
			$rotated_image = imagerotate($resizedImage, -$angle, 0);
			// find new width & height of rotated image
			$rotated_width = imagesx($rotated_image);
			$rotated_height = imagesy($rotated_image);
			// diff between rotated & original sizes
			$dx = $rotated_width - $imgW;
			$dy = $rotated_height - $imgH;
			// crop rotated image to fit into original rezized rectangle
			$cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
			imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
			imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
			// crop image into selected area
			$final_image = imagecreatetruecolor($cropW, $cropH);
			imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
			imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
			// finally output png image
			//imagepng($final_image, $output_filename.$type, $png_quality);
			imagejpeg($final_image, $output_filename.$type, $jpeg_quality);
			$response = Array(
				"status" => 'success',
				"url" => 'http://manage.tatildukkani.com/assets/data/destinations/'.$name.$type
			);
			
			$this->load->model('default_model');
			$filter['destination_id'] = $did;
			$filter['destination_type'] = $dtype;
			$pictures = $this->default_model->destination_picture_list($filter);
			if(empty($pictures[0]['picture']))
			{
				    $insert['default'] 		=  'Evet';
					$dest = $this->default_model->destination_get($did,$dtype);
					$up3['picture'] = $name.$type;
					$this->default_model->destination_update($dest['id'],$up3);	
			}
			
			
			
			
			$insert['picture'] 			=  $name.$type;
			$insert['destination_id']   =  $did;
			$insert['destination_type'] =  $dtype;
			$this->default_model->destination_picture_add($insert);
			unlink(FCPATH."assets/data/tmp/".$name);
			
			
			
		}
		print json_encode($response);	
		
	}
	
}
