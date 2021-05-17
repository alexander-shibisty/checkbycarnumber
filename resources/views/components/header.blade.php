<div class="col-sm">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{route('index')}}">Ukr-stat</a>
            <button class="navbar-toggler" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navbarNav" 
                aria-controls="navbarNav" 
                aria-expanded="false" 
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link{{$routeName === 'index' ? ' active' : ''}}" aria-current="page" href="{{route('index')}}">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{$routeName === 'numbers' ? ' active' : ''}}" href="{{route('numbers')}}">База номеров</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link{{$routeName === 'numbers' ? ' active' : ''}}" href="{{route('numbers')}}">Легковые</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{$routeName === 'numbers' ? ' active' : ''}}" href="{{route('numbers')}}">Грузовые</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{$routeName === 'numbers' ? ' active' : ''}}" href="{{route('numbers')}}">Мото</a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>
</div>
