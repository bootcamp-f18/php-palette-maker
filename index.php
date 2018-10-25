<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="dist/css/output.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <title>PHP Palette Maker</title>
  </head>
  <body class="container mt-4">

      <h1 class="text-center">PHP Palette Maker</h1>

<?php

    require_once("components/colors.php");
    require_once("components/palettes.php");

    $action = '';
    if (isset($_POST["action"])) { $action = $_POST["action"]; }

    $GLOBALS["statusMessage"] = '';
    $GLOBALS["statusMessageClass"] = 'alert-success';


    // Basic routing!
    switch ($action) {
        case "deletecolor":
            $safeColorId = htmlentities($_POST["colorid"]);
            deleteColor($safeColorId);
            break;
        case "addcolor":
            $safeColorName = htmlentities($_POST["colorname"]);
            $safeColorHex = htmlentities($_POST["colorhex"]);
            addColor($safeColorName, $safeColorHex);
            break;
        case "addpalette":
            $safePaletteName = htmlentities($_POST["palettename"]);
            addPalette($safePaletteName);
            break;
        case "deletepalette":
            $safePaletteId = htmlentities($_POST["paletteid"]);
            deletePalette($safePaletteId);
            break;
        case "deletecolorfrompalette":
            $safePaletteId = htmlentities($_POST["paletteid"]);
            $safeColorId = htmlentities($_POST["colorid"]);
            deleteColorFromPalette($safePaletteId, $safeColorId);
            break;
    }


    // Do we need to alert the user of anything?
    if ($GLOBALS["statusMessage"] != '') {
        echo '<div class="alert ' . $GLOBALS["statusMessageClass"] . '">' . $GLOBALS["statusMessage"] . "</div>\n";
    }

    // Load data
    $colorList = getColorList();
    $paletteList = getPaletteList();

?>

    <div class="row mt-4">

        <div class="col col-12 col-md-6">
            <h3 class="text-center">Palettes</h3>
            <form class="form-inline mt-4 mb-4" method="post" action="">
                <input class="form-control mr-2" name="palettename" value="" placeholder="Palette name...">
                <button type="submit" class="btn btn-success">Add</button>
                <input type="hidden" name="action" value="addpalette">
            </form>
            <div>

<?php
    foreach ($paletteList as $palette) {
?>
                <div class="card mb-3">
                    <div class="card-header clearfix">
                        <div class="float-left pt-1"><h6><?=$palette["name"]?></h6></div>
                        <div class="float-right">
                            <form method="post" action="">
                                <input type="hidden" name="paletteid" value="<?=$palette["id"]?>">
                                <input type="hidden" name="action" value="deletepalette">
                                <button class="btn p-0 btn-light" type="submit"><i class="text-danger far fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">


<?php
    foreach (getPaletteColors($palette["id"]) as $color) {
?>
        <div class="row">
            <div class="littleSwatch my-auto" style="background-color: #<?=$color["hex"]?>"></div>
            <div class="col my-auto"><?=$color["name"]?>, <code>#<?=$color["hex"]?></code></div>
            <div class="text-right my-auto">
                <form method="post" action="">
                    <input type="hidden" name="colorid" value="<?=$color["id"]?>">
                    <input type="hidden" name="paletteid" value="<?=$palette["id"]?>">
                    <input type="hidden" name="action" value="deletecolorfrompalette">
                    <button class="btn btn-sm" type="submit"><i class="text-danger far fa-trash-alt"></i></button>
                </form>
            </div>
        </div>
<?php
    }
?>

                    </div>
                </div>

<?php
    }
?>

            </div>






        </div>



        <div class="col col-12 col-md-6">
            <h3 class="text-center">Colors</h3>
            <form class="form-inline mt-4 mb-4" method="post" action="">
                <input class="form-control mr-2" name="colorname" value="" placeholder="Color name...">
                <div class="col input-group mr-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">#</div>
                    </div>
                    <input type="text" class="form-control" name="colorhex" placeholder="Hex value...">
                </div>
                <button type="submit" class="btn btn-success">Add</button>
                <input type="hidden" name="action" value="addcolor">
            </form>
            <div>
<?php
    foreach ($colorList as $color) {
?>
                <div class="row mb-4">
                    <div class="bigSwatch" style="background-color: #<?=$color["hex"]?>"></div>
                    <div class="col my-auto"><?=$color["name"]?>, <code>#<?=$color["hex"]?></code></div>
                    <div class="text-right my-auto">
                        <form method="post" action="">
                            <input type="hidden" name="colorid" value="<?=$color["id"]?>">
                            <input type="hidden" name="action" value="deletecolor">
                            <button class="btn" type="submit"><i class="text-danger far fa-trash-alt"></i></button>
                        </form>
                    </div>
                </div>
<?php
    }
?>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
