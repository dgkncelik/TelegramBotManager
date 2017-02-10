<?php

class CDashboard extends CI_Controller{
	
	public function __construct(){
		parent::__construct();

		$this->load->model('MBot');
		$this->load->model('MMessage');
		$this->load->model('MScript');
		$this->load->helper('url');
		
	}

	public function index(){
		$this->load->view('header');
		$this->load->view('footer');
	}

	public function includeElement($file_name = NULL){
		//for including css and js files
		if(trim($file_name) == ''){
			return '';
		}

		if(substr($file_name, -4) == '.css'){
			$path = 'css/' . $file_name;
			header('Content-type: text/css');
			$this->load->view($path);
		}elseif (substr($file_name, -3) == '.js'){
			header('Content-type: text/css');
			$path = 'js/' . $file_name;
			$this->load->view($path);
		}

	}

}