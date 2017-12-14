<?php
/**
 * Created by PhpStorm.
 * User: Ludovic
 * Date: 29/10/2017
 * Time: 11:09
 */

namespace AppBundle\Utils;


class Slugger
{
    public static function createSlug($str, $delimiter = ''){

        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;

    }
}
