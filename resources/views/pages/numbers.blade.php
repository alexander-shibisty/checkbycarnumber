@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-9">
            <h1>Полная база номеров</h1>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Номер</th>
                        <th>Производитель</th>
                        <th>Параметры</th>
                        <th>Цвет</th>
                        <th>Кузов</th>
                        <th>Регистрация</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cars as $key => $car)
                    <tr>
                        <td><a href="{{route('number', ['slug' => $car->slug ? $car->slug : '0'])}}">{{(string)(($page * $limit - $limit) + ($key + 1))}}</a></td>
                        <td><a href="{{route('number', ['slug' => $car->slug ? $car->slug : '0'])}}">{{$car->number}}</a></td>
                        <td><a href="{{route('number', ['slug' => $car->slug ? $car->slug : '0'])}}">
                            {{mb_convert_case(mb_strtolower($car->manufacturer->name, 'UTF-8'), MB_CASE_TITLE, 'UTF-8')}}<br>
                            {{$car->model->name}}
                        </a></td>
                        <td><a href="{{route('number', ['slug' => $car->slug ? $car->slug : '0'])}}">
                            {{$car->own_weight}} кг.<br>
                            @if($car->capacity)
                                {{$car->capacity}} л/куб
                            @endif
                        </a></td>
                        <td><a href="{{route('number', ['slug' => $car->slug ? $car->slug : '0'])}}">{{mb_convert_case(mb_strtolower($car->color->name, 'UTF-8'), MB_CASE_TITLE, 'UTF-8')}}</a></td>
                        <td><a href="{{route('number', ['slug' => $car->slug ? $car->slug : '0'])}}">
                            {{mb_convert_case(mb_strtolower($car->type->name, 'UTF-8'), MB_CASE_TITLE, 'UTF-8')}}<br>
                            {{mb_convert_case(mb_strtolower($car->body->name, 'UTF-8'), MB_CASE_TITLE, 'UTF-8')}}
                        </a></td>
                        <td><a href="{{route('number', ['slug' => $car->slug ? $car->slug : '0'])}}">{{date('Y-m-d', $car->operation_date)}}</a></td>
                    <tr>
                    @endforeach
                </tbody>
            </table>
            {{$cars->render()}}
        </div>
        <div class="col-sm-3">
            <table class="table table-striped table-hover">
                <tbody>
                    @foreach($fuels as $key => $fuel)
                    <tr>
                        <td>{{(string)($key + 1)}}</td>
                        <td>
                            <a href="#">{{mb_convert_case(mb_strtolower($fuel->name, 'UTF-8'), MB_CASE_TITLE, 'UTF-8')}}</a>
                        </td>
                    <tr>
                    @endforeach
                </tbody>
            </table>

            <table class="table table-striped table-hover">
                <tbody>
                    @foreach($colors as $key => $color)
                    <tr>
                        <td>{{(string)($key + 1)}}</td>
                        <td>
                            <a href="#">{{mb_convert_case(mb_strtolower($color->name, 'UTF-8'), MB_CASE_TITLE, 'UTF-8')}}</a>
                        </td>
                    <tr>
                    @endforeach
                </tbody>
            </table>

            <table class="table table-striped table-hover">
                <tbody>
                    @foreach($types as $key => $type)
                    <tr>
                        <td>{{(string)($key + 1)}}</td>
                        <td>
                            <a href="#">{{mb_convert_case(mb_strtolower($type->name, 'UTF-8'), MB_CASE_TITLE, 'UTF-8')}}</a>
                        </td>
                    <tr>
                    @endforeach
                </tbody>
            </table>

            <table class="table table-striped table-hover">
                <tbody>
                    @foreach($purposes as $key => $purpose)
                    <tr>
                        <td>{{(string)($key + 1)}}</td>
                        <td>
                            <a href="#">{{mb_convert_case(mb_strtolower($purpose->name, 'UTF-8'), MB_CASE_TITLE, 'UTF-8')}}</a>
                        </td>
                    <tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    @include('components.footer')
@endsection
