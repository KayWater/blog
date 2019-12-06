<?php
namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\RegistRequest;
use App\Models\User;

class RegisterController extends Controller
{
    use RegistersUsers;

     /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle a registration request for the application.
     *
     * @param  App\Http\Requests\RegistRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegistRequest $request)
    {
        $user = $this->create($request->all());

        //event(new Registered($user));

        $this->guard('api')->login($user);

        return $this->registered($request, $user);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  Array $data
     * @return \App\Models\User
     */
    protected function create($data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * User registered
     * @param   \Illuminate\Http\Request $request
     * @param   \App\Models\User $user
     * @return  \Illuminate\Http\Response
     */
    protected function registered(Request $request, $user)
    {
        return response()->json([
            'user' => $user,
        ], 200);
    }
}