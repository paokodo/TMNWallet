# DemzaHQ's TMNWallet
An **unofficial** PHP API for TrueMoney Wallet Application.
  
## Download  
Go to [releases page](https://github.com/DemzaHQ/TMNWallet/releases) and then download the **lastest** release, here you go!
  
## Which class is right for your project?
- **src/TMNWallet.php**  
A class for starting a new project.
  
- **src/class.truewallet.php**  
A class for old project(s) that still depend on "class.truewallet.php"  
and need to use TMNWallet without touch or change your source code.
  
## Example Usage
```php
$tmn = new TMNWallet('your@email.com', 'y0ur$ecureP@ssw0rd');
$token = json_decode($tmn->GetToken(), true)['data']['accessToken'];
```
  
## Contributors
- [d3mza](http://github.com/d3mza) (Developer & Maintainer)
- [xIndy](https://github.com/exzajung) (Original Developer of **class.truewallet.php**)
