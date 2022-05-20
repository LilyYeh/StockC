<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Laravel 9.x 
實作練習一個掛單系統

### [使用 sail 建置 laravel](https://laravel.com/docs/8.x/installation#getting-started-on-macos)
```
> curl -s "https://laravel.build/laravel8" | bash
> cd laravel8
> ./vendor/bin/sail up
```
### 建置 vue3
```
> composer require laravel/ui
> php artisan ui vue (--auth)
> npm install -save-dev vue@next
> npm run dev

執行一次 npm run dev 之後，package.json 會增添 "vue-loader": "^16.8.3"，
請再次執行 npm run dev
```
★小提醒：建置好後，laravel 提供的 example-component 是vue2語法，因此不能直接使用。



### 小技巧
#### link storage to public
★小提醒：用Laradock，需進到 container 內把 public/storage 整個砍掉，然後在 project root path 重新建立軟連結。
```
php artisan storage:link
```
