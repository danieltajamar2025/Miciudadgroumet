@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1>{{ $restaurant->name }}</h1>
        <p><strong>Dirección:</strong> {{ $restaurant->address }}</p>
        @if($restaurant->phone)
            <p><strong>Teléfono:</strong> {{ $restaurant->phone }}</p>
        @endif
        @if($restaurant->description)
            <p><strong>Descripción:</strong> {{ $restaurant->description }}</p>
        @endif
        
        @auth
            @if(auth()->id() === $restaurant->user_id)
                <div class="mb-3">
                    <a href="{{ route('restaurants.edit', $restaurant) }}" class="btn btn-warning">Editar</a>
                    <form method="POST" action="{{ route('restaurants.destroy', $restaurant) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <h3>Reseñas</h3>
        
        @auth
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Agregar Reseña</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('reviews.store', $restaurant) }}">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="rating" class="form-label">Calificación *</label>
                            <select class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating" required>
                                <option value="">Selecciona una calificación</option>
                                <option value="1">⭐ 1 estrella</option>
                                <option value="2">⭐⭐ 2 estrellas</option>
                                <option value="3">⭐⭐⭐ 3 estrellas</option>
                                <option value="4">⭐⭐⭐⭐ 4 estrellas</option>
                                <option value="5">⭐⭐⭐⭐⭐ 5 estrellas</option>
                            </select>
                            @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="comment" class="form-label">Comentario</label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" 
                                      id="comment" name="comment" rows="3" 
                                      placeholder="Comparte tu experiencia...">{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Enviar Reseña</button>
                    </form>
                </div>
            </div>
        @endauth
        
        @forelse($restaurant->reviews as $review)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>{{ $review->user->name }}</strong>
                            <div>
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        ⭐
                                    @else
                                        ☆
                                    @endif
                                @endfor
                            </div>
                        </div>
                        @auth
                            @if(auth()->id() === $review->user_id)
                                <form method="POST" action="{{ route('reviews.destroy', $review) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('¿Eliminar reseña?')">Eliminar</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                    @if($review->comment)
                        <p class="mt-2">{{ $review->comment }}</p>
                    @endif
                    <small class="text-muted">{{ $review->created_at->format('d/m/Y') }}</small>
                </div>
            </div>
        @empty
            <p>No hay reseñas aún.</p>
        @endforelse
    </div>
</div>
@endsection