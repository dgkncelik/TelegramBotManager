<?php

class MBot extends CI_Model {
	
	public $id;
	public $name;
	public $token;
	public $create_date;
	public $info;
	

	public function __construct(){
		parent::__construct();

	}

	public function botTableName(){
		//table's name that stores bot's information
		return "bot";
	}
	
	public function index(){
		//model default method
	}

	public function checkBotExists(){
		
		$checkForExists = "";
		
		$checkForExists = $this->db->select('*');
		$checkForExists = $this->db->from($this->botTableName());
		$checkForExists = $this->db->where('token', $this->token);
		$checkForExists = $this->db->get();
		$checkForExists = $checkForExists->result_array();
		if(count($checkForExists) <= 0){
			return array(0,"ERR.MBOT.CHECK_BOT_EXISTS.There-is-no-bot-with-token");
		}

		return array(1,"SUC.MBOT.CHECK_BOT_EXISTS.Bot-Exists");
	}

	public function createNewBot(){

		$checkForDuplication = "";

		$checkForDuplication = $this->db->select('*');
		$checkForDuplication = $this->db->from($this->botTableName());
		$checkForDuplication = $this->db->where('name', $this->name);
		$checkForDuplication = $this->db->get();
		$checkForDuplication = $checkForDuplication->result_array();
		if(count($checkForDuplication) > 0){
			//var_dump($checkForDuplication);
			return array(0,"ERR.MBOT.CREATE_NEW_BOT.There-is-bot-with-same-name");
		}

		$checkForDuplication = $this->db->select('*');
		$checkForDuplication = $this->db->from($this->botTableName());
		$checkForDuplication = $this->db->where('token', $this->token);
		$checkForDuplication = $this->db->get();
		$checkForDuplication = $checkForDuplication->result_array();
		if(count($checkForDuplication) > 0){
			//var_dump($checkForDuplication);
			return arraY(0,"ERR.MBOT.CREATE_NEW_BOT.There-is-bot-with-same-token");
		}

		if(($this->create_date == NULL) or (trim($this->create_date) == "")){
			$this->create_date = time(); //unix time stamp
		}

		$this->db->insert($this->botTableName(), $this);

		return array(1,"SUC.MBOT.CREATE_NEW_BOT.Bot-have-been-created-successfully");
		
	}

	public function deleteBot(){
	
		$checkForDeletion = "";
		$checkForDeletion = $this->db->select('*');
		$checkForDeletion = $this->db->from($this->botTableName());
		$checkForDeletion = $this->db->where('token', ($this->token));
		$checkForDeletion = $this->db->get();
		$checkForDeletion = $checkForDeletion->result_array();
		if(count($checkForDeletion) <= 0){
			return array(0,"ERR.MBOT.DELETE_BOT.There-is-no-bot-with-token");
		}

		$checkForDeletion = $this->db->where('token', $this->token);
		$checkForDeletion = $this->db->delete($this->botTableName());
		
		return array(1,"SUC.MBOT.DELETE_BOT.Bot-have-been-deleted");
	}



	public function pickBot(){
		
		if($this->token == NULL or trim($this->token) == ''){
			$checkForPick = $this->db->select('*');
			$checkForPick = $this->db->from($this->botTableName());
			$checkForPick = $this->db->get();
			$checkForPick = $checkForPick->result_array();

			if(count($checkForPick) <= 0){
				return array(0, 'ERR.MBOT.PICK_BOT.There-is-no-bot');
			}else{
				return $checkForPick;
			}
		}

		$checkForPick = $this->db->select('*');
		$checkForPick = $this->db->from($this->botTableName());
		$checkForPick = $this->db->where('token', ($this->token));
		$checkForPick = $this->db->get();
		$checkForPick = $checkForPick->result_array();

		if(count($checkForPick) <= 0){
			return array(0, 'ERR.MBOT.PICK_BOT.There-is-no-bot-with-token');
		}else{
			return $checkForPick;
		}
		
	}
}