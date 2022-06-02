<?php

namespace App\Events;

use App\Http\Controllers\ProductController;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Log;

class BarnMatched
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $productId;
    public $marketPrice;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($productId)
    {
        $this->productId = $productId;
    
        $marketPrice = ProductController::marketPrice($productId);
        $this->marketPrice = $marketPrice;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
