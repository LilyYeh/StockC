##Database: Seeding 
####步驟1. 執行指令以新增 database/seeders/
```
> php artisan make:seeder ItemSeeder
```
####步驟2. 編輯 ItemSeeder.php。seeder 只包含一個 method：run()
```
use App\Models\Item;

public function run()
{
    Item::factory(50)->create();
}
```
####步驟3. 使用 Models 和 Factories 產出資料
- 輸入資料庫的永久性資料
```
$items = Item::factory()->count(3)->create();
```
- 即時資料
```
$items = Item::factory()->count(3)->make();
$items = Item::factory()->count(5)->suspended()->make();
```
- 一個 Item 有10個掛單(Barn)。 5筆空倉(type=2)，5筆多倉(type=1)
```
use App\Models\Item;
use App\Models\Barn;
use Illuminate\Database\Eloquent\Factories\Sequence;

public function run()
{
    Item::factory()
            ->count(5)
            ->has(Barn::factory()
                        ->count(10)
                        ->state(new Sequence(
                                   ['type' => 1],
                                   ['type' => 2],
            )),'barns')
            ->create();
}
```
####步驟4. Running Seeder
```
> php artisan db:seed

> php artisan db:seed --class=ItemSeeder
```
❤︎小技巧：刪除所有 table, re-run migrations, re-building your database.
```
> php artisan migrate:fresh --seed
```