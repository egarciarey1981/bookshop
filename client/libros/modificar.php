<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/jpg" href="/favicon.png" />
</head>

<body>
    <h1>Editar libro</h1>

    <form id="formulario_modificar_libro" style="display: none;">
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
                    500: function(response) {
                        alert(response.responseJSON.error);
                    },
                    400: function(response) {
                        alert(response.responseJSON.error);
                    },
                    404: function() {
                        alert('Género no encontrado');
                        window.location.href = 'http://localhost:8081/libros/listar.php';
                    },
                    200: function(response) {
                        $('#titulo').val(response.data.book.title);
                        $('#formulario_modificar_libro').show();
                        $('#titulo').focus().val($('#titulo').val());
                    }
                },
            });

            $('#formulario_modificar_libro').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: "http://localhost:8080/book/<?= $_GET['id'] ?>",
                    type: "PUT",
                    dataType: "json",
                    data: {
                        title: $('#titulo').val()
                    },
                    statusCode: {
                        500: function() {
                            if (response.responseJSON.error) {
                                console.log(response.responseJSON.error);
                            }
                            alert('Error en el servidor');
                            window.location.href = 'http://localhost:8081/libros/listar.php';
                        },
                        400: function() {
                            if (response.responseJSON.error) {
                                console.log(response.responseJSON.error);
                            }
                            alert('Datos incorrectos');
                        },
                        200: function(response) {
                            alert('Libro actualizado');
                            window.location.href = 'http://localhost:8081/libros/listar.php';
                        }
                    }
                })
            });
        });
    </script>
</body>

</html>