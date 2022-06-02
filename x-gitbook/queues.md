# Queues
使用者掛單後，放進 Queue 等待媒合。
#### 步驟1. 選擇 Queues connections
- Laravel 提供了幾種 Queues Connection，可開啟config/queue.php查看提供了哪些選擇。而我們選擇使用 database。
- 更改 .env
```
QUEUE_CONNECTION=database
```
- 使用 migration 新增 queue table
```
> php artisan queue:table
> php artisan migrate
```
#### 步驟2. 執行指令以新增 app/Jobs
```
> php artisan make:job BarnMatchJob
```
#### 步驟3. 指派任務給 BarnMatchJob
- BarnMatchJob 負責處理掛單
```
//$barnData 掛單資料
BarnMatchJob::dispatch($barnData);
```
#### 步驟4. app/Jobs/BarnMatchJob
- Create a new job instance.
```
public function __construct($barnData)
{
    $this->barnData = $barnData;
}
```
- Execute the job.
```
public function handle()
{
    //掛單媒合
    if(成交){
        //成交 event
        BarnMatched::dispatch($this->barnData["iid"]);
    }

    //廣播「最佳五檔」至每個頁面
    broadcast(new PendingOrder($data));
}
```
- 每次編輯完 app/Jobs/BarnMatchJob，必須在執行一次
```
> php artisan queue:work
```
❤︎小提醒：debug 可以用 Log::info()，log 檔記錄在 storage/logs/laravel.log。