<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/jpg" href="/favicon.png" />
</head>

<body>
    <h1></h1>

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
                    404: function(response) {
                        alert(response.responseJSON.error);
                    },
                    200: function(response) {
                        $('h1').text(response.data.book.title);
                    }
                },
            });
        });
    </script>
</body>

</html>