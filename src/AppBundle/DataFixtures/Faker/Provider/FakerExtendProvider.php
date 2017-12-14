<?php

namespace AppBundle\DataFixtures\Faker\Provider;
use AppBundle\AppBundle;
use AppBundle\Entity\Image;
use Faker;


class FakerExtendProvider
{
    public static function randomChoice($array){
        $rand_key = array_rand($array,1);
        return $array[$rand_key];
    }

    public static function fakerExt($attribut,$data = null)
    {
        $faker= Faker\Factory::create();
        $str ='';
        switch ($attribut) {
            case 'nom_prest':
                $choice = self::randomChoice(['Zen', 'Cool', 'Bien-Etre', 'Palace', 'ASBL', 'et fils', 'S.A.', 'Detente', 'Yang']);
                $str = ($faker->word) . ' ' . $choice;
                break;

            case 'email_prest':
                $str = 'p.' . ($faker->email);
                break;
            case 'email_inter':
                $str = 'i.' . ($faker->email);
                break;
            case 'tva':
//                je génère le chiffre en 2 fois car il le traite comme un integer et le nombre devient trop grand
                $str = 'TVA BE 0'.$faker->randomNumber(5,true).$faker->randomNumber(5,true);
                break;
            case 'nom_image':
                $unix = substr((str_replace(' ','',microtime())),2);
                $str = $unix.'.jpg';
                break;
            case 'test':
//                $str = print_r($data,true);
                $str = new Image();
                $str['nom'] = 'gagagou.jpg';
                break;
            case 'float':
                $str = $faker->randomFloat(3,0,1);
                break;
            case 'pdf':
                $str = $faker->slug.'.pdf';
        }

        return $str;
    }
}






