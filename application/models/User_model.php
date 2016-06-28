<?php
class User_model extends CI_Model {
	
	function user_check($login,$password)
	{			
		$this->db->select("id");
		$this->db->from("users");
		$this->db->where("email",$login);
		$this->db->where("password",$password);	
		$this->db->where("status",'1');
		$query = $this->db->get();
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data[0];
		} else {
			return FALSE;	
		}
	}
	
	function user_forget_check($login)
	{			
		$this->db->select("id,firstname,surname");
		$this->db->from("users");
		$this->db->where("email",$login);
		$this->db->where("status",'1');
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data[0];
		} else {
			return FALSE;	
		}
	}
	
	function user_guid_check($guid)
	{			
		$this->db->select("id,firstname,surname");
		$this->db->from("users");
		$this->db->where("forget_guid",$guid);
		$this->db->where("status",'1');
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data[0];
		} else {
			return FALSE;	
		}
	}
	
	function user_key_check($key)
	{			
		$this->db->select("id");
		$this->db->from("v_users");
		$this->db->where("key",$key);
		$this->db->where("key !=",'');
		$this->db->where("status",'1');
		$query = $this->db->get();	    
		$data  = $query->result_array();
		if(! empty($data[0]))
		{
			return $data[0]['id'];
		} else {
			return FALSE;	
		}
	}
	
	function user_update($id,$data)
	{	
		$this->db->where('id', $id);
		return $this->db->update('users',$data);	
	}
	
	function user_delete($id)
	{	
		$this->db->where('id', $id);
		return $this->db->delete('users');	
	}
	
	function user_add($data)
	{	
		return $this->db->insert('users',$data);	
	}
	
	function user_get($id)
	{
		$this->db->select();
		$this->db->from("users");
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
	
	function user_list($filter = array())
	{
		$this->db->select();
		$this->db->from("users");
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
	
	
}

/* End of file user_model.php */
/* Location: ./application/model/user_model.php */