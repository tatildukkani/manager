<?php
class Default_model extends CI_Model {
	
	
	
	function destination_picture_add($data)
	{	
		return $this->db->insert('destination_pictures',$data);	
	}
	
	function destination_picture_get($picture)
	{
		$this->db->select();
		$this->db->from("destination_pictures");
		$this->db->where("picture",$picture);
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data[0];
		} else {
			return FALSE;	
		}
	}
	
	
	
	function destination_picture_update_all($did,$type,$data)
	{	
		$this->db->where('destination_id', $did);
		$this->db->where('destination_type', $type);
		return $this->db->update('destination_pictures',$data);	
	}
	
	function destination_picture_update($picture,$data)
	{	
		$this->db->where('picture', $picture);
		return $this->db->update('destination_pictures',$data);	
	}
	
	function destination_picture_list($filter = array())
	{
		$this->db->select();
		$this->db->from("destination_pictures");
		if(!empty($filter))
		{
			foreach($filter as $key => $value){
				$this->db->where($key,$value);
			}
		}
		$this->db->order_by('default');
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function destination_picture_delete($picture)
	{	
		$this->db->where('picture', $picture);
		return $this->db->delete('destination_pictures');	
	}
	
	function destination_video_add($data)
	{	
		return $this->db->insert('destination_videos',$data);	
	}
	
	function destination_video_list($filter = array())
	{
		$this->db->select();
		$this->db->from("destination_videos");
		if(!empty($filter))
		{
			foreach($filter as $key => $value){
				$this->db->where($key,$value);
			}
		}
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function destination_video_delete($id)
	{	
		$this->db->where('id', $id);
		return $this->db->delete('destination_videos');	
	}
	
	function destination_search($lat,$lng,$radius)
	{
		$uz = $radius/1000;
		$uz     = $uz/1.609344;
		$query = $this->db->query('SELECT
  destination_id as id,destination_type as type, (
    3959 * acos (
      cos ( radians('.$lat.') )
      * cos( radians( lat ) )
      * cos( radians( lng ) - radians('.$lng.') )
      + sin ( radians('.$lat.') )
      * sin( radians( lat ) )
    )
  ) AS distance,lat,lng
FROM destinations
HAVING distance < '.$uz.'
ORDER BY distance');
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}		
		
	}
	
	function destination_get($did,$type)
	{
		$this->db->select();
		$this->db->from("destinations");
		$this->db->where("destination_id",$did);
		$this->db->where("destination_type",$type);
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data[0];
		} else {
			return FALSE;	
		}
	}
	
	function destination_list($filter = array())
	{
		$this->db->select('id,destination_id,destination_type,lat,lng,radius');
		$this->db->from("destinations");
		if(!empty($filter))
		{
			foreach($filter as $key => $value){
				$this->db->where($key,$value);
			}
		}
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	
	function destination_add($data)
	{	
		return $this->db->insert('destinations',$data);	
	}
	
	function destination_update($id,$data)
	{	
		$this->db->where('id', $id);
		return $this->db->update('destinations',$data);	
	}
	
	
	function landmark_datatable($datatable = array())
	{
				
		$this->db->select(implode(',',$datatable['Columns']));
		$this->db->from("landmarks");
		if(!empty($datatable))
		{
			
			
			//where
			if ( $datatable['sSearch'] != "" )
			{
				for ( $i=0 ; $i<count($datatable['Columns']) ; $i++ )
				{
					$this->db->or_like($datatable['Columns'][$i], ( $datatable['sSearch'] )); 
				}
			}
			//where
			
			//order
			if (isset( $datatable['iSortCol_0'] ) )
			{
				for ($i=0 ; $i<intval( $datatable['iSortingCols'] ) ; $i++ )
				{
					if ($datatable['bSortable_'.intval($datatable['iSortCol_'.$i]) ] == "true" )
					{
					 $this->db->order_by($datatable['Columns'][intval( $datatable['iSortCol_'.$i] ) ], ( $datatable['sSortDir_'.$i] )); 
					}
				}
			}
			//order
			
			//limit
			if ( isset( $datatable['iDisplayStart'] ) && $datatable['iDisplayLength'] != '-1' )
			{
				$this->db->limit($datatable['iDisplayLength'],$datatable['iDisplayStart']);
			}
			//limit
			
			
		}
		
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function landmark_datatable_count($datatable = array())
	{
				
		$this->db->select(implode(',',$datatable['Columns']));
		$this->db->from("landmarks");
		if(!empty($datatable))
		{
			
			
			//where
			if ( $datatable['sSearch'] != "" )
			{
				for ( $i=0 ; $i<count($datatable['Columns']) ; $i++ )
				{
					$this->db->or_like($datatable['Columns'][$i], ( $datatable['sSearch'] )); 
				}
			}
			//where
	
		}

	    return $this->db->count_all_results();
		
	}	
	
	function landmark_add($data)
	{	
		return $this->db->insert('landmarks',$data);	
	}
	
	function landmark_get($id)
	{
		$this->db->select();
		$this->db->from("landmarks");
		$this->db->where("id",$id);
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data[0];
		} else {
			return FALSE;	
		}
	}
	
	
	function landmark_search($lat,$lng,$radius)
	{
		$uz = $radius/1000;
		$uz     = $uz/1.609344;
		$query = $this->db->query('SELECT
  id,type, (
    3959 * acos (
      cos ( radians('.$lat.') )
      * cos( radians( lat ) )
      * cos( radians( lng ) - radians('.$lng.') )
      + sin ( radians('.$lat.') )
      * sin( radians( lat ) )
    )
  ) AS distance,lat,lng
FROM landmarks
HAVING distance < '.$uz.'
ORDER BY distance');
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}		
		
	}
	
	
	function landmark_list($filter = array())
	{
		$this->db->select('id,landmark,type,lat,lng,radius');
		$this->db->from("landmarks");
		if(!empty($filter))
		{
			foreach($filter as $key => $value){
				$this->db->where($key,$value);
			}
		}
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function distance_find($type,$id)
	{
		$query = $this->db->query('SELECT * FROM distance WHERE ((from_type = "'.$type.'" AND from_id = "'.$id.'") OR (to_type = "'.$type.'" AND to_id = "'.$id.'"))');
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}		
		
	}
	
	
	function hotel_get($did)
	{
		$this->db->select();
		$this->db->from("hotels");
		$this->db->where("id",$did);
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data[0];
		} else {
			return FALSE;	
		}
	}
	
	function hotel_add($data)
	{	
		return $this->db->insert('hotels',$data);	
	}
	
	function hotel_delete($id)
	{	
		$this->db->where('id', $id);
		return $this->db->delete('hotels');	
	}
	
	function hotel_update($id,$data)
	{	
		$this->db->where('id', $id);
		return $this->db->update('hotels',$data);	
	}

	
	function hotel_datatable($datatable = array())
	{
				
		$this->db->select(implode(',',$datatable['Columns']));
		$this->db->from("hotels");
		if(!empty($datatable))
		{
			
			
			//where
			if ( $datatable['sSearch'] != "" )
			{
				for ( $i=0 ; $i<count($datatable['Columns']) ; $i++ )
				{
					$this->db->or_like($datatable['Columns'][$i], ( $datatable['sSearch'] )); 
				}
			}
			//where
			
			//order
			if (isset( $datatable['iSortCol_0'] ) )
			{
				for ($i=0 ; $i<intval( $datatable['iSortingCols'] ) ; $i++ )
				{
					if ($datatable['bSortable_'.intval($datatable['iSortCol_'.$i]) ] == "true" )
					{
					 $this->db->order_by($datatable['Columns'][intval( $datatable['iSortCol_'.$i] ) ], ( $datatable['sSortDir_'.$i] )); 
					}
				}
			}
			//order
			
			//limit
			if ( isset( $datatable['iDisplayStart'] ) && $datatable['iDisplayLength'] != '-1' )
			{
				$this->db->limit($datatable['iDisplayLength'],$datatable['iDisplayStart']);
			}
			//limit
			
			
		}
		
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function hotel_datatable_count($datatable = array())
	{
				
		$this->db->select(implode(',',$datatable['Columns']));
		$this->db->from("hotels");
		if(!empty($datatable))
		{
			
			
			//where
			if ( $datatable['sSearch'] != "" )
			{
				for ( $i=0 ; $i<count($datatable['Columns']) ; $i++ )
				{
					$this->db->or_like($datatable['Columns'][$i], ( $datatable['sSearch'] )); 
				}
			}
			//where
	
		}

	    return $this->db->count_all_results();
		
	}
	
	function blog_get($did)
	{
		$this->db->select();
		$this->db->from("blogs");
		$this->db->where("id",$did);
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data[0];
		} else {
			return FALSE;	
		}
	}
	
	function blog_add($data)
	{	
		return $this->db->insert('blogs',$data);	
	}
	
	function blog_datatable($datatable = array())
	{
				
		$this->db->select(implode(',',$datatable['Columns']));
		$this->db->from("blogs");
		if(!empty($datatable))
		{
			
			
			//where
			if ( $datatable['sSearch'] != "" )
			{
				for ( $i=0 ; $i<count($datatable['Columns']) ; $i++ )
				{
					$this->db->or_like($datatable['Columns'][$i], ( $datatable['sSearch'] )); 
				}
			}
			//where
			
			//order
			if (isset( $datatable['iSortCol_0'] ) )
			{
				for ($i=0 ; $i<intval( $datatable['iSortingCols'] ) ; $i++ )
				{
					if ($datatable['bSortable_'.intval($datatable['iSortCol_'.$i]) ] == "true" )
					{
					 $this->db->order_by($datatable['Columns'][intval( $datatable['iSortCol_'.$i] ) ], ( $datatable['sSortDir_'.$i] )); 
					}
				}
			}
			//order
			
			//limit
			if ( isset( $datatable['iDisplayStart'] ) && $datatable['iDisplayLength'] != '-1' )
			{
				$this->db->limit($datatable['iDisplayLength'],$datatable['iDisplayStart']);
			}
			//limit
			
			
		}
		
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function blog_datatable_count($datatable = array())
	{
				
		$this->db->select(implode(',',$datatable['Columns']));
		$this->db->from("blogs");
		if(!empty($datatable))
		{
			
			
			//where
			if ( $datatable['sSearch'] != "" )
			{
				for ( $i=0 ; $i<count($datatable['Columns']) ; $i++ )
				{
					$this->db->or_like($datatable['Columns'][$i], ( $datatable['sSearch'] )); 
				}
			}
			//where
	
		}

	    return $this->db->count_all_results();
		
	}	
	
	function blog_delete($id)
	{	
		$this->db->where('id', $id);
		return $this->db->delete('blogs');	
	}
	
	function blog_update($id,$data)
	{	
		$this->db->where('id', $id);
		return $this->db->update('blogs',$data);	
	}
	
	function blog_picture_add($data)
	{	
		return $this->db->insert('blog_pictures',$data);	
	}
	
	
	
	function blog_picture_get($picture)
	{
		$this->db->select();
		$this->db->from("blog_pictures");
		$this->db->where("picture",$picture);
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data[0];
		} else {
			return FALSE;	
		}
	}
	
	function blog_picture_update_all($id,$data)
	{	
		$this->db->where('blog_id', $id);
		return $this->db->update('blog_pictures',$data);	
	}
	
	function blog_picture_update($picture,$data)
	{	
		$this->db->where('picture', $picture);
		return $this->db->update('blog_pictures',$data);	
	}
	
	function blog_picture_list($filter = array())
	{
		$this->db->select();
		$this->db->from("blog_pictures");
		if(!empty($filter))
		{
			foreach($filter as $key => $value){
				$this->db->where($key,$value);
			}
		}
		$this->db->order_by('default');
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function blog_picture_delete($picture)
	{	
		$this->db->where('picture', $picture);
		return $this->db->delete('blog_pictures');	
	}
	
	function blog_category_add($data)
	{	
		return $this->db->insert('blog_categories',$data);	
	}
	
	function blog_category_get($picture)
	{
		$this->db->select();
		$this->db->from("blog_categories");
		$this->db->where("id",$picture);
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data[0];
		} else {
			return FALSE;	
		}
	}
	
	function blog_category_list($filter = array())
	{
		$this->db->select();
		$this->db->from("blog_categories");
		if(!empty($filter))
		{
			foreach($filter as $key => $value){
				$this->db->where($key,$value);
			}
		}
		$this->db->order_by('category');
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function blog_category_delete($picture)
	{	
		$this->db->where('id', $picture);
		return $this->db->delete('blog_categories');	
	}
	
	function blog_category_update($picture,$data)
	{	
		$this->db->where('id', $picture);
		return $this->db->update('blog_categories',$data);	
	}
	
	
	function landmark_delete($id)
	{	
		$this->db->where('id', $id);
		return $this->db->delete('landmarks');	
	}
	
	function landmark_update($id,$data)
	{	
		$this->db->where('id', $id);
		return $this->db->update('landmarks',$data);	
	}
	
	function landmark_picture_add($data)
	{	
		return $this->db->insert('landmark_pictures',$data);	
	}
	
	
	
	function landmark_picture_get($picture)
	{
		$this->db->select();
		$this->db->from("landmark_pictures");
		$this->db->where("picture",$picture);
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data[0];
		} else {
			return FALSE;	
		}
	}
	
	function landmark_picture_update_all($id,$data)
	{	
		$this->db->where('landmark_id', $id);
		return $this->db->update('landmark_pictures',$data);	
	}
	
	function landmark_picture_update($picture,$data)
	{	
		$this->db->where('picture', $picture);
		return $this->db->update('landmark_pictures',$data);	
	}
	
	function landmark_picture_list($filter = array())
	{
		$this->db->select();
		$this->db->from("landmark_pictures");
		if(!empty($filter))
		{
			foreach($filter as $key => $value){
				$this->db->where($key,$value);
			}
		}
		$this->db->order_by('default');
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function landmark_picture_delete($picture)
	{	
		$this->db->where('picture', $picture);
		return $this->db->delete('landmark_pictures');	
	}
	
	function landmark_video_add($data)
	{	
		return $this->db->insert('landmark_videos',$data);	
	}
	
	function landmark_video_list($filter = array())
	{
		$this->db->select();
		$this->db->from("landmark_videos");
		if(!empty($filter))
		{
			foreach($filter as $key => $value){
				$this->db->where($key,$value);
			}
		}
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function landmark_video_delete($id)
	{	
		$this->db->where('id', $id);
		return $this->db->delete('landmark_videos');	
	}
	
	function banner_add($data)
	{	
		return $this->db->insert('banners',$data);	
	}
	
	function banner_get($id)
	{
		$this->db->select();
		$this->db->from("banners");
		$this->db->where("id",$id);
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data[0];
		} else {
			return FALSE;	
		}
	}
	
	function banner_delete($id)
	{	
		$this->db->where('id', $id);
		return $this->db->delete('banners');	
	}
	
	function banner_update($id,$data)
	{	
		$this->db->where('id', $id);
		return $this->db->update('banners',$data);	
	}
	
	function banner_area_add($data)
	{	
		return $this->db->insert('banner_areas',$data);	
	}
	
	function banner_area_delete($id)
	{	
		$this->db->where('id', $id);
		return $this->db->delete('banner_areas');	
	}
	
	function banner_area_list($filter = array())
	{
		$this->db->select();
		$this->db->from("banner_areas");
		if(!empty($filter))
		{
			foreach($filter as $key => $value){
				$this->db->where($key,$value);
			}
		}
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function banner_area_all_delete($id)
	{	
		$this->db->where('banner_id', $id);
		return $this->db->delete('banner_areas');	
	}
	
	
	
	function banner_datatable($datatable = array())
	{
				
		$this->db->select(implode(',',$datatable['Columns']));
		$this->db->from("v_banners");
		if(!empty($datatable))
		{
			
			
			//where
			if ( $datatable['sSearch'] != "" )
			{
				for ( $i=0 ; $i<count($datatable['Columns']) ; $i++ )
				{
					$this->db->or_like($datatable['Columns'][$i], ( $datatable['sSearch'] )); 
				}
			}
			//where
			
			//order
			if (isset( $datatable['iSortCol_0'] ) )
			{
				for ($i=0 ; $i<intval( $datatable['iSortingCols'] ) ; $i++ )
				{
					if ($datatable['bSortable_'.intval($datatable['iSortCol_'.$i]) ] == "true" )
					{
					 $this->db->order_by($datatable['Columns'][intval( $datatable['iSortCol_'.$i] ) ], ( $datatable['sSortDir_'.$i] )); 
					}
				}
			}
			//order
			
			//limit
			if ( isset( $datatable['iDisplayStart'] ) && $datatable['iDisplayLength'] != '-1' )
			{
				$this->db->limit($datatable['iDisplayLength'],$datatable['iDisplayStart']);
			}
			//limit
			
			
		}
		
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function banner_datatable_count($datatable = array())
	{
				
		$this->db->select(implode(',',$datatable['Columns']));
		$this->db->from("v_banners");
		if(!empty($datatable))
		{
			
			
			//where
			if ( $datatable['sSearch'] != "" )
			{
				for ( $i=0 ; $i<count($datatable['Columns']) ; $i++ )
				{
					$this->db->or_like($datatable['Columns'][$i], ( $datatable['sSearch'] )); 
				}
			}
			//where
	
		}

	    return $this->db->count_all_results();
		
	}	
	
	function hotel_category_add($data)
	{	
		return $this->db->insert('categories',$data);	
	}
	
	function hotel_category_list($filter = array())
	{
		$this->db->select();
		$this->db->from("categories");
		if(!empty($filter))
		{
			foreach($filter as $key => $value){
				$this->db->where($key,$value);
			}
		}
		$this->db->order_by('category');
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function hotel_category_get($id)
	{
		$this->db->select();
		$this->db->from("categories");
		$this->db->where("id",$id);
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data[0];
		} else {
			return FALSE;	
		}
	}
	
	function hotel_category_delete($id)
	{	
		$this->db->where('id', $id);
		return $this->db->delete('categories');	
	}
	
	function hotel_category_update($id,$data)
	{	
		$this->db->where('id', $id);
		return $this->db->update('categories',$data);	
	}
	
	
	function hotel_category_datatable($datatable = array())
	{
				
		$this->db->select(implode(',',$datatable['Columns']));
		$this->db->from("categories");
		if(!empty($datatable))
		{
			
			
			//where
			if ( $datatable['sSearch'] != "" )
			{
				for ( $i=0 ; $i<count($datatable['Columns']) ; $i++ )
				{
					$this->db->or_like($datatable['Columns'][$i], ( $datatable['sSearch'] )); 
				}
			}
			//where
			
			//order
			if (isset( $datatable['iSortCol_0'] ) )
			{
				for ($i=0 ; $i<intval( $datatable['iSortingCols'] ) ; $i++ )
				{
					if ($datatable['bSortable_'.intval($datatable['iSortCol_'.$i]) ] == "true" )
					{
					 $this->db->order_by($datatable['Columns'][intval( $datatable['iSortCol_'.$i] ) ], ( $datatable['sSortDir_'.$i] )); 
					}
				}
			}
			//order
			
			//limit
			if ( isset( $datatable['iDisplayStart'] ) && $datatable['iDisplayLength'] != '-1' )
			{
				$this->db->limit($datatable['iDisplayLength'],$datatable['iDisplayStart']);
			}
			//limit
			
			
		}
		
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function hotel_category_datatable_count($datatable = array())
	{
				
		$this->db->select(implode(',',$datatable['Columns']));
		$this->db->from("categories");
		if(!empty($datatable))
		{
			
			
			//where
			if ( $datatable['sSearch'] != "" )
			{
				for ( $i=0 ; $i<count($datatable['Columns']) ; $i++ )
				{
					$this->db->or_like($datatable['Columns'][$i], ( $datatable['sSearch'] )); 
				}
			}
			//where
	
		}

	    return $this->db->count_all_results();
		
	}	
	
	function category_destination_add($data)
	{	
		return $this->db->insert('category_destinations',$data);	
	}
	
	function category_destination_delete($id)
	{	
		$this->db->where('id', $id);
		return $this->db->delete('category_destinations');	
	}
	
	function category_destination_list($filter = array())
	{
		$this->db->select();
		$this->db->from("category_destinations");
		if(!empty($filter))
		{
			foreach($filter as $key => $value){
				$this->db->where($key,$value);
			}
		}
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function category_hotel_add($data)
	{	
		return $this->db->insert('category_hotels',$data);	
	}
	
	function category_hotel_delete($id)
	{	
		$this->db->where('id', $id);
		return $this->db->delete('category_hotels');	
	}
	
	function category_hotel_list($filter = array())
	{
		$this->db->select();
		$this->db->from("category_hotels");
		if(!empty($filter))
		{
			foreach($filter as $key => $value){
				$this->db->where($key,$value);
			}
		}
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function category_concept_add($data)
	{	
		return $this->db->insert('category_concepts',$data);	
	}
	
	function category_concept_delete($id)
	{	
		$this->db->where('id', $id);
		return $this->db->delete('category_concepts');	
	}
	
	function category_concept_list($filter = array())
	{
		$this->db->select();
		$this->db->from("category_concepts");
		if(!empty($filter))
		{
			foreach($filter as $key => $value){
				$this->db->where($key,$value);
			}
		}
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function category_var_add($data)
	{	
		return $this->db->insert('category_vars',$data);	
	}
	
	function category_var_delete($id)
	{	
		$this->db->where('id', $id);
		return $this->db->delete('category_vars');	
	}
	
	function category_var_key_delete($id)
	{	
		$this->db->where('category_var', $id);
		return $this->db->delete('category_vars');	
	}
	
	function category_var_list($filter = array())
	{
		$this->db->select();
		$this->db->from("category_vars");
		if(!empty($filter))
		{
			foreach($filter as $key => $value){
				$this->db->where($key,$value);
			}
		}
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function category_var_all_delete($id)
	{	
		$this->db->where('category_id', $id);
		return $this->db->delete('category_vars');	
	}
	
	function hotel_search($lat,$lng,$radius)
	{
		$uz    = $radius/1000;
		$uz     = $uz/1.609344;
		$DB2   = $this->load->database('erp', TRUE);
		$query = $DB2->query("SELECT
  id, 'hotel' as type, (
    3959 * acos (
      cos ( radians(".$lat.") )
      * cos( radians( lat ) )
      * cos( radians( lng ) - radians(".$lng.") )
      + sin ( radians(".$lat.") )
      * sin( radians( lat ) )
    )
  ) AS distance,lat,lng
FROM opt_hotels WHERE lat IS NOT NULL AND lng IS NOT NULL
HAVING distance < ".$uz."
ORDER BY distance");
		$data  = $query->result_array();
		$DB2->close();
		
		
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}		
		
	}
	
	function hotel_list($filter = array())
	{
		$DB2   = $this->load->database('erp', TRUE);
		$DB2->select('id,name,lat,lng');
		$DB2->from("opt_hotels");
		if(!empty($filter))
		{
			foreach($filter as $key => $value){
				$DB2->where($key,$value);
			}
		}
	//	$DB2->where('country_id','2');
		$query = $DB2->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	
	
	function redirect_get($did)
	{
		$this->db->select();
		$this->db->from("redirects");
		$this->db->where("id",$did);
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data[0];
		} else {
			return FALSE;	
		}
	}
	
	function redirect_add($data)
	{	
		return $this->db->insert('redirects',$data);	
	}
	
	function redirect_datatable($datatable = array())
	{
				
		$this->db->select(implode(',',$datatable['Columns']));
		$this->db->from("redirects");
		if(!empty($datatable))
		{
			
			
			//where
			if ( $datatable['sSearch'] != "" )
			{
				for ( $i=0 ; $i<count($datatable['Columns']) ; $i++ )
				{
					$this->db->or_like($datatable['Columns'][$i], ( $datatable['sSearch'] )); 
				}
			}
			//where
			
			//order
			if (isset( $datatable['iSortCol_0'] ) )
			{
				for ($i=0 ; $i<intval( $datatable['iSortingCols'] ) ; $i++ )
				{
					if ($datatable['bSortable_'.intval($datatable['iSortCol_'.$i]) ] == "true" )
					{
					 $this->db->order_by($datatable['Columns'][intval( $datatable['iSortCol_'.$i] ) ], ( $datatable['sSortDir_'.$i] )); 
					}
				}
			}
			//order
			
			//limit
			if ( isset( $datatable['iDisplayStart'] ) && $datatable['iDisplayLength'] != '-1' )
			{
				$this->db->limit($datatable['iDisplayLength'],$datatable['iDisplayStart']);
			}
			//limit
			
			
		}
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function redirect_datatable_count($datatable = array())
	{
				
		$this->db->select(implode(',',$datatable['Columns']));
		$this->db->from("redirects");
		if(!empty($datatable))
		{
			
			
			//where
			if ( $datatable['sSearch'] != "" )
			{
				for ( $i=0 ; $i<count($datatable['Columns']) ; $i++ )
				{
					$this->db->or_like($datatable['Columns'][$i], ( $datatable['sSearch'] )); 
				}
			}
			//where
	
		}

	    return $this->db->count_all_results();
		
	}	
	
	function redirect_delete($id)
	{	
		$this->db->where('id', $id);
		return $this->db->delete('redirects');	
	}
	
	function redirect_update($id,$data)
	{	
		$this->db->where('id', $id);
		return $this->db->update('redirects',$data);	
	}
	
	
	
	function web_page_get($did)
	{
		$this->db->select();
		$this->db->from("web_pages");
		$this->db->where("id",$did);
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data[0];
		} else {
			return FALSE;	
		}
	}
	
	function web_page_add($data)
	{	
		return $this->db->insert('web_pages',$data);	
	}
	
	function web_page_datatable($datatable = array())
	{
				
		$this->db->select(implode(',',$datatable['Columns']));
		$this->db->from("web_pages");
		if(!empty($datatable))
		{
			
			
			//where
			if ( $datatable['sSearch'] != "" )
			{
				for ( $i=0 ; $i<count($datatable['Columns']) ; $i++ )
				{
					$this->db->or_like($datatable['Columns'][$i], ( $datatable['sSearch'] )); 
				}
			}
			//where
			
			//order
			if (isset( $datatable['iSortCol_0'] ) )
			{
				for ($i=0 ; $i<intval( $datatable['iSortingCols'] ) ; $i++ )
				{
					if ($datatable['bSortable_'.intval($datatable['iSortCol_'.$i]) ] == "true" )
					{
					 $this->db->order_by($datatable['Columns'][intval( $datatable['iSortCol_'.$i] ) ], ( $datatable['sSortDir_'.$i] )); 
					}
				}
			}
			//order
			
			//limit
			if ( isset( $datatable['iDisplayStart'] ) && $datatable['iDisplayLength'] != '-1' )
			{
				$this->db->limit($datatable['iDisplayLength'],$datatable['iDisplayStart']);
			}
			//limit
			
			
		}
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data;
		} else {
			return FALSE;	
		}
		
	}
	
	function web_page_datatable_count($datatable = array())
	{
				
		$this->db->select(implode(',',$datatable['Columns']));
		$this->db->from("web_pages");
		if(!empty($datatable))
		{
			
			
			//where
			if ( $datatable['sSearch'] != "" )
			{
				for ( $i=0 ; $i<count($datatable['Columns']) ; $i++ )
				{
					$this->db->or_like($datatable['Columns'][$i], ( $datatable['sSearch'] )); 
				}
			}
			//where
	
		}

	    return $this->db->count_all_results();
		
	}	
	
	function web_page_delete($id)
	{	
		$this->db->where('id', $id);
		return $this->db->delete('web_pages');	
	}
	
	function web_page_update($id,$data)
	{	
		$this->db->where('id', $id);
		return $this->db->update('web_pages',$data);	
	}
	
	
}

/* End of file user_model.php */
/* Location: ./application/model/user_model.php */