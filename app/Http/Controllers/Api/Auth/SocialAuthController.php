<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SocialAuthController extends Controller
{
	use IssueTokenTrait;

	private $client;

	public function __construct(){
		$this->client = Client::find(2);
	}


    public function socialAuth(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required',
    		'email' => 'nullable|email',
    		'provider' => 'required|in:facebook,twitter,google',
    		'provider_user_id' => 'required',

    	])

    	$socialAccount = SocialAccount::where('provider', $request->provider)
    									->where('provider_user_id', $request->provider_user_id
    									->first();

    	if($socialAccount){
    		return $this->issueToken($request, 'social');
    	}
    }
}
