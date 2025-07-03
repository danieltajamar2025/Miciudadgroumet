<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Restaurant $restaurant)
    {
        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500'
        ]);

        $data['user_id'] = auth()->id();
        $data['restaurant_id'] = $restaurant->id;

        Review::create($data);

        return redirect()->route('restaurants.show', $restaurant)->with('success', 'Reseña agregada');
    }

    public function destroy(Review $review)
    {
        if (auth()->id() !== $review->user_id) {
            abort(403);
        }

        $restaurant = $review->restaurant;
        $review->delete();

        return redirect()->route('restaurants.show', $restaurant)->with('success', 'Reseña eliminada');
    }
}