# 建置 vue3
前端框架使用 Vue.js 3
```
> composer require laravel/ui
> php artisan ui vue (--auth)
> npm install -save-dev vue@next
> npm run dev

執行一次 npm run dev 之後，package.json 會增添 "vue-loader": "^16.8.3"，
然後，再次執行 npm run dev
```
★小提醒：
1. 建置好後，laravel 提供的 example-component 是 vue2 語法，因此不能直接使用。<br>
2. 記得添加 resources/js/ 或 resources/css/ 下的檔案至 webpack.mix.js 編譯。