<p align="center">
    <img src="https://s-cart.org/logo.png" width="150"><br>
</p>
<p align="center">Open source e-commerce for business use laravel framework</p>
<p align="center">
<a href="http://demo.s-cart.org">Demo</a> | <a href="https://s-cart.org">Home page</a> | <a href="https://s-cart.org/installation.html">Installation</a> | <a href="https://s-cart.org/guide.html">Document</a>
</p>
<p align="center">
<a href="https://packagist.org/packages/lanhktc/s-cart"><img src="https://poser.pugx.org/lanhktc/s-cart/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/lanhktc/s-cart"><img src="https://poser.pugx.org/lanhktc/s-cart/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/lanhktc/s-cart"><img src="https://poser.pugx.org/lanhktc/s-cart/license.svg" alt="License"></a>
</p>
<p align="center"><img src="https://s-cart.org/images/screen/v210/s-cart-1.jpg"></p>
<p align="center"><img src="https://s-cart.org/images/screen/v210/product-detail.jpg"></p>
<p align="center"><img src="https://s-cart.org/images/screen/v210/s-cart-2.jpg"></p>
<p align="center"><img src="https://s-cart.org/images/screen/v210/s-cart-3.jpg"></p>
<p align="center"><img src="https://s-cart.org/images/screen/v210/s-cart-4.jpg"></p>
<p align="center"><img src="https://s-cart.org/images/screen/v210/s-cart-5.jpg"></p>
<p align="center"><img src="https://s-cart.org/images/screen/v210/s-cart-6.jpg"></p>
<p align="center"><img src="https://s-cart.org/images/screen/v210/s-cart-7.jpg"></p>



## About S-cart
Free Open source E-commerce use Laravel framework for Business

## Technology
- Core <a href="https://laravel.com">Laravel Framework</a>
- Back-end <a href="http://laravel-admin.org">Laravel Admin</a>
- In addition, s-cart also integrates other free open source libraries.

## List Functions of S-cart

======= SHOPPING =======

- Multi-language
- Currencies
- Customer sign up
- Purchase history
- Process cart
- Manage product: price sale, cost price, promotion price, quantity, multi images, attributes ..
- Categories product
- Brand product
- Api manager

======= SYSTEM MANAGEMENT =======

- Manage & permission users, groups
- Customer management
- Image management
- Order management: edit orders, update payment status, shipping status ...
- Order history
- Report:  chart, statistics, export csv, pdf...
- Generate image thumbnail, watermark
- Manage banner, logo
- Configure email SMTP
- System configuration: turn off website, hide / show products

======= EXTENSIONS =======

- Shipping
- Discount
- Payment
...Support for integrated extension from 3rd party

======= MODULES =======

- Blog/News
- Cms content: content categories, entries
...Support for integrated modules from 3rd party


## Requirements:

Version 1.6 ~ 2.1.0:

> Core laravel framework 5.6. Requirements::

```
- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
```
Version 1.5:

> Core laravel framework 5.5. Requirements:

```
- PHP >= 7.0.0
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
```


## Installation & configuration:

Install last version S-cart

```
composer create-project lanhktc/s-cart
```

or, install a specific version of S-cart, ex 2.1.0

```
composer create-project lanhktc/s-cart your-project "2.1.0"
```


- Chmod -R 777 public/documents/website
- Folder thumbnail: public/documents/website/thumb.

```
- Create a new database. Then, import file sql database/s-cart.sql.
- Link admin: your-domain/system_admin. User/pass admin/admin
```



## Demo:

- Font-end : http://demo.s-cart.org
- Back-end: http://demo.s-cart.org/system_admin   <code>User/pass: test/123456</code>

