@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1>Авто {{$car->type->name}} {{$car->body->name}} {{$car->number}} {{$car->color->name}}</h1>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fields as $key => $field)
                    <tr>
                        <td>{{$field}}</td>
                        <td>{{ is_object($car->$key) ? $car->$key->name : $car->$key }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <footer class="card">
            <div class="card-body">
                <p class="card-text">
                    Полная доступная информация об транспортном средстве гос. номер 
                    {{$car->number}} марки {{$car->manufacturer->name}} модели {{$car->model->name}}.
                </p>
            </div>
        </footer>
    </div>
    @include('components.footer')
@endsection
