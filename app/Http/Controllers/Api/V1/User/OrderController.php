<?php

namespace App\Http\Controllers\Api\V1\User;

use App\ApiCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\OrderRequest;
use App\Http\Resources\OrderCollection;
use App\Models\Order;
use App\Http\Resources\Order as OrderResources;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    public function index()
    {
        $orders=auth()->user()->orders()->latest()->get();
        return $this->respond(new OrderCollection($orders));
    }

    public function store(OrderRequest $request)
    {
        $request->validated();

        $order=Order::create([
            'user_id'=>auth()->user()->id,
            'count'=>$request->count,
            'amount'=>$request->count*200
        ]);

        return $this->respond(new OrderResources($order));
    }

    public function show(Order $order)
    {
        if (!Gate::allows('user-order',$order)){
            return $this->respondNotAccess(ApiCode::NOT_ACCESS);
        }
        return $this->respond(new OrderResources($order));
    }

    public function update(OrderRequest $request, Order $order)
    {
        if (!Gate::allows('user-order',$order)){
            return $this->respondNotAccess(ApiCode::NOT_ACCESS);
        }
        $order->update([
            'count'=>$request->count,
            'amount'=>$request->count*200
        ]);
        return $this->respond(new OrderResources($order),'Updated successfully');
    }

    public function destroy(Order $order)
    {
        if (!Gate::allows('user-order',$order)){
            return $this->respondNotAccess(ApiCode::NOT_ACCESS);
        }
        $order->delete();
        return $this->respondWithMessage('Deleted successfully');
    }
}
