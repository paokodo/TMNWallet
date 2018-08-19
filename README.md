# DemzaHQ's TMNWallet
An **unofficial** PHP API for TrueMoney Wallet Application.

## Which class is right for your project?
- **src/TMNWallet.php**  
A class for starting new project
  
- **src/class.truewallet.php**  
A class for old project(s) that still depend on "class.truewallet.php" 
and need to use TMNWallet without changing code.

## Example Usage
```php
$tmn = new TMNWallet('your@email.com', 'y0ur$ecureP@ssw0rd');
$token = json_decode($tmn->GetToken(), true)['data']['accessToken'];
```

## Contributors
- [d3mza](http://github.com/lion328) (Developer & Maintainer)
- [xIndy](https://github.com/exzajung) (Developer of **class.truewallet.php**)
