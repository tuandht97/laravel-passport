<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{

	private $client;

	public function __construct()
	{
		$this->client = DB::table('oauth_clients')->find(2);
	}

    public function register(Request $request)
    {
    	$this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')) 
        ]);

    	// $params = [
    	// 	'grant_type' => 'password',
	    //     'client_id' => $this->client->id,
	    //     'client_secret' => $this->client->secret,
	    //     'username' => $user->email,
	    //     'password' => $user->password,
	    //     'scope' => '*',
    	// ];

    	// $request->request->add($params);

    	// $proxy = Request::create('oauth/token', 'POST');

    	// return Route::dispatch($proxy);

    	$http = new Client;

		$response = $http->post('http://localhost:8888/oauth/token', [
		    'form_params' => [
		        'grant_type' => 'password',
		        'client_id' => '2',
		        'client_secret' => 'yJG9UgXzsX1uZHveo3kJvVHetcfFOajFfBm3BgcK',
		        'username' => 'tuandht97@gmail.com',
		        'password' => 'abcdef',
		        'scope' => '',
		    ],
		]);

		return json_decode((string) $response->getBody(), true);
    	//dd($request->all());
    }
}
