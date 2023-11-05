<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/jpg" href="/favicon.png" />
</head>

<body>
    <h1>Listado de libros</h1>

    <form id="formulario_filtrar_libros">
        <input type="text" id="nombre" name="nombre">
        <input type="submit" value="Buscar">
        <a id="enlace_limpiar_formulario" href="javascript:void(0)" onclick="limpiarFormulario()" style="display: none;">Limpiar</a>
    </form>

    <p>
        <a href="http://localhost:8081/libros/crear.php">Crear libro</a>
    </p>

    <table id="libros">
        <thead>
            <tr>
                <th>Título</th>
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

        function cargarLibros(pagina, filtro = '') {
            
            $('#libros tbody').html('');
            $.ajax({
                url: "http://localhost:8080/book?limit=" + elementos + "&offset=" + (pagina - 1) * elementos + "&filter=" + filtro,
                type: "GET",
                dataType: "json",
                statusCode: {
                    500: function() {
                        alert('Error en el servidor');
                    },
                    200: function(response) {
                        if (response.data.total == 0) {
                            $('#libros tbody').append('<tr><td colspan="2">No hay libros</td></tr>');
                        } else {
                            pintarLibros(response.data.books);
                            pintarPaginacion(response.data.total);
                        }
                    }
                },
            });
        }

        function pintarLibros(libros) {
            $.each(libros, function(key, value) {
                var fila = "<tr>";
                fila += "<td>" + value.title + "</td>";
                fila += "<td>";
                fila += "<a href='http://localhost:8081/libros/modificar.php?id=" + value.id + "'>Modificar</a> ";
                fila += "<a href='http://localhost:8081/libros/eliminar.php?id=" + value.id + "'>Eliminar</a>";
                fila += "</td>";
                fila += "</tr>";
                $('#libros tbody').append(fila);
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
            cargarLibros(pagina);
        }

        function cargarPagina(nuevaPagina) {
            pagina = nuevaPagina;
            filtro = $('#nombre').val();
            cargarLibros(pagina, filtro);
        }

        $('#formulario_filtrar_libros').submit(function(event) {
            event.preventDefault();
            filtro = $('#nombre').val();
            $('#enlace_limpiar_formulario').show();
            cargarLibros(pagina, filtro);
        });

        $(document).ready(function() {
            cargarLibros(pagina);
            $('#nombre').focus();
        });
    </script>
</body>

</html>