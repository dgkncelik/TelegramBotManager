<?php

class CScript extends CI_Controller{

	public function __construct(){
		parent::__construct();

		$this->load->model('MBot');
		$this->load->model('MMessage');
		$this->load->model('MScript');
		$this->load->helper('url');
	}

	public function index(){
		$this->load->view('header');
		$data['script_list'] = '';
		$data['script_list'] = $this->MScript->showScript();
		
		$data['bot_list'] = '';
		$data['bot_list'] = $this->MBot->pickBot();

		$this->load->view('scripts', $data);
		$this->load->view('footer');
	}

	public function createScript(){


	}


}