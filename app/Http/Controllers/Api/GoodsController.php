<?php

namespace App\Http\Controllers\Api;

use App\Goods;
use App\Host;
use App\Http\Resources\GoodsCollection;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    public function show()
    {
        return new GoodsCollection(Goods::paginate());
    }
}
