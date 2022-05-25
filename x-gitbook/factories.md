# Database: Factories
產出測試資料的工廠<br>
#### 步驟1. 執行指令以新增 database/factories/
```
> php artisan make:factory ItemFactory
```
#### 步驟2. 編輯 ItemFactory.php。ItemFactory.php 包含2個 function<br>
- 第1個. definition() 預設欄位資料
```
public function definition()
{
    return [
        'name' => $this->faker->name(),
        'market_price' => $this->faker->numberBetween(10,200),
        'image' => $this->faker->imageUrl(),
    ];
}

```
- 第2個. suspended() 指定欄位資料
```
return $this->state(function (array $attributes) {
    return [
        'market_price' => $this->faker->numberBetween(400,500),
    ];
});
```
❤︎ 小技巧：使用 [Faker](https://laravel.com/docs/8.x/installation#getting-started-on-macos) PHP library 產生 random data。