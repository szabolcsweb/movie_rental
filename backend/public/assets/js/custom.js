console.log('called');
$(document).ready(function () {
    $(".rent-movie-btn").click(function () {
        const $target = $(this);
        const movieId = $target.data("movie-id");
        $("#rentMovieModal input[name='movie_id']").val(movieId);
    });

    $(".return-movie-btn").click(function () {
        const $target = $(this);
        const movieId = $target.data("movie-id");
        $("#returnMovieModal input[name='movie_id']").val(movieId);
    });
});