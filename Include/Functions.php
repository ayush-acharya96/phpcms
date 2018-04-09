<?php
/**
 * Created by PhpStorm.
 * User: SPR!NG
 * Date: 3/17/2018
 * Time: 9:39 AM
 */

function Redirect_to($New_Location) {
    header("Location:".$New_Location);
    exit;
}