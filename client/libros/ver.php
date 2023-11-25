<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/jpg" href="/favicon.png" />
</head>

<body>
    <?php include __DIR__ . '/../includes/nav.html' ?>
    <h1></h1>
    <p id="generos"></p>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "http://localhost:8080/book/<?= $_GET['id'] ?>",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    generos = 'Sin géneros'
                    if (response.data.book.genres.length > 0) {
                        enlaces = [];
                        response.data.book.genres.forEach(function(genero) {
                            enlaces.push('<a href="http://localhost:8081/generos/ver.php?id=' + genero.id + '">' + genero.name + '</a>');
                        });
                        generos = enlaces.join(', ');
                    }
                    $('h1').text(response.data.book.title);
                    $('#generos').html('Géneros: ' + generos);
                },
                error: function(response) {
                    alert(response.responseJSON.error);
                },
            });
        });
    </script>
</body>

</html>