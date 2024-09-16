<?php 





?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>error</title>
    <?php

    include("../assets/scrollbar/scrollbar.php")

    ?>
</head>
<body>

    <main>
        <div class="container">
            <h1>404</h1>
            <p>Something went wrong!</p>
            <a href="#" onclick="goBack()">BACK</a>
        </div>
    </main>    
</body>
<style>

    <?php include("./error.css") ?>

</style>
<script>
    <?php include("./error.js") ?>
</script>
</html>