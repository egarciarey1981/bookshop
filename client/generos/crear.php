<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/jpg" href="/favicon.png" />
</head>

<body>
    <h1>Crear género</h1>

    <form id="formulario_crear_genero">
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
            $('#nombre').focus();
            $('#formulario_crear_genero').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: "http://localhost:8080/genre",
                    type: "POST",
                    dataType: "json",
                    data: {
                        name: $('#nombre').val()
                    },
                    statusCode: {
                        500: function() {
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
                        201: function() {
                            alert('Género creado');
                            window.location.href = 'http://localhost:8081/generos/listar.php';
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>