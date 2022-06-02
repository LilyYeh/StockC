<?php

namespace App\Jobs;

use App\Events\BarnMatched;
use App\Events\PendingOrder;
use App\Http\Controllers\ProductController;
use App\Models\Barn;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class BarnMatchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    private $barnData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($barnData)
    {
        $this->barnData = $barnData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //insert database
        $barn = Barn::create($this->barnData);
    
        $this_barn_id = $barn->id;
    
        $otherBarn = Barn::where('iid', $this->barnData["iid"])
                    ->where('type', Barn::other_type($this->barnData["type"])) //1多倉 2空倉
                    ->where('clinch', 0) //未成交
                    ->where('price', $this->barnData["price"])
                    ->orderby('id','asc')
                    ->first();
    
        if($otherBarn) //成交
        {
            $a = Barn::where('id', $this_barn_id)
                ->update(['clinch' => 1, 'clinch_id' => $otherBarn->id]);
            $b = Barn::where('id', $otherBarn->id)
                ->update(['clinch' => 1, 'clinch_id' => $this_barn_id]);
        
            //成交 event
            BarnMatched::dispatch($this->barnData["iid"]);
        }
    
        $barn = ProductController::selectBarn($this->barnData["iid"]);
        $data = ['pid'=>$this->barnData["iid"],'barn'=>$barn];
        broadcast(new PendingOrder($data));
    }
}
