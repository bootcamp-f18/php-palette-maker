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

?>
