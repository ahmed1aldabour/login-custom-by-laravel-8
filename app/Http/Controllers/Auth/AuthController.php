<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            return redirect()->route('admin.adminIndex');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required'
        ]);

        $login_data=[
            'email'=>       $request->email,
            'password'=>    $request->password,
        ];

        if (Auth::attempt($login_data) && Auth::user()->status === 1)
        {
            //Active Account
            return redirect()->route('admin.adminIndex');
        }
        elseif (Auth::attempt($login_data) && Auth::user()->status === 0)
        {
            return 'حسابك معلق';
        }

        return redirect()->back()->with('error','Login details are not valid');
    }

    public function register()
    {
        if (Auth::check())
        {
            return redirect()->route('admin.adminIndex');
        }
        return view('auth.register');
    }

    public function store(AuthRequest $request)
    {
//        $rules= $this->getRules();
//        $message= $this->getMessages();
//        $validator = Validator::make($request->all(),$rules, $message);
//
//        if ($validator->fails())
//        {
//            return redirect()->back()->withErrors($validator)->withInput($request->all());
//        }

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
        ]);
        return redirect()->route('login')->with('success','user created successfully');

    }

    public function logout() {
        if(Auth::check())
        {
            Auth::logout();
            return redirect()->route('login');
        }

    }

    /**   Get the validation rules that apply to the request   **/
//    protected function getRules()
//    {
//        return[
//            'name' => ['required', 'string', 'max:255'],
//            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//            'password' => ['required', 'string', 'min:8', 'confirmed']
//        ];
//    }
//    protected function getMessages()
//    {
//        return[
//            'name.required'         =>__('register.name.required'),
//            'email.required'        =>__('register.email.required'),
//            'email.email'           =>__('register.email.email'),
//            'email.unique'          =>__('register.name.string'),
//            'password.required'     =>__('register.password.required'),
//            'password.min'          =>__('register.name.string'),
//            'password.confirmed'    =>__('register.name.string'),
//        ];
//    }


}
