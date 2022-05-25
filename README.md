<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Laravel 9.x 
實作練習一個股票掛單系統

## 執行環境建置
請依照指示一步一步往下執行以完成 Local 環境

- 執行指令以安裝 laravel
```
composer install
```
- 執行指令以安裝 laravel 環境設定檔
```
cp .env.example .env
```
- 啟動執行環境
```
./vendor/bin/sail up -d
```

## 資料庫建置
- 執行指令創建 table
```
php artisan migrate
```
- 執行指令匯入資料
```
php artisan db:seed
```


## 我的筆記：
- 環境建置
   - [使用 sail 建置 laravel](x-gitbook/sail.md)
   - [建置 vue3](x-gitbook/vue3.md)
   - [Eloquent: Relationships](x-gitbook/eloquent.md)
   - [Database: Migrations](x-gitbook/migrations.md)
   - [Database: Factories](x-gitbook/factories.md)
   - [Database: Seeding](x-gitbook/seeding.md)
- Laravel 模組
   - Queue Job
   - Broadcast
   - Event, Event Listener
- 其他
   - [小工具](x-gitbook/tool.md)
