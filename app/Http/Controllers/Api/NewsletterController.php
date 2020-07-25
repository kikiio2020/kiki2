<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;
use Illuminate\Http\Response;
use App\NewsSubscriber;

class NewsletterController extends Controller
{
    private const DH_API_URL = 'https://api.dreamhost.com';
    private const LIST_NAME_KIKIIO_NEWS = 'news';
    private const API_DOMAIN_KIKIIO = 'kikiio.com';
    
    
    
    private function getDhClient() 
    {
        return new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);
    }
    
    private function getDhApiCommandUrl(string $command, array $params = []): string
    {
        $url = \config('services.dhapi.url') . '/?'; 
        $params['key'] = \config('services.dhapi.key');
        $params['cmd'] = $command;
        $params['listname'] = self::LIST_NAME_KIKIIO_NEWS;
        $params['domain'] = self::API_DOMAIN_KIKIIO;
            
        return 
            $url . 
            array_reduce(
                array_keys($params), 
                function(?string $result='', $paramKey) use ($params): string {
                    return $result . '&' . $paramKey . '=' . $params[$paramKey];
                }
            );
    }
    
    public function subscribeNews(Request $request): Response
    {
        \Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required',
            'country' => 'required',
            'region' => 'required',
        ])->validate();

        if (NewsSubscriber::where('email', $request->email)->count()) {
            return response('Already subscribed', Response::HTTP_BAD_REQUEST);
        }
        
        $client = $this->getDhClient();
        $response = $client->get(
            $this->getDhApiCommandUrl(
                'announcement_list-add_subscriber',
                [
                    'email' => $request->get('email'),
                    'name' => $request->get('name'),
                ]
            )
        )->getBody()->getContents();
        
        if (false !== strpos($response, 'error')) {
            return response($response, Response::HTTP_BAD_REQUEST);
        }
            
        $subscriber = new NewsSubscriber();
        $subscriber->fill($request->all());
        $subscriber->unsubscribe_code = uniqid();
        $subscriber->save();
        /*
         $subscriber = NewsSubscriber::firstOrCreate(
         ['email' => $request->email],
         [
         'name' => $request->name,
         'country' => $request->country,
         'region' => $request->region,
         ]
         );
         */
        
        return response($response, Response::HTTP_OK);
    }

    public function unsubscribeNews(Request $request): Response
    {
        \Validator::make($request->all(), [
            'email' => 'required|email',
        ])->validate();
        
        $subscriber = NewsSubscriber::where('email', $request->email)->first();
        if (!$subscriber) {
            return response('Email doesn\'t exist', Response::HTTP_BAD_REQUEST);
        }
        
        $client = $this->getDhClient();
        $response = $client->get(
            $this->getDhApiCommandUrl(
                'announcement_list-remove_subscriber',
                [
                    'email' => $request->get('email'),
                ]
            )
        )->getBody()->getContents();
        
        if (false !== strpos($response, 'error')) {
            return response($response, Response::HTTP_BAD_REQUEST);
        }
        
        $subscriber->delete();           
        return response($response, Response::HTTP_OK);
    }
    
}
