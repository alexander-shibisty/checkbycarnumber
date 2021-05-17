@extends('layouts.main')

@section('content')
<div class="row">

    @foreach($manufacturers as $manufacturer)
    <div class="col-4">
        <div class="p-3 border bg-light">{{$manufacturer->name}}</div>
    </div>
    @endforeach
    
<!-- 
    <div class="col-sm-9">
        <div class="row">
            <div class="col-sm-4">
                <h4>Общая</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Стат.</th>
                            <th scope="col">Кол-во</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Всего операций</td>
                            <td>0</td>
                        <tr>
                        <tr>
                            <td>Всего номеров</td>
                            <td>0</td>
                        <tr>
                        <tr>
                            <td>Всего автомобилей</td>
                            <td>0</td>
                        <tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <h4>По годам</h4>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Стат.</th>
                    <th scope="col">Кол-во</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Всего операций</td>
                    <td>0</td>
                <tr>
                <tr>
                    <td>Всего номеров</td>
                    <td>0</td>
                <tr>
                <tr>
                    <td>Всего автомобилей</td>
                    <td>0</td>
                <tr>
            </tbody>
        </table>
    </div> -->
</div>

<div class="row">
    <footer class="card">
        <h5 class="card-header">Об Ukr-stat</h5>
        <div class="card-body">
            <p class="card-text">
                Цель нашего сайта сделать данные об автомобилях доступнее для каждого.
            </p>
        </div>
    </footer>

    <footer class="copygirht">
        <a href="https://www.linkedin.com/in/alexander-shibisty-497767163/">Made by Alexander Shibisty</a><br>
        <span>{{date('Y-m-d')}}</span>
    </footer>
</div>
@endsection
