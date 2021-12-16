# Description [![Build Status](https://secure.travis-ci.org/jeresig/jquery.hotkeys.png)](http://travis-ci.org/jeresig/jquery.hotkeys)

**Invoice Number Generator** is a more flexible package, that can help you to generate unique invoice number with custom prefix depends on year.

This package is easy to use and will help you to simplify your code.

## Installation Process

```
composer require skycoder/invoice-number-generator
```
When successfully install your package. you just run `php artisan migrate` command
## Uses
Just use this line of code into your method which store data
```php 

$service = new InvoiceNumberGeneratorService();
$invoice_number = $service->currentYear()->prefix('sale-inv')->setCompanyId(1)->startAt(500000)->getInvoiceNumber('Sale');
    
 // your code here
    
$service->setNextInvoiceNo();
```
and use this namespace top of the class

`use Skycoder\InvoiceNumberGenerator\InvoiceNumberGeneratorService;`
