@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1>{{ isset($restaurant) ? 'Editar Restaurante' : 'Crear Restaurante' }}</h1>
        
        <form method="POST" action="{{ isset($restaurant) ? route('restaurants.update', $restaurant) : route('restaurants.store') }}">
            @csrf
            @if(isset($restaurant))
                @method('PUT')
            @endif
            
            <div class="form-group mb-3">
                <label for="name" class="form-label">Nombre *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $restaurant->name ?? '') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group mb-3">
                <label for="address" class="form-label">Dirección *</label>
                <textarea class="form-control @error('address') is-invalid @enderror" 
                          id="address" name="address" rows="3" required>{{ old('address', $restaurant->address ?? '') }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group mb-3">
                <label for="phone" class="form-label">Teléfono</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                       id="phone" name="phone" value="{{ old('phone', $restaurant->phone ?? '') }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="4">{{ old('description', $restaurant->description ?? '') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">
                {{ isset($restaurant) ? 'Actualizar' : 'Crear' }} Restaurante
            </button>
            <a href="{{ route('restaurants.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection