<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
		$data['title']  = 'Dashboard';
		$uid 			= $this->session->userdata('uid');
		$data['member'] = $this->user_model->user_get($uid);
		$this->load->view('dashboard',$data);
	}
	
	
	
	
}
