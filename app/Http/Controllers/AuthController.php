<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\Audit;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
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
        return $response;
        return json_encode(json_decode((string) $response->getBody(), true));
    }

    public function getAuthUser()
    {
        $user = Auth::user();

        // $user->load(['userable' => function ($q) {
        //   return $q->with('photo');
        // }]);
        if ($user->userable_type === 'App\Models\Personnel') {
            $user->load(['userable' => function($query) {
                $query->with('photo');
            }, 'userGroup' => function ($query) {
                $query->with(['permissions']);
            }]);
        } else {
            $user->load(['userable']);
        }

        return new UserResource($user);
    }

    public function checkIfAuthorize(Request $request)
    {
        //filter disbursement status id
        $data = $request->all();

        $user = User::where('username', $data['username'])
            ->where('user_group_id', 1)
            ->first();

        $result = 0;

        if ($user) {
            $result = Hash::check($data['password'], $user->getAuthPassword());
        }
        
        return $result;
    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        $auditService = new AuditService();
        $data['event'] = 'Logout';
        $data['user_id'] = auth()->id();
        $auditService->store($data);

        return response()->json('Logged out successfully', 200);
    }
}
