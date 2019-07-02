<?php
require_once 'code/core/Base.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" type="text/css" href="libs/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="includes/css/style.css">
        <title>Organizer wydatków</title>

        <script type="text/javascript" src="libs/js/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="libs/js/bootstrap.min.js"></script>
    </head>
    <body>

        <div class="d-flex flex-column">
            <?php ElementLoader::insertElement(ElementLoader::HEADER); ?>

            <div class="d-flex flex-column justify-content-center align-items-center">

                <div class="content-panel">

                    <?php ElementLoader::insertElement(ElementLoader::MONTH_LIST); ?>

                </div>
            </div>
        </div>
        <script type="text/javascript" src="includes/js/urls.js"></script>
        <script type="text/javascript" src="includes/js/main.js"></script>
    </body>
</html> 