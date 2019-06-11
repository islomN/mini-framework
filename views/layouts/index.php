<?php
$assets = new \app\core\Assets;
?>
<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="_csrf" content="<?= \app\core\Request::csrf()?>">
    <link rel="icon" href="favicon.ico">

    <title><?= encode($this->title)?></title>

    <?= $assets->css()?>
</head>

<body>

<div class="container">
    <!-- Example row of columns -->
    <?= $content?>
    <hr>
</div> <!-- /container -->

<?= $assets->js()?>
<script>
    
</script>

</body></html>