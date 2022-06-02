# Events
當媒合成功時，觸發掛單成交事件。
#### 步驟1. 註冊 Events & Listeners
- 在 App\Providers\EventServiceProvider 註冊 Events & Listeners
```
use App\Events\BarnMatched;
use App\Listeners\BarnMatchedListener;

protected $listen = [
    BarnMatched::class => [          //成交事件
        BarnMatchedListener::class,  //Listening成交事件
    ],
];
```
- 產生 EventServiceProvide 檔案裡註冊的 Events & Listeners 
```
> php artisan event:generate
```
- 手動產生 Events & Listeners
```
> php artisan make:event BarnMatched
> php artisan make:listener BarnMatchedListener --event=BarnMatched
```
#### 步驟2. 編輯 Events & Listeners
- App\Events\BarnMatched 當成交事件發生時
```
class BarnMatched
{
    public $productId;   //商品ID
    public $marketPrice; //商品成交價
   
    public function __construct($productId)
    {
        $this->productId = $productId;
    
        $marketPrice = ProductController::marketPrice($productId);
        $this->marketPrice = $marketPrice;
    }
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
```
- App\Listeners\BarnMatchedListener 接收 BarnMatched $event
```
class BarnMatchedListener
{
    public function __construct()
    {
        Log::info('BarnMatchedListener listener construct');
    }

    public function handle(BarnMatched $event)
    {
        Log::info('BarnMatchedListener listener handle');
    }
}
```