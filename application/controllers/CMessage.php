<?php

class CMessage extends CI_Controller{

	public function __construct(){
		parent::__construct();

		$this->load->model('MMessage');
		$this->load->model('MBot');
		$this->load->model('MScript');
	}
	
	public function index(){
		$this->load->view('header');
		$this->MBot->token = NULL;
		$ResultData = $this->MBot->pickBot();
			if($ResultData['0'] == 0){
				$data['bot_list'] = 'There is no bot!';
				$this->load->view('messages', $data);
			}else{
				$data['bot_list'] = $ResultData;
				$this->load->view('messages', $data);
			}
		$this->load->view('footer');
		//controller default method
	}

	public function getMessageFromTelegram($botToken){

		$this->MBot->token = $botToken;
		$resultCheck = $this->MBot->checkBotExists();

		if($resultCheck['0'] == 1){
			$HTTP_RAW_INPUT = $this->input->raw_input_stream;
			$this->MMessage->message = $HTTP_RAW_INPUT;
			$this->MMessage->save_date= time();
				$this->MBot->token = $botToken;
				$findBotId = $this->MBot->pickBot();
				$findBotId = $findBotId['0']['id'];
			$this->MMessage->bot_id = $findBotId;
			$this->MMessage->saveMessage();
		}

	}


	public function sendMessageToTelegram($botToken, $chatId, $message_text){

		$createRequestUrl = 'https://api.telegram.org/bot' . $botToken . '/sendMessage?chat_id=' . $chatId . '&text=' . $message_text;

		$cURLfunction = curl_init();
		curl_setopt($cURLfunction, CURLOPT_URL, $createRequestUrl);
		curl_setopt($cURLfunction, CURLOPT_RETURNTRANSFER, 1);

		$out_put = curl_exec($cURLfunction);

		curl_close($cURLfunction);

		var_dump($createRequestUrl);
		var_dump($out_put);

	}

	public function viewMessage(){
		$bot_id = trim($this->input->post('inputBotName'));
		$ResultData = $this->MMessage->searchMessage($bot_id, 'bot_id', 'none');
		if($ResultData['0'] == 0){
			$ResultData = 'There is no messages for this bot';
		}

		$data['message_result'] = $ResultData;
		$ResultData = $this->MBot->pickBot();
			if($ResultData['0'] == 0){
				$data['bot_list'] = 'There is no bot!';
			}else{
				$data['bot_list'] = $ResultData;
			}
		$this->load->view('header');
		$this->load->view('messages', $data);
		$this->load->view('footer');
		//var_dump($ResultData);
	}

	public function deleteMessage($message_id = NULL){
		if(($message_id == NULL) or (trim($message_id) == '')){
			$ResultData = 'You should specify the message which you want to delete';
		}else{
			$ResultData = $this->MMessage->deleteMessage($message_id);
			$data['delete_result'] = $ResultData['1'];

			$ResultData = $this->MBot->pickBot();
			if($ResultData['0'] == 0){
				$data['bot_list'] = 'There is no bot!';
			}else{
				$data['bot_list'] = $ResultData;
			}
			
			$this->load->view('header');
			$this->load->view('messages', $data);

			$this->load->view('footer');
		}
	}


}

