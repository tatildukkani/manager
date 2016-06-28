<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('user_model');
        $uid = $this->session->userdata('uid');
		
    }

	public function index()
	{
		if(!empty($this->uid))
		{
			redirect('dashboard');
			die();
			exit();
		}
		
		$this->load->view('login');
	}
	
	public function close()
	{
		unset($_SESSION['uid']);
		$this->session->unset_tempdata('uid');
		session_destroy();
		$this->session->sess_destroy();
		redirect('login');
		exit();
	}
	
	public function auth()
	{
		
		if(!empty($this->uid))
		{
			redirect('dashboard');
			die();
			exit();
		}
		
		$username = $this->input->post('username');	
		$password = $this->input->post('password');	
		
		if(!empty($username) && !empty($password))
		{
			$password = md5($password);
			
			$user = $this->user_model->user_check($username,$password);
			if(!empty($user['id']))
			{
				$user_data = array('uid'  => $user['id']);
				$this->session->set_userdata($user_data);	
				redirect('dashboard');
				exit();
			}
		
		} 
		
		redirect('login');
		exit();
		
		
	}
	
	
}
