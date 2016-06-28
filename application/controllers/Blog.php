<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

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
		$data['title']  = 'Bloglar';
		$del = $this->input->get('del');
		
		$data['noty'] = '';
		
		if(!empty($del))
		{
			$this->load->model('default_model');	
			$this->default_model->blog_delete($del);
			$data['noty'] = '1';
		}
	
		$uid 			= $this->session->userdata('uid');
		$data['member'] = $this->user_model->user_get($uid);
		$this->load->view('blog/blog',$data);
	}
	
	public function category()
	{
		$data['title']  = 'Blog Kategorileri';
		$del = $this->input->get('del');
		
		$data['noty'] = '';
		
		if(!empty($del))
		{
			$this->load->model('default_model');	
			$this->default_model->blog_category_delete($del);
			$data['noty'] = '1';
		}
	
	
	
		$uid 			= $this->session->userdata('uid');
		$data['member'] = $this->user_model->user_get($uid);
		$this->load->view('blog/categories',$data);
	}
	
	private function _category_list($cid)
	{
		
		$this->load->model('default_model');

		$request=$this->default_model->blog_category_list();
		
		
		
		// $list değişkeninde sırayla tümkategoriler bulunuyor.
		$list=array();
		foreach($request as $key => $val){
			$list[$request[$key]['id']]=$request[$key];
		}
		
		
		$tree = array();
		// Her bir kategoriyi tek tek döndür...
		foreach ($list as $id => $item)
		{
	 
			if ($cid > 0){
				// Eğer kategori id set edilmiş ise birincil düzey yap...
				$kontrol=$cid;
			}else{
				// Eğer kategori birincil düzey ise... (yani alt kategorileri almıyoruz!)
				$kontrol=0;
			}
	 
			if ($item['parent_id'] == $kontrol)
			{
				// $tree değişekeninde birincil düzey olarak ekledik.
				$tree[$item['id']] = $item;
	 
				// Bu kategoriyi kaydettiğimiz için de (yani işimiz bitti!) $list dizisinden kaldırıyoruz.
				unset($list[$id]);
	 
				// Ve şimdi can alıcı nokta! Bu ana kategorinin alt kategorisi var mı diye alt kategorilerine bakıyoruz...
				$this->_sub_category_list($list, $tree[$item['id']]);
			}
		}
		
		return $tree;
		
	}
	
	private function _sub_category_list(&$list, &$selected)
	{
		/*  Kategori_List() fonksiyonu ile beraber çalışır.
		 *  Alt kategorileri arayan yardımcı fonksiyonumuz.
		 *  &$list: Veritabanından çektiğimiz ham kategorileri içeriyor.
		 *  &$selected: Üzerinde işlem yapılacak (varsa alt kategorisi eklenecek) kategoriyi içeriyor.
		 */
	 
		// Her bir kategoriyi tek tek döndür...
		foreach ($list as $id => $item)
		{
			// Eğer babasının kimliğiyle kendi kimliği aynıysa... (yani alt kategori ise!)
			if ($item['parent_id'] == $selected['id'])
			{
				// Seçimin "sub_cats"ına alt kategorisini ekle.
				$selected['sub_cats'][$item['id']] = $item;
	 
				// Babasını bulduğuna göre artık $list'eden kaldırabiliriz.
				unset($list[$id]);
	 
				// Alt kategorinin de çocuğu olabilme ihtimali için aynı işlemleri ona da yapıyoruz...
				$this->_sub_category_list($list, $selected['sub_cats'][$item['id']]);
			}
		}
	}
	
	var $select;
	
	private function _category_select($tree,$sid='',$level=0,$pid='',$sss='')
	{
 		
		foreach ($tree as $id => $item)
		{
			if($item['id'] != $sid)
			{
				$selected = '';
				if($item['id'] == $pid){
					$selected = 'selected';
				} else if($item['id'] == $sss){
					$selected = 'selected';
				}
				$this->select .= '<option value="'.$id.'" '.$selected.'>'.str_repeat('- ', $level*3).$item['category'].'</option>';
				if (!empty($item['sub_cats'])){ $this->_category_select($item['sub_cats'],$sid,$level + 1,$pid,$sss); }
			} 
			
			
		}
		
		return $this->select;
	}
	
	var  $json= array();
 
 	public function category_json()
	{
		$y=0;
		$tree = $this->_category_list('');
		$this->json = '[';
	
		foreach ($tree as $id => $item)
		{ 
			
				if($y != '0')
				{
					$this->json .= ',';
				}
				$ss = 'false';
				if(!empty($tree[$id]['sub_cats']))
				{
					$ss = 'true';	
				}
				$this->json .= '{"key":"'.$tree[$id]['id'].'","title": "'.$tree[$id]['category'].'", "expanded": false, "folder": '.$ss.' ';
			
				if(!empty($tree[$id]['sub_cats']))
				{
					$this->_sub_category_json($tree[$id]['sub_cats']);	
				}
				$this->json .= '}';	
				
				$y++;
		}
		$this->json .= ']';
		
		
		$this->output
        ->set_content_type('application/json')
        ->set_output($this->json);
	
		
	}
	
	
	private function _sub_category_json($tree)
	{
		
		$y = 0;
		if(!empty($tree))
		{
			$this->json .= ', "children": [';
			foreach ($tree as $id => $item)
			{ 
				if($y != '0')
				{
					$this->json .= ',';
				}
				$ss = 'false';
				if(!empty($tree[$id]['sub_cats']))
				{
					$ss = 'true';	
				}
					$this->json .= '{"key":"'.$tree[$id]['id'].'","title": "'.$tree[$id]['category'].'", "expanded": false, "folder": '.$ss.' ';
					if(!empty($tree[$id]['sub_cats']))
					{
						$this->_sub_category_json($tree[$id]['sub_cats']);	
					}
					$this->json .= '}';	
					$y++;
			}
			$this->json .= ']';
		}
	}
	
	public function category_add()
	{
		$data['categories'] = $this->_category_list('');
		 $this->_category_select($data['categories']); 
		$data['select']     = $this->select;
			
		$add = $this->input->get('add');
		if(!empty($add))
		{
			if($add == '1')
			{
				$category		 = $this->input->post('category');
				$parent_id		 = $this->input->post('parent_id');
				
				
				$url 				= seo_url($category);
				$insert['category'] = $category;
				$insert['url'] 		= $url;
				if(!empty($parent_id)){
					$insert['parent_id'] = $parent_id;
				} else {
					$insert['parent_id'] = NULL;
				}
			
				$this->load->model('default_model');
				$add = $this->default_model->blog_category_add($insert);
			    $last = $this->db->insert_id();
				print $last;
				exit();
			}
		}
		
		$update = $this->input->get('update');
		if(!empty($update))
		{
			
				$category		 = $this->input->post('category');
				$parent_id		 = $this->input->post('parent_id');
				
				$url 				= seo_url($category);
				$insert['category'] = $category;
				$insert['url'] 		= $url;
				if(!empty($parent_id)){
					$insert['parent_id'] = $parent_id;
				} else {
					$insert['parent_id'] = NULL;
				}
				
				$this->load->model('default_model');
				$add = $this->default_model->blog_category_update($update,$insert);
				print $update;
				exit();
			
		}
		
		
		$data['title']  = 'Blog Kategorisi Ekle';
		$uid 			= $this->session->userdata('uid');
		$data['member'] = $this->user_model->user_get($uid);
		$this->load->view('blog/category_add',$data);
	}
	
	public function blog()
	{
		$data['categories'] = $this->_category_list('');
		$id = $this->input->get('id');
		
	   
		$this->load->model('default_model');
		$data['post'] = $this->default_model->blog_get($id);
		$this->_category_select($data['categories'],'',0,'',$data['post']['category_id']); 
		
		$data['select']     = $this->select;		
		$data['title']  = 'Blog - '.$data['post']['title'];
		$uid 			= $this->session->userdata('uid');
		$data['member'] = $this->user_model->user_get($uid);
		$this->load->view('blog/blog_detail',$data);
	}
	
	public function category_detail()
	{
		$data['categories'] = $this->_category_list('');
	  
		
		$id = $this->input->get('id');
		
	   
		$this->load->model('default_model');
		$data['category'] = $this->default_model->blog_category_get($id);
		
		 $this->_category_select($data['categories'],$id,0,$data['category']['parent_id']); 
		$data['select']     = $this->select;		
		$data['title']  = 'Blog Kategorisi - '.$data['category']['category'];
		$uid 			= $this->session->userdata('uid');
		$data['member'] = $this->user_model->user_get($uid);
		$this->load->view('blog/category_detail',$data);
	}
	
	public function add()
	{
		
		$data['categories'] = $this->_category_list('');
		 $this->_category_select($data['categories']); 
		$data['select']     = $this->select;
		$add = $this->input->get('add');
		if(!empty($add))
		{
			if($add == '1')
			{
				$title	     = $this->input->post('title');
				$category_id = $this->input->post('category_id');
				$description = $this->input->post('description');
				
				$url = seo_url($title);
				$insert['title'] = $title;
				$insert['url'] = $url;
				$insert['category_id'] = $category_id;
				$insert['post_date'] = date('Y-m-d H:i:s');
				$insert['post'] = $description;
				$this->load->model('default_model');
				$add = $this->default_model->blog_add($insert);
			    $last = $this->db->insert_id();
				print $last;
				exit();
			}
		}
		
		$update = $this->input->get('update');
		if(!empty($update))
		{
			
				$landmark	 = $this->input->post('landmark');
				$type		 = $this->input->post('type');
				$lat		 = $this->input->post('lat');
				$lng		 = $this->input->post('lng');
				$url		 = $this->input->post('url');
				$radius      = $this->input->post('radius');
				$description = $this->input->post('description');
				$url = seo_url($url);
				
				$insert['landmark'] = $landmark;
				$insert['type'] = $type;
				$insert['lat'] = $lat;
				$insert['lng'] = $lng;
				$insert['type'] = $type;
				$insert['radius'] = $radius;
				$insert['url'] = $url;
				$insert['description'] = $description;
				$this->load->model('default_model');
				$add = $this->default_model->landmark_update($update,$insert);
				print $update;
				exit();
			
		}
		
		
		$data['title']  = 'Yazı Ekle';
		$uid 			= $this->session->userdata('uid');
		$data['member'] = $this->user_model->user_get($uid);
		$this->load->view('blog/blog_add',$data);
	}
	
	
	public function datasource()
	{
		$datafilter = $_GET;
		$datafilter['Columns']   = array('id','picture','title','post_date');
		$this->load->model('default_model');
		$data   = $this->default_model->blog_datatable($datafilter);
		$count  = $this->default_model->blog_datatable_count($datafilter);
				
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
			  
			  $fname = 'blog_'.time().'_'.rand(10, 99);
	
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
			$this->default_model->blog_picture_delete($del);	
			unlink(FCPATH."assets/data/posts/".$del);
			unlink(FCPATH."assets/data/posts/thumbs/".$del);
		}
		
		
		$id     = $this->input->get('id'); 
		
		$head   = $this->input->get('head'); 
		if(!empty($head))
		{
			
			$up3['picture'] = $head;
			$this->default_model->blog_update($id,$up3);	
			
			$up['default']  = 'Hayır';	
			$this->default_model->blog_picture_update_all($id,$up);
				
			$up2['default'] = 'Evet';	
			$this->default_model->blog_picture_update($head,$up2);	
			
		}

		
		$filter['blog_id'] = $id;
		$data['pictures'] = $this->default_model->blog_picture_list($filter);
		
		$this->load->view('blog/blog_picture',$data); 
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
		
		$output_filename = FCPATH."assets/data/posts/".$name;
		$output_filename2 = FCPATH."assets/data/posts/thumbs/".$name;
		
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
				"url" => 'http://manage.tatildukkani.com/assets/data/posts/'.$name.$type
			);
			
			
			$dosya = 'http://manage.tatildukkani.com/assets/data/posts/'.$name.$type;
			$hedef  = imagecreatetruecolor('140', '79');
			$kaynak = imagecreatefromjpeg($dosya);

			// Resmi örnekleyelim
			imagecopyresampled($hedef, $kaynak, 0, 0, 0, 0, '140', '79', '750', '422');
			imagejpeg($hedef, $output_filename2.$type,100);
			
			
			
			$this->load->model('default_model');
			$filter['blog_id'] = $id;
			$pictures = $this->default_model->blog_picture_list($filter);
			if(empty($pictures[0]['picture']))
			{
				$insert['default'] 		=  'Evet';
				$up3['picture'] = $name.$type;
				$this->default_model->blog_update($id,$up3);	
			}
			
			
			
			
			$insert['picture'] 			=  $name.$type;
			$insert['blog_id']      =  $id;
			
			$this->default_model->blog_picture_add($insert);
			unlink(FCPATH."assets/data/tmp/".$name);
			
			
			
		}
		print json_encode($response);	
		
	}
	
}
