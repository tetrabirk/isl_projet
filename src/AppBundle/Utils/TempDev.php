<?php
/**
 * Created by PhpStorm.
 * User: Vi
 * Date: 7/11/2017
 * Time: 20:20
 */

namespace AppBundle\Utils;


class TempDev
{
    static function reductionLienImage($string)
    {
        $moinsjpg = substr($string,0,-4);
        $exploded = explode('_',$moinsjpg);
        while ($exploded[1] >= 10)
        {
            $exploded[1] += -10;
        }
        return $exploded[0].'_'.$exploded[1].'.jpg';
    }
}