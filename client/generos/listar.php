<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/jpg" href="/favicon.png" />
</head>

<body>
    <nav>
        <lu>
            <li><a href="http://localhost:8081/libros/listar.php">Libros</a></li>
            <li><a href="http://localhost:8081/generos/listar.php">Géneros</a></li>
        </lu>
    </nav>

    <h1>Listado de géneros</h1>

    <form id="formulario_filtrar_generos">
        <input type="text" id="nombre" name="nombre">
        <input type="submit" value="Buscar">
        <a id="enlace_limpiar_formulario" href="javascript:void(0)" onclick="limpiarFormulario()" style="display: none;">Limpiar</a>
    </form>

    <p>
        <a href="http://localhost:8081/generos/crear.php">Crear género</a>
    </p>

    <table id="generos">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <div id="paginacion"></div>

    <script>
        var pagina = 1;
        var elementos = 5;
        var filtro = '';

        function cargarGeneros(pagina, filtro = '') {

            $('#generos tbody').html('');
            $.ajax({
                url: "http://localhost:8080/genre?limit=" + elementos + "&offset=" + (pagina - 1) * elementos + "&filter=" + filtro,
                type: "GET",
                dataType: "json",
                statusCode: {
                    500: function() {
                        if (response.responseJSON.error) {
                            console.log(response.responseJSON.error);
                        }
                        alert('Error en el servidor');
                    },
                    200: function(response) {
                        if (response.data.total == 0) {
                            $('#generos tbody').append('<tr><td colspan="2">No hay géneros</td></tr>');
                        } else {
                            pintarGeneros(response.data.genres);
                            pintarPaginacion(response.data.total);
                        }
                    }
                },
            });
        }

        function pintarGeneros(generos) {
            $.each(generos, function(key, value) {
                var fila = "<tr>";
                fila += "<td>" + value.name + "</td>";
                fila += "<td>";
                fila += "<a href='http://localhost:8081/generos/modificar.php?id=" + value.id + "'>Modificar</a> ";
                fila += "<a href='http://localhost:8081/generos/eliminar.php?id=" + value.id + "'>Eliminar</a>";
                fila += "</td>";
                fila += "</tr>";
                $('#generos tbody').append(fila);
            });
        }

        function pintarPaginacion(total) {
            var paginacion = "";
            if (total > elementos) {
                for (var i = 1; i <= Math.ceil(total / elementos); i++) {
                    if (i == pagina) {
                        paginacion += "<strong>" + i + "</strong> ";
                    } else {
                        paginacion += "<a href='javascript:void(0)' onclick='cargarPagina(" + i + ")'>" + i + "</a> ";
                    }
                }
            }
            $('#paginacion').html(paginacion);
        }

        function limpiarFormulario() {
            $('#nombre').val('');
            $('#enlace_limpiar_formulario').hide();
            cargarGeneros(pagina);
        }

        function cargarPagina(nuevaPagina) {
            pagina = nuevaPagina;
            filtro = $('#nombre').val();
            cargarGeneros(pagina, filtro);
        }

        $('#formulario_filtrar_generos').submit(function(event) {
            event.preventDefault();
            filtro = $('#nombre').val();
            $('#enlace_limpiar_formulario').show();
            cargarGeneros(pagina, filtro);
        });

        $(document).ready(function() {
            cargarGeneros(pagina);
            $('#nombre').focus();
        });
    </script>
</body>

</html>