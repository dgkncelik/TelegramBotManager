<?php

class CBot extends CI_Controller{

	public function __construct(){
		
		parent::__construct();
		$this->load->model('MBot');
		$this->load->model('MMessage');
		$this->load->model('MScript');
	}

	public function index(){
		$this->load->view('header');
		$data['bot_list'] = $this->getAllBots();
		$this->load->view('bots', $data);
		$this->load->view('footer');

		
	}

	public function createBot(){
		$inputBotName = trim($this->input->post('inputBotName'));
		$inputToken = trim($this->input->post('inputToken'));
		$inputInfo = trim($this->input->post('inputInfo'));
		$inputCreateDate = time();

		$ResultData = "";
		
		if($inputBotName == '' or $inputBotName == NULL){
			$ResultData = $ResultData . '<br>' . 'Bot name must not be empty'; 
		}elseif ($inputToken == '' or $inputToken == NULL) {
			$ResultData = $ResultData . '<br>' . 'Telegram token must not be empty';
		}elseif ($inputInfo == '' or $inputInfo == NULL) {
			$ResultData = $ResultData . '<br>' . 'Info must not be empty';
		}else{
			if((json_decode($this->setWebHook($inputToken))->ok) == 1){

				$this->MBot->name = $inputBotName;
				$this->MBot->token = $inputToken;
				$this->MBot->info = $inputInfo;
				$this->MBot->create_date =  $inputCreateDate;

			
				$ResultData = $this->MBot->createNewBot();
				$ResultData = $ResultData['1'];
				$ResultData = $ResultData . '<br>Telegram Answer:' . $this->setWebHook($inputToken);						
			}else{
				$ResultData = $ResultData . '<br>' . 'Telegram bot service did not return "ok" result for your bot. Not existed token';
			}

		}

		$data['result'] = $ResultData;
		$data['bot_list'] = $this->getAllBots();
		$this->load->view('header');
		$this->load->view('bots', $data);
		$this->load->view('footer');
	}

	public function getAllBots(){
		$this->MBot->token = NULL;
		$result = $this->MBot->pickBot();

		return $result;
	}

	public function deleteBot($bot_token = NULL){
		if($bot_token == NULL){
			$data['result'] = 'Token must not be empty for deleting bot';
			$data['bot_list'] = $this->getAllBots();
			$this->load->view('header');
			$this->load->view('bots', $data);
			$this->load->view('footer');
		}else{
			$this->MBot->token = $bot_token;
			$ResultData = $this->MBot->deleteBot();
			$ResultData = $ResultData['1'];
			$data['result'] = $ResultData;
			$data['bot_list'] = $this->getAllBots();
			$this->load->view('header');
			$this->load->view('bots', $data);
			$this->load->view('footer');
		}


	}


	public function setWebHook($botToken){
		
		$serverName = $_SERVER['SERVER_NAME'];
		$defaultRecivingPerma = 'm';
		$createRequestUrl = 'https://api.telegram.org/bot'. $botToken . '/setWebhook?url=https://' . $serverName . '/' . $defaultRecivingPerma . '/' . $botToken;

		$cURLfunction = curl_init();
		curl_setopt($cURLfunction, CURLOPT_URL, $createRequestUrl);
		curl_setopt($cURLfunction, CURLOPT_RETURNTRANSFER, 1);

		$out_put = curl_exec($cURLfunction);

		curl_close($cURLfunction);
		return ($out_put);
	}

}