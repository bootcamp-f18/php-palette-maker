<?php

    require_once("utility.php");

    function getPaletteList() {
        $result = pg_query(getDb(), "SELECT id, name FROM palette ORDER BY name");
        return pg_fetch_all($result);
    }

    function addPalette($name) {
        $sql = "INSERT INTO palette (name) VALUES ('$name')";
        $result = pg_query(getDb(), $sql);
        if ($result) {
            $GLOBALS["statusMessage"] = "<strong>$name</strong> was added.";
            $GLOBALS["statusMessageClass"] = "alert-success";
        }
        else {
            $GLOBALS["statusMessage"] = "<strong>$name</strong> was not added.";
            $GLOBALS["statusMessageClass"] = "alert-danger";
        }
    }

    function deletePalette($id) {

    }

    function getPaletteColors($palette_id) {
        $sql = "SELECT c.id, c.name, c.hex FROM color AS c
                JOIN color_palette AS cp ON cp.color_id = c.id
                WHERE cp.palette_id = " . $palette_id . "
                ORDER BY c.name";
        $result = pg_query(getDb(), $sql);
        return pg_fetch_all($result);
    }

    function deleteColorFromPalette($palette_id, $color_id) {
        $sql = "DELETE FROM colorkhkhk_palette WHERE color_id = " . $color_id . " and palette_id = " . $palette_id;
        $result = pg_query(getDb(), $sql);
        if ($result) {
            $GLOBALS["statusMessage"] = "The selected color was removed from the palette.";
            $GLOBALS["statusMessageClass"] = "alert-success";
        }
        else {
            $GLOBALS["statusMessage"] = "Could not remove the selected color from the palette.";
            $GLOBALS["statusMessageClass"] = "alert-danger";
        }

    }

?>
