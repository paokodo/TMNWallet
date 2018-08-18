<?php
/*
Demza Development
TMNWallet
Unofficial API for Truemoney Wallet Application

Source: https://github.com/DemzaHQ/TMNWallet
Website: https://www.demzahq.com / https://demza.info
*/

require_once 'TMNWallet.php';
date_default_timezone_set('Asia/Bangkok');

$wallet = new TMNWallet('your@email.com', 'y0ur_p@$$w0rd');

$start_date = date('Y-m-d', strtotime('-365 days'));
$end_date = date('Y-m-d', strtotime('1 days'));

$token = json_decode($wallet->GetToken(), true)['data']['accessToken'];
$activities = json_decode($wallet->GetTransaction($token, $start_date, $end_date), true)['data']['activities'];

foreach($activities as $reports) {
    if($reports['text3En'] == 'creditor') {
        $txData = json_decode($wallet->GetReport($token,$reports['reportID']),true);
        $tx['id'] = $txData['data']['section4']['column2']['cell1']['value'];
        $tx['message'] = $txData['data']['personalMessage']['value'];
        $tx['fee'] = $txData['data']['section3']['column2']['cell1']['value'];
        $tx['date'] = $txData['data']['section4']['column1']['cell1']['value'];
        $tx['sender']['name'] = $txData['data']['section2']['column1']['cell2']['value'];
        $tx['sender']['phone'] = $txData['data']['ref1'];
        $tx['amount'] = $txData['data']['section3']['column1']['cell1']['value'];
        $tx['amount'] = str_replace(',', '', $tx['amount']);
         
        echo $tx['id'] . ' - amount ' . $tx['amount'] . ' THB - by ' . $tx['sender']['phone'] . ' (' . $tx['sender']['name'] . ')' . ' at ' . $tx['date'] . ' || message: ' . $tx['message'] . '<br>';
    }
}
?>
