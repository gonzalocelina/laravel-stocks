<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Support\Facades\Auth;

class FacebookController extends Controller
{
    /**
     * Check the JS API generated cookie and logs in the corresponding User
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * @throws FacebookSDKException
     */
    public function login()
    {
        $fb = new Facebook([
            'app_id' => env('FB_APP_ID'),
            'app_secret' => env('FB_APP_SECRET'),
            'default_graph_version' => 'v2.10',
        ]);

        $helper = $fb->getJavaScriptHelper();
        try {
            $accessToken = $helper->getAccessToken();
        } catch(FacebookSDKException $e) {
            // Validation fails
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (!isset($accessToken)) {
            return redirect("/");
        }

        $fb->setDefaultAccessToken($accessToken);

        try {
            $response = $fb->get('/me?fields=name,email');
            $userNode = $response->getGraphUser();
        } catch(FacebookSDKException $e) {
            // Graph fails
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $userData = [
            'social_id' => $userNode->getId(),
            'name' => $userNode->getName(),
            'email' => $userNode->getEmail(),
        ];

        $user = User::getOrCreate($userData, 'facebook');

        Auth::loginUsingId($user->getId());

        return redirect("/stocks");

    }
}
