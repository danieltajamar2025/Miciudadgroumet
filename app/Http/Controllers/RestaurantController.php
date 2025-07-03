<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::with('reviews')->active()->get();
        return view('restaurants.index', compact('restaurants'));
    }

    public function show(Restaurant $restaurant)
    {
        $restaurant->load('reviews.user');
        return view('restaurants.show', compact('restaurant'));
    }

    public function create()
    {
        return view('restaurants.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3',
            'address' => 'required',
            'phone' => 'nullable',
            'description' => 'nullable'
        ]);
        
        $data['user_id'] = auth()->id();
        Restaurant::create($data);
        
        return redirect()->route('restaurants.index')->with('success', 'Restaurante creado');
    }

    public function edit(Restaurant $restaurant)
    {
        if (auth()->id() !== $restaurant->user_id) {
            abort(403);
        }
        return view('restaurants.form', compact('restaurant'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        if (auth()->id() !== $restaurant->user_id) {
            abort(403);
        }
        
        $data = $request->validate([
            'name' => 'required|min:3',
            'address' => 'required',
            'phone' => 'nullable',
            'description' => 'nullable'
        ]);
        
        $restaurant->update($data);
        
        return redirect()->route('restaurants.show', $restaurant)->with('success', 'Restaurante actualizado');
    }

    public function destroy(Restaurant $restaurant)
    {
        if (auth()->id() !== $restaurant->user_id) {
            abort(403);
        }
        
        $restaurant->delete();
        
        return redirect()->route('restaurants.index')->with('success', 'Restaurante eliminado');
    }
}