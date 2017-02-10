<?php

class MScript extends CI_Model{

	public $name;
	public $create_date;
	public $bot_token;
	public $path;

	public function __construct(){
		parent::__construct();
	}

	public function scriptTableName(){
		//script table name
		return "script";
	}

	public function index(){
		//model default method
	}

	public function createScript(){

		$checkForDuplication = $this->db->select('*');
		$checkForDuplication = $this->db->from($this->scriptTableName());
		$checkForDuplication = $this->db->where('name', $this->name);
		$checkForDuplication = $this->db->get();
		$checkForDuplication = $checkForDuplication->result_array();

		if(count($checkForDuplication) > 0){
			return array(0, 'ERR.MSCRIPT.CREATE_SCRIPT.There-is-script-with-same-name');
		}else{
			$saveScript = $this->db->insert($this->scriptTableName(), $this);

			return array(1, 'SUC.MSCRIPT.CREATE_SCRIPT.Script-have-been-saved');
		}

	}

	public function deleteScript(){
		$checkForDeletion = $this->db->select('*');
		$checkForDeletion = $this->db->from($this->scriptTableName());
		$checkForDeletion = $this->db->where('name',
			 $this->name);
		$checkForDeletion = $this->db->get();
		$checkForDeletion = $checkForDeletion->result_array();

		if(count($checkForDeletion) <= 0){
			return array(0, 'ERR.MSCRIPT.DELETE_SCRIPT.There-is-no-script-with-name');
		}else{
			$checkForDeletion = $this->db->where('name', $this->name);
			$checkForDeletion = $this->db->delete($this->scriptTableName());
			return array(1, 'SUC.MSCRIPT.DELETE_SCRIPT.Script-have-been-deleted');
		}
	}

	public function runScript($script_parameter = NULL){
		$checkForRun = $this->db->select('*');
		$checkForRun = $this->db->from($this->scriptTableName());
		$checkForRun = $this->db->where('name', $this->name);
		$checkForRun = $this->db->get();
		$checkForRun = $checkForRun->result_array();

		if(count($checkForRun) <= 0){
			return array(0, 'ERR.MSCRIPT.RUN_SCRIPT.There-is-no-script-with-name');
		}else{
			$getToken = $checkForRun['0']['bot_token'];
			if($getToken != $this->bot_token){
				return array(0, 'ERR.MSCRIPT.RUN_SCRIPT.This-bot-not-auth-for-this-script');
			}else{
				$getScriptPath = $checkForRun['0']['path'];
								
				if(substr($getScriptPath, -3) == 'php'){
					$scriptPrefix = 'php';
				}elseif(substr($getScriptPath, -2) == 'sh'){
					$scriptPrefix = '/bin/bash';
				}elseif(substr($getScriptPath, -2) == 'py'){
					$scriptPrefix = 'python';
				}
			}
			$fullScriptPath = $scriptPrefix . ' ' . $getScriptPath . ' ' . $script_parameter;
		}

		$scriptResult = exec($fullScriptPath);

		return $scriptResult;
	}

	public function checkScriptExists(){
		$checkForExists = $this->db->select('*');
		$checkForExists = $this->db->from($this->scriptTableName());
		$checkForExists = $this->db->where('name', $this->name);
		$checkForExists = $this->db->get();
		$checkForExists =$checkForExists->result_array();

		if(count($checkForExists) <= 0){
			return array(0,'ERR.MSCRIPT.CHECK_SCRIPT_EXISTS.There-is-no-script-with-name');
		}else{
			return array(1,'SUC.MSCRIPT.CHECK_SCRIPT_EXISTS.Script-exists');
		}
	}


	public function showScript($script_id = NULL){
		
		if($script_id==NULL){
			$checkForShow = $this->db->select('*');
			$checkForShow = $this->db->from($this->scriptTableName());
			$checkForShow = $this->db->get();
			$checkForShow = $checkForShow->result_array();	
		}else{
			$checkForShow = $this->db->select('*');
			$checkForShow = $this->db->from($this->scriptTableName());
			$checkForShow = $this->db->where('id', $script_id);
			$checkForShow = $this->db->get();
			$checkForShow = $checkForShow->result_array();	
		}

		if(count($checkForShow) == 0){
			return array(0, 'ERR.MSCRIPT.SHOW_SCRIPT.There-is-no-script-with');
		}else{
			return $checkForShow;
		}
	}

	

}