<?php


namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Attempt login
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->success([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_at' => time() + $this->guard()->factory()->getTTL() * 60
            ], [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_at' => time() + $this->guard()->factory()->getTTL() * 60
            ]);
        }

        return $this->failed(null, 'Unauthorized', 401);
    }

    /**
     * Logout
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return $this->success();
    }

    /**
     * Add a new admin account
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'password' => 'required|min:6'
        ]);

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return $this->success($user, 'New Admin has been created');
    }
}
