# 小技巧
#### link storage to public
★小提醒：用Laradock，需進到 container 內把 public/storage 整個砍掉，然後在 project root path 重新建立軟連結。
```
> php artisan storage:link
```
#### 【一次建立】Generate a model and a migration, factory, seeder, and controller...
```
# Generate a model and a FlightFactory class...
> php artisan make:model Flight --factory
> php artisan make:model Flight -f
 
# Generate a model and a FlightSeeder class...
> php artisan make:model Flight --seed
> php artisan make:model Flight -s
 
# Generate a model and a FlightController class...
> php artisan make:model Flight --controller
> php artisan make:model Flight -c
 
# Generate a model, FlightController resource class, and form request classes...
> php artisan make:model Flight --controller --resource --requests
> php artisan make:model Flight -crR
 
# Generate a model and a FlightPolicy class...
> php artisan make:model Flight --policy
 
# Generate a model and a migration, factory, seeder, and controller...
> php artisan make:model Flight -mfsc
 
# Shortcut to generate a model, migration, factory, seeder, policy, controller, and form requests...
> php artisan make:model Flight --all
 
# Generate a pivot model...
> php artisan make:model Member --pivot
```
