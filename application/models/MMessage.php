<?php

class MMessage extends CI_Model{

	public $message;
	public $save_date;
	public $bot_id;

	
	public function __construct(){
		parent::__construct();
	}

	
	public function messageTableName(){
		//message table name
		return "message";
	}

	public function index(){
		//model default method
	}

	public function saveMessage(){
		
		$savingMessage = array('message' => ($this->message),
							   'save_date' => ($this->save_date),
							   'bot_id' => ($this->bot_id)
							   );
		$savingMessage = $this->db->insert($this->messageTableName(), $savingMessage);

		return array(1,"SUC.MMESSAGE.SAVE_MESSAGE.Message-saved");
	}

	public function deleteMessage($message_id = NULL){

		$checkForDelete = "";
		$checkForDelete = $this->db->select('*');
		$checkForDelete = $this->db->from($this->messageTableName());
		$checkForDelete = $this->db->where('id', $message_id);
		$checkForDelete = $this->db->get();
		$checkForDelete = $checkForDelete->result_array();

		if(count($checkForDelete) <= 0){
			return array(0, "ERR.MMESSAGE.DELETE_MESSAGE.There-is-no-message-with-id");
		}

		$checkForDelete = $this->db->where('id' , $message_id);
		$checkForDelete = $this->db->delete($this->messageTableName());

		return array(0, "SUC.MMESSAGE.DELETE_MESSAGE.Message-deleted");
	}

	public function showMessage($message_id = NULL){
		if($message_id == NULL){
			$showAllMessage = $this->db->select('*');
			$showAllMessage = $this->db->from($this->messageTableName());
			$showAllMessage = $this->db->get();
			$showAllMessage = $showAllMessage->result_array();

			if(count($showAllMessage) <= 0){
				return array(0, 'ERR.MMESSAGE.SHOW_MESSAGE.There-are-no-messages');
			}else{
				return $showAllMessage;
			}
		}

		$showSpecMessage = $this->db->select('*');
		$showSpecMessage = $this->db->from($this->messageTableName());
		$showSpecMessage = $this->db->where('id', $message_id);
		$showSpecMessage = $this->db->get();
		$showSpecMessage = $showSpecMessage->result_array();

		if(count($showSpecMessage) <= 0){
			return array(0,'ERR.MMESSAGE.SHOW_MESSAGE.There-is-no-message-with-id');
		}else{
			return $showSpecMessage;
		}
	}

	public function searchMessage($search_parameter, $search_column = NULL, $regex_option = 'both'){
		$search_message = $this->db->select('*');
		$search_message = $this->db->from($this->messageTableName());
		if($search_column == NULL){
			$search_column = 'message';
		}
		$search_message = $this->db->like($search_column, $search_parameter,$regex_option);
		$search_message = $this->db->get();

		$search_message = $search_message->result_array();

		if(count($search_message) <= 0){
			return array(0, "ERR.MMESSAGE.SEARCH_MESSAGE.There-is-no-match-message");
		}else{
			return $search_message;			
		}
	}


	
}