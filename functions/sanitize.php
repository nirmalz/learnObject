<?php
/**
 * Created by PhpStorm.
 * User: Nirmal
 * Date: 2/23/2015
 * Time: 3:49 PM
 */

function escape($string){
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}