@extends('control')

@section('user')
    <user></user>
@endsection()

@section('content')
    <div class="row content">
        <div class="col-md-12 title">
            <div class="panel panel-default">
                <h1>Новое блюдо</h1>
            </div>
        </div>

        <div class="form-add">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif()

            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    Данные заполнены некоректно
                </div>
            @endif()

            <form action="/store/food" method="POST" enctype="multipart/form-data">
                {{ method_field('POST') }}
                {{ csrf_field() }}

                <div class="form-group">
                    <input type="text" name="name" id="name" placeholder="Название" class="form-control">
                </div>

                <div class="form-group">
                    <select name="category" id="category" class="form-control">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach()
                    </select>
                </div>

                <div class="form-group">
                    <input type="text" name="price" id="price" placeholder="Цена" class="form-control">
                </div>

                <div class="form-group">
                    <input type="text" name="protein" id="protein" placeholder="Белки" class="form-control structure-food">
                </div>

                <div class="form-group">
                    <input type="text" name="fat" id="fat" placeholder="Жиры" class="form-control structure-food">
                </div>

                <div class="form-group">
                    <input type="text" name="carbohydrates" id="carbohydrates" placeholder="Углеводы" class="form-control structure-food">
                </div>

                <div class="form-group">
                    <input type="text" name="calories" id="calories" placeholder="Калории" class="form-control structure-food">
                </div>

                <div class="form-group">
                    <input type="text" name="weight" id="weight" placeholder="Вес" class="form-control structure-food">
                </div>

                <div class="form-group">
                    <textarea name="structure" id="structure" class="form-control" cols="30" rows="10" placeholder="Описание"></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Фото</label>
                    <div class="preview-image">
                        <input id="image" type="file" class="form-control" name="image">
                        <img src="#" id="onload-image" width="60px" />
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" value="Добавить" class="btn btn-default">
                </div>
            </form>
        </div>
    </div>
@endsection()