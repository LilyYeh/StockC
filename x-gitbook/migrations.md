# Database: Migrations
使用 Migraions 建置資料表。<br> 
傳統建置資料庫的方式是匯出整個資料庫的Schema和資料，再匯入新資料庫，若資料量龐大將會很耗時。<br>
Laravel 提供了 Migrations 來寫資料庫的 Schema，並建置資料表。
####步驟1. 執行指令以新增 database/migrations
- Creating Tables
```
> php artisan make:migration create_item_table
```
- Creating Columns
```
> php artisan make:migration add_image_to_item_table --table=item
```
####步驟2. 編輯 2022_05_20_082459_create_item_table.php
- Creating Tables
```
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

public function up()
{
    Schema::create('item', function (Blueprint $table) {
        $table->id()->comment('商品ID')->index()->unique();
        $table->string('name')->comment('商品名稱');
        $table->integer('market_price')->comment('市價')->default(0);
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('item');
}
```
- Creating Columns
```
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

public function up()
{
    Schema::table('item', function (Blueprint $table) {
        $table->string('image')->comment('商品圖')->after('market_price');
    });
}

public function down()
{
    Schema::table('item', function (Blueprint $table) {
        $table->dropColumn('image');
    });
}
```
####步驟3. run migration 以新增資料庫 table
```
> php artisan migrate
```
####步驟4. 查看 migration 狀態
```
> php artisan migrate:status
```