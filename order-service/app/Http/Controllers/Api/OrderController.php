<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
         switch ($request->method()) {
            case 'GET':
                if ($id = $request->route('id')) {
                    return Order::findOrFail($id);
                }
                return Order::paginate(10);

            case 'POST':
                $data = $request->validate([
                    'user_id'  => 'required|integer|min:1',
                    'item'     => 'required|string|max:255',
                    'quantity' => 'required|integer|min:1',
                    'total'    => 'required|numeric|min:0',
                ]);
                return response()->json(Order::create($data), 201);

            case 'PUT':
                $id = $request->route('id');
                $order = Order::findOrFail($id);
                $data = $request->validate([
                    'user_id'  => 'sometimes|integer|min:1',
                    'item'     => 'sometimes|string|max:255',
                    'quantity' => 'sometimes|integer|min:1',
                    'total'    => 'sometimes|numeric|min:0',
                ]);
                $order->update($data);
                return $order;

            case 'DELETE':
                $id = $request->route('id');
                $order = Order::findOrFail($id);
                $order->delete();
                return response()->noContent();

            default:
                abort(405);
        }
    }
}
