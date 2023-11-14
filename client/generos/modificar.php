<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/jpg" href="/favicon.png" />
</head>

<body>
    <h1>Editar género</h1>

    <form id="formulario_modificar_genero" style="display: none;">
        <table>
            <tbody>
                <tr>
                    <td>Nombre</td>
                    <td><input type="text" id="nombre" name="nombre"></td>
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
                url: "http://localhost:8080/genre/<?= $_GET['id'] ?>",
                type: "GET",
                dataType: "json",
                statusCode: {
                    500: function(response) {
                        alert(response.responseJSON.error);
                    },
                    400: function(response) {
                        alert(response.responseJSON.error);
                    },
                    404: function(response) {
                        alert('Género no encontrado');
                        window.location.href = 'http://localhost:8081/generos/listar.php';
                    },
                    200: function(response) {
                        $('#nombre').val(response.data.genre.name);
                        $('#formulario_modificar_genero').show();
                        $('#nombre').focus().val($('#nombre').val());
                    }
                },
            });

            $('#formulario_modificar_genero').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: "http://localhost:8080/genre/<?= $_GET['id'] ?>",
                    type: "PUT",
                    dataType: "json",
                    data: {
                        name: $('#nombre').val()
                    },
                    statusCode: {
                        500: function(response) {
                            if (response.responseJSON.error) {
                                console.log(response.responseJSON.error);
                            }
                            alert('Error en el servidor');
                            window.location.href = 'http://localhost:8081/generos/listar.php';
                        },
                        400: function() {
                            if (response.responseJSON.error) {
                                console.log(response.responseJSON.error);
                            }
                            alert('Datos incorrectos');
                        },
                        200: function(response) {
                            alert('Género modificado correctamente');
                            window.location.href = 'http://localhost:8081/generos/listar.php';
                        }
                    }
                })
            });
        });
    </script>
</body>

</html>