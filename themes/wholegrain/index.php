<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
    <title>Recipes</title>
</head>

<body>

<main>
    <a id="permalink" href=""><h2 id="title"></h2></a>
    <div id="content"></div>
    <div id="ingredients"></div>
    <p id="category"></p>
</main>

<button id="loadMoreRecipes">Hit Me! (Get a Recipe)</button>

<script src = "https://code.jquery.com/jquery-3.3.1.js"
    integrity = "sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin = "anonymous"></script>
</script>
<script>
    jQuery(function ($) {
        $('button').click(function (e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: 'wp-json/wp/v2/recipes?filter[orderby]=rand&filter[taxonomy]=category',
                dataType: 'json',
                cache: false,
                success: function (data) {
                    var post = data.shift();
                    $('#permalink').html(post.link.rendered);
                    $('#title').html(post.title.rendered);
                    $('#content').html(post.content.rendered);
                    $('#ingredients').html(post.ingredients);
                    $('#category').html('Category:' + post.categories_names);      
                }
            });
        });
    });

</script>
</body>

</html>
