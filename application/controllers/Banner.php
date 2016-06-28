<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends CI_Controller {

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

	public function category()
	{
		$data['title']  = 'Kategori ve Listeleme Bannerları';
		$del = $this->input->get('del');
		$del2 = $this->input->get('del2');
		
		$data['noty'] = '';
		
		if(!empty($del))
		{
			$this->load->model('default_model');	
			$this->default_model->banner_delete($del);
			$this->default_model->banner_area_all_delete($del);
			
			$data['noty'] = '1';
		}
		
		if(!empty($del2))
		{
			$this->load->model('default_model');	
			$this->default_model->banner_area_delete($del2);
			$data['noty'] = '1';
		}
	
		$uid 			= $this->session->userdata('uid');
		$data['member'] = $this->user_model->user_get($uid);
		$this->load->view('banner/category_banner',$data);
	}
	
	public function category_banner()
	{
		
		
		$id = $this->input->get('id');
		$this->load->model('default_model');
		$data['banner'] = $this->default_model->banner_get($id);
		
		
		$data['title']  = 'Kategori Bannerı - '.$data['banner']['name'];
		$uid 			= $this->session->userdata('uid');
		$data['member'] = $this->user_model->user_get($uid);
		$this->load->view('banner/category_banner_detail',$data);
	}
	
	public function category_banner_add()
	{
		$add = $this->input->get('add');
		if(!empty($add))
		{
			if($add == '1')
			{
				$name	 = $this->input->post('name');
				$link		 = $this->input->post('link');
				$banner_date		 = $this->input->post('banner_date');
				if(!empty($banner_date))
				{
					$dt = explode('-',$banner_date);
					if(!empty($dt[1]))
					{
						$insert['begin'] = date_convert(trim($dt[0]),'Y-m-d');
						$insert['end']   = date_convert(trim($dt[1]),'Y-m-d');
					}
						
				}
				
				
				$insert['name'] = $name;
				$insert['link'] = $link;
				
				$this->load->model('default_model');
				$add = $this->default_model->banner_add($insert);
			    $last = $this->db->insert_id();
				print $last;
				exit();
			}
		}
		
		$update = $this->input->get('update');
		if(!empty($update))
		{
			
				$popularity	 = $this->input->post('popularity');
				$banner_date = $this->input->post('banner_date');
				$url		 = $this->input->post('url');
				$name   	 = $this->input->post('name');
				$status		 = $this->input->post('status');
				
				
				if(!empty($banner_date))
				{
					$dt = explode('-',$banner_date);
					if(!empty($dt[1]))
					{
						$insert['begin'] = date_convert(trim($dt[0]),'Y-m-d');
						$insert['end']   = date_convert(trim($dt[1]),'Y-m-d');
					}
						
				}
				
				$insert['name'] = $name;
				$insert['status'] = $status;
				$insert['link'] = $url;
				$insert['popularity'] = $popularity;
				$this->load->model('default_model');
				$add = $this->default_model->banner_update($update,$insert);
				print $update;
				exit();
			
		}
		
		
		$data['title']  = 'Kategori Banner Ekle';
		$uid 			= $this->session->userdata('uid');
		$data['member'] = $this->user_model->user_get($uid);
		$this->load->view('banner/category_banner_add',$data);
	}
	
	
	public function datasource()
	{
		$datafilter = $_GET;
		$datafilter['Columns']   = array('id','picture','name','area_name','popularity','begin','end','status','area_id');
		$this->load->model('default_model');
		$data   = $this->default_model->banner_datatable($datafilter);
		$count  = $this->default_model->banner_datatable_count($datafilter);
				
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
	
	public function category_banner_areas()
	{
		$id = $this->input->get('id');
		$filter['banner_id'] = $id;
		$this->load->model('default_model');
		
		
		$add = $this->input->get('add');
		if(!empty($add))
		{
			if($add == '1')
			{
				
				$insert['banner_id'] = $id;
				$insert['area']		 = $this->input->get('area');
				$insert['area_name'] = $this->input->get('name');
				
				$this->load->model('default_model');
				$add = $this->default_model->banner_area_add($insert);

			
			}
		}
		
		$del = $this->input->get('del');
		if(!empty($del))
		{
			$this->default_model->banner_area_delete($del);
		}
		
		$data['list']  = $this->default_model->banner_area_list($filter);
		
		
		$this->load->view('banner/category_banner_areas',$data);
	}
	
	
	public function destination_find()
	{
		
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
	
		$this->load->view('banner/category_banner_destination_list',$data);
		
	}
	
	public function category_find()
	{
		
		$id = $this->input->get('id');
		$q  = $this->input->get('c_q');
		if(!empty($q))
		{
			$data['id'] = $id;
			class_exists('SphinxClient') or require_once(APPPATH.'libraries/sphinx/sphinxapi.php');
			$cl = new SphinxClient();
			$cl->AddQuery ($q,"hotel_category_search");
			$result = $cl->RunQueries();
			if(!empty($result[0]['matches'])){
			$data['results'] = array_values($result[0]['matches']);
			} else {
			$data['results'] = array();	
			}
		
		}
	
		$this->load->view('banner/category_banner_category_list',$data);
		
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
