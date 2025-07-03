<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::with('reviews')->active()->get();
        return response()->json($restaurants);
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
        $restaurant = Restaurant::create($data);
        
        return response()->json(['success' => true, 'data' => $restaurant], 201);
    }

    public function show($id)
    {
        $restaurant = Restaurant::with('reviews.user')->find($id);
        
        if (!$restaurant) {
            return response()->json(['error' => 'Restaurante no encontrado'], 404);
        }
        
        return response()->json($restaurant);
    }

    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::find($id);
        
        if (!$restaurant) {
            return response()->json(['error' => 'Restaurante no encontrado'], 404);
        }
        
        if (auth()->id() !== $restaurant->user_id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }
        
        $data = $request->validate([
            'name' => 'required|min:3',
            'address' => 'required',
            'phone' => 'nullable',
            'description' => 'nullable'
        ]);
        
        $restaurant->update($data);
        
        return response()->json(['success' => true, 'data' => $restaurant]);
    }

    public function destroy($id)
    {
        $restaurant = Restaurant::find($id);
        
        if (!$restaurant) {
            return response()->json(['error' => 'Restaurante no encontrado'], 404);
        }
        
        if (auth()->id() !== $restaurant->user_id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }
        
        $restaurant->delete();
        
        return response()->json(['success' => true, 'message' => 'Restaurante eliminado']);
    }
}