<?php
/*
Demza Development
TMNWallet
Unofficial API for Truemoney Wallet Application

(c) 2018, Demza Development. Licensed under MIT License.
Source: https://github.com/DemzaHQ/TMNWallet
Website: https://www.demzahq.com / https://demza.info
*/
class TMNWallet {
	private $username;
	private $password;
	private $login_type;
	private $passhash;

	private $api_signin = "https://api-ewm.truemoney.com/api/v1/signin?&";
	private $api_profile = "https://api-ewm.truemoney.com/api/v1/profile/";
	private $api_topup = "https://api-ewm.truemoney.com/api/api/v1/topup/mobile/";
	private $api_gettran = "https://api-ewm.truemoney.com/api/v1/profile/transactions/history/";
	private $api_getreport = "https://api-ewm.truemoney.com/api/v1/profile/activities/";

	private $device_os = "android";
	private $device_id = "d520d0d12d0d48cb89394905168c6ed5";
	private $device_type = "CPH1611";
	private $device_version = "6.0.1";
	private $app_name = "wallet";
	private $app_version = "4.0.1";
	private $deviceToken = "fUUbZJ9nwBk:APA91bHHgBBHhP9rqBEon_BtUNz3rLHQ-sYXnezA10PRSWQTwFpMvC9QiFzh-CqPsbWEd6x409ATC5RVsHAfk_-14cSqVdGzhn8iX2K_DiNHvpYfMMIzvFx_YWpYj5OaEzMyIPh3mgtx";
	private $mobileTracking = "dJyFzn\/GIq7lrjv2RCsZbphpp0L\/W2+PsOTtOpg352mgWrt4XAEAAA==";

	public function __construct($user, $pass, $type = 'email') {
		$this->username = $user;
		$this->password = $pass;
		$this->login_type = $type;
		$this->passhash = sha1($user.$pass);
	}

	public function GetToken() {
		$url = $this->api_signin.'device_os='.$this->device_os.'&device_id='.$this->device_id.'&device_type='.$this->device_type.'&device_version='.$this->device_version.'&app_name='.$this->app_name.'&app_version='.$this->app_version;
		$header = array(
			"Host: api-ewm.truemoney.com",
			"Content-Type: application/json"
		);
		$postfield = array(
			"username"=>$this->username,
			"password"=>$this->passhash,
			"type"=>$this->login_type,
			"deviceToken"=>$this->deviceToken,
			"mobileTracking"=>$this->mobileTracking,
		);
		$data_string = json_encode($postfield);
		return $this->WalletCurl($url, $data_string, $header);
	}

	public function GetProfile($token) {
		$url = $this->api_profile.$token.'?&device_os='.$this->device_os.'&device_id='.$this->device_id.'&device_type='.$this->device_type.'&device_version='.$this->device_version.'&app_name='.$this->app_name.'&app_version='.$this->app_version;
		$header = array("Host: api-ewm.truemoney.com");
		return $this->WalletCurl($url, false, $header);
	}

	public function GetTransaction($token, $start, $end, $limit = 50) {
		$url = $this->api_gettran.$token.'/?startDate='.$start.'&endDate='.$end.'&limit='.$limit.'&page=1&type=&action=';
		$header = array("Host: api-ewm.truemoney.com");
		return $this->WalletCurl($url, false, $header);
	}

	public function GetReport($token, $id) {
		$url = $this->api_getreport.$id.'/detail/'.$token.'?&device_os='.$this->device_os.'&device_id='.$this->device_id.'&device_type='.$this->device_type.'&device_version='.$this->device_version.'&app_name='.$this->app_name.'&app_version='.$this->app_version;
		$header = array("Host: api-ewm.truemoney.com");
		return $this->WalletCurl($url, false, $header);
	}

    public function Topup($cashcard,$token) {
		$url = $this->api_topup.time()."/".$token."/cashcard/".$cashcard;
		$header = array("Host: api-ewm.truemoney.com");
		return $this->WalletCurl($url, true, $header);
	}

	private function WalletCurl($url, $data, $header) {
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);  
		if($data){
			curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_USERAGENT,'okhttp/3.8.0');
		$result = curl_exec($ch);
		return $result;
	}
}
?>