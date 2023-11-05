<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/jpg" href="/favicon.png" />
</head>

<body>
    <h1>Editar libro</h1>

    <form id="formulario_editar_libro" style="display: none;">
        <table>
            <tbody>
                <tr>
                    <td>Título</td>
                    <td><input type="text" id="titulo" name="titulo"></td>
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
            $.ajax({
                url: "http://localhost:8080/book/<?= $_GET['id'] ?>",
                type: "GET",
                dataType: "json",
                statusCode: {
                    500: function() {
                        alert('Error en el servidor');
                        window.location.href = 'http://localhost:8081/generos/listar.php';
                    },
                    404: function() {
                        alert('Género no encontrado');
                        window.location.href = 'http://localhost:8081/generos/listar.php';
                    },
                    200: function(response) {
                        $('#titulo').val(response.data.book.title);
                        $('#formulario_editar_libro').show();
                        $('#titulo').focus().val($('#titulo').val());
                    }
                },
            });

            $('#formulario_editar_libro').submit(function(event) {
                event.preventDefault();
                $.ajax({
                        url: "http://localhost:8080/book/<?= $_GET['id'] ?>",
                        type: "PUT",
                        dataType: "json",
                        data: {
                            title: $('#titulo').val()
                        }
                    })
                    .done(function(data, textStatus, jqXHR) {
                        alert('Libro actualizado');
                        window.location.href = 'http://localhost:8081/libros/listar.php';
                    })
            });
        });
    </script>
</body>

</html>