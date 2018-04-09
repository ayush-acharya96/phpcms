<?php
/**
 * Created by PhpStorm.
 * User: SPR!NG
 * Date: 3/16/2018
 * Time: 9:10 PM
 */
session_start();
function Message() {
    if(isset($_SESSION["ErrorMessage"])){
        $Output = "<div class=\"alert alert-danger\">";
        $Output.= htmlentities($_SESSION["ErrorMessage"]);
        $Output.="</div>";
        $_SESSION["ErrorMessage"] = null;
        return $Output;
    }
}

function SuccessMessage() {
    if(isset($_SESSION["SuccessMessage"])){
        $Output = "<div class=\"alert alert-success\">";
        $Output.= htmlentities($_SESSION["SuccessMessage"]);
        $Output.="</div>";
        $_SESSION["SuccessMessage"] = null;
        return $Output;
    }
}