@extends('layouts.app')
@section('styles')
<style>
   #outer{
      width: auto;
      text-align: center;
   }
   .inner{
      display: inline-block;
   }
</style>
@endsection
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-4">
      
   </div>
   <div class="col-md-8">
      <div class="card">
         <div class="card-header">{{ __('Список') }} <a class="btn btn-sm btn-info float-end" href="{{ route('todos.create' )}}">Создать задачу</a></div>
         <div class="card-header">     
            <div class="filter-container">
               <h2>Фильтр</h2>
               <form class="row">
                     @csrf
                     <input name="user_id" type="hidden" class="form-control" value="{{ auth()->user()->id }}">
                     <div class="col-md-3">
                        <label for="">Поиск по названию</label>
                        <input name="title" type="text" class="form-control" >
                     </div>

                     <div class="col-md-2">
                        <label for="">Завершено</label>
                        <select name="завершено" class="form-control" >
                           <option value="">Выберите</option>
                           <option value="1">завершено</option>
                           <option value="0">В завершении</option>
                        </select>
                     </div>

                     <div class="col-md-3">
                        <label for="">Теги</label>
                        <input name="tags" type="text" class="form-control" >
                     </div>

                     <div class="col-md-2" style="display: flex;align-items: flex-end;" >
                        <div>
                           <button type="submit" class="btn btn-primary" >Фильтр</button>
                        </div>
                     </div>
               </form>
            </div>
         </div>

         <div id="table" class="card-body">
               
                  

                     <table class="table">
                        <thead>
                           <tr>
                              <th>Название</th>
                              <th>Описание</th>
                              <th>Изображение</th>
                              <th>Теги</th>
                              <th>Завершено</th>
                              <th>Действия</th>
                           </tr>
                        </thead>
                        <tbody>
                        @if (count($todos)>0)
                           @foreach ($todos as $todo)
                           <tr id="{{ $todo->id}}">
                              <td>{{ $todo->title }}</td>
                              <td>{{ $todo->description }}</td>
                              <td>
                                 @if($todo->image != '' )
                                    @if(in_array( auth()->user()->id , explode(",",$todo->id_user) ) )
                                       <a class="" href="{{ route('todos.edit', $todo->id)}}"><img src="/images/thumbnail/{{ $todo->image }}" width="150px"></a>
                                    @else
                                       <img src="/images/thumbnail/{{ $todo->image }}" width="150px">
                                    @endif
                                 @endif
                              </td>
                              <td id="outer">
                                 @foreach(explode(",",$todo->keywords) as $tag)
                                    <label class="inner btn-sm btn-info">{{ $tag }}</label>
                                 @endforeach
                              </td>
                              <td id="completed-{{ $todo->id}}">
                                 @if($todo->is_completed == 1 )
                                    <a class="btn btn-sm btn-success" 
                                          id="btn-completed"
                                       data-completed="0" data-id="{{ $todo->id}}">Завершено</a>
                                 @else
                                    <a class="btn btn-sm btn-danger" 
                                          id="btn-completed"
                                        data-completed="1" data-id="{{ $todo->id}}">В Работе</a>
                                 @endif
                              </td>
                              <td id="outer">
                                 <a class="inner btn btn-sm btn-success" href="{{ route('todos.show', $todo->id)}}">Посмотреть</a>
                                 @if(in_array( auth()->user()->id , explode(",",$todo->id_user) ) )
                                 <a class="inner btn btn-sm btn-info" href="{{ route('todos.edit', $todo->id)}}">Редактировать</a>
                                 <form class="inner">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="todo_id" value="{{ $todo->id}}">
                                    <input id="btn-delete" type="submit" class="btn btn-sm btn-danger" value="Удалить">
                                 </form>
                                 @endif
                              </td>
                           </tr>
                           @endforeach
                        @endif
                        </tbody>
                     </table>
                  
            </div>
      </div>
   </div>
</div>
@endsection
