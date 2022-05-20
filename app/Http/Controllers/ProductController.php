<?php

namespace App\Http\Controllers;

use App\Events\BarnMatched;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Barn;
use DB;
use Auth;
use Carbon\Carbon;
use App\Jobs\BarnMatchJob;
use Log;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('product');
    }
    
    public function detail($id)
    {
        /*$productInfo = Item::find($id);
        
        return view('productDetail',[
            'productInfo' => $productInfo
        ]);*/
    
        return view('productDetail');
    }
    
    public function getMarketPrice(Request $request)
    {
        $p_id = $request->input('p_id');
        
        $data = $this->marketPrice($p_id);
        
        $result = array('status'=>'ok','data'=>$data);
        return $result;
    }
    
    public function getPendingOrder(Request $request)
    {
        $data = $this->selectBarn($request->input('p_id'));
        
        $result = array('status'=>'ok','data'=>$data);
        return $result;
    }
    
    public function pendingOrder(Request $request)
    {
        $p_id = $request->input('p_id');
        $type = $request->input('type');
        $price = $request->input('price');
        $other_type = Barn::other_type($type);
        $uid = 0;
        //if(Auth::check()){
        //    $uid = Auth::id();
        //}
        
        $barnData = [
            'iid' => $p_id,
            'uid' => $uid,
            'price' => $price,
            'type' => $type,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ];
        
        //BarnMatchJob::dispatch($barnData)->delay(Carbon::now()->addSecond(10));
        BarnMatchJob::dispatch($barnData);
        
        $result = array('status'=>'ok');
        return $result;
    }
    
    public static function selectBarn($productId){
        $buy = Barn::select('price',DB::raw('count(*) as qty'))
            ->where('iid',$productId)
            ->where('type',2) //空倉
            ->where('clinch',0) //未成交
            ->groupby('price')
            ->orderby('price','desc')
            ->take(5)
            ->get()
            ->toArray();
        $sell = Barn::select('price',DB::raw('count(*) as qty'))
            ->where('iid',$productId)
            ->where('type',1) //多倉
            ->where('clinch',0) //未成交
            ->groupby('price')
            ->orderby('price','asc')
            ->take(5)
            ->get()
            ->toArray();
        return $data = array(
            'buy' => $buy,    //最佳五檔(買)
            'sell' => $sell   //最佳五檔(賣)
        );
    }
    
    public static function marketPrice($productId)
    {
        $productInfo = Item::select('market_price')->where('id',$productId)->first();
        $getLastMarketPrice = Barn::select('price')
            ->where('iid',$productId)
            ->where('type',1) //多倉
            ->where('clinch',1) //成交
            ->orderby('updated_at','desc')
            ->first();
        $marketPrice = $productInfo->market_price;
        $priceSpread = 0;
        $rate = 0;
        if(!empty($getLastMarketPrice)){
            $lastMarketPrice = $marketPrice;
            $marketPrice = $getLastMarketPrice->price;
            $priceSpread = $marketPrice - $lastMarketPrice;
            $rate = $priceSpread/$lastMarketPrice*100;
        }
        
        return $data = array(
            'marketPrice' => $marketPrice, //市價
            'priceSpread' => $priceSpread, //漲跌價
            'rate' => $rate,               //漲跌幅度
        );
    }
}
