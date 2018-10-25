<?php

    require_once("utility.php");

    function getColorList() {
        $result = pg_query(getDb(), "SELECT id, name, hex FROM color ORDER BY name");
        return pg_fetch_all($result);
    }

    function allUsedColors() {
        $sql = "SELECT DISTINCT color_id FROM color_palette ORDER BY color_id";
        $result = pg_query(getDb(), $sql);
        $colors = pg_fetch_all($result);
        $ids = [];
        foreach ($colors as $color) {
            array_push($ids, $color["color_id"]);
        }
        return $ids;
    }

    function addColor($name, $hex) {
        $sql = "INSERT INTO color (name, hex) VALUES ('$name', '$hex')";
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

    function deleteColor($id) {
        $sql = "DELETE FROM color WHERE id = " . $id;
        $result = pg_query(getDb(), $sql);
        if ($result) {
            $GLOBALS["statusMessage"] = "The color was deleted.";
            $GLOBALS["statusMessageClass"] = "alert-success";
        }
        else {
            $GLOBALS["statusMessage"] = "The color was not deleted.";
            $GLOBALS["statusMessageClass"] = "alert-danger";
        }
    }

?>
