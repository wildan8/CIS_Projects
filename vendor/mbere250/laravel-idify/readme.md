<div align="center">

!['IDify'](img/IDify.png)

</div>
<div align="center">

[![Latest Version](https://img.shields.io/packagist/v/mbere250/laravel-idify?label=version)](https://packagist.org/packages/mbere250/laravel-idify/)   [![Total Downloads](https://img.shields.io/packagist/dt/mbere250/laravel-idify.svg)](https://packagist.org/packages/mbere250/laravel-idify)    [![License](https://img.shields.io/packagist/l/mbere250/laravel-idify.svg)](https://github.com/mbere250/laravel-idify/blob/main/LICENCE) [![Website irebelibrary.com](https://img.shields.io/website-up-down-green-red/http/monip.org.svg)](https://irebelibrary.com/library_plugin/laravel-idify) [![GitHub forks](https://img.shields.io/github/forks/mbere250/laravel-idify.svg?style=social&label=Fork&maxAge=2592000)](https://GitHub.com/mbere250/laravel-idify/network/) [![GitHub stars](https://img.shields.io/github/stars/mbere250/laravel-idify.svg?style=social&label=Star&maxAge=2592000)](https://GitHub.com/mbere250/laravel-idify/stargazers/)


</div>

`IDify` is a package for Laravel used to create custom or unique ID for Laravel project. When you use this package, you will be able to create custom IDs for Students, Products, Invoices, etc... ( `INV-1234`,`INV2210-001`,`KAM_2010-0032`, `STD-0004`,`STD202210-4004`).

## Getting Started

### Requirements
- PHP >= 7.2.5
- Composer is required
- Laravel 7.x, 8.x and 9.x

### No documentation yet!
You can found only article show how to use this package on [laravel-idify](http://irebelibrary.com/library_plugin/laravel-idify).

### Installation
This package can be installed through `composer require`. Before install this, make sure that your are working with PHP >= 7.1 in your system.
Just run the following command in your cmd or terminal:
```bash
 composer require mbere250/laravel-idify
```




After you have installed `IDify` package, open your Laravel config file config/app.php and add the following line.

In the $providers array add the service providers for this package.
```php
 Mbere250\IDify\IDifyServiceProvider::class,
```


### Package initialization
Import `IDify` package on controller using below line:


```php
use Mbere250\IDify\IDify;
```
Inside method, you can generate custom ID using model or table name.
> **Using Model name**: Suppose we have model Called `Student`, use below technique:
```php
$custom_id =  IDify::model(new Student)
                   ->column('student_id')
                   ->prefix('STD')
                   ->separator('-')
                   ->length('4')
                   ->generate();

              DB::table('students')->insert([
                     'name'=>'Any name',
                     'student_id'=>$custom_id
                   ]);  
```

> **Using Table name**: Suppose we have table Called `students` in database, use below technique:
```php
$custom_id =  IDify::table('students')
                   ->column('student_id')
                   ->prefix('STD')
                   ->separator('-')
                   ->length('4')
                   ->generate();

               DB::table('students')->insert([
                     'name'=>'Any name',
                     'student_id'=>$custom_id
                   ]);         
```
### Configuration
Function   |  Default   | Description 
--------------- | ------------- | ---------- 
`model()`  | - | **required**, Pass model name as parameter inside this function. eg: `model(new User)` or `model(new User())`. 
`table()`  | - | **required**, Pass table name as parameter inside this function. eg: `table('users')`
`column()` | -|**required**, Pass table column as parameter inside this function. This is where generated custom ID will be stored. eg: `column('custom_id')` ,`column('student_id')`, `column('invoice_id')`, etc..
`prefix()` | - | **required**, This is very important function on this chain. Just pass a unique String value that will be attached to the custom ID. eg: `prefix('KAM')`, `prefix('ENV')`, etc...
`separator()`| null|You may not pass any parameter inside this function, this will give you something like: `STD22100001`,`STD22100003`. But you can pass any separator parameter using symbol **eg**: `separator('-')`, `separator('_')`. This will give you something like: `STD2210-0001`, `STD2210_0001`
`length()`| 4 | By default, this value is `4` but you can pass any value as parameter. eg: `length(5)`. This is the number of zeros after prefix string. But you may leave as empty. I highly recommand this value not more that 5, because it is not necessary.
`generate()`|null|**required** , This will be last function on this chain to generate custom ID. No parameter required for this function.

---

## Examples

#### - Normal usage
You can use simple custom ID generator by using below technique:
```php
   $cid =  IDify::model(new Student)
                ->column('student_id')
                ->prefix('STD')
                ->separator('_')
                ->length()
                ->generate();
```
>Results: **`STD_0001`**, **`STD_0309`**, **`STD_9399`**, **`STD_9400`**, etc..


#### - Combinations
You can combine `String` and `Date` as prefix parameter by using below technique:
```php
 $cid =  IDify::model(new Student)
              ->column('student_id')
              ->prefix('STD'.date('ym'))
              ->separator('_')
              ->length()
              ->generate();

 $cid =  IDify::model(new Student)
              ->column('student_id')
              ->prefix('STD'.date('ym').'ICT')
              ->separator('-')
              ->length()
              ->generate();
```
>Results: **`STD2210_0001`**, **`STD2012_4069`**, **`STD2210ICT-0001`**, **`STD2210ICT-6887`**, etc..

## License

`IDify` is released under the MIT License.