<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProxyController extends Controller
{
    public function users(Request $request){
        $url = rtrim(config('services.users.base'),'/') . '/api/users';
        $resp = Http::withHeaders($this->forwardedHeaders($request))
        ->send($request->method(),$url, $this->payload($request));

        return $this->relay($resp);
    }

    public function userById(Request $request, $id){
        $url = rtrim(config('service.users.base'),'/') . "/api/users{$id}";
        $resp = Http::withHeaders($this->forwardedHeaders($request))
            ->send($request->method(), $url, $this->payload($request));

        return $this->relay($resp);
    }

    public function orders(Request $request)
    {
        $url = rtrim(config('services.orders.base'), '/') . '/api/orders';
        $resp = Http::withHeaders($this->forwardedHeaders($request))
            ->send($request->method(), $url, $this->payload($request));

        return $this->relay($resp);
    }

    public function orderById(Request $request, $id)
    {
        $url = rtrim(config('services.orders.base'), '/') . "/api/orders/{$id}";
        $resp = Http::withHeaders($this->forwardedHeaders($request))
            ->send($request->method(), $url, $this->payload($request));

        return $this->relay($resp);
    }

    private function forwardedHeaders(Request $request) {
        return [
            'Accept' => 'application/json',

        ];
    }

    private function payload(Request $request) : array{
        return [
            'query'=>$request->query(),
            'json'=> $request->isJson() ? $request->json()->all() : $request->all(),
        ];
    }

     private function relay($resp)
    {
        return response($resp->body(), $resp->status())->withHeaders(
            collect($resp->headers())->map(fn($v) => $v[0])->toArray()
        );
    }
}
