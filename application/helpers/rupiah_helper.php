<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function bersihkanRupiah($string) {
    $string = str_replace('Rp', '', $string);
    $string = str_replace('.', '', $string);
    return $string;
}