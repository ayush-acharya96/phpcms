<?php
/**
 * Created by PhpStorm.
 * User: SPR!NG
 * Date: 3/16/2018
 * Time: 2:50 PM
 */

date_default_timezone_set('Asia/Kathmandu');
$CurrentTime = time();
$DateTime = strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);
$DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
echo $DateTime;