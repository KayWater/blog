<?php
namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

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
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Validator messages
        $rules = [
            'name' => 'required|string|min:2|max:18',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ];
        $messages = [
            'name.required' => '请输入用户名',
            'name.string' => '用户名包含非法字符',
            'name.min' => '用户名必须为2~18位字符',
            'name.max' => '用户名必须为2~18位字符',
            'email.required' => '请输入邮箱地址',
            'email.email' => '请输入合法的邮箱地址',
            'email.unique' => '该邮箱已注册！',
            'password.required' => '请输入密码',
            'password.min' => '请输入至少6位字符密码',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();
      
        $user = $this->create($request->all());

        //event(new Registered($user));

        $params = [
    		'grant_type' => 'password',
    		'client_id' => config('passport.password_client_id'),
    		'client_secret' => config('passport.password_client_secret'),
    		'username' => $request->input('email'),
    		'password' => $request->input('password'),
    		'scope' => '*'
        ];
        
    	$request->request->add($params);

    	$proxy = Request::create('oauth/token', 'POST');

    	return Route::dispatch($proxy);
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
}