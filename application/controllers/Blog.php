<?php
class Blog extends CI_Controller{



	public function index(){
		echo "hello world";
	}

	public function merhaba($deger){
		echo "girdigin deger " . $deger;
	}
}