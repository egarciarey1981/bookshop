<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/jpg" href="/favicon.png" />
</head>

<body>
    <?php include __DIR__ . '/../includes/nav.html' ?>

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
                success: function(response) {
                    $('#nombre').val(response.data.genre.name);
                    $('#formulario_modificar_genero').show();
                    $('#nombre').focus().val($('#nombre').val());
                },
                error: function(response) {
                    alert(response.responseJSON.error);
                }
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
                    success: function(response) {
                        alert('Género modificado');
                        window.location.href = 'http://localhost:8081/generos/listar.php';
                    },
                    error: function(response) {
                        alert(response.responseJSON.error);
                    }
                })
            });
        });
    </script>
</body>

</html>