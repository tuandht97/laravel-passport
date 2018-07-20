<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Socialite;

class LoginController extends Controller
{

	private $client;

	public function __construct()
	{
		$this->client = DB::table('oauth_clients')->find(2);
	}

    public function login(Request $request)
    {
    	$this->validate($request, [
    		'username' => 'required',
    		'password' => 'required'
    	]);

    	$http = new Client;

		$response = $http->post('http://localhost:8888/oauth/token', [
		    'form_params' => [
		        'grant_type' => 'password',
		        'client_id' => '2',
		        'client_secret' => 'yJG9UgXzsX1uZHveo3kJvVHetcfFOajFfBm3BgcK',
		        'username' => request('username'),
		        'password' => request('password'),
		        'scope' => '',
		    ],
		]);

		return json_decode((string) $response->getBody(), true);
    }


    public function refresh(Request $request)
    {
    	$this->validate($request, [
    		'refresh_token' => 'required'
    	]);

    	$http = new GuzzleHttp\Client;

		$response = $http->post('http://localhost:8888/oauth/token', [
		    'form_params' => [
		        'grant_type' => 'refresh_token',
		        'refresh_token' => 'the-refresh-token',
		        'client_id' => '2',
		        'client_secret' => 'yJG9UgXzsX1uZHveo3kJvVHetcfFOajFfBm3BgcK',
		        'scope' => '',
		    ],
		]);

		return json_decode((string) $response->getBody(), true);

    }

    public function logout(Request $request)
    {
    	$accessToken = Auth::user()->token();

    	DB::table('oauth_refresh_tokens')
    		->where('access_token_id', $accessToken->id)
    		->update(['revoked' => true]);

    	$accessToken->revoke();
    	
    	return response()->json([], 204);
    }

     /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();

        // $user->token;
    }

}

