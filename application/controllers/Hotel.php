<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hotel extends CI_Controller {

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


	public function datasource()
	{
		$datafilter = $_GET;
		$datafilter['Columns']   = array('id','hotel_id','picture','name');
		$this->load->model('default_model');
		$data   = $this->default_model->hotel_datatable($datafilter);
		$count  = $this->default_model->hotel_datatable_count($datafilter);
				
		for($i=0; $i<count($data); $i++)
		{
			for($x=0; $x<count($datafilter['Columns']); $x++)
			{
				$redata[$i][$x] = $data[$i][$datafilter['Columns'][$x]];	
			}
		}
		
		$output = array("draw" => intval($_GET['sEcho']),"recordsTotal" => $count,"recordsFiltered" => $count,"data" => $redata);
		
		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($output));
	
	}
	
	
	public function hotel_add()
	{
		$add = $this->input->get('add');
		if(!empty($add))
		{
			if($add == '1')
			{
				$name	     = $this->input->post('name');
				$url		 = seo_url($name);
				
				$insert['category'] = $name;
				$insert['url'] = $url;
				
				$this->load->model('default_model');
				$add = $this->default_model->hotel_add($insert);
			    $last = $this->db->insert_id();
				print $last;
				exit();
			} 
		}
		
	
		

		$update = $this->input->get('update');
		if(!empty($update))
		{
			
				$description 		 = $this->input->post('description');
				$parent_id  		 = $this->input->post('parent_id');
				$url			     = $this->input->post('url');
				$name   	 		 = $this->input->post('name');
				$controller_function = $this->input->post('controller_function');
				
				
				$insert['category'] = $name;
				$insert['controller_function'] = $controller_function;
				$insert['url'] = $url;
				if(!empty($description)){
				$insert['description'] = $description;
				}
				if(!empty($parent_id)){
				$insert['parent_id'] = $parent_id;
				}
				$this->load->model('default_model');
				$add = $this->default_model->hotel_category_update($update,$insert);
				print $update;
				exit();
			
		}
		
		
		$data['title']  = 'Otel Ekle';
		$uid 			= $this->session->userdata('uid');
		$data['member'] = $this->user_model->user_get($uid);
		$this->load->view('hotel/hotel_add',$data);
	}
	
	public function hotel_search()
	{
		$data = array();
		$name = $this->input->post('name');
		
		if(!empty($name))
		{
			class_exists('SphinxClient') or require_once(APPPATH.'libraries/sphinx/sphinxapi.php');
			$cl = new SphinxClient();
			$cl->AddQuery ($name,"hotel_search");
			$result = $cl->RunQueries();
			if(!empty($result[0]['matches'])){
				$data['results'] = array_values($result[0]['matches']);
			} else {
				$data['results'] = array();	
			}
		
		}

		$this->load->view('hotel/hotel_search',$data);
		
	}
	
	public function hotel_list()
	{
		$data['title']  = 'Oteller';
		$del = $this->input->get('del');		
		$data['noty'] = '';
		
		if(!empty($del))
		{
			$this->load->model('default_model');	
			$this->default_model->hotel_delete($del);
			$data['noty'] = '1';
		}
		
		$uid 			= $this->session->userdata('uid');
		$data['member'] = $this->user_model->user_get($uid);
		$this->load->view('hotel/hotels',$data);
	}
	
	public function category()
	{
		$data['title']  = 'Otel Kategorileri';
		$del = $this->input->get('del');		
		$data['noty'] = '';
		
		if(!empty($del))
		{
			$this->load->model('default_model');	
			$this->default_model->banner_delete($del);
			$this->default_model->banner_area_all_delete($del);
			
			$data['noty'] = '1';
		}
		
		
	
		$uid 			= $this->session->userdata('uid');
		$data['member'] = $this->user_model->user_get($uid);
		$this->load->view('hotel/category',$data);
	}
	
	public function category_detail()
	{
		
		
		$id = $this->input->get('id');
		$this->load->model('default_model');
		$data['category']    = $this->default_model->hotel_category_get($id);
		$filter['parent_id'] = NULL;
		$data['categories']  = $this->default_model->hotel_category_list($filter);
		
		unset($filter);
		$filter['category_id'] = $id;
		$data['vars'] = $this->default_model->category_var_list($filter);
		
		$data['title']  = 'Otel Kategorileri - '.$data['category']['category'];
		$uid 			= $this->session->userdata('uid');
		$data['member'] = $this->user_model->user_get($uid);
		$this->load->view('hotel/category_detail',$data);
	}
	
	public function category_add()
	{
		$add = $this->input->get('add');
		if(!empty($add))
		{
			if($add == '1')
			{
				$name	     = $this->input->post('name');
				$url		 = seo_url($name);
				
				
				
				$insert['category'] = $name;
				$insert['url'] = $url;
				
				$this->load->model('default_model');
				$add = $this->default_model->hotel_category_add($insert);
			    $last = $this->db->insert_id();
				print $last;
				exit();
			} 
		}
		
		$listing_key_add = $this->input->get('listing_key_add');
		if(!empty($listing_key_add))
		{
			
				$l_key	             = $this->input->post('l_key');
				$l_value	         = $this->input->post('l_value');
				$l_description	     = $this->input->post('l_description');
				
				
				$insert['category_id']  = $listing_key_add;
				$insert['category_var'] = $l_key;
				$insert['category_val'] = $l_value;
				$insert['description']  = $l_description;
				
				$this->load->model('default_model');
				
				$this->default_model->category_var_key_delete($l_key);
				$add = $this->default_model->category_var_add($insert);
			    $last = $this->db->insert_id();
				print $last;
				exit();
			 
		}
		
		$listing_update = $this->input->get('listing_update');
		if(!empty($listing_update))
		{
			$this->load->model('default_model');
			$eb				 = $this->input->post('eb');
			$nochild 		 = $this->input->post('nochild');
			$min_price		 = $this->input->post('min_price');
			$max_price   	 = $this->input->post('max_price');
			$min_review		 = $this->input->post('min_review');
			$max_review		 = $this->input->post('max_review');
			$min_point		 = $this->input->post('min_point');
			$max_point		 = $this->input->post('max_point');
			$age1			 = $this->input->post('age1');
			$age2		 	 = $this->input->post('age2');

			$this->default_model->category_var_all_delete($listing_update);
			$f=0;
			if($eb == '1')
			{
				$insert[$f]['category_id']  = $listing_update;
				$insert[$f]['category_var'] = 'eb';
				$insert[$f]['category_val'] = '1';
				$insert[$f]['description']  = 'Erken Rezervasyon İndirimli';
				$f++;
			}
			
			if($nochild == '1')
			{
				$insert[$f]['category_id']  = $listing_update;
				$insert[$f]['category_var'] = 'nochild';
				$insert[$f]['category_val'] = '1';
				$insert[$f]['description']  = 'Çocuk Kabul Etmeyenler';
				$f++;
			}
			
			if($min_price > 0)
			{
				$insert[$f]['category_id']  = $listing_update;
				$insert[$f]['category_var'] = 'min_price';
				$insert[$f]['category_val'] = $min_price;
				$insert[$f]['description']  = 'Minimum '.$min_price.' TL';
				$f++;
			}
			
			if($max_price > 0)
			{
				$insert[$f]['category_id']  = $listing_update;
				$insert[$f]['category_var'] = 'max_price';
				$insert[$f]['category_val'] = $max_price;
				$insert[$f]['description']  = 'Maximum '.$max_price.' TL';
				$f++;
			}
			
			if($min_review > 0)
			{
				$insert[$f]['category_id']  = $listing_update;
				$insert[$f]['category_var'] = 'min_review';
				$insert[$f]['category_val'] = $min_review;
				$insert[$f]['description']  = 'Minimum '.$min_review.' Yorum';
				$f++;
			}
			
			if($max_review > 0)
			{
				$insert[$f]['category_id']  = $listing_update;
				$insert[$f]['category_var'] = 'max_review';
				$insert[$f]['category_val'] = $max_review;
				$insert[$f]['description']  = 'Maximum '.$max_review.' Yorum';
				$f++;
			}
			
			if($min_point > 0)
			{
				$insert[$f]['category_id']  = $listing_update;
				$insert[$f]['category_var'] = 'min_point';
				$insert[$f]['category_val'] = $min_point;
				$insert[$f]['description']  = 'Minimum '.$min_point.' Puan';
				$f++;
			}
			
			if($max_point > 0)
			{
				$insert[$f]['category_id']  = $listing_update;
				$insert[$f]['category_var'] = 'max_point';
				$insert[$f]['category_val'] = $max_point;
				$insert[$f]['description']  = 'Maximum '.$max_point.' Puan';
				$f++;
			}
			
			if($age2 > 0)
			{
				$insert[$f]['category_id']  = $listing_update;
				$insert[$f]['category_var'] = 'age2';
				$insert[$f]['category_val'] = $age2;
				$insert[$f]['description']  = '2. Çocuk Minimum '.$age2.' Yaş Ücretsiz';
				$f++;
			}
			
			if($age1 > 0)
			{
				$insert[$f]['category_id']  = $listing_update;
				$insert[$f]['category_var'] = 'age1';
				$insert[$f]['category_val'] = $age1;
				$insert[$f]['description']  = '1. Çocuk Minimum '.$age1.' Yaş Ücretsiz';
				$f++;
			}
			
			$this->db->insert_batch('category_vars', $insert); 
			
		}
		$update = $this->input->get('update');
		if(!empty($update))
		{
			
				$description 		 = $this->input->post('description');
				$parent_id  		 = $this->input->post('parent_id');
				$url			     = $this->input->post('url');
				$name   	 		 = $this->input->post('name');
				$controller_function = $this->input->post('controller_function');
				
				
				$insert['category'] = $name;
				$insert['controller_function'] = $controller_function;
				$insert['url'] = $url;
				if(!empty($description)){
				$insert['description'] = $description;
				}
				if(!empty($parent_id)){
				$insert['parent_id'] = $parent_id;
				}
				$this->load->model('default_model');
				$add = $this->default_model->hotel_category_update($update,$insert);
				print $update;
				exit();
			
		}
		
		
		$data['title']  = 'Otel Kategori Ekle';
		$uid 			= $this->session->userdata('uid');
		$data['member'] = $this->user_model->user_get($uid);
		$this->load->view('hotel/category_add',$data);
	}
	
	
	public function category_datasource()
	{
		$datafilter = $_GET;
		$datafilter['Columns']   = array('id','category','url');
		$this->load->model('default_model');
		$data   = $this->default_model->hotel_category_datatable($datafilter);
		$count  = $this->default_model->hotel_category_datatable_count($datafilter);
				
		for($i=0; $i<count($data); $i++)
		{
			for($x=0; $x<count($datafilter['Columns']); $x++)
			{
				$redata[$i][$x] = $data[$i][$datafilter['Columns'][$x]];	
			}
		}
		
		$output = array("draw" => intval($_GET['sEcho']),"recordsTotal" => $count,"recordsFiltered" => $count,"data" => $redata);
		
		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($output));
	
	}
	
	
	private function _hotels($data)
	{
		class_exists('SphinxClient') or require_once(APPPATH.'libraries/sphinx/sphinxapi.php');
		
		
		$select = '*';
		$cl = new SphinxClient();	
		$cl->SetLimits(0,1000);	
	    $cl->SetGroupBy('name', SPH_GROUPBY_ATTR, "net_fee asc");
		
		if(!empty($data['vars'][0]['id']))
		{
			for($i=0; $i<count($data['vars']); $i++)
			{
				$var = $data['vars'][$i]['category_var'];
				if($var == 'max_price')
				{
					$select .= ", IF(net_fee <= ".$data['vars'][$i]['category_val'].", 10, 0) AS max_price";
				} else if($var == 'min_price'){
					$select .= ", IF(net_fee >= ".$data['vars'][$i]['category_val'].", 10, 0) AS min_price";
				} else if($var == 'age1'){
					$select .= ", IF(age1 >= ".$data['vars'][$i]['category_val'].", 10, 0) AS min_age1";
				} else if($var == 'age2'){
					$select .= ", IF(age2 >= ".$data['vars'][$i]['category_val'].", 10, 0) AS min_age2";
				} else if($var == 'min_point'){
					$select .= ", IF(point >= ".$data['vars'][$i]['category_val'].", 10, 0) AS min_point";
				} else if($var == 'max_point'){
					$select .= ", IF(point <= ".$data['vars'][$i]['category_val'].", 10, 0) AS max_point";
				} else if($var == 'min_review'){
					$select .= ", IF(reviews >= ".$data['vars'][$i]['category_val'].", 10, 0) AS min_review";
				} else if($var == 'max_review'){
					$select .= ", IF(reviews <= ".$data['vars'][$i]['category_val'].", 10, 0) AS max_review";
				} else if($var == 'nochild'){
					$select .= ", IF(age1 < 1, 10, 0) AS nochild";
				
				}
			}
			
			if($select != '*')
			{
				$cl->SetSelect("*,$select");
			}
			
			
			for($i=0; $i<count($data['vars']); $i++)
			{
				$var = $data['vars'][$i]['category_var'];
				if($var == 'max_price')
				{
					$cl->SetFilter('max_price',array(10));	
				} else if($var == 'min_price'){
					$cl->SetFilter('min_price',array(10));	
				} else if($var == 'age1'){
					$cl->SetFilter('min_age1',array(10));	
				} else if($var == 'age2'){
					$cl->SetFilter('min_age2',array(10));	
				} else if($var == 'min_point'){
					$cl->SetFilter('min_point',array(10));	
				} else if($var == 'max_point'){
					$cl->SetFilter('max_point',array(10));	
				} else if($var == 'min_review'){
					$cl->SetFilter('min_review',array(10));	
				} else if($var == 'max_review'){
					$cl->SetFilter('max_review',array(10));
				} else if($var == 'eb'){
					$cl->SetFilter('eb',array(1));	
				} else if($var == 'nochild'){
					$cl->SetFilter('nochild',array('10'));	
				}
			}
		}
		
		
		$concepts = array();
		if(!empty($data['concepts'][0]['id']))
		{
			for($i=0; $i<count($data['concepts']); $i++)
			{
				$concepts[] = $data['concepts'][$i]['concept_id'];
			}
			$cl->SetFilter('concept_id',$concepts);	
		}
		
		$hotels = array();
		if(!empty($data['hotels'][0]['id']))
		{
			for($i=0; $i<count($data['hotels']); $i++)
			{
				$hotels[] = $data['hotels'][$i]['hotel_id'];
			}
			$cl->SetFilter('hid',$hotels);	
		}
		
		$countries = array();
		$cities = array();
		$districts = array();
		$towns = array();
		if(!empty($data['destinations'][0]['id']))
		{
			for($i=0; $i<count($data['destinations']); $i++)
			{
				if($data['destinations'][$i]['destination_type'] == 'country')
				{
					$countries[] = $data['destinations'][$i]['destination_id'];
				} else if($data['destinations'][$i]['destination_type'] == 'city'){
					$cities[] = $data['destinations'][$i]['destination_id'];
				} else if($data['destinations'][$i]['destination_type'] == 'district'){
					$districts[] = $data['destinations'][$i]['destination_id'];
				} else if($data['destinations'][$i]['destination_type'] == 'town'){
					$towns[] = $data['destinations'][$i]['destination_id'];
				}
			}
			
			
			if(!empty($countries[0]))
			{
				$cl->SetFilter('country_id',$countries);	
			}
			if(!empty($cities[0]))
			{
				$cl->SetFilter('city_id',$cities);	
			}
			if(!empty($districts[0]))
			{
				$cl->SetFilter('district_id',$districts);	
			}
			if(!empty($towns[0]))
			{
				$cl->SetFilter('town_id',$towns);	
			}
		}
		
		
		
		$cl->AddQuery('', "hotel_prices");
		$result = $cl->Query();
		
		
		
		$hoteldata['total'] = $result['total_found'];
		$hoteldata['hotels'] = array_values($result['matches']);
		
		
		
		
		
		return $hoteldata;	
	}
	
	public function category_hotels()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		
		$id = $this->input->get('id');
		$this->load->model('default_model');
		$data['category'] = $this->default_model->hotel_category_get($id);
		
	
		
		$this->load->model('default_model');
		$filter['category_id'] = $id;
		$destinations = $this->default_model->category_destination_list($filter);
		$hotels = $this->default_model->category_hotel_list($filter);
		$concepts = $this->default_model->category_concept_list($filter);
		$vars = $this->default_model->category_var_list($filter);
		
		$der['destinations'] = $destinations;
		$der['hotels']    = $hotels;
		$der['concepts'] = $concepts;
		$der['vars'] = $vars;
		$data = $this->_hotels($der);

		
		$this->load->view('hotel/category_hotels',$data);
	}
	
	public function category_area()
	{
		
		$id = $this->input->get('id');
		$this->load->model('default_model');
		$data['category'] = $this->default_model->hotel_category_get($id);
		
	
		
		$this->load->model('default_model');
		
		
		$add = $this->input->get('destination_add');
		if(!empty($add))
		{
			if($add == '1')
			{
				
				$insert['category_id']      = $id;
				$insert['destination_id']   = $this->input->get('did');
				$insert['destination_type'] = $this->input->get('type');
				$insert['destination']      = $this->input->get('name');
				$this->load->model('default_model');
				$add = $this->default_model->category_destination_add($insert);

			
			}
		}
		
		$hotel_add = $this->input->get('hotel_add');
		if(!empty($hotel_add))
		{
			if($hotel_add == '1')
			{
				
				$insert['category_id']      	  = $id;
				$insert['hotel_id']   			  = $this->input->get('hid');
				$insert['hotel']				  = $this->input->get('name');
				$insert['hotel_description']      = $this->input->get('desc');
				$this->load->model('default_model');
				$add = $this->default_model->category_hotel_add($insert);

			
			}
		}
		
		$concept_add = $this->input->get('concept_add');
		if(!empty($concept_add))
		{
			if($concept_add == '1')
			{
				
				$insert['category_id']      	  = $id;
				$insert['concept_id']   			 = $this->input->get('cid');
				$insert['concept']				  = $this->input->get('name');
				
				$this->load->model('default_model');
				$add = $this->default_model->category_concept_add($insert);

			
			}
		}
		
		$del = $this->input->get('destination_del');
		if(!empty($del))
		{
			$this->default_model->category_destination_delete($del);
		}
		
		$hotel_del = $this->input->get('hotel_del');
		if(!empty($hotel_del))
		{
			$this->default_model->category_hotel_delete($hotel_del);
		}
		
		$var_del = $this->input->get('var_del');
		if(!empty($var_del))
		{
			$this->default_model->category_var_delete($var_del);
		}
		
		$concept_del = $this->input->get('concept_del');
		if(!empty($concept_del))
		{
			$this->default_model->category_concept_delete($concept_del);
		}
		
		$filter['category_id'] = $id;
		$destinations = $this->default_model->category_destination_list($filter);
		$hotels = $this->default_model->category_hotel_list($filter);
		$concepts = $this->default_model->category_concept_list($filter);
		$vars = $this->default_model->category_var_list($filter);
		
		$data['destinations'] = $destinations;
		$data['hotels']    = $hotels;
		$data['concepts'] = $concepts;
		$data['vars'] = $vars;
		

		
		$this->load->view('hotel/category_areas',$data);
	}
	
	
	public function destination_find()
	{
		
		$data = array();
		
		$id = $this->input->get('id');
		$q  = $this->input->get('d_q');
		if(!empty($q))
		{
			$data['id'] = $id;
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
	
		$this->load->view('hotel/category_destination_list',$data);
		
	}
	
	public function hotel_find()
	{
		
		$data = array();
		
		$id = $this->input->get('id');
		$q  = $this->input->get('h_q');
		if(!empty($q))
		{
			$data['id'] = $id;
			class_exists('SphinxClient') or require_once(APPPATH.'libraries/sphinx/sphinxapi.php');
			$cl = new SphinxClient();
			$cl->AddQuery ($q,"hotel_search");
			$result = $cl->RunQueries();
			if(!empty($result[0]['matches'])){
			$data['results'] = array_values($result[0]['matches']);
			} else {
			$data['results'] = array();	
			}
		
		}
	
		$this->load->view('hotel/category_hotel_list',$data);
		
	}
	
	public function concept_find()
	{
		
		$data = array();
		
		$id = $this->input->get('id');
		$q  = $this->input->get('c_q');
		if(!empty($q))
		{
			$data['id'] = $id;
			class_exists('SphinxClient') or require_once(APPPATH.'libraries/sphinx/sphinxapi.php');
			$cl = new SphinxClient();
			$cl->AddQuery ($q,"concepts");
			$result = $cl->RunQueries();
			if(!empty($result[0]['matches'])){
			$data['results'] = array_values($result[0]['matches']);
			} else {
			$data['results'] = array();	
			}
		
		}
	
		$this->load->view('hotel/category_concept_list',$data);
		
	}
	
	public function upload()
	{
		$id = $this->input->get('id');
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
			  
			  $fname = 'category_banner_'.$id;
	
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
			$this->default_model->landmark_picture_delete($del);	
			unlink(FCPATH."assets/data/landmarks/".$del);
		}
		
		
		$id     = $this->input->get('id'); 
		
		$head   = $this->input->get('head'); 
		if(!empty($head))
		{
			$up['default']  = 'Hayır';	
			$this->default_model->landmark_picture_update_all($id,$up);
				
			$up2['default'] = 'Evet';	
			$this->default_model->landmark_picture_update($head,$up2);	
			
		}

		
		$filter['landmark_id'] = $id;
		$data['pictures'] = $this->default_model->landmark_picture_list($filter);
		
		$this->load->view('landmark/landmark_picture',$data); 
	}
	
	
	
	
	public function update()
	{
		
		$id   = $this->input->get('id'); 
		$type   = $this->input->get('type'); 
		$description = $this->input->post('description');	
		$lat = $this->input->post('lat');	
		$lng = $this->input->post('lng');
		$radius = $this->input->post('radius');	
		
		$this->load->model('default_model');
		$filter['landmark_id'] = $id;
		$dest = $this->default_model->landmark_get($id,$dtype);
		
		
		$insert['landmark_id'] = $did;
		$insert['landmark_type'] = $dtype;
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
			$this->default_model->landmark_add($insert);
		} else {
			$this->default_model->landmark_update($dest['id'],$insert);
		}
		
	}
	
	public function crop()
	{
		
		$id   = $this->input->get('id'); 
		
		
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
		
		$output_filename = FCPATH."assets/data/banners/".$name;
		
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
				"message" => 'Can`t write cropped File ->'. dirname($output_filename).' -> '.$imgUrl
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
				"url" => 'http://manage.tatildukkani.com/assets/data/landmarks/'.$name.$type
			);
			
			$this->load->model('default_model');
			
			$insert['picture'] 			=  $name.$type;
			$this->default_model->banner_update($id,$insert);
			unlink(FCPATH."assets/data/tmp/".$name);
			
			
			
		}
		print json_encode($response);	
		
	}
	
}
