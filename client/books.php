<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/jpg" href="/favicon.png"/>
</head>

<body>
    <h1>Listado de libros</h1>

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

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "http://localhost:8080/book",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $.each(data.books, function(key, value) {
                        var fila = "<tr>";
                        fila += "<td>" + value.title + "</td>";
                        fila += "<td><a href='http://localhost:8080/book/" + value.id + "'>Ver</a> | <a href='http://localhost:8080/book/" + value.id + "/edit'>Editar</a> | <a href='http://localhost:8080/book/" + value.id + "/delete'>Eliminar</a></td>";
                        fila += "</tr>";
                        $('#libros tbody').append(fila);
                    });
                }
            });
        });
    </script>
</body>

</html>