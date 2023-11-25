<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/jpg" href="/favicon.png" />
</head>

<body>
    <?php include __DIR__ . '/../includes/nav.html' ?>

    <h1>Crear libro</h1>

    <form id="formulario_crear_libro">
        <table>
            <tbody>
                <tr>
                    <td>Título</td>
                    <td><input type="text" id="titulo" name="titulo"></td>
                </tr>
                <tr>
                    <td>Géneros</td>
                    <td id="generos">                        
                    </td>
                </tr>
            </tbody>
        </table>
        <p>
            <a href="javascript:history.back()">Volver</a>
            <input type="submit" value="Guardar">
        </p>
    </form>
    
    <script>
        $(document).ready(function() {
            $('#titulo').focus();
            $.ajax({
                url: "http://localhost:8080/genre",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.data.total == 0) {
                        $('#generos').append('No hay géneros');
                    } else {
                        response.data.genres.forEach(function(genero) {
                            $('#generos').append('<input type="checkbox" name="generos[]" value="' + genero.id + '"> ' + genero.name + '<br>');
                        });
                    }
                },
                error: function(response) {
                    alert(response.responseJSON.error);
                },
            });
            $('#formulario_crear_libro').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: "http://localhost:8080/book",
                    type: "POST",
                    dataType: "json",
                    data: {
                        title: $('#titulo').val(),
                        genres: $('input[name="generos[]"]:checked').map(function() {
                            return $(this).val();
                        }).get()
                    },
                    success: function(response) {
                        alert('Libro creado');
                        window.location.href = 'http://localhost:8081/libros/listar.php';
                    },
                    error: function(response) {
                        alert(response.responseJSON.error);
                    },
                });
            });
        });
    </script>
</body>

</html>