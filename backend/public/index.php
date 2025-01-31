<?php
require_once __DIR__ . '/../config/db.php'; // Eloquent kapcsolat
require_once __DIR__ . '/../controllers/MovieController.php';

$controller = new MovieController();
$search = $_GET['q'] ?? null;
$currentPage = $_GET['page'] ?? null;
$movies = $controller->index($currentPage, $search);

// var_dump($movies);
// die;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Rental</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/assets/css/custom.css" rel="stylesheet">
</head>

<body>
    <header class="bg-primary text-white">
        <div>
            <nav class="navbar navbar-expand-md navbar-dark bg-dark">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="navbar-nav me-auto mb-2 mb-md-0">
                            <li class="nav-item">
                                <a class="nav-link" href="/public/index.php?page=1">Főoldal</a>
                            </li>
                        </ul>
                        <form class="d-flex" action="/public/index.php?page=1" method="GET">
                            <input class="form-control me-2" type="text" name="q" placeholder="Film keresés..."
                                aria-label="Search" value="<?= $_GET['q'] ?? ''; ?>">
                            <button class="btn btn-outline-success" type="submit">Keresés</button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <div class="container mt-4">

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['errors']) && is_array($_SESSION['errors'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?= $error; ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>


        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cím</th>
                    <th>Műfaj</th>
                    <th>Megjelenési év</th>
                    <th>Értékelés</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movies as $movie): ?>
                    <tr class="<?= $movie->is_rented ? 'bg-danger' : ''; ?>">
                        <td><?= $movie->id; ?></td>
                        <td><?= $movie->title; ?></td>
                        <td><?= $movie->genre; ?></td>
                        <td><?= $movie->release_year; ?></td>
                        <td><?= $movie->rating; ?></td>
                        <td class="text-center">
                            <?php if ($movie->is_rented): ?>
                                <button type="button" class="btn btn-info return-movie-btn" data-bs-toggle="modal"
                                    data-bs-target="#returnMovieModal" data-movie-id="<?= $movie->id; ?>">
                                    Vissza adás
                                </button>
                            <?php else: ?>
                                <button type="button" class="btn btn-success rent-movie-btn" data-bs-toggle="modal"
                                    data-bs-target="#rentMovieModal" data-movie-id="<?= $movie->id; ?>">
                                    Foglalás
                                </button>
                            <?php endif; ?>

                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

        <!-- Oldalszámozás linkjei -->
        <div class="d-flex justify-content-center">
            <nav>
                <ul class="pagination">
                    <!-- Első oldal -->
                    <li class="page-item">
                        <a class="page-link"
                            href="?page=1<?= isset($search) ? '&q=' . urlencode($search) : '' ?>">Első</a>
                    </li>

                    <!-- Előző oldal -->
                    <li class="page-item ">
                        <a class="page-link"
                            href="<?= ($currentPage > 1) ? '?page=' . ($currentPage - 1) . (isset($search) ? '&q=' . urlencode($search) : '') : '#' ?>">‹</a>
                    </li>

                    <!-- Következő oldal -->
                    <li class="page-item">
                        <a class="page-link"
                            href="<?= ($currentPage < 2) ? '?page=' . ($currentPage + 1) . (isset($search) ? '&q=' . urlencode($search) : '') : '#' ?>">›</a>
                    </li>

                    <!-- Utolsó oldal -->
                    <li class="page-item">
                        <a class="page-link"
                            href="?page=<?= $totalPages ?><?= isset($search) ? '&q=' . urlencode($search) : '' ?>">Utolsó</a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>


    <!-- Rent Modal -->
    <div class="modal fade" id="rentMovieModal" tabindex="-1" aria-labelledby="movieRentLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/public/rent.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="movieRentLabel">Film kölcsönzése</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Film ID -->
                        <input type="hidden" name="movie_id" id="movie_id">

                        <!-- Foglaló neve -->
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Foglaló neve</label>
                            <input type="text" name="customer_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Mégse</button>
                        <button type="submit" class="btn btn-success">Kölcsönzés</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Return Modal -->
    <div class="modal fade" id="returnMovieModal" tabindex="-1" aria-labelledby="returnMovieModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/public/return.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="movieRentLabel">Film visszaadása</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Film ID -->
                        <input type="hidden" name="movie_id" id="movie_id">

                        <!-- Foglaló neve -->
                        <div class="mb-3">
                            Biztos, hogy vissza akarod adni a filmet?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Nem</button>
                        <button type="submit" class="btn btn-success">Igen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-3 mt-5">
        <div class="container text-center">
            <p>&copy; <?= date('Y'); ?> Your Company. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS (optional for interactions like modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="/public/assets/js/custom.js"></script>
</body>

</html>