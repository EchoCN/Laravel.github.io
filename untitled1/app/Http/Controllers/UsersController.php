<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;

use Intervention\Image\Facades\Image;
use Mail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function register()
    {
        return view('register');
    }
    public function store(UserRegisterRequest $request)
    {
        $data = [
            'confirm_code'=>str_random(48),
            'avatar'=>'https://lorempixel.com/256/256/?52293',
        ];
        $user = User::create(array_merge($request->all(),$data));
        return redirect('/index');
    }
    public function login(){
        return view('login');
    }
    public function signin(UserLoginRequest $request)
    {
        if (\Auth::attempt([
            'email'=>$request->get('email'),
            'password'=>$request->get('password'),
            'is_confirmed' => 0
        ])){
            return redirect('/index');
        }
        \Session::flash('user_login_failed','密码不正确或者邮箱没验证');
        return redirect('user/login')->withInput();
    }
    public function changeAvatar(Request $request)
    {
        $file = $request->file('avatar');
        $input = array('image'=>$file);
        $rules = array(
            'image'=>'image'
        );
        $validator = \Validator::make($input,$rules);
        if ($validator->fails()){
            return \Response::json([
                'success' => false,
                'errors'=>$validator->getMessageBag()->toArray()
            ]);

        }
        $destinationPath = 'uploads/';
        $filename = \Auth::user()->id.'-'.time().$file->getClientOriginalName();
        $file->move($destinationPath,$filename);
        Image::make($destinationPath.$filename)->fit(400)->save();

        return \Response::json([
            'success' => true,
            'avatar' => '/'.$destinationPath.$filename
        ]);
    }
    public function logout(){
        \Auth::logout();
        return redirect('/index');
    }
    public function cropAvatar(Request $request)
    {
        $photo = mb_substr($request->get('photo'),1);
        $width = (int) $request->get('w');
        $height = (int) $request->get('h');
        $xAlign = (int)$request->get('x');
        $yAlign = (int) $request->get('y');

        Image::make($photo)->crop($width,$height,$xAlign,$yAlign)->save();

        $user = \Auth::user();
        $user->avatar = $request->get('photo');
        $user->save();

        return redirect('/user/avatar');
    }
    public function avatar(){
        return view('avatar');
    }
}
