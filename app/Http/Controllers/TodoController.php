<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseMessage;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(){
        $userId = auth()->user()->id; 
        $todos = Todo::where('id_user', 'like', '%'.$userId.'%')->orWhere('id_user_content', 'like', '%'.$userId.'%')->get();
        return view('todos.index',[
            'todos' => $todos
        ]);
    }
    public function search(Request $request){
        $userId = auth()->user()->id; 
        $tags = [];
        if($request->tags != ''){
            $tags = explode(",", $request->tags);
        }
        $title = $request->title;
        $completed = $request->completed;
        $todos = Todo::Where('id_user', 'like', '%'.$userId.'%')
        ->Where(function ($query) use ($title) {
            if($title != '') {
                $query->Where('title', 'like', $title)->get();
            }
        })->Where(function ($query) use ($completed) {
            if($completed != '') {
                $query->Where('В работе', 'like', $completed)->get();
            }
        })->Where(function ($query) use ($tags) {
            foreach ($tags as $tag) {
                $query->orWhere('keywords', 'like', '%'.$tag.'%')->get();
            }
        })->get();
        // return view('todos.index',[
        //     'todos' => $todos
        // ]);
        return Response::json([
            'success' => true,
            'message' => 'Успешно',
            'data' =>$todos,
        ]);
    }
    public function create(){
        $users = User::all();
        return view('todos.create',[
            'users' => $users
        ]);
    }
    public function store(TodoRequest $request){
        // $request->validated();
        $userId = auth()->user()->id; 
        
        $input = $request->all();
        unset($input['ajax']);
        unset($input['role']);
        $input['id_user'] = $userId;
        if($request->id_user_content == ''){
            $input['id_user_content'] = '';
        }else{
            if($request->role == '' ){
                request()->session()->flash('error', 'Unable to locate the Role');
                return redirect()->route('todos.create')->withErrors([
                    'error' => 'Unable to locate the Role'
                ]);
            }elseif ($request->role == 0) {
                $input['id_user_content'] = $userId.','.$request->id_user_content;
            }elseif ($request->role == 1) {
                $input['id_user'] = $userId.','.$request->id_user_content;
                $input['id_user_content'] = '';
            }
        }
        if ($request->hasfile('image')) {
            $filename = $input['image']->getClientOriginalName();

            //Сохраняем оригинальную картинку
            $input['image']->move('images/origin/',$filename);

            //Создаем миниатюру изображения и сохраняем ее
            $thumbnail = Image::make('images/origin/'.$filename);
            $thumbnail->resize(150, 150);
            $thumbnail->save('images/thumbnail/'.$filename);

            $input['image'] = $filename;
        }else{
            $input['image'] = '';
        }
        $input['is_completed'] = 0;
        $input['keywords'] = str_replace('"', '', $input['keywords']);
        $todo = Todo::create($input);
        $input['id'] = $todo->id;
        $request->session()->flash('alert-success', 'Запись создана успешно');
        if($request->ajax == 'ajax'){
            return Response::json([
                'success' => true,
                'message' => 'Задача создана',
                'data' => $input,
            ]);
        }
        return redirect()->route('todos.index');
    }
    public function show($id){
        $todo = Todo::find($id);
        if(!$todo){
            request()->session()->flash('error', 'Unable to locate the Todo');
            return redirect()->route('todos.index')->withErrors([
                'error' => 'Unable to locate the Todo'
            ]);
        }
        return view('todos.show', ['todo'=>$todo]);
    }
    public function edit($id){
        $todo = Todo::find($id);
        $users = User::all();
        if(!$todo){
            request()->session()->flash('error', 'Unable to locate the Todo');
            return redirect()->route('todos.index')->withErrors([
                'error' => 'Unable to locate the Todo'
            ]);
        }
        return view('todos.edit', ['todo'=>$todo, 'users'=>$users]);
    }

    public function update(Request $request){
        $userId = auth()->user()->id; 
        
        $todo = Todo::find($request->todo_id);
        if(!$todo){
            request()->session()->flash('error', 'Unable to locate the Todo');
            return redirect()->route('todos.index')->withErrors([
                'error' => 'Unable to locate the Todo'
            ]);
        }
        $input = $request->all();
        unset($input['ajax']);
        $input['id_user'] = $userId;
        if ($request->hasfile('image')) {
            $filename = $input['image']->getClientOriginalName();

            //Сохраняем оригинальную картинку
            $input['image']->move('images/origin/',$filename);

            //Создаем миниатюру изображения и сохраняем ее
            $thumbnail = Image::make('images/origin/'.$filename);
            $thumbnail->resize(150, 150);
            $thumbnail->save('images/thumbnail/'.$filename);

            //Сохраняем в БД
            $input['image'] = $filename;
        }

        $todo->update($input);

        $request->session()->flash('alert-info', 'Запись обновлена успешно');
        if($request->ajax == 'ajax'){
            return Response::json([
                'success' => true,
                'message' => 'Запись обновлена успешно',
                'data' => $input,
            ]);
        }
        return redirect()->route('todos.index');
    }
    public function destroy(Request $request){
        $todo = Todo::find($request->todo_id);
        if(!$todo){
            request()->session()->flash('error', 'Unable to locate the Todo');
            return redirect()->route('todos.index')->withErrors([
                'error' => 'Unable to locate the Todo'
            ]);
        }

        $todo->delete();
        $request->session()->flash('alert-success', 'Todo Deleted Successfully');
        if($request->ajax == 'ajax'){
            return Response::json([
                'success' => true,
                'message' => 'Запись удалена успешно',
            ]);
        }
        return redirect()->route('todos.index');
    }
}
