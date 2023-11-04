<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/jpg" href="/favicon.png"/>
</head>

<body>
    <h1>Listado de géneros</h1>

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

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "http://localhost:8080/genre",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $.each(data.genres, function(key, value) {
                        var fila = "<tr>";
                        fila += "<td>" + value.name + "</td>";
                        fila += "<td><a href='http://localhost:8080/book/" + value.id + "'>Ver</a> | <a href='http://localhost:8080/book/" + value.id + "/edit'>Editar</a> | <a href='http://localhost:8080/book/" + value.id + "/delete'>Eliminar</a></td>";
                        fila += "</tr>";
                        $('#generos tbody').append(fila);
                    });
                }
            });
        });
    </script>
</body>

</html>