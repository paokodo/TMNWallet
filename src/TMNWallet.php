<?php
/*
Demza Development
TMNWallet
Unofficial API for Truemoney Wallet Application

Source: https://github.com/DemzaHQ/TMNWallet
Website: https://demza.info
*/
class TMNWallet {
    // ** Login Credential **
    private $username;
    private $password;
    private $authtype;

    // ** API Host & API Endpoint **
    private $api_host = 'https://api-ewm.truemoney.com/api/v1';
    private $api_endpoint_signin = '/signin';
    private $api_endpoint_profile = '/profile/';
    private $api_endpoint_topup = '/topup/mobile/';
    private $api_endpoint_gettran = '/profile/transactions/history/';
    private $api_endpoint_getreport = '/profile/activities/';

    public function __construct($user, $pass, $type = 'email') {
        $this->username = $user;
        $this->password = $pass;
        $this->authtype = $type;
    }

    public function GetToken() {
        $url = $this->api_host.$this->api_endpoint_signin;
        $header = array(
            "Host: api-ewm.truemoney.com",
            "Content-Type: application/json"
        );
        $data = array(
            "username"=> $this->username,
            "password"=> sha1($this->username.$this->password),
            "type"=> $this->authtype,
        );
        return $this->WalletCurl($url, json_encode($data), $header);
    }

    public function GetProfile($token) {
        $url = $this->api_host.$this->api_endpoint_profile.$token;
        $header = array("Host: api-ewm.truemoney.com");
        return $this->WalletCurl($url, false, $header);
    }

    public function GetTransaction($token, $start, $end, $limit = 50) {
        $url = $this->api_host.$this->api_endpoint_gettran.$token.'/?startDate='.$start.'&endDate='.$end.'&limit='.$limit.'&page=1&type=&action=';
        $header = array("Host: api-ewm.truemoney.com");
        return $this->WalletCurl($url, false, $header);
    }

    public function GetReport($token, $id) {
        $url = $this->api_host.$this->api_endpoint_getreport.$id.'/detail/'.$token;
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
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
        if ($data) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'okhttp/3.8.0');
        $result = curl_exec($ch);
        return $result;
    }
}
?>
