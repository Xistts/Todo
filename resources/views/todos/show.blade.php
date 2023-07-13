@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Список') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                     <a href="{{ url()->previous() }}" class="btn btn-sm btn-info">Назад</a><br>
                    <b>Название: </b> {{ $todo->title}}<br>
                    <b>Описание: </b> {{ $todo->description}}<br>
                    <b>Теги: </b> 
                                @foreach(explode(",",$todo->keywords) as $tag)
                                    <label class="inner btn-sm btn-info">{{ $tag }}</label>
                                 @endforeach<br>
                    <img src="/images/origin/{{ $todo->image }}">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
