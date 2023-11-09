<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/jpg" href="/favicon.png" />
</head>

<body>
    <h1></h1>
    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Optio dolorum veniam, rerum quos ullam aspernatur fuga consequuntur ab autem omnis blanditiis non iure, illum, rem aperiam! Modi odio consequuntur voluptates?</p>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "http://localhost:8080/genre/<?= $_GET['id'] ?>",
                type: "GET",
                dataType: "json",
                statusCode: {
                    500: function(response) {
                        if (response.responseJSON.error) {
                            console.log(response.responseJSON.error);
                        }
                        alert('Error en el servidor');
                        window.location.href = 'http://localhost:8081/generos/listar.php';
                    },
                    404: function(response) {
                        if (response.responseJSON.error) {
                            console.log(response.responseJSON.error);
                        }
                        alert('Género no encontrado');
                        window.location.href = 'http://localhost:8081/generos/listar.php';
                    },
                    200: function(response) {
                        $('#nombre').val(response.data.genre.name);
                        $('#formulario_editar_genero').show();
                        $('#nombre').focus().val($('#nombre').val());
                        $('h1').text(response.data.genre.name);
                    }
                },
            });

            $('#formulario_editar_genero').submit(function(event) {
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