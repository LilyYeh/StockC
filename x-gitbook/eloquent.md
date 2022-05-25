# Eloquent
關聯式資料庫
#### 步驟1. 執行指令以新增 app/Models/
```
> php artisan make:model Item
> php artisan make:model Barn
```
#### 步驟2. 建立關係 Relationships
- 一對多 One to Many
```
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Item extends Model
{
    public function barns()
    {
        return $this->hasMany(Barn::class);
    }
}
```

```
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Barn extends Model
{
    public function item()
    {
        return $this->belongsTo(Item::class,'iid');
    }
}
```