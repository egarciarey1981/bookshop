<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/jpg" href="/favicon.png" />
</head>

<body>
    <?php include __DIR__ . '/../includes/nav.html' ?>

    <h1></h1>
    <p id="number_of_books"></p>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "http://localhost:8080/genre/<?= $_GET['id'] ?>",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    $('h1').text(response.data.genre.name);
                    $('#number_of_books').text("Books: " + response.data.genre.number_of_books);
                },
                error: function(response) {
                    if (response.status == 404)
                        alert("Género no encontrado");
                    else if (response.status == 500)
                        alert("Error interno del servidor");
                    else
                        alert("Error desconocido");
                }
            });
        });
    </script>
</body>

</html>