<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        // try {
            $http = new \GuzzleHttp\Client;
            $response = $http->post(url('/') . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => Config::get('client.id'),
                    'client_secret' => Config::get('client.secret'),
                    'username' => $data['username'],
                    'password' => $data['password'],
                    'scope' => '',
                ],
            ]);
            return json_encode(json_decode((string) $response->getBody(), true));
        // } catch (ClientErrorResponseException $exception) {
        //     $responseBody = $exception->getResponse()->getBody(true);
        // }
    }

    public function getAuthUser()
    {
        $user = Auth::user();

        // $user->load(['userable' => function ($q) {
        //   return $q->with('photo');
        // }]);

        $user->load(['userable', 'userGroup' => function ($query) {
            $query->with(['permissions']);
        }]);

        return new UserResource($user);
    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json('Logged out successfully', 200);
    }
}
