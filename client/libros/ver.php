<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/jpg" href="/favicon.png" />
</head>

<body>
    <h1></h1>
    <ul id="generos"></ul>
    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cupiditate cum nam voluptate quidem, facilis ratione natus saepe, omnis provident unde soluta hic voluptatum tempore odio ea impedit dolore reprehenderit! Nesciunt?</p>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "http://localhost:8080/book/<?= $_GET['id'] ?>",
                type: "GET",
                dataType: "json",
                statusCode: {
                    500: function() {
                        if (response.responseJSON.error) {
                            console.log(response.responseJSON.error);
                        }
                        alert('Error en el servidor');
                        window.location.href = 'http://localhost:8081/generos/listar.php';
                    },
                    404: function() {
                        if (response.responseJSON.error) {
                            console.log(response.responseJSON.error);
                        }
                        alert('Género no encontrado');
                        window.location.href = 'http://localhost:8081/generos/listar.php';
                    },
                    200: function(response) {
                        $('#titulo').val(response.data.book.title);
                        $('#generos').html(response.data.book.genres.map(genre => `<li><a href="http://localhost:8081/generos/ver.php?id=${genre.id}">${genre.name}</a></li>`).join(''));
                        $('#formulario_modificar_libro').show();
                        $('#titulo').focus().val($('#titulo').val());
                        $('h1').text(response.data.book.title);
                    }
                },
            });
        });
    </script>
</body>

</html>