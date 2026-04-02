<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function reserve(Request $request, Book $book): JsonResponse
    {
        if (! $book->available) {
            return response()->json([
                'message' => 'This book is not currently available for reservation.',
            ], 409);
        }

        $reservation = DB::transaction(function () use ($request, $book): Reservation {
            $book->update(['available' => false]);

            return Reservation::create([
                'user_id'     => $request->user()->id,
                'book_id'     => $book->id,
                'reserved_at' => now(),
                'returned_at' => null,
            ]);
        });

        $reservation->load('book');

        return response()->json([
            'message' => 'Book reserved successfully.',
            'data'    => $reservation,
        ], 201);
    }

    public function myReservations(Request $request): JsonResponse
    {
        $reservations = Reservation::with('book')
            ->where('user_id', $request->user()->id)
            ->latest('reserved_at')
            ->get();

        return response()->json(['data' => $reservations]);
    }
}
