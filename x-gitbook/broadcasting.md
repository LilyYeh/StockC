# Broadcasting
廣播的目的在於讓 Client 端看到即時資料，不需重整網頁。<br><br>
本專案會在以下兩個情況使用廣播：
1. 掛單在 Queue 消化後，產生訂單並廣播「最佳五檔」。
2. 若交易成功，廣播商品「市價」。
#### 步驟1. 註冊 [Pusher Channels](https://pusher.com/channels)
- Pusher Channels 是一個提供 echo server 的平台，我們在 Pusher Channels 註冊一個免費方案，每天可廣播20萬則 messages。

#### 步驟2. 設定 Server Side 設置
- config/broadcasting.php
```
'connections' => [

    'pusher' => [
        'driver' => 'pusher',
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'app_id' => env('PUSHER_APP_ID'),
        'options' => [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ],
        'client_options' => [
            // Guzzle client options: https://docs.guzzlephp.org/en/stable/request-options.html
        ],
    ],
]
```
- 設定.env。將 [Pusher Channels](https://pusher.com/channels) 提供的 key 填入、更改 BROADCAST_DRIVER
```
BROADCAST_DRIVER=pusher
```
```
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```
- config/app.php 移除註解
```
'providers' => [
   App\Providers\BroadcastServiceProvider::class,
]
```
- 安裝 Pusher Channel PHP SDK
```
> composer require pusher/pusher-php-server
```
#### 步驟3. Client Side 設置
- 安裝相關套件
```
> npm install --save-dev laravel-echo pusher-js
```
- resources/js/bootstrap.js 移除註解
```
import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: process.env.MIX_PUSHER_APP_KEY,
  cluster: process.env.MIX_PUSHER_APP_CLUSTER,
  forceTLS: true
});
```
- compile 
```
> npm run dev
```
#### 步驟4. 廣播最佳五檔至每個 Client
- 產生「廣播事件」
```
> php artisan make:event PendingOrder
```
#### 步驟5. PendingOrder event 架構
- Server Side
```
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PendingOrder implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    private $productid;
    private $barn;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->productid = $data['pid'];
        $this->barn = $data['barn'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('product.'.$this->productid);
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'pendingOrder';
    }
    
    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastWith()
    {
        return ['data'=>$this->barn];
    }
}
```
- Client Side
```
Pusher.logToConsole = true;

Echo.channel('product.'+this.product)
    .listen('.pendingOrder', (e) => {
        console.log('listening .pendingOrder')
        console.log(e);
        this.buy = e.data.buy;
        this.sell = e.data.sell;

    }).listen('.clinch', (e) => {
        console.log(e);
        this.marketPrice = e.data.marketPrice;
        this.priceSpread = e.data.priceSpread;
        this.rate = e.data.rate;
    });
```
- 每次編輯完 PendingOrder，都需要再執行一次
```
> php artisan queue:work
```
❤︎小提醒：若 queue:work 報錯，可以進 log 檔看看錯誤訊息。記得 "use Log" 歐！
