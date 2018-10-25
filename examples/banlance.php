<?php
/*
Demza Development
TMNWallet
Unofficial API for Truemoney Wallet Application
Source: https://github.com/DemzaHQ/TMNWallet
Website: https://www.demzahq.com / https://demza.info
*/
require_once '../src/TMNWallet.php';
date_default_timezone_set('Asia/Bangkok');
$wallet = new TMNWallet('your@email.com', 'y0ur_p@$$w0rd');
$token = json_decode($wallet->GetToken(), true)['data']['accessToken'];

echo $wallet->GetBanlance($token);
?>
