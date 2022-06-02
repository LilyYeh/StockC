<?php

namespace App\Listeners;

use App\Events\BarnMatched;
use App\Events\Clinch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class BarnMatchedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\BarnMatched  $event
     * @return void
     */
    public function handle(BarnMatched $event)
    {
        $data = ['productId'=>$event->productId,'marketPrice'=>$event->marketPrice];
        broadcast(new Clinch($data));
    }
}
