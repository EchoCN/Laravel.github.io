<?php

namespace App\Http\Controllers;

use App\Discussion;
use App\Comment;
use App\Http\Requests\StoreBlogRequest;
use App\Markdown\Markdown;
use Illuminate\Http\Request;
use YuanChao\Editor\EndaEditor;



class PostsController extends Controller{

    protected $markdown;

    public function __construct(Markdown $markdown)
    {
        $this->middleware('auth',['only'=>['create','store','edit','update']]);
        $this->markdown = $markdown;
    }
    public function upload()
    {
        $data = EndaEditor::uploadImgFile('endaEdit');

        return json_encode($data);
    }

    public function index(){
        $discussions = Discussion::latest()->get();//最新发布置顶
        return view('index',compact('discussions'));
    }
    public function edit($id)
    {
        $discussion = Discussion::findOrFail($id);//find和fail，找到或者没有找到
        if(\Auth::user()->id !== $discussion->user_id){
            return redirect('/index');
        }
        return view('edit',compact('discussion'));
    }

    public function show($id){
        $discussion = Discussion::findorfail($id);
        $comments = Comment::where('discussion_id',$id)->with('user')->get();
        $html = $this->markdown->markdown($discussion->body);
        return view('show',compact('discussion','html','comments'));
    }
    public function create()
    {
        return view('create');
    }
    public function update(StoreBlogRequest $request,$id)
    {
        $discussion = Discussion::findOrFail($id);

        $discussion->update($request->all());
        return redirect()->action('PostsController@show',['id'=>$discussion->id]);
    }

    public function store(StoreBlogRequest $request)
    {
        $data = [
            'user_id'=>\Auth::user()->id,
            'last_user_id'=>\Auth::user()->id,
        ];
        $discussion = Discussion::create(array_merge($request->all(),$data));
        return redirect()->action('PostsController@show',['id'=>$discussion->id]);
    }
}