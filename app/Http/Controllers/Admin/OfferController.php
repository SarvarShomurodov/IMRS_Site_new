<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;

class OfferController extends Controller
{
    public function index(){
      $items = Offer::orderBy('created_at', 'DESC')->paginate(30);

      return view('admin.offers.index', compact('items'));
    }


    public function item($id){
      $item = Offer::find($id);
      $item->update(['status'=>'1']);
      return view('admin.offers.item', compact('item'));
    }
}
