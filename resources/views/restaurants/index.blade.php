@extends('layouts.app')

@section('content')
<h1>Directorio de Restaurantes</h1>

@auth
    <a href="{{ route('restaurants.create') }}" class="btn btn-primary mb-3">Agregar Restaurante</a>
@endauth

<div class="row">
    @forelse($restaurants as $restaurant)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $restaurant->name }}</h5>
                    <p class="card-text">{{ $restaurant->address }}</p>
                    @if($restaurant->phone)
                        <p class="card-text"><small>📞 {{ $restaurant->phone }}</small></p>
                    @endif
                    
                    <a href="{{ route('restaurants.show', $restaurant) }}" class="btn btn-primary">Ver Detalles</a>
                    
                    @auth
                        @if(auth()->id() === $restaurant->user_id)
                            <a href="{{ route('restaurants.edit', $restaurant) }}" class="btn btn-warning btn-sm">Editar</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <p class="text-center">No hay restaurantes registrados.</p>
        </div>
    @endforelse
</div>
@endsection