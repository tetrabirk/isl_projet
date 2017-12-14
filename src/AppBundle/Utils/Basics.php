<?php
/**
 * Created by PhpStorm.
 * User: Vi
 * Date: 7/11/2017
 * Time: 20:20
 */

namespace AppBundle\Utils;


class Basics
{
    public function moyenne($array)
    {
        return array_sum($array)/count($array);
    }
}