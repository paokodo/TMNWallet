# DemzaHQ's TMNWallet
An **unofficial** PHP API for TrueMoney Wallet Application.
  
  
## Installing  
### **Direct Download without Composer**  
Go to [releases page](https://github.com/DemzaHQ/TMNWallet/releases) and then download the **lastest** release, here you go!  
### **via Composer**  
Run this command  
```bash
$ composer require demzahq/tmnwallet
```
  
## Example Usage
```php
$tmn = new TMNWallet('your@email.com', 'y0ur$ecureP@ssw0rd');
$token = json_decode($tmn->GetToken(), true)['data']['accessToken'];
```
  
## Contributors
- [Maythiwat](http://github.com/maythiwat) (Developer & Maintainer)
- [xIndy](https://github.com/exzajung) (Original Developer of **class.truewallet.php**)
