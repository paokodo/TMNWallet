<?php
/*
Demza Development
TMNWallet
Unofficial API for Truemoney Wallet Application

Source: https://github.com/DemzaHQ/TMNWallet
Website: https://www.demzahq.com / https://demza.info
*/
class TMNWallet {
    // ** Login Credential **
    private $username;
    private $password;
    private $passhash;
    private $login_type;

    // ** API Host & API Endpoint **
    private $api_host = 'https://api-ewm.truemoney.com/api/v1';
    private $api_endpoint_signin = '/signin?&';
    private $api_endpoint_profile = '/profile/';
    private $api_endpoint_topup = '/topup/mobile/';
    private $api_endpoint_gettran = '/profile/transactions/history/';
    private $api_endpoint_getreport = '/profile/activities/';

    // ** Wallet App Info **
    private $app_name = 'wallet';
    private $app_version = '4.13.6';

    // ** Device Info **
    private $device_os = 'android';
    private $device_id = 'f88a363c7839454c9b54f80890143cb0';
    private $device_type = 'LDN-LX2';
    private $device_version = '8.0.0';

    public function __construct($user, $pass, $type = 'email') {
        $this->username = $user;
        $this->password = $pass;
        $this->login_type = $type;
        $this->passhash = sha1($user.$pass);
    }

    public function GetToken() {
        $url = $this->api_host.$this->api_endpoint_signin.'device_os='.$this->device_os.'&device_id='.$this->device_id.'&device_type='.$this->device_type.'&device_version='.$this->device_version.'&app_name='.$this->app_name.'&app_version='.$this->app_version;
        $header = array(
            "Host: api-ewm.truemoney.com",
            "Content-Type: application/json"
        );
        $data = array(
            "username"=> $this->username,
            "password"=> $this->passhash,
            "type"=> $this->login_type,
        );
        return $this->WalletCurl($url, json_encode($data), $header);
    }

    public function GetProfile($token) {
        $url = $this->api_host.$this->api_endpoint_profile.$token.'?&device_os='.$this->device_os.'&device_id='.$this->device_id.'&device_type='.$this->device_type.'&device_version='.$this->device_version.'&app_name='.$this->app_name.'&app_version='.$this->app_version;
        $header = array("Host: api-ewm.truemoney.com");
        return $this->WalletCurl($url, false, $header);
    }

    public function GetTransaction($token, $start, $end, $limit = 50) {
        $url = $this->api_host.$this->api_endpoint_gettran.$token.'/?startDate='.$start.'&endDate='.$end.'&limit='.$limit.'&page=1&type=&action=';
        $header = array("Host: api-ewm.truemoney.com");
        return $this->WalletCurl($url, false, $header);
    }

    public function GetReport($token, $id) {
        $url = $this->api_host.$this->api_endpoint_getreport.$id.'/detail/'.$token.'?&device_os='.$this->device_os.'&device_id='.$this->device_id.'&device_type='.$this->device_type.'&device_version='.$this->device_version.'&app_name='.$this->app_name.'&app_version='.$this->app_version;
        $header = array("Host: api-ewm.truemoney.com");
        return $this->WalletCurl($url, false, $header);
    }

    public function Topup($cashcard, $token) {
        $url = $this->api_host.$this->api_endpoint_topup.time().'/'.$token.'/cashcard/'.$cashcard;
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
            curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
            curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        }
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_USERAGENT,'okhttp/3.8.0');
        $result = curl_exec($ch);
        return $result;
    }
}
?>
