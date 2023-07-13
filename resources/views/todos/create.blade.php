@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Создание задачи</div>

                <div class="card-body">

                @if ($errors->any())
                  <div class="alert alert-danger">
                     <ul>
                           @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                           @endforeach
                     </ul>
                  </div>
               @endif

                <form method="post" action="{{ route('todos.store')}}" enctype="multipart/form-data">
                  @csrf
                  <div class="mb-3">
                     <label class="form-label">Название</label>
                     <input type="text" name="title" class="form-control" >
                  </div>
                  <div class="mb-3">
                     <label class="form-label">Описания</label>
                     <textarea name="description" class="form-control" cols="5" rows="5"></textarea>
                  </div>
                  <div class="mb-3 form-group">
                        <label class="form-label">Теги</label>
                        <input type="text" name="keywords" class="form-control" data-role="tagsinput">
                  </div>
                  <div class="mb-3 form-group">
                        <label class="form-label">Пользователи</label>
                        <select name="id_user_content" class="form-control" multiple>
                           @foreach ($users as $user)
                           @if($user->id != auth()->user()->id)
                              <option value="{{ $user->id }}">{{ $user->name }}</option>
                           @endif
                           @endforeach
                        </select>
                  </div>
                  <div class="mb-3 form-group">
                        <label class="form-label">Роли пользователей</label>
                        <select name="role" class="form-control">
                              <option value="">Выбрать роль</option>
                              <option value="0">Чтение</option>
                              <option value="1">Редактирование</option>
                        </select>
                  </div>
                  <div class="mb-3">
                     <strong>Image:</strong>
                     <input type="file" name="image" class="form-control" accept="image/png, image/jpeg, image/jpg" placeholder="image">
                  </div>
                  <button type="submit" class="btn btn-primary">Подтвердить</button>
               </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
