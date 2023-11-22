<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/jpg" href="/favicon.png" />
    <style>
        td {
            padding-right: 5px;
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../includes/nav.html' ?>

    <h1>Eliminar género</h1>

    <form id="formulario_eliminar_genero" style="display: none;">
        <p>¿Está seguro que desea eliminar el género <strong><span id="genero"></span></strong>?</p>
        <p>
            <a href="javascript:history.back()">Volver</a>
            <input type="submit" value="Eliminar">
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
                    404: function(response) {
                        alert('Género no encontrado');
                    },
                    400: function(response) {
                        alert(response.responseJSON.error);
                    },
                    200: function(response) {
                        $('#genero').html(response.data.genre.name);
                        $('#formulario_eliminar_genero').show();
                    }
                }
            });
            $('#formulario_eliminar_genero').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: "http://localhost:8080/genre/<?= $_GET['id'] ?>",
                    type: "DELETE",
                    dataType: "json",
                    statusCode: {
                        500: function(response) {
                            alert(response.responseJSON.error);
                        },
                        404: function(response) {
                            alert('Género no encontrado');
                        },
                        400: function(response) {
                            alert(response.responseJSON.error);
                        },
                        200: function() {
                            alert('Género eliminado');
                            window.location.href = 'http://localhost:8081/generos/listar.php';
                        }
                    }
                })
            });
        });
    </script>
</body>

</html>