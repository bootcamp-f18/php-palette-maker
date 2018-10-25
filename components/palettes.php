<?php

    require_once("utility.php");

    function getPaletteList() {
        $result = pg_query(getDb(), "SELECT id, name FROM palette ORDER BY name");
        return pg_fetch_all($result);
    }

    function allFilledPalettes() {
        $sql = "SELECT DISTINCT palette_id FROM color_palette ORDER BY palette_id";
        $result = pg_query(getDb(), $sql);
        $palettes = pg_fetch_all($result);
        $ids = [];
        foreach ($palettes as $palette) {
            array_push($ids, $palette["palette_id"]);
        }
        return $ids;
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
        $sql = "DELETE FROM palette WHERE id = " . $id;
        $result = pg_query(getDb(), $sql);
        if ($result) {
            $GLOBALS["statusMessage"] = "The palette was deleted.";
            $GLOBALS["statusMessageClass"] = "alert-success";
        }
        else {
            $GLOBALS["statusMessage"] = "The palette was not deleted.";
            $GLOBALS["statusMessageClass"] = "alert-danger";
        }
    }

    function getAddableColors($palette_id) {
        $sql = "SELECT id, name, hex FROM color
                WHERE color.id NOT IN (SELECT color_id FROM color_palette WHERE palette_id = " . $palette_id . ")
                ORDER BY name";
        $result = pg_query(getDb(), $sql);
        return pg_fetch_all($result);
    }

    function getPaletteColors($palette_id) {
        $sql = "SELECT c.id, c.name, c.hex FROM color AS c
                JOIN color_palette AS cp ON cp.color_id = c.id
                WHERE cp.palette_id = " . $palette_id . "
                ORDER BY c.name";
        $result = pg_query(getDb(), $sql);
        $all = pg_fetch_all($result);
        if ($all) {
            return $all;
        }
        return [];
    }

    function deleteColorFromPalette($palette_id, $color_id) {
        $sql = "DELETE FROM color_palette WHERE color_id = " . $color_id . " and palette_id = " . $palette_id;
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

    function addColorToPalette($palette_id, $color_id) {
        $sql = "INSERT INTO color_palette (color_id, palette_id) VALUES ($color_id, $palette_id)";
        $result = pg_query(getDb(), $sql);
        if ($result) {
            $GLOBALS["statusMessage"] = "The selected color was added to the palette.";
            $GLOBALS["statusMessageClass"] = "alert-success";
        }
        else {
            $GLOBALS["statusMessage"] = "Could not add the selected color to the palette.";
            $GLOBALS["statusMessageClass"] = "alert-danger";
        }
    }

?>
