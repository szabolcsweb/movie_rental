<?php

require_once __DIR__ . '/../config/db.php'; // Eloquent
require_once __DIR__ . '/../models/Movie.php';
require_once __DIR__ . '/../models/MovieRental.php';

class MovieController
{
    public function index($currentPage = null, $search = null)
    {
        $search = $_GET['q'] ?? '';
        $currentPage = $_GET['page'] ?? 1;
        $perPage = 30;
        $offset = ($currentPage - 1) * $perPage;
        $total = Movie::count();
        $totalPages = ceil($total / $perPage);
        
        // eager load Eloquent-el
        $query = Movie::with('rental');

        if ($search) {
            $query->where('title', 'LIKE', "%{$search}%");
        }

        $movies = $query->orderBy('id', 'asc')
            ->offset($offset)
            ->limit($perPage)
            ->get()
            ->map(function ($movie) {
                // ha nincs reláció (vagyis null), nincs lefoglalva
                $movie->is_rented = $movie->rental !== null ? TRUE : FALSE;
                return $movie;
            });

        return $movies;
    }

    public function rent(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movie_id = $_POST['movie_id'] ?? null;
            $customer_name = $_POST['customer_name'] ?? null;

            if (!$movie_id || !$customer_name) {
                $_SESSION['error'] = "Minden mező kitöltése kötelező!";
            } elseif (MovieRental::where('movie_id', $movie_id)->exists()) {
                $_SESSION['error'] = "Ez a film már foglalt.";
            } else {
                // új kölcsönzés 
                MovieRental::create([
                    'movie_id' => $movie_id,
                    'customer_name' => $customer_name,
                    'rental_date' => date('Y-m-d'),
                    'return_date' => null
                ]);

                $_SESSION['success'] = "Film sikeresen lefoglalva!";
            }

            header("Location: /public/index.php?page=1");
            exit();
        }
    }

    public function return(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movie_id = $_POST['movie_id'] ?? null;

            if ($movie_id && MovieRental::where('movie_id', $movie_id)->exists()) {
                MovieRental::where('movie_id', $movie_id)->delete();
                $_SESSION['success'] = "Film visszahozva!";
            } else {
                $_SESSION['error'] = "Nem található ilyen kölcsönzés.";
            }

            header("Location: /public/index.php?page=1");
            exit();
        }
    }
}
