<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Abus;
use AppBundle\Entity\Admin;
use AppBundle\Entity\Bloc;
use AppBundle\Entity\CategorieDeServices;
use AppBundle\Entity\CodePostal;
use AppBundle\Entity\Commentaire;
use AppBundle\Entity\DocumentPDF;
use AppBundle\Entity\Image;
use AppBundle\Entity\Internaute;
use AppBundle\Entity\Localite;
use AppBundle\Entity\Newsletter;
use AppBundle\Entity\Prestataire;
use AppBundle\Entity\Promotion;
use AppBundle\Entity\Stage;
use AppBundle\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Faker;

class Fixtures extends Fixture
{
    static $nbreCategorie = 8;
    static $nbrePrestataire = 20;
    static $nbreInternaute = 10;
    static $nbreCommentaire = 50;
    static $nbreNewsletter = 50;
    static $nbreAbus = 10;

    static $maxFavorisParInternaute = 10;
    static $maxCategoriesParPrestataire = 5;
    static $maxPhotosParPrestataire = 5;
    static $maxStagesParPrestataire = 5;
    static $maxPromotionsParPrestataire = 5;
    static $maxCategoriesParPromotion = 2;

    static $encryptedPassword = '$2a$12$og1AI.Y/3oCN.GdQtZl7muTw6Ffn9bFjTY0LWIh/yTCCdjfgpss32'; //'password' en bcrypt 12

    //joli array avec tt les CP de Belgique et les localitée correspondante, pris sur le site de la Poste et reformaté pour du PHP
    static $cpLocalite = array(
        1005 => array(0 => 'Assemblée Réunie de la Commission Communautaire',),
        1006 => array(0 => 'Raad van de Vlaamse Gemeenschapscommissie',),
        1007 => array(0 => 'Assemblée de la Commission Communautaire Française',),
        1008 => array(0 => 'Chambre des Représentants',),
        1009 => array(0 => 'Senat de Belgique',),
        1011 => array(0 => 'Vlaams parlement',),
        1012 => array(0 => 'Parlement de la Communauté française',),
        1020 => array(0 => 'Laeken',),
        1030 => array(0 => 'SCHAERBEEK',),
        1031 => array(0 => 'Organisations Sociales Chrétiennes',),
        1033 => array(0 => 'RTL-TVI',),
        1035 => array(0 => 'Ministère de la Région de Bruxelles Capitale',),
        1040 => array(0 => 'ETTERBEEK',),
        1041 => array(0 => 'International Press Center',),
        1043 => array(0 => 'VRT',),
        1044 => array(0 => 'RTBF',),
        1046 => array(0 => 'European External Action Service',),
        1047 => array(0 => 'Parlement Européen',),
        1048 => array(0 => 'Union Européenne - Conseil',),
        1049 => array(0 => 'Union Européenne - Commission',),
        1050 => array(0 => 'IXELLES',),
        1060 => array(0 => 'SAINT-GILLES',),
        1070 => array(0 => 'ANDERLECHT',),
        1080 => array(0 => 'MOLENBEEK-SAINT-JEAN',),
        1081 => array(0 => 'KOEKELBERG',),
        1082 => array(0 => 'BERCHEM-SAINTE-AGATHE',),
        1083 => array(0 => 'GANSHOREN',),
        1090 => array(0 => 'JETTE',),
        1099 => array(0 => 'Bruxelles X',),
        1100 => array(0 => 'Postcheque',),
        1101 => array(0 => 'Scanning',),
        1105 => array(0 => 'SOC',),
        1110 => array(0 => 'OTAN',),
        1120 => array(0 => 'Neder-Over-Heembeek',),
        1130 => array(0 => 'Haren',),
        1140 => array(0 => 'EVERE',),
        1150 => array(0 => 'WOLUWE-SAINT-PIERRE',),
        1160 => array(0 => 'AUDERGHEM',),
        1170 => array(0 => 'WATERMAEL-BOITSFORT',),
        1180 => array(0 => 'UCCLE',),
        1190 => array(0 => 'FOREST',),
        1200 => array(0 => 'WOLUWE-SAINT-LAMBERT',),
        1210 => array(0 => 'SAINT-JOSSE-TEN-NOODE',),
        1212 => array(0 => 'SPF Mobilité',),
        1300 => array(0 => 'Limal', 1 => 'WAVRE',),
        1301 => array(0 => 'Bierges',),
        1310 => array(0 => 'LA HULPE',),
        1315 => array(0 => 'Glimes', 1 => 'INCOURT', 2 => 'Opprebais', 3 => 'Piètrebais', 4 => 'Roux-Miroir',),
        1320 => array(0 => 'BEAUVECHAIN', 1 => 'Hamme-Mille', 2 => 'L\'Ecluse', 3 => 'Nodebais', 4 => 'Tourinnes-La-Grosse',),
        1325 => array(0 => 'Bonlez', 1 => 'CHAUMONT-GISTOUX', 2 => 'Corroy-Le-Grand', 3 => 'Dion-Valmont', 4 => 'Longueville',),
        1330 => array(0 => 'RIXENSART',),
        1331 => array(0 => 'Rosières',),
        1332 => array(0 => 'Genval',),
        1340 => array(0 => 'Ottignies', 1 => 'OTTIGNIES-LOUVAIN-LA-NEUVE',),
        1341 => array(0 => 'Céroux-Mousty',),
        1342 => array(0 => 'Limelette',),
        1348 => array(0 => 'Louvain-La-Neuve',),
        1350 => array(0 => 'Enines', 1 => 'Folx-Les-Caves', 2 => 'Jandrain-Jandrenouille', 3 => 'Jauche', 4 => 'Marilles', 5 => 'Noduwez', 6 => 'ORP-JAUCHE', 7 => 'Orp-Le-Grand',),
        1357 => array(0 => 'HÉLÉCINE', 1 => 'Linsmeau', 2 => 'Neerheylissem', 3 => 'Opheylissem',),
        1360 => array(0 => 'Malèves-Sainte-Marie-Wastines', 1 => 'Orbais', 2 => 'PERWEZ', 3 => 'Thorembais-Les-Béguines', 4 => 'Thorembais-Saint-Trond',),
        1367 => array(0 => 'Autre-Eglise', 1 => 'Bomal', 2 => 'Geest-Gérompont-Petit-Rosière', 3 => 'Gérompont', 4 => 'Grand-Rosière-Hottomont', 5 => 'Huppaye', 6 => 'Mont-Saint-André', 7 => 'RAMILLIES',),
        1370 => array(0 => 'Dongelberg', 1 => 'Jauchelette', 2 => 'JODOIGNE', 3 => 'Jodoigne-Souveraine', 4 => 'Lathuy', 5 => 'Mélin', 6 => 'Piétrain', 7 => 'Saint-Jean-Geest', 8 => 'Saint-Remy-Geest', 9 => 'Zétrud-Lumay',),
        1380 => array(0 => 'Couture-Saint-Germain', 1 => 'LASNE', 2 => 'Lasne-Chapelle-Saint-Lambert', 3 => 'Maransart', 4 => 'Ohain', 5 => 'Plancenoit',),
        1390 => array(0 => 'Archennes', 1 => 'Biez', 2 => 'Bossut-Gottechain', 3 => 'GREZ-DOICEAU', 4 => 'Nethen',),
        1400 => array(0 => 'Monstreux', 1 => 'NIVELLES',),
        1401 => array(0 => 'Baulers',),
        1402 => array(0 => 'Thines',),
        1404 => array(0 => 'Bornival',),
        1410 => array(0 => 'WATERLOO',),
        1420 => array(0 => 'BRAINE-L\'ALLEUD',),
        1421 => array(0 => 'Ophain-Bois-Seigneur-Isaac',),
        1428 => array(0 => 'Lillois-Witterzée',),
        1430 => array(0 => 'Bierghes', 1 => 'Quenast', 2 => 'REBECQ', 3 => 'Rebecq-Rognon',),
        1435 => array(0 => 'Corbais', 1 => 'Hévillers', 2 => 'MONT-SAINT-GUIBERT',),
        1440 => array(0 => 'BRAINE-LE-CHÂTEAU', 1 => 'Wauthier-Braine',),
        1450 => array(0 => 'CHASTRE', 1 => 'Chastre-Villeroux-Blanmont', 2 => 'Cortil-Noirmont', 3 => 'Gentinnes', 4 => 'Saint-Géry',),
        1457 => array(0 => 'Nil-Saint-Vincent-Saint-Martin', 1 => 'Tourinnes-Saint-Lambert', 2 => 'WALHAIN', 3 => 'Walhain-Saint-Paul',),
        1460 => array(0 => 'ITTRE', 1 => 'Virginal-Samme',),
        1461 => array(0 => 'Haut-Ittre',),
        1470 => array(0 => 'Baisy-Thy', 1 => 'Bousval', 2 => 'GENAPPE',),
        1471 => array(0 => 'Loupoigne',),
        1472 => array(0 => 'Vieux-Genappe',),
        1473 => array(0 => 'Glabais',),
        1474 => array(0 => 'Ways',),
        1476 => array(0 => 'Houtain-Le-Val',),
        1480 => array(0 => 'Clabecq', 1 => 'Oisquercq', 2 => 'Saintes', 3 => 'TUBIZE',),
        1490 => array(0 => 'COURT-SAINT-ETIENNE',),
        1495 => array(0 => 'Marbais', 1 => 'Mellery', 2 => 'Sart-Dames-Avelines', 3 => 'Tilly', 4 => 'VILLERS-LA-VILLE',),
        1500 => array(0 => 'HALLE',),
        1501 => array(0 => 'Buizingen',),
        1502 => array(0 => 'Lembeek',),
        1540 => array(0 => 'Herfelingen', 1 => 'HERNE',),
        1541 => array(0 => 'Sint-Pieters-Kapelle',),
        1547 => array(0 => 'BIÉVÈNE',),
        1560 => array(0 => 'HOEILAART',),
        1570 => array(0 => 'GALMAARDEN', 1 => 'Tollembeek', 2 => 'Vollezele',),
        1600 => array(0 => 'Oudenaken', 1 => 'Sint-Laureins-Berchem', 2 => 'SINT-PIETERS-LEEUW',),
        1601 => array(0 => 'Ruisbroek',),
        1602 => array(0 => 'Vlezenbeek',),
        1620 => array(0 => 'DROGENBOS',),
        1630 => array(0 => 'LINKEBEEK',),
        1640 => array(0 => 'RHODE-SAINT-GENÈSE',),
        1650 => array(0 => 'BEERSEL',),
        1651 => array(0 => 'Lot',),
        1652 => array(0 => 'Alsemberg',),
        1653 => array(0 => 'Dworp',),
        1654 => array(0 => 'Huizingen',),
        1670 => array(0 => 'Bogaarden', 1 => 'Heikruis', 2 => 'PEPINGEN',),
        1671 => array(0 => 'Elingen',),
        1673 => array(0 => 'Beert',),
        1674 => array(0 => 'Bellingen',),
        1700 => array(0 => 'DILBEEK', 1 => 'Sint-Martens-Bodegem', 2 => 'Sint-Ulriks-Kapelle',),
        1701 => array(0 => 'Itterbeek',),
        1702 => array(0 => 'Groot-Bijgaarden',),
        1703 => array(0 => 'Schepdaal',),
        1730 => array(0 => 'ASSE', 1 => 'Bekkerzeel', 2 => 'Kobbegem', 3 => 'Mollem',),
        1731 => array(0 => 'Relegem', 1 => 'Zellik',),
        1733 => array(0 => 'HighCo DATA',),
        1740 => array(0 => 'TERNAT',),
        1741 => array(0 => 'Wambeek',),
        1742 => array(0 => 'Sint-Katherina-Lombeek',),
        1745 => array(0 => 'Mazenzele', 1 => 'OPWIJK',),
        1750 => array(0 => 'Gaasbeek', 1 => 'LENNIK', 2 => 'Sint-Kwintens-Lennik', 3 => 'Sint-Martens-Lennik',),
        1755 => array(0 => 'GOOIK', 1 => 'Kester', 2 => 'Leerbeek', 3 => 'Oetingen',),
        1760 => array(0 => 'Onze-Lieve-Vrouw-Lombeek', 1 => 'Pamel', 2 => 'ROOSDAAL', 3 => 'Strijtem',),
        1761 => array(0 => 'Borchtlombeek',),
        1770 => array(0 => 'LIEDEKERKE',),
        1780 => array(0 => 'WEMMEL',),
        1785 => array(0 => 'Brussegem', 1 => 'Hamme', 2 => 'MERCHTEM',),
        1790 => array(0 => 'AFFLIGEM', 1 => 'Essene', 2 => 'Hekelgem', 3 => 'Teralfene',),
        1800 => array(0 => 'Peutie', 1 => 'VILVOORDE',),
        1804 => array(0 => 'Cargovil',),
        1818 => array(0 => 'VTM',),
        1820 => array(0 => 'Melsbroek', 1 => 'Perk', 2 => 'STEENOKKERZEEL',),
        1830 => array(0 => 'MACHELEN',),
        1831 => array(0 => 'Diegem',),
        1840 => array(0 => 'LONDERZEEL', 1 => 'Malderen', 2 => 'Steenhuffel',),
        1850 => array(0 => 'GRIMBERGEN',),
        1851 => array(0 => 'Humbeek',),
        1852 => array(0 => 'Beigem',),
        1853 => array(0 => 'Strombeek-Bever',),
        1860 => array(0 => 'MEISE',),
        1861 => array(0 => 'Wolvertem',),
        1880 => array(0 => 'KAPELLE-OP-DEN-BOS', 1 => 'Nieuwenrode', 2 => 'Ramsdonk',),
        1910 => array(0 => 'Berg', 1 => 'Buken', 2 => 'KAMPENHOUT', 3 => 'Nederokkerzeel',),
        1930 => array(0 => 'Nossegem', 1 => 'ZAVENTEM',),
        1931 => array(0 => 'Brucargo',),
        1932 => array(0 => 'Sint-Stevens-Woluwe',),
        1933 => array(0 => 'Sterrebeek',),
        1934 => array(0 => 'Office Exchange Brussels Airport Remailing',),
        1935 => array(0 => 'Corporate Village',),
        1950 => array(0 => 'KRAAINEM',),
        1970 => array(0 => 'WEZEMBEEK-OPPEM',),
        1980 => array(0 => 'Eppegem', 1 => 'ZEMST',),
        1981 => array(0 => 'Hofstade',),
        1982 => array(0 => 'Elewijt', 1 => 'Weerde',),
        2000 => array(0 => 'ANTWERPEN',),
        2018 => array(0 => 'ANTWERPEN',),
        2020 => array(0 => 'ANTWERPEN',),
        2030 => array(0 => 'ANTWERPEN',),
        2040 => array(0 => 'ANTWERPEN', 1 => 'Berendrecht', 2 => 'Lillo', 3 => 'Zandvliet',),
        2050 => array(0 => 'ANTWERPEN',),
        2060 => array(0 => 'ANTWERPEN',),
        2070 => array(0 => 'Burcht', 1 => 'ZWIJNDRECHT',),
        2075 => array(0 => 'CSM Antwerpen X',),
        2099 => array(0 => 'Antwerpen x',),
        2100 => array(0 => 'Deurne',),
        2110 => array(0 => 'WIJNEGEM',),
        2140 => array(0 => 'Borgerhout',),
        2150 => array(0 => 'BORSBEEK',),
        2160 => array(0 => 'WOMMELGEM',),
        2170 => array(0 => 'Merksem',),
        2180 => array(0 => 'Ekeren',),
        2200 => array(0 => 'HERENTALS', 1 => 'Morkhoven', 2 => 'Noorderwijk',),
        2220 => array(0 => 'Hallaar', 1 => 'HEIST-OP-DEN-BERG',),
        2221 => array(0 => 'Booischot',),
        2222 => array(0 => 'Itegem', 1 => 'Wiekevorst',),
        2223 => array(0 => 'Schriek',),
        2230 => array(0 => 'HERSELT', 1 => 'Ramsel',),
        2235 => array(0 => 'Houtvenne', 1 => 'HULSHOUT', 2 => 'Westmeerbeek',),
        2240 => array(0 => 'Massenhoven', 1 => 'Viersel', 2 => 'ZANDHOVEN',),
        2242 => array(0 => 'Pulderbos',),
        2243 => array(0 => 'Pulle',),
        2250 => array(0 => 'OLEN',),
        2260 => array(0 => 'Oevel', 1 => 'Tongerlo', 2 => 'WESTERLO', 3 => 'Zoerle-Parwijs',),
        2270 => array(0 => 'HERENTHOUT',),
        2275 => array(0 => 'Gierle', 1 => 'LILLE', 2 => 'Poederlee', 3 => 'Wechelderzande',),
        2280 => array(0 => 'GROBBENDONK',),
        2288 => array(0 => 'Bouwel',),
        2290 => array(0 => 'VORSELAAR',),
        2300 => array(0 => 'TURNHOUT',),
        2310 => array(0 => 'RIJKEVORSEL',),
        2320 => array(0 => 'HOOGSTRATEN',),
        2321 => array(0 => 'Meer',),
        2322 => array(0 => 'Minderhout',),
        2323 => array(0 => 'Wortel',),
        2328 => array(0 => 'Meerle',),
        2330 => array(0 => 'MERKSPLAS',),
        2340 => array(0 => 'BEERSE', 1 => 'Vlimmeren',),
        2350 => array(0 => 'VOSSELAAR',),
        2360 => array(0 => 'OUD-TURNHOUT',),
        2370 => array(0 => 'ARENDONK',),
        2380 => array(0 => 'RAVELS',),
        2381 => array(0 => 'Weelde',),
        2382 => array(0 => 'Poppel',),
        2387 => array(0 => 'BAARLE-HERTOG',),
        2390 => array(0 => 'MALLE', 1 => 'Oostmalle', 2 => 'Westmalle',),
        2400 => array(0 => 'MOL',),
        2430 => array(0 => 'Eindhout', 1 => 'LAAKDAL', 2 => 'Vorst',),
        2431 => array(0 => 'Varendonk', 1 => 'Veerle',),
        2440 => array(0 => 'GEEL',),
        2450 => array(0 => 'MEERHOUT',),
        2460 => array(0 => 'KASTERLEE', 1 => 'Lichtaart', 2 => 'Tielen',),
        2470 => array(0 => 'RETIE',),
        2480 => array(0 => 'DESSEL',),
        2490 => array(0 => 'BALEN',),
        2491 => array(0 => 'Olmen',),
        2500 => array(0 => 'Koningshooikt', 1 => 'LIER',),
        2520 => array(0 => 'Broechem', 1 => 'Emblem', 2 => 'Oelegem', 3 => 'RANST',),
        2530 => array(0 => 'BOECHOUT',),
        2531 => array(0 => 'Vremde',),
        2540 => array(0 => 'HOVE',),
        2547 => array(0 => 'LINT',),
        2550 => array(0 => 'KONTICH', 1 => 'Waarloos',),
        2560 => array(0 => 'Bevel', 1 => 'Kessel', 2 => 'NIJLEN',),
        2570 => array(0 => 'DUFFEL',),
        2580 => array(0 => 'Beerzel', 1 => 'PUTTE',),
        2590 => array(0 => 'BERLAAR', 1 => 'Gestel',),
        2600 => array(0 => 'Berchem',),
        2610 => array(0 => 'Wilrijk',),
        2620 => array(0 => 'HEMIKSEM',),
        2627 => array(0 => 'SCHELLE',),
        2630 => array(0 => 'AARTSELAAR',),
        2640 => array(0 => 'MORTSEL',),
        2650 => array(0 => 'EDEGEM',),
        2660 => array(0 => 'Hoboken',),
        2800 => array(0 => 'MECHELEN', 1 => 'Walem',),
        2801 => array(0 => 'Heffen',),
        2811 => array(0 => 'Hombeek', 1 => 'Leest',),
        2812 => array(0 => 'Muizen',),
        2820 => array(0 => 'BONHEIDEN', 1 => 'Rijmenam',),
        2830 => array(0 => 'Blaasveld', 1 => 'Heindonk', 2 => 'Tisselt', 3 => 'WILLEBROEK',),
        2840 => array(0 => 'Reet', 1 => 'RUMST', 2 => 'Terhagen',),
        2845 => array(0 => 'NIEL',),
        2850 => array(0 => 'BOOM',),
        2860 => array(0 => 'SINT-KATELIJNE-WAVER',),
        2861 => array(0 => 'Onze-Lieve-Vrouw-Waver',),
        2870 => array(0 => 'Breendonk', 1 => 'Liezele', 2 => 'PUURS', 3 => 'Ruisbroek',),
        2880 => array(0 => 'BORNEM', 1 => 'Hingene', 2 => 'Mariekerke', 3 => 'Weert',),
        2890 => array(0 => 'Lippelo', 1 => 'Oppuurs', 2 => 'SINT-AMANDS',),
        2900 => array(0 => 'SCHOTEN',),
        2910 => array(0 => 'ESSEN',),
        2920 => array(0 => 'KALMTHOUT',),
        2930 => array(0 => 'BRASSCHAAT',),
        2940 => array(0 => 'Hoevenen', 1 => 'STABROEK',),
        2950 => array(0 => 'KAPELLEN',),
        2960 => array(0 => 'BRECHT', 1 => 'Sint-Job-In-\'T-Goor', 2 => 'Sint-Lenaarts',),
        2970 => array(0 => '\'S Gravenwezel', 1 => 'SCHILDE',),
        2980 => array(0 => 'Halle', 1 => 'ZOERSEL',),
        2990 => array(0 => 'Loenhout', 1 => 'WUUSTWEZEL',),
        3000 => array(0 => 'LEUVEN',),
        3001 => array(0 => 'Heverlee',),
        3010 => array(0 => 'Kessel Lo',),
        3012 => array(0 => 'Wilsele',),
        3018 => array(0 => 'Wijgmaal',),
        3020 => array(0 => 'HERENT', 1 => 'Veltem-Beisem', 2 => 'Winksele',),
        3040 => array(0 => 'HULDENBERG', 1 => 'Loonbeek', 2 => 'Neerijse', 3 => 'Ottenburg', 4 => 'Sint-Agatha-Rode',),
        3050 => array(0 => 'OUD-HEVERLEE',),
        3051 => array(0 => 'Sint-Joris-Weert',),
        3052 => array(0 => 'Blanden',),
        3053 => array(0 => 'Haasrode',),
        3054 => array(0 => 'Vaalbeek',),
        3060 => array(0 => 'BERTEM', 1 => 'Korbeek-Dijle',),
        3061 => array(0 => 'Leefdaal',),
        3070 => array(0 => 'KORTENBERG',),
        3071 => array(0 => 'Erps-Kwerps',),
        3078 => array(0 => 'Everberg', 1 => 'Meerbeek',),
        3080 => array(0 => 'Duisburg', 1 => 'TERVUREN', 2 => 'Vossem',),
        3090 => array(0 => 'OVERIJSE',),
        3110 => array(0 => 'ROTSELAAR',),
        3111 => array(0 => 'Wezemaal',),
        3118 => array(0 => 'Werchter',),
        3120 => array(0 => 'TREMELO',),
        3128 => array(0 => 'Baal',),
        3130 => array(0 => 'BEGIJNENDIJK', 1 => 'Betekom',),
        3140 => array(0 => 'KEERBERGEN',),
        3150 => array(0 => 'HAACHT', 1 => 'Tildonk', 2 => 'Wespelaar',),
        3190 => array(0 => 'BOORTMEERBEEK',),
        3191 => array(0 => 'Hever',),
        3200 => array(0 => 'AARSCHOT', 1 => 'Gelrode',),
        3201 => array(0 => 'Langdorp',),
        3202 => array(0 => 'Rillaar',),
        3210 => array(0 => 'Linden', 1 => 'LUBBEEK',),
        3211 => array(0 => 'Binkom',),
        3212 => array(0 => 'Pellenberg',),
        3220 => array(0 => 'HOLSBEEK', 1 => 'Kortrijk-Dutsel', 2 => 'Sint-Pieters-Rode',),
        3221 => array(0 => 'Nieuwrode',),
        3270 => array(0 => 'Scherpenheuvel', 1 => 'SCHERPENHEUVEL-ZICHEM',),
        3271 => array(0 => 'Averbode', 1 => 'Zichem',),
        3272 => array(0 => 'Messelbroek', 1 => 'Testelt',),
        3290 => array(0 => 'Deurne', 1 => 'DIEST', 2 => 'Schaffen', 3 => 'Webbekom',),
        3293 => array(0 => 'Kaggevinne',),
        3294 => array(0 => 'Molenstede',),
        3300 => array(0 => 'Bost', 1 => 'Goetsenhoven', 2 => 'Hakendover', 3 => 'Kumtich', 4 => 'Oorbeek', 5 => 'Oplinter', 6 => 'Sint-Margriete-Houtem', 7 => 'TIENEN', 8 => 'Vissenaken',),
        3320 => array(0 => 'HOEGAARDEN', 1 => 'Meldert',),
        3321 => array(0 => 'Outgaarden',),
        3350 => array(0 => 'Drieslinter', 1 => 'LINTER', 2 => 'Melkwezer', 3 => 'Neerhespen', 4 => 'Neerlinter', 5 => 'Orsmaal-Gussenhoven', 6 => 'Overhespen', 7 => 'Wommersom',),
        3360 => array(0 => 'BIERBEEK', 1 => 'Korbeek-Lo', 2 => 'Lovenjoel', 3 => 'Opvelp',),
        3370 => array(0 => 'BOUTERSEM', 1 => 'Kerkom', 2 => 'Neervelp', 3 => 'Roosbeek', 4 => 'Vertrijk', 5 => 'Willebringen',),
        3380 => array(0 => 'Bunsbeek', 1 => 'GLABBEEK',),
        3381 => array(0 => 'Kapellen',),
        3384 => array(0 => 'Attenrode',),
        3390 => array(0 => 'Houwaart', 1 => 'Sint-Joris-Winge', 2 => 'Tielt', 3 => 'TIELT-WINGE',),
        3391 => array(0 => 'Meensel-Kiezegem',),
        3400 => array(0 => 'Eliksem', 1 => 'Ezemaal', 2 => 'Laar', 3 => 'LANDEN', 4 => 'Neerwinden', 5 => 'Overwinden', 6 => 'Rumsdorp', 7 => 'Wange',),
        3401 => array(0 => 'Waasmont', 1 => 'Walsbets', 2 => 'Walshoutem', 3 => 'Wezeren',),
        3404 => array(0 => 'Attenhoven', 1 => 'Neerlanden',),
        3440 => array(0 => 'Budingen', 1 => 'Dormaal', 2 => 'Halle-Booienhoven', 3 => 'Helen-Bos', 4 => 'ZOUTLEEUW',),
        3450 => array(0 => 'GEETBETS', 1 => 'Grazen',),
        3454 => array(0 => 'Rummen',),
        3460 => array(0 => 'Assent', 1 => 'BEKKEVOORT',),
        3461 => array(0 => 'Molenbeek-Wersbeek',),
        3470 => array(0 => 'KORTENAKEN', 1 => 'Ransberg', 2 => 'Sint-Margriete-Houtem',),
        3471 => array(0 => 'Hoeleden',),
        3472 => array(0 => 'Kersbeek-Miskom',),
        3473 => array(0 => 'Waanrode',),
        3500 => array(0 => 'HASSELT', 1 => 'Sint-Lambrechts-Herk',),
        3501 => array(0 => 'Wimmertingen',),
        3510 => array(0 => 'Kermt', 1 => 'Spalbeek',),
        3511 => array(0 => 'Kuringen', 1 => 'Stokrooie',),
        3512 => array(0 => 'Stevoort',),
        3520 => array(0 => 'ZONHOVEN',),
        3530 => array(0 => 'Helchteren', 1 => 'Houthalen', 2 => 'HOUTHALEN-HELCHTEREN',),
        3540 => array(0 => 'Berbroek', 1 => 'Donk', 2 => 'HERK-DE-STAD', 3 => 'Schulen',),
        3545 => array(0 => 'HALEN', 1 => 'Loksbergen', 2 => 'Zelem',),
        3550 => array(0 => 'Heusden', 1 => 'HEUSDEN-ZOLDER', 2 => 'Zolder',),
        3560 => array(0 => 'Linkhout', 1 => 'LUMMEN', 2 => 'Meldert',),
        3570 => array(0 => 'ALKEN',),
        3580 => array(0 => 'BERINGEN',),
        3581 => array(0 => 'Beverlo',),
        3582 => array(0 => 'Koersel',),
        3583 => array(0 => 'Paal',),
        3590 => array(0 => 'DIEPENBEEK',),
        3600 => array(0 => 'GENK',),
        3620 => array(0 => 'Gellik', 1 => 'LANAKEN', 2 => 'Neerharen', 3 => 'Veldwezelt',),
        3621 => array(0 => 'Rekem',),
        3630 => array(0 => 'Eisden', 1 => 'Leut', 2 => 'MAASMECHELEN', 3 => 'Mechelen-Aan-De-Maas', 4 => 'Meeswijk', 5 => 'Opgrimbie', 6 => 'Vucht',),
        3631 => array(0 => 'Boorsem', 1 => 'Uikhoven',),
        3640 => array(0 => 'Kessenich', 1 => 'KINROOI', 2 => 'Molenbeersel', 3 => 'Ophoven',),
        3650 => array(0 => 'Dilsen', 1 => 'DILSEN-STOKKEM', 2 => 'Elen', 3 => 'Lanklaar', 4 => 'Rotem', 5 => 'Stokkem',),
        3660 => array(0 => 'OPGLABBEEK',),
        3665 => array(0 => 'AS',),
        3668 => array(0 => 'Niel-Bij-As',),
        3670 => array(0 => 'Ellikom', 1 => 'Gruitrode', 2 => 'Meeuwen', 3 => 'MEEUWEN-GRUITRODE', 4 => 'Neerglabbeek', 5 => 'Wijshagen',),
        3680 => array(0 => 'MAASEIK', 1 => 'Neeroeteren', 2 => 'Opoeteren',),
        3690 => array(0 => 'ZUTENDAAL',),
        3700 => array(0 => '\'S Herenelderen', 1 => 'Berg', 2 => 'Diets-Heur', 3 => 'Haren', 4 => 'Henis', 5 => 'Kolmont', 6 => 'Koninksem', 7 => 'Lauw', 8 => 'Mal', 9 => 'Neerrepen', 10 => 'Nerem', 11 => 'Overrepen', 12 => 'Piringen', 13 => 'Riksingen', 14 => 'Rutten', 15 => 'Sluizen', 16 => 'TONGEREN', 17 => 'Vreren', 18 => 'Widooie',),
        3717 => array(0 => 'HERSTAPPE',),
        3720 => array(0 => 'KORTESSEM',),
        3721 => array(0 => 'Vliermaalroot',),
        3722 => array(0 => 'Wintershoven',),
        3723 => array(0 => 'Guigoven',),
        3724 => array(0 => 'Vliermaal',),
        3730 => array(0 => 'HOESELT', 1 => 'Romershoven', 2 => 'Sint-Huibrechts-Hern', 3 => 'Werm',),
        3732 => array(0 => 'Schalkhoven',),
        3740 => array(0 => 'Beverst', 1 => 'BILZEN', 2 => 'Eigenbilzen', 3 => 'Grote-Spouwen', 4 => 'Hees', 5 => 'Kleine-Spouwen', 6 => 'Mopertingen', 7 => 'Munsterbilzen', 8 => 'Rijkhoven', 9 => 'Rosmeer', 10 => 'Waltwilder',),
        3742 => array(0 => 'Martenslinde',),
        3746 => array(0 => 'Hoelbeek',),
        3770 => array(0 => 'Genoelselderen', 1 => 'Herderen', 2 => 'Kanne', 3 => 'Membruggen', 4 => 'Millen', 5 => 'RIEMST', 6 => 'Val-Meer', 7 => 'Vlijtingen', 8 => 'Vroenhoven', 9 => 'Zichen-Zussen-Bolder',),
        3790 => array(0 => 'Fouron-Saint-Martin', 1 => 'FOURONS', 2 => 'Mouland',),
        3791 => array(0 => 'Remersdaal',),
        3792 => array(0 => 'Fouron-Saint-Pierre',),
        3793 => array(0 => 'Teuven',),
        3798 => array(0 => 'Fouron-Le-Comte',),
        3800 => array(0 => 'Aalst', 1 => 'Brustem', 2 => 'Engelmanshoven', 3 => 'Gelinden', 4 => 'Groot-Gelmen', 5 => 'Halmaal', 6 => 'Kerkom-Bij-Sint-Truiden', 7 => 'Ordingen', 8 => 'SINT-TRUIDEN', 9 => 'Zepperen',),
        3803 => array(0 => 'Duras', 1 => 'Gorsem', 2 => 'Runkelen', 3 => 'Wilderen',),
        3806 => array(0 => 'Velm',),
        3830 => array(0 => 'Berlingen', 1 => 'WELLEN',),
        3831 => array(0 => 'Herten',),
        3832 => array(0 => 'Ulbeek',),
        3840 => array(0 => 'Bommershoven', 1 => 'BORGLOON', 2 => 'Broekom', 3 => 'Gors-Opleeuw', 4 => 'Gotem', 5 => 'Groot-Loon', 6 => 'Haren', 7 => 'Hendrieken', 8 => 'Hoepertingen', 9 => 'Jesseren', 10 => 'Kerniel', 11 => 'Kolmont', 12 => 'Kuttekoven', 13 => 'Rijkel', 14 => 'Voort',),
        3850 => array(0 => 'Binderveld', 1 => 'Kozen', 2 => 'NIEUWERKERKEN', 3 => 'Wijer',),
        3870 => array(0 => 'Batsheers', 1 => 'Bovelingen', 2 => 'Gutshoven', 3 => 'HEERS', 4 => 'Heks', 5 => 'Horpmaal', 6 => 'Klein-Gelmen', 7 => 'Mechelen-Bovelingen', 8 => 'Mettekoven', 9 => 'Opheers', 10 => 'Rukkelingen-Loon', 11 => 'Vechmaal', 12 => 'Veulen',),
        3890 => array(0 => 'Boekhout', 1 => 'GINGELOM', 2 => 'Jeuk', 3 => 'Kortijs', 4 => 'Montenaken', 5 => 'Niel-Bij-Sint-Truiden', 6 => 'Vorsen',),
        3891 => array(0 => 'Borlo', 1 => 'Buvingen', 2 => 'Mielen-Boven-Aalst', 3 => 'Muizen',),
        3900 => array(0 => 'OVERPELT',),
        3910 => array(0 => 'NEERPELT', 1 => 'Sint-Huibrechts-Lille',),
        3920 => array(0 => 'LOMMEL',),
        3930 => array(0 => 'Achel', 1 => 'Hamont', 2 => 'HAMONT-ACHEL',),
        3940 => array(0 => 'Hechtel', 1 => 'HECHTEL-EKSEL',),
        3941 => array(0 => 'Eksel',),
        3945 => array(0 => 'HAM', 1 => 'Kwaadmechelen', 2 => 'Oostham',),
        3950 => array(0 => 'BOCHOLT', 1 => 'Kaulille', 2 => 'Reppel',),
        3960 => array(0 => 'Beek', 1 => 'BREE', 2 => 'Gerdingen', 3 => 'Opitter', 4 => 'Tongerlo',),
        3970 => array(0 => 'LEOPOLDSBURG',),
        3971 => array(0 => 'Heppen',),
        3980 => array(0 => 'TESSENDERLO',),
        3990 => array(0 => 'Grote-Brogel', 1 => 'Kleine-Brogel', 2 => 'PEER', 3 => 'Wijchmaal',),
        4000 => array(0 => 'Glain', 1 => 'LIÈGE', 2 => 'Rocourt',),
        4020 => array(0 => 'Bressoux', 1 => 'Jupille-Sur-Meuse', 2 => 'LIÈGE', 3 => 'Wandre',),
        4030 => array(0 => 'Grivegnee',),
        4031 => array(0 => 'Angleur',),
        4032 => array(0 => 'Chênee',),
        4040 => array(0 => 'HERSTAL',),
        4041 => array(0 => 'Milmort', 1 => 'Vottem',),
        4042 => array(0 => 'Liers',),
        4050 => array(0 => 'CHAUDFONTAINE',),
        4051 => array(0 => 'Vaux-Sous-Chèvremont',),
        4052 => array(0 => 'Beaufays',),
        4053 => array(0 => 'Embourg',),
        4075 => array(0 => 'CSM Liege X',),
        4099 => array(0 => 'Liège X',),
        4100 => array(0 => 'Boncelles', 1 => 'SERAING',),
        4101 => array(0 => 'Jemeppe-Sur-Meuse',),
        4102 => array(0 => 'Ougrée',),
        4120 => array(0 => 'Ehein', 1 => 'NEUPRÉ', 2 => 'Rotheux-Rimière',),
        4121 => array(0 => 'Neuville-En-Condroz',),
        4122 => array(0 => 'Plainevaux',),
        4130 => array(0 => 'ESNEUX', 1 => 'Tilff',),
        4140 => array(0 => 'Dolembreux', 1 => 'Gomzé-Andoumont', 2 => 'Rouvreux', 3 => 'SPRIMONT',),
        4141 => array(0 => 'Louveigné',),
        4160 => array(0 => 'ANTHISNES',),
        4161 => array(0 => 'Villers-Aux-Tours',),
        4162 => array(0 => 'Hody',),
        4163 => array(0 => 'Tavier',),
        4170 => array(0 => 'COMBLAIN-AU-PONT',),
        4171 => array(0 => 'Poulseur',),
        4180 => array(0 => 'Comblain-Fairon', 1 => 'Comblain-La-Tour', 2 => 'HAMOIR',),
        4181 => array(0 => 'Filot',),
        4190 => array(0 => 'FERRIÈRES', 1 => 'My', 2 => 'Vieuxville', 3 => 'Werbomont', 4 => 'Xhoris',),
        4210 => array(0 => 'BURDINNE', 1 => 'Hannêche', 2 => 'Lamontzée', 3 => 'Marneffe', 4 => 'Oteppe',),
        4217 => array(0 => 'HÉRON', 1 => 'Lavoir', 2 => 'Waret-L\'Evêque',),
        4218 => array(0 => 'Couthuin',),
        4219 => array(0 => 'Acosse', 1 => 'Ambresin', 2 => 'Meeffe', 3 => 'WASSEIGES',),
        4250 => array(0 => 'BoÃ«lhe', 1 => 'GEER', 2 => 'Hollogne-Sur-Geer', 3 => 'Lens-Saint-Servais',),
        4252 => array(0 => 'Omal',),
        4253 => array(0 => 'Darion',),
        4254 => array(0 => 'Ligney',),
        4257 => array(0 => 'BERLOZ', 1 => 'Corswarem', 2 => 'Rosoux-Crenwick',),
        4260 => array(0 => 'Avennes', 1 => 'BRAIVES', 2 => 'Ciplet', 3 => 'Fallais', 4 => 'Fumal', 5 => 'Ville-En-Hesbaye',),
        4261 => array(0 => 'Latinne',),
        4263 => array(0 => 'Tourinne',),
        4280 => array(0 => 'Abolens', 1 => 'Avernas-Le-Bauduin', 2 => 'Avin', 3 => 'Bertrée', 4 => 'Blehen', 5 => 'Cras-Avernas', 6 => 'Crehen', 7 => 'Grand-Hallet', 8 => 'HANNUT', 9 => 'Lens-Saint-Remy', 10 => 'Merdorp', 11 => 'Moxhe', 12 => 'Petit-Hallet', 13 => 'Poucet', 14 => 'Thisnes', 15 => 'Trognée', 16 => 'Villers-Le-Peuplier', 17 => 'Wansin',),
        4287 => array(0 => 'LINCENT', 1 => 'Pellaines', 2 => 'Racour',),
        4300 => array(0 => 'Bettincourt', 1 => 'Bleret', 2 => 'Bovenistier', 3 => 'Grand-Axhe', 4 => 'Lantremange', 5 => 'Oleye', 6 => 'WAREMME',),
        4317 => array(0 => 'Aineffe', 1 => 'Borlez', 2 => 'Celles', 3 => 'FAIMES', 4 => 'Les Waleffes', 5 => 'Viemme',),
        4340 => array(0 => 'AWANS', 1 => 'Fooz', 2 => 'Othée', 3 => 'Villers-L\'Evêque',),
        4342 => array(0 => 'Hognoul',),
        4347 => array(0 => 'FEXHE-LE-HAUT-CLOCHER', 1 => 'Freloux', 2 => 'Noville', 3 => 'Roloux', 4 => 'Voroux-Goreux',),
        4350 => array(0 => 'Lamine', 1 => 'Momalle', 2 => 'Pousset', 3 => 'REMICOURT',),
        4351 => array(0 => 'Hodeige',),
        4357 => array(0 => 'DONCEEL', 1 => 'Haneffe', 2 => 'Jeneffe', 3 => 'Limont',),
        4360 => array(0 => 'Bergilers', 1 => 'Grandville', 2 => 'Lens-Sur-Geer', 3 => 'OREYE', 4 => 'Otrange',),
        4367 => array(0 => 'CRISNÉE', 1 => 'Fize-Le-Marsal', 2 => 'Kemexhe', 3 => 'Odeur', 4 => 'Thys',),
        4400 => array(0 => 'Awirs', 1 => 'Chokier', 2 => 'FLÉMALLE', 3 => 'Flémalle-Grande', 4 => 'Flémalle-Haute', 5 => 'Gleixhe', 6 => 'Ivoz-Ramet', 7 => 'Mons-Lez-Liège',),
        4420 => array(0 => 'Montegnée', 1 => 'SAINT-NICOLAS', 2 => 'Tilleur',),
        4430 => array(0 => 'ANS',),
        4431 => array(0 => 'Loncin',),
        4432 => array(0 => 'Alleur', 1 => 'Xhendremael',),
        4450 => array(0 => 'JUPRELLE', 1 => 'Lantin', 2 => 'Slins',),
        4451 => array(0 => 'Voroux-Lez-Liers',),
        4452 => array(0 => 'Paifve', 1 => 'Wihogne',),
        4453 => array(0 => 'Villers-Saint-Siméon',),
        4458 => array(0 => 'Fexhe-Slins',),
        4460 => array(0 => 'Bierset', 1 => 'Grâce-Berleur', 2 => 'GRÂCE-HOLLOGNE', 3 => 'Hollogne-Aux-Pierres', 4 => 'Horion-Hozémont', 5 => 'Velroux',),
        4470 => array(0 => 'SAINT-GEORGES-SUR-MEUSE',),
        4480 => array(0 => 'Clermont-Sous-Huy', 1 => 'Ehein', 2 => 'ENGIS', 3 => 'Hermalle-Sous-Huy',),
        4500 => array(0 => 'Ben-Ahin', 1 => 'HUY', 2 => 'Tihange',),
        4520 => array(0 => 'Antheit', 1 => 'Bas-Oha', 2 => 'Huccorgne', 3 => 'Moha', 4 => 'Vinalmont', 5 => 'WANZE',),
        4530 => array(0 => 'Fize-Fontaine', 1 => 'Vaux-Et-Borset', 2 => 'Vieux-Waleffe', 3 => 'VILLERS-LE-BOUILLET', 4 => 'Warnant-Dreye',),
        4537 => array(0 => 'Bodegnée', 1 => 'Chapon-Seraing', 2 => 'Seraing-Le-Château', 3 => 'VERLAINE',),
        4540 => array(0 => 'AMAY', 1 => 'Ampsin', 2 => 'Flône', 3 => 'Jehay', 4 => 'Ombret',),
        4550 => array(0 => 'NANDRIN', 1 => 'Saint-Séverin', 2 => 'Villers-Le-Temple', 3 => 'Yernée-Fraineux',),
        4557 => array(0 => 'Abée', 1 => 'Fraiture', 2 => 'Ramelot', 3 => 'Seny', 4 => 'Soheit-Tinlot', 5 => 'TINLOT',),
        4560 => array(0 => 'Bois-Et-Borsu', 1 => 'CLAVIER', 2 => 'Les Avins', 3 => 'Ocquier', 4 => 'Pailhe', 5 => 'Terwagne',),
        4570 => array(0 => 'MARCHIN', 1 => 'Vyle-Et-Tharoul',),
        4577 => array(0 => 'MODAVE', 1 => 'Outrelouxhe', 2 => 'Strée-Lez-Huy', 3 => 'Vierset-Barse',),
        4590 => array(0 => 'Ellemelle', 1 => 'OUFFET', 2 => 'Warzée',),
        4600 => array(0 => 'Lanaye', 1 => 'Lixhe', 2 => 'Richelle', 3 => 'VISÉ',),
        4601 => array(0 => 'Argenteau',),
        4602 => array(0 => 'Cheratte',),
        4606 => array(0 => 'Saint-André',),
        4607 => array(0 => 'Berneau', 1 => 'Bombaye', 2 => 'DALHEM', 3 => 'Feneur', 4 => 'Mortroux',),
        4608 => array(0 => 'Neufchâteau', 1 => 'Warsage',),
        4610 => array(0 => 'Bellaire', 1 => 'BEYNE-HEUSAY', 2 => 'Queue-Du-Bois',),
        4620 => array(0 => 'FLÉRON',),
        4621 => array(0 => 'Retinne',),
        4623 => array(0 => 'Magnée',),
        4624 => array(0 => 'Romsée',),
        4630 => array(0 => 'Ayeneux', 1 => 'Micheroux', 2 => 'SOUMAGNE', 3 => 'Tignée',),
        4631 => array(0 => 'Evegnée',),
        4632 => array(0 => 'Cérexhe-Heuseux',),
        4633 => array(0 => 'Melen',),
        4650 => array(0 => 'Chaineux', 1 => 'Grand-Rechain', 2 => 'HERVE', 3 => 'Julémont',),
        4651 => array(0 => 'Battice',),
        4652 => array(0 => 'Xhendelesse',),
        4653 => array(0 => 'Bolland',),
        4654 => array(0 => 'Charneux',),
        4670 => array(0 => 'BLÉGNY', 1 => 'Mortier', 2 => 'Trembleur',),
        4671 => array(0 => 'Barchon', 1 => 'Housse', 2 => 'Saive',),
        4672 => array(0 => 'Saint-Remy',),
        4680 => array(0 => 'Hermée', 1 => 'OUPEYE',),
        4681 => array(0 => 'Hermalle-Sous-Argenteau',),
        4682 => array(0 => 'Heure-Le-Romain', 1 => 'Houtain-Saint-Siméon',),
        4683 => array(0 => 'Vivegnis',),
        4684 => array(0 => 'Haccourt',),
        4690 => array(0 => 'BASSENGE', 1 => 'Boirs', 2 => 'Eben-Emael', 3 => 'Glons', 4 => 'Roclenge-Sur-Geer', 5 => 'Wonck',),
        4700 => array(0 => 'EUPEN',),
        4701 => array(0 => 'Kettenis',),
        4710 => array(0 => 'LONTZEN',),
        4711 => array(0 => 'Walhorn',),
        4720 => array(0 => 'LA CALAMINE',),
        4721 => array(0 => 'Neu-Moresnet',),
        4728 => array(0 => 'Hergenrath',),
        4730 => array(0 => 'Hauset', 1 => 'RAEREN',),
        4731 => array(0 => 'Eynatten',),
        4750 => array(0 => 'BUTGENBACH', 1 => 'Elsenborn',),
        4760 => array(0 => 'BULLANGE', 1 => 'Manderfeld',),
        4761 => array(0 => 'Rocherath',),
        4770 => array(0 => 'AMBLÈVE', 1 => 'Meyerode',),
        4771 => array(0 => 'Heppenbach',),
        4780 => array(0 => 'Recht', 1 => 'SAINT-VITH',),
        4782 => array(0 => 'Schoenberg',),
        4783 => array(0 => 'Lommersweiler',),
        4784 => array(0 => 'Crombach',),
        4790 => array(0 => 'BURG-REULAND', 1 => 'Reuland',),
        4791 => array(0 => 'Thommen',),
        4800 => array(0 => 'Ensival', 1 => 'Lambermont', 2 => 'Petit-Rechain', 3 => 'Polleur', 4 => 'VERVIERS',),
        4801 => array(0 => 'Stembert',),
        4802 => array(0 => 'Heusy',),
        4820 => array(0 => 'DISON',),
        4821 => array(0 => 'Andrimont',),
        4830 => array(0 => 'LIMBOURG',),
        4831 => array(0 => 'Bilstain',),
        4834 => array(0 => 'Goé',),
        4837 => array(0 => 'BAELEN', 1 => 'Membach',),
        4840 => array(0 => 'WELKENRAEDT',),
        4841 => array(0 => 'Henri-Chapelle',),
        4845 => array(0 => 'JALHAY', 1 => 'Sart-Lez-Spa',),
        4850 => array(0 => 'Montzen', 1 => 'Moresnet', 2 => 'PLOMBIÈRES',),
        4851 => array(0 => 'Gemmenich', 1 => 'Sippenaeken',),
        4852 => array(0 => 'Hombourg',),
        4860 => array(0 => 'Cornesse', 1 => 'PEPINSTER', 2 => 'Wegnez',),
        4861 => array(0 => 'Soiron',),
        4870 => array(0 => 'Forêt', 1 => 'Fraipont', 2 => 'Nessonvaux', 3 => 'TROOZ',),
        4877 => array(0 => 'OLNE',),
        4880 => array(0 => 'AUBEL',),
        4890 => array(0 => 'Clermont', 1 => 'Thimister', 2 => 'THIMISTER-CLERMONT',),
        4900 => array(0 => 'SPA',),
        4910 => array(0 => 'La Reid', 1 => 'Polleur', 2 => 'THEUX',),
        4920 => array(0 => 'AYWAILLE', 1 => 'Ernonheid', 2 => 'Harzé', 3 => 'Louveigné', 4 => 'Sougné-Remouchamps',),
        4950 => array(0 => 'Faymonville', 1 => 'Robertville', 2 => 'Sourbrodt', 3 => 'WAIMES',),
        4960 => array(0 => 'Bellevaux-Ligneuville', 1 => 'Bevercé', 2 => 'MALMEDY',),
        4970 => array(0 => 'Francorchamps', 1 => 'STAVELOT',),
        4980 => array(0 => 'Fosse', 1 => 'TROIS-PONTS', 2 => 'Wanne',),
        4983 => array(0 => 'Basse-Bodeux',),
        4987 => array(0 => 'Chevron', 1 => 'La Gleize', 2 => 'Lorcé', 3 => 'Rahier', 4 => 'STOUMONT',),
        4990 => array(0 => 'Arbrefontaine', 1 => 'Bra', 2 => 'LIERNEUX',),
        5000 => array(0 => 'Beez', 1 => 'NAMUR',),
        5001 => array(0 => 'Belgrade',),
        5002 => array(0 => 'Saint-Servais',),
        5003 => array(0 => 'Saint-Marc',),
        5004 => array(0 => 'Bouge',),
        5010 => array(0 => 'SA SudPresse',),
        5012 => array(0 => 'Parlement Wallon',),
        5020 => array(0 => 'Champion', 1 => 'Daussoulx', 2 => 'Flawinne', 3 => 'Malonne', 4 => 'Suarlée', 5 => 'Temploux', 6 => 'Vedrin',),
        5021 => array(0 => 'Boninne',),
        5022 => array(0 => 'Cognelée',),
        5024 => array(0 => 'Gelbressée', 1 => 'Marche-Les-Dames',),
        5030 => array(0 => 'Beuzet', 1 => 'Ernage', 2 => 'GEMBLOUX', 3 => 'Grand-Manil', 4 => 'Lonzée', 5 => 'Sauvenière',),
        5031 => array(0 => 'Grand-Leez',),
        5032 => array(0 => 'Bossière', 1 => 'Bothey', 2 => 'Corroy-Le-Château', 3 => 'Isnes', 4 => 'Mazy',),
        5060 => array(0 => 'Arsimont', 1 => 'Auvelais', 2 => 'Falisolle', 3 => 'Keumiée', 4 => 'Moignelée', 5 => 'SAMBREVILLE', 6 => 'Tamines', 7 => 'Velaine-Sur-Sambre',),
        5070 => array(0 => 'Aisemont', 1 => 'FOSSES-LA-VILLE', 2 => 'Le Roux', 3 => 'Sart-Eustache', 4 => 'Sart-Saint-Laurent', 5 => 'Vitrival',),
        5080 => array(0 => 'Emines', 1 => 'LA BRUYÈRE', 2 => 'Rhisnes', 3 => 'Villers-Lez-Heest', 4 => 'Warisoulx',),
        5081 => array(0 => 'Bovesse', 1 => 'Meux', 2 => 'Saint-Denis-Bovesse',),
        5100 => array(0 => 'Dave', 1 => 'Jambes', 2 => 'Naninne', 3 => 'Wépion', 4 => 'Wierde',),
        5101 => array(0 => 'Erpent', 1 => 'Lives-Sur-Meuse', 2 => 'Loyers',),
        5140 => array(0 => 'Boignée', 1 => 'Ligny', 2 => 'SOMBREFFE', 3 => 'Tongrinne',),
        5150 => array(0 => 'FLOREFFE', 1 => 'Floriffoux', 2 => 'Franière', 3 => 'Soye',),
        5170 => array(0 => 'Arbre', 1 => 'Bois-De-Villers', 2 => 'Lesve', 3 => 'Lustin', 4 => 'PROFONDEVILLE', 5 => 'Rivière',),
        5190 => array(0 => 'Balâtre', 1 => 'Ham-Sur-Sambre', 2 => 'JEMEPPE-SUR-SAMBRE', 3 => 'Mornimont', 4 => 'Moustier-Sur-Sambre', 5 => 'Onoz', 6 => 'Saint-Martin', 7 => 'Spy',),
        5300 => array(0 => 'ANDENNE', 1 => 'Bonneville', 2 => 'Coutisse', 3 => 'Landenne', 4 => 'Maizeret', 5 => 'Namêche', 6 => 'Sclayn', 7 => 'Seilles', 8 => 'Thon', 9 => 'Vezin',),
        5310 => array(0 => 'Aische-En-Refail', 1 => 'Bolinne', 2 => 'Boneffe', 3 => 'Branchon', 4 => 'Dhuy', 5 => 'EGHEZÉE', 6 => 'Hanret', 7 => 'Leuze', 8 => 'Liernu', 9 => 'Longchamps', 10 => 'Mehaigne', 11 => 'Noville-Sur-Méhaigne', 12 => 'Saint-Germain', 13 => 'Taviers', 14 => 'Upigny', 15 => 'Waret-La-Chaussée',),
        5330 => array(0 => 'ASSESSE', 1 => 'Maillen', 2 => 'Sart-Bernard',),
        5332 => array(0 => 'Crupet',),
        5333 => array(0 => 'Sorinne-La-Longue',),
        5334 => array(0 => 'Florée',),
        5336 => array(0 => 'Courrière',),
        5340 => array(0 => 'Faulx-Les-Tombes', 1 => 'GESVES', 2 => 'Haltinne', 3 => 'Mozet', 4 => 'Sorée',),
        5350 => array(0 => 'Evelette', 1 => 'OHEY',),
        5351 => array(0 => 'Haillot',),
        5352 => array(0 => 'Perwez-Haillot',),
        5353 => array(0 => 'Goesnes',),
        5354 => array(0 => 'Jallet',),
        5360 => array(0 => 'HAMOIS', 1 => 'Natoye',),
        5361 => array(0 => 'Mohiville', 1 => 'Scy',),
        5362 => array(0 => 'Achet',),
        5363 => array(0 => 'Emptinne',),
        5364 => array(0 => 'Schaltin',),
        5370 => array(0 => 'Barvaux-Condroz', 1 => 'Flostoy', 2 => 'HAVELANGE', 3 => 'Jeneffe', 4 => 'Porcheresse', 5 => 'Verlée',),
        5372 => array(0 => 'Méan',),
        5374 => array(0 => 'Maffe',),
        5376 => array(0 => 'Miécret',),
        5377 => array(0 => 'Baillonville', 1 => 'Bonsin', 2 => 'Heure', 3 => 'Hogne', 4 => 'Nettinne', 5 => 'Noiseux', 6 => 'Sinsin', 7 => 'SOMME-LEUZE', 8 => 'Waillet',),
        5380 => array(0 => 'Bierwart', 1 => 'Cortil-Wodon', 2 => 'FERNELMONT', 3 => 'Forville', 4 => 'Franc-Waret', 5 => 'Hemptinne', 6 => 'Hingeon', 7 => 'Marchovelette', 8 => 'Noville-Les-Bois', 9 => 'Pontillas', 10 => 'Tillier',),
        5500 => array(0 => 'Anseremme', 1 => 'Bouvignes-Sur-Meuse', 2 => 'DINANT', 3 => 'Dréhance', 4 => 'Falmagne', 5 => 'Falmignoul', 6 => 'Furfooz',),
        5501 => array(0 => 'Lisogne',),
        5502 => array(0 => 'Thynes',),
        5503 => array(0 => 'Sorinnes',),
        5504 => array(0 => 'Foy-Notre-Dame',),
        5520 => array(0 => 'Anthée', 1 => 'ONHAYE',),
        5521 => array(0 => 'Serville',),
        5522 => array(0 => 'Falaen',),
        5523 => array(0 => 'Sommière', 1 => 'Weillen',),
        5524 => array(0 => 'Gerin',),
        5530 => array(0 => 'Dorinne', 1 => 'Durnal', 2 => 'Evrehailles', 3 => 'Godinne', 4 => 'Houx', 5 => 'Mont', 6 => 'Purnode', 7 => 'Spontin', 8 => 'YVOIR',),
        5537 => array(0 => 'ANHÉE', 1 => 'Annevoie-Rouillon', 2 => 'Bioul', 3 => 'Denée', 4 => 'Haut-Le-Wastia', 5 => 'Sosoye', 6 => 'Warnant',),
        5540 => array(0 => 'HASTIÈRE', 1 => 'Hastière-Lavaux', 2 => 'Hermeton-Sur-Meuse', 3 => 'Waulsort',),
        5541 => array(0 => 'Hastière-Par-Delà',),
        5542 => array(0 => 'Blaimont',),
        5543 => array(0 => 'Heer',),
        5544 => array(0 => 'Agimont',),
        5550 => array(0 => 'Alle', 1 => 'Bagimont', 2 => 'Bohan', 3 => 'Chairière', 4 => 'Laforet', 5 => 'Membre', 6 => 'Mouzaive', 7 => 'Nafraiture', 8 => 'Orchimont', 9 => 'Pussemange', 10 => 'Sugny', 11 => 'VRESSE-SUR-SEMOIS',),
        5555 => array(0 => 'Baillamont', 1 => 'Bellefontaine', 2 => 'BIÈVRE', 3 => 'Cornimont', 4 => 'Graide', 5 => 'Gros-Fays', 6 => 'Monceau-En-Ardenne', 7 => 'Naomé', 8 => 'Oizy', 9 => 'Petit-Fays',),
        5560 => array(0 => 'Ciergnon', 1 => 'Finnevaux', 2 => 'HOUYET', 3 => 'Hulsonniaux', 4 => 'Mesnil-Eglise', 5 => 'Mesnil-Saint-Blaise',),
        5561 => array(0 => 'Celles',),
        5562 => array(0 => 'Custinne',),
        5563 => array(0 => 'Hour',),
        5564 => array(0 => 'Wanlin',),
        5570 => array(0 => 'Baronville', 1 => 'BEAURAING', 2 => 'Dion', 3 => 'Felenne', 4 => 'Feschaux', 5 => 'Honnay', 6 => 'Javingue', 7 => 'Vonêche', 8 => 'Wancennes', 9 => 'Winenne',),
        5571 => array(0 => 'Wiesme',),
        5572 => array(0 => 'Focant',),
        5573 => array(0 => 'Martouzin-Neuville',),
        5574 => array(0 => 'Pondrôme',),
        5575 => array(0 => 'Bourseigne-Neuve', 1 => 'Bourseigne-Vieille', 2 => 'GEDINNE', 3 => 'Houdremont', 4 => 'Louette-Saint-Denis', 5 => 'Louette-Saint-Pierre', 6 => 'Malvoisin', 7 => 'Patignies', 8 => 'Rienne', 9 => 'Sart-Custinne', 10 => 'Vencimont', 11 => 'Willerzie',),
        5576 => array(0 => 'Froidfontaine',),
        5580 => array(0 => 'Ave-Et-Auffe', 1 => 'Buissonville', 2 => 'Eprave', 3 => 'Han-Sur-Lesse', 4 => 'Jemelle', 5 => 'Lavaux-Saint-Anne', 6 => 'Lessive', 7 => 'Mont-Gauthier', 8 => 'ROCHEFORT', 9 => 'Villers-Sur-Lesse', 10 => 'Wavreille',),
        5589 => array(0 => 'Jemelle',),
        5590 => array(0 => 'Achêne', 1 => 'Braibant', 2 => 'Chevetogne', 3 => 'CINEY', 4 => 'Conneux', 5 => 'Haversin', 6 => 'Leignon', 7 => 'Pessoux', 8 => 'Serinchamps', 9 => 'Sovet',),
        5600 => array(0 => 'Fagnolle', 1 => 'Franchimont', 2 => 'Jamagne', 3 => 'Jamiolle', 4 => 'Merlemont', 5 => 'Neuville', 6 => 'Omezée', 7 => 'PHILIPPEVILLE', 8 => 'Roly', 9 => 'Romedenne', 10 => 'Samart', 11 => 'Sart-En-Fagne', 12 => 'Sautour', 13 => 'Surice', 14 => 'Villers-En-Fagne', 15 => 'Villers-Le-Gambon', 16 => 'Vodecée',),
        5620 => array(0 => 'Corenne', 1 => 'Flavion', 2 => 'FLORENNES', 3 => 'Hemptinne-Lez-Florennes', 4 => 'Morville', 5 => 'Rosée', 6 => 'Saint-Aubin',),
        5621 => array(0 => 'Hanzinelle', 1 => 'Hanzinne', 2 => 'Morialmé', 3 => 'Thy-Le-Baudouin',),
        5630 => array(0 => 'CERFONTAINE', 1 => 'Daussois', 2 => 'Senzeille', 3 => 'Silenrieux', 4 => 'Soumoy', 5 => 'Villers-Deux-Eglises',),
        5640 => array(0 => 'Biesme', 1 => 'Biesmerée', 2 => 'Graux', 3 => 'METTET', 4 => 'Oret', 5 => 'Saint-Gérard',),
        5641 => array(0 => 'Furnaux',),
        5644 => array(0 => 'Ermeton-Sur-Biert',),
        5646 => array(0 => 'Stave',),
        5650 => array(0 => 'Castillon', 1 => 'Chastrès', 2 => 'Clermont', 3 => 'Fontenelle', 4 => 'Fraire', 5 => 'Pry', 6 => 'Vogenée', 7 => 'WALCOURT', 8 => 'Yves-Gomezée',),
        5651 => array(0 => 'Berzée', 1 => 'Gourdinne', 2 => 'Laneffe', 3 => 'Rognée', 4 => 'Somzée', 5 => 'Tarcienne', 6 => 'Thy-Le-Château',),
        5660 => array(0 => 'Aublain', 1 => 'Boussu-En-Fagne', 2 => 'Brûly', 3 => 'Brûly-De-Pesche', 4 => 'COUVIN', 5 => 'Cul-Des-Sarts', 6 => 'Dailly', 7 => 'Frasnes', 8 => 'Gonrieux', 9 => 'Mariembourg', 10 => 'Pesche', 11 => 'Petigny', 12 => 'Petite-Chapelle', 13 => 'Presgaux',),
        5670 => array(0 => 'Dourbes', 1 => 'Le Mesnil', 2 => 'Mazée', 3 => 'Nismes', 4 => 'Oignies-En-Thiérache', 5 => 'Olloy-Sur-Viroin', 6 => 'Treignes', 7 => 'Vierves-Sur-Viroin', 8 => 'VIROINVAL',),
        5680 => array(0 => 'DOISCHE', 1 => 'Gimnée', 2 => 'Gochenée', 3 => 'Matagne-La-Grande', 4 => 'Matagne-La-Petite', 5 => 'Niverlée', 6 => 'Romerée', 7 => 'Soulme', 8 => 'Vaucelles', 9 => 'Vodelée',),
        6000 => array(0 => 'CHARLEROI',),
        6001 => array(0 => 'Marcinelle',),
        6010 => array(0 => 'Couillet',),
        6020 => array(0 => 'Dampremy',),
        6030 => array(0 => 'Goutroux', 1 => 'Marchienne-Au-Pont',),
        6031 => array(0 => 'Monceau-Sur-Sambre',),
        6032 => array(0 => 'Mont-Sur-Marchienne',),
        6040 => array(0 => 'Jumet',),
        6041 => array(0 => 'Gosselies',),
        6042 => array(0 => 'Lodelinsart',),
        6043 => array(0 => 'Ransart',),
        6044 => array(0 => 'Roux',),
        6060 => array(0 => 'Gilly',),
        6061 => array(0 => 'Montignies-Sur-Sambre',),
        6075 => array(0 => 'CSM Charleroi X',),
        6099 => array(0 => 'Charleroi X',),
        6110 => array(0 => 'MONTIGNY-LE-TILLEUL',),
        6111 => array(0 => 'Landelies',),
        6120 => array(0 => 'Cour-Sur-Heure', 1 => 'HAM-SUR-HEURE', 2 => 'Jamioulx', 3 => 'Marbaix', 4 => 'Nalinnes',),
        6140 => array(0 => 'FONTAINE-L\'EVÊQUE',),
        6141 => array(0 => 'Forchies-La-Marche',),
        6142 => array(0 => 'Leernes',),
        6150 => array(0 => 'ANDERLUES',),
        6180 => array(0 => 'COURCELLES',),
        6181 => array(0 => 'Gouy-Lez-Piéton',),
        6182 => array(0 => 'Souvret',),
        6183 => array(0 => 'Trazegnies',),
        6200 => array(0 => 'Bouffioulx', 1 => 'CHÂTELET', 2 => 'Châtelineau',),
        6210 => array(0 => 'Frasnes-Lez-Gosselies', 1 => 'LES BONS VILLERS', 2 => 'Rèves', 3 => 'Villers-Perwin', 4 => 'Wayaux',),
        6211 => array(0 => 'Mellet',),
        6220 => array(0 => 'FLEURUS', 1 => 'Heppignies', 2 => 'Lambusart', 3 => 'Wangenies',),
        6221 => array(0 => 'Saint-Amand',),
        6222 => array(0 => 'Brye',),
        6223 => array(0 => 'Wagnelée',),
        6224 => array(0 => 'Wanfercée-Baulet',),
        6230 => array(0 => 'Buzet', 1 => 'Obaix', 2 => 'PONT-à-CELLES', 3 => 'Thiméon', 4 => 'Viesville',),
        6238 => array(0 => 'Liberchies', 1 => 'Luttre',),
        6240 => array(0 => 'FARCIENNES', 1 => 'Pironchamps',),
        6250 => array(0 => 'Aiseau', 1 => 'AISEAU-PRESLES', 2 => 'Pont-De-Loup', 3 => 'Presles', 4 => 'Roselies',),
        6280 => array(0 => 'Acoz', 1 => 'GERPINNES', 2 => 'Gougnies', 3 => 'Joncret', 4 => 'Loverval', 5 => 'Villers-Poterie',),
        6440 => array(0 => 'Boussu-Lez-Walcourt', 1 => 'Fourbechies', 2 => 'FROIDCHAPELLE', 3 => 'Vergnies',),
        6441 => array(0 => 'Erpion',),
        6460 => array(0 => 'Bailièvre', 1 => 'CHIMAY', 2 => 'Robechies', 3 => 'Saint-Remy', 4 => 'Salles', 5 => 'Villers-La-Tour',),
        6461 => array(0 => 'Virelles',),
        6462 => array(0 => 'Vaulx-Lez-Chimay',),
        6463 => array(0 => 'Lompret',),
        6464 => array(0 => 'Baileux', 1 => 'Bourlers', 2 => 'Forges', 3 => 'L\'Escaillère', 4 => 'Rièzes',),
        6470 => array(0 => 'Grandrieu', 1 => 'Montbliart', 2 => 'Rance', 3 => 'Sautin', 4 => 'Sivry', 5 => 'SIVRY-RANCE',),
        6500 => array(0 => 'Barbençon', 1 => 'BEAUMONT', 2 => 'Leugnies', 3 => 'Leval-Chaudeville', 4 => 'Renlies', 5 => 'Solre-Saint-Géry', 6 => 'Thirimont',),
        6511 => array(0 => 'Strée',),
        6530 => array(0 => 'Leers-Et-Fosteau', 1 => 'THUIN',),
        6531 => array(0 => 'Biesme-Sous-Thuin',),
        6532 => array(0 => 'Ragnies',),
        6533 => array(0 => 'Biercée',),
        6534 => array(0 => 'Gozée',),
        6536 => array(0 => 'Donstiennes', 1 => 'Thuillies',),
        6540 => array(0 => 'LOBBES', 1 => 'Mont-Sainte-Geneviève',),
        6542 => array(0 => 'Sars-La-Buissière',),
        6543 => array(0 => 'Bienne-Lez-Happart',),
        6560 => array(0 => 'Bersillies-L\'Abbaye', 1 => 'ERQUELINNES', 2 => 'Grand-Reng', 3 => 'Hantes-Wihéries', 4 => 'Montignies-Saint-Christophe', 5 => 'Solre-Sur-Sambre',),
        6567 => array(0 => 'Fontaine-Valmont', 1 => 'Labuissière', 2 => 'MERBES-LE-CHÂTEAU', 3 => 'Merbes-Sainte-Marie',),
        6590 => array(0 => 'MOMIGNIES',),
        6591 => array(0 => 'Macon',),
        6592 => array(0 => 'Monceau-Imbrechies',),
        6593 => array(0 => 'Macquenoise',),
        6594 => array(0 => 'Beauwelz',),
        6596 => array(0 => 'Forge-Philippe', 1 => 'Seloignes',),
        6600 => array(0 => 'BASTOGNE', 1 => 'Longvilly', 2 => 'Noville', 3 => 'Villers-La-Bonne-Eau', 4 => 'Wardin',),
        6630 => array(0 => 'MARTELANGE',),
        6637 => array(0 => 'FAUVILLERS', 1 => 'Hollange', 2 => 'Tintange',),
        6640 => array(0 => 'Hompré', 1 => 'Morhet', 2 => 'Nives', 3 => 'Sibret', 4 => 'Vaux-Lez-Rosières', 5 => 'VAUX-SUR-SÛRE',),
        6642 => array(0 => 'Juseret',),
        6660 => array(0 => 'HOUFFALIZE', 1 => 'Nadrin',),
        6661 => array(0 => 'Mont', 1 => 'Tailles',),
        6662 => array(0 => 'Tavigny',),
        6663 => array(0 => 'Mabompré',),
        6666 => array(0 => 'Wibrin',),
        6670 => array(0 => 'GOUVY', 1 => 'Limerlé',),
        6671 => array(0 => 'Bovigny',),
        6672 => array(0 => 'Beho',),
        6673 => array(0 => 'Cherain',),
        6674 => array(0 => 'Montleban',),
        6680 => array(0 => 'Amberloup', 1 => 'SAINTE-ODE', 2 => 'Tillet',),
        6681 => array(0 => 'Lavacherie',),
        6686 => array(0 => 'Flamierge',),
        6687 => array(0 => 'BERTOGNE',),
        6688 => array(0 => 'Longchamps',),
        6690 => array(0 => 'Bihain', 1 => 'VIELSALM',),
        6692 => array(0 => 'Petit-Thier',),
        6698 => array(0 => 'Grand-Halleux',),
        6700 => array(0 => 'ARLON', 1 => 'Bonnert', 2 => 'Heinsch', 3 => 'Toernich',),
        6704 => array(0 => 'Guirsch',),
        6706 => array(0 => 'Autelbas',),
        6717 => array(0 => 'ATTERT', 1 => 'Nobressart', 2 => 'Nothomb', 3 => 'Thiaumont', 4 => 'Tontelange',),
        6720 => array(0 => 'HABAY', 1 => 'Habay-La-Neuve', 2 => 'Hachy',),
        6721 => array(0 => 'Anlier',),
        6723 => array(0 => 'Habay-La-Vieille',),
        6724 => array(0 => 'Houdemont', 1 => 'Rulles',),
        6730 => array(0 => 'Bellefontaine', 1 => 'Rossignol', 2 => 'Saint-Vincent', 3 => 'TINTIGNY',),
        6740 => array(0 => 'ETALLE', 1 => 'Sainte-Marie-Sur-Semois', 2 => 'Villers-Sur-Semois',),
        6741 => array(0 => 'Vance',),
        6742 => array(0 => 'Chantemelle',),
        6743 => array(0 => 'Buzenol',),
        6747 => array(0 => 'Châtillon', 1 => 'Meix-Le-Tige', 2 => 'SAINT-LÉGER',),
        6750 => array(0 => 'MUSSON', 1 => 'Mussy-La-Ville', 2 => 'Signeulx',),
        6760 => array(0 => 'Bleid', 1 => 'Ethe', 2 => 'Ruette', 3 => 'VIRTON',),
        6761 => array(0 => 'Latour',),
        6762 => array(0 => 'Saint-Mard',),
        6767 => array(0 => 'Dampicourt', 1 => 'Harnoncourt', 2 => 'Lamorteau', 3 => 'ROUVROY', 4 => 'Torgny',),
        6769 => array(0 => 'Gérouville', 1 => 'MEIX-DEVANT-VIRTON', 2 => 'Robelmont', 3 => 'Sommethonne', 4 => 'Villers-La-Loue',),
        6780 => array(0 => 'Hondelange', 1 => 'MESSANCY', 2 => 'Wolkrange',),
        6781 => array(0 => 'Sélange',),
        6782 => array(0 => 'Habergy',),
        6790 => array(0 => 'AUBANGE',),
        6791 => array(0 => 'Athus',),
        6792 => array(0 => 'Halanzy', 1 => 'Rachecourt',),
        6800 => array(0 => 'Bras', 1 => 'Freux', 2 => 'LIBRAMONT-CHEVIGNY', 3 => 'Moircy', 4 => 'Recogne', 5 => 'Remagne', 6 => 'Saint-Pierre', 7 => 'Sainte-Marie-Chevigny',),
        6810 => array(0 => 'CHINY', 1 => 'Izel', 2 => 'Jamoigne',),
        6811 => array(0 => 'Les Bulles',),
        6812 => array(0 => 'Suxy',),
        6813 => array(0 => 'Termes',),
        6820 => array(0 => 'FLORENVILLE', 1 => 'Fontenoille', 2 => 'Muno', 3 => 'Sainte-Cécile',),
        6821 => array(0 => 'Lacuisine',),
        6823 => array(0 => 'Villers-Devant-Orval',),
        6824 => array(0 => 'Chassepierre',),
        6830 => array(0 => 'BOUILLON', 1 => 'Les Hayons', 2 => 'Poupehan', 3 => 'Rochehaut',),
        6831 => array(0 => 'Noirfontaine',),
        6832 => array(0 => 'Sensenruth',),
        6833 => array(0 => 'Ucimont', 1 => 'Vivy',),
        6834 => array(0 => 'Bellevaux',),
        6836 => array(0 => 'Dohan',),
        6838 => array(0 => 'Corbion',),
        6840 => array(0 => 'Grandvoir', 1 => 'Grapfontaine', 2 => 'Hamipré', 3 => 'Longlier', 4 => 'NEUFCHÂTEAU', 5 => 'Tournay',),
        6850 => array(0 => 'Carlsbourg', 1 => 'Offagne', 2 => 'PALISEUL',),
        6851 => array(0 => 'Nollevaux',),
        6852 => array(0 => 'Maissin', 1 => 'Opont',),
        6853 => array(0 => 'Framont',),
        6856 => array(0 => 'Fays-Les-Veneurs',),
        6860 => array(0 => 'Assenois', 1 => 'Ebly', 2 => 'LÉGLISE', 3 => 'Mellier', 4 => 'Witry',),
        6870 => array(0 => 'Arville', 1 => 'Awenne', 2 => 'Hatrival', 3 => 'Mirwart', 4 => 'SAINT-HUBERT', 5 => 'Vesqueville',),
        6880 => array(0 => 'Auby-Sur-Semois', 1 => 'BERTRIX', 2 => 'Cugnon', 3 => 'Jehonville', 4 => 'Orgeo',),
        6887 => array(0 => 'HERBEUMONT', 1 => 'Saint-Médard', 2 => 'Straimont',),
        6890 => array(0 => 'Anloy', 1 => 'LIBIN', 2 => 'Ochamps', 3 => 'Redu', 4 => 'Smuid', 5 => 'Transinne', 6 => 'Villance',),
        6900 => array(0 => 'Aye', 1 => 'Hargimont', 2 => 'Humain', 3 => 'MARCHE-EN-FAMENNE', 4 => 'On', 5 => 'Roy', 6 => 'Waha',),
        6920 => array(0 => 'Sohier', 1 => 'WELLIN',),
        6921 => array(0 => 'Chanly',),
        6922 => array(0 => 'Halma',),
        6924 => array(0 => 'Lomprez',),
        6927 => array(0 => 'Bure', 1 => 'Grupont', 2 => 'Resteigne', 3 => 'TELLIN',),
        6929 => array(0 => 'DAVERDISSE', 1 => 'Gembes', 2 => 'Haut-Fays', 3 => 'Porcheresse',),
        6940 => array(0 => 'Barvaux-Sur-Ourthe', 1 => 'DURBUY', 2 => 'Grandhan', 3 => 'Septon', 4 => 'Wéris',),
        6941 => array(0 => 'Bende', 1 => 'Bomal-Sur-Ourthe', 2 => 'Borlon', 3 => 'Heyd', 4 => 'Izier', 5 => 'Tohogne', 6 => 'Villers-Sainte-Gertrude',),
        6950 => array(0 => 'Harsin', 1 => 'NASSOGNE',),
        6951 => array(0 => 'Bande',),
        6952 => array(0 => 'Grune',),
        6953 => array(0 => 'Ambly', 1 => 'Forrières', 2 => 'Lesterny', 3 => 'Masbourg',),
        6960 => array(0 => 'Dochamps', 1 => 'Grandmenil', 2 => 'Harre', 3 => 'Malempré', 4 => 'MANHAY', 5 => 'Odeigne', 6 => 'Vaux-Chavanne',),
        6970 => array(0 => 'TENNEVILLE',),
        6971 => array(0 => 'Champlon',),
        6972 => array(0 => 'Erneuville',),
        6980 => array(0 => 'Beausaint', 1 => 'LA ROCHE-EN-ARDENNE',),
        6982 => array(0 => 'Samrée',),
        6983 => array(0 => 'Ortho',),
        6984 => array(0 => 'Hives',),
        6986 => array(0 => 'Halleux',),
        6987 => array(0 => 'Beffe', 1 => 'Hodister', 2 => 'Marcourt', 3 => 'RENDEUX',),
        6990 => array(0 => 'Fronville', 1 => 'Hampteau', 2 => 'HOTTON', 3 => 'Marenne',),
        6997 => array(0 => 'Amonines', 1 => 'EREZÉE', 2 => 'Mormont', 3 => 'Soy',),
        7000 => array(0 => 'MONS',),
        7010 => array(0 => 'SHAPE',),
        7011 => array(0 => 'Ghlin',),
        7012 => array(0 => 'Flénu', 1 => 'Jemappes',),
        7020 => array(0 => 'Maisières', 1 => 'Nimy',),
        7021 => array(0 => 'Havre',),
        7022 => array(0 => 'Harmignies', 1 => 'Harveng', 2 => 'Hyon', 3 => 'Mesvin', 4 => 'Nouvelles',),
        7024 => array(0 => 'Ciply',),
        7030 => array(0 => 'Saint-Symphorien',),
        7031 => array(0 => 'Villers-Saint-Ghislain',),
        7032 => array(0 => 'Spiennes',),
        7033 => array(0 => 'Cuesmes',),
        7034 => array(0 => 'Obourg', 1 => 'Saint-Denis',),
        7040 => array(0 => 'Asquillies', 1 => 'Aulnois', 2 => 'Blaregnies', 3 => 'Bougnies', 4 => 'Genly', 5 => 'Goegnies-Chaussée', 6 => 'QUÉVY', 7 => 'Quévy-Le-Grand', 8 => 'Quévy-Le-Petit',),
        7041 => array(0 => 'Givry', 1 => 'Havay',),
        7050 => array(0 => 'Erbaut', 1 => 'Erbisoeul', 2 => 'Herchies', 3 => 'JURBISE', 4 => 'Masnuy-Saint-Jean', 5 => 'Masnuy-Saint-Pierre',),
        7060 => array(0 => 'Horrues', 1 => 'SOIGNIES',),
        7061 => array(0 => 'Casteau', 1 => 'Thieusies',),
        7062 => array(0 => 'Naast',),
        7063 => array(0 => 'Chaussée-Notre-Dame-Louvignies', 1 => 'Neufvilles',),
        7070 => array(0 => 'Gottignies', 1 => 'LE ROEULX', 2 => 'Mignault', 3 => 'Thieu', 4 => 'Ville-Sur-Haine',),
        7080 => array(0 => 'Eugies', 1 => 'FRAMERIES', 2 => 'La Bouverie', 3 => 'Noirchain', 4 => 'Sars-La-Bruyère',),
        7090 => array(0 => 'BRAINE-LE-COMTE', 1 => 'Hennuyères', 2 => 'Henripont', 3 => 'Petit-Roeulx-Lez-Braine', 4 => 'Ronquières', 5 => 'Steenkerque',),
        7100 => array(0 => 'Haine-Saint-Paul', 1 => 'Haine-Saint-Pierre', 2 => 'LA LOUVIÈRE', 3 => 'Saint-Vaast', 4 => 'Trivières',),
        7110 => array(0 => 'Boussoit', 1 => 'Houdeng-Aimeries', 2 => 'Houdeng-Goegnies', 3 => 'Maurage', 4 => 'Strépy-Bracquegnies',),
        7120 => array(0 => 'Croix-Lez-Rouveroy', 1 => 'ESTINNES', 2 => 'Estinnes-Au-Mont', 3 => 'Estinnes-Au-Val', 4 => 'Fauroeulx', 5 => 'Haulchin', 6 => 'Peissant', 7 => 'Rouveroy', 8 => 'Vellereille-Le-Sec', 9 => 'Vellereille-Les-Brayeux',),
        7130 => array(0 => 'Battignies', 1 => 'BINCHE', 2 => 'Bray',),
        7131 => array(0 => 'Waudrez',),
        7133 => array(0 => 'Buvrinnes',),
        7134 => array(0 => 'Epinois', 1 => 'Leval-Trahegnies', 2 => 'Péronnes-Lez-Binche', 3 => 'Ressaix',),
        7140 => array(0 => 'MORLANWELZ', 1 => 'Morlanwelz-Mariemont',),
        7141 => array(0 => 'Carnières', 1 => 'Mont-Sainte-Aldegonde',),
        7160 => array(0 => 'CHAPELLE-LEZ-HERLAIMONT', 1 => 'Godarville', 2 => 'Piéton',),
        7170 => array(0 => 'Bellecourt', 1 => 'Bois-D\'Haine', 2 => 'Fayt-Lez-Manage', 3 => 'La Hestre', 4 => 'MANAGE',),
        7180 => array(0 => 'SENEFFE',),
        7181 => array(0 => 'Arquennes', 1 => 'Familleureux', 2 => 'Feluy', 3 => 'Petit-Roeulx-Lez-Nivelles',),
        7190 => array(0 => 'ECAUSSINNES', 1 => 'Ecaussinnes-D\'Enghien', 2 => 'Marche-Lez-Ecaussinnes',),
        7191 => array(0 => 'Ecaussinnes-Lalaing',),
        7300 => array(0 => 'BOUSSU',),
        7301 => array(0 => 'Hornu',),
        7320 => array(0 => 'BERNISSART',),
        7321 => array(0 => 'Blaton', 1 => 'Harchies',),
        7322 => array(0 => 'Pommeroeul', 1 => 'Ville-Pommeroeul',),
        7330 => array(0 => 'SAINT-GHISLAIN',),
        7331 => array(0 => 'Baudour',),
        7332 => array(0 => 'Neufmaison', 1 => 'Sirault',),
        7333 => array(0 => 'Tertre',),
        7334 => array(0 => 'Hautrage', 1 => 'Villerot',),
        7340 => array(0 => 'COLFONTAINE', 1 => 'Paturages', 2 => 'Warquignies', 3 => 'Wasmes',),
        7350 => array(0 => 'Hainin', 1 => 'HENSIES', 2 => 'Montroeul-Sur-Haine', 3 => 'Thulin',),
        7370 => array(0 => 'Blaugies', 1 => 'DOUR', 2 => 'Elouges', 3 => 'Wihéries',),
        7380 => array(0 => 'Baisieux', 1 => 'QUIÉVRAIN',),
        7382 => array(0 => 'Audregnies',),
        7387 => array(0 => 'Angre', 1 => 'Angreau', 2 => 'Athis', 3 => 'Autreppe', 4 => 'Erquennes', 5 => 'Fayt-Le-Franc', 6 => 'HONNELLES', 7 => 'Marchipont', 8 => 'Montignies-Sur-Roc', 9 => 'Onnezies', 10 => 'Roisin',),
        7390 => array(0 => 'QUAREGNON', 1 => 'Wasmuel',),
        7500 => array(0 => 'Ere', 1 => 'Saint-Maur', 2 => 'TOURNAI',),
        7501 => array(0 => 'Orcq',),
        7502 => array(0 => 'Esplechin',),
        7503 => array(0 => 'Froyennes',),
        7504 => array(0 => 'Froidmont',),
        7506 => array(0 => 'Willemeau',),
        7510 => array(0 => '3 Suisses',),
        7511 => array(0 => 'Vitrine Magique',),
        7512 => array(0 => 'Yves Rocher',),
        7513 => array(0 => 'Yves Rocher',),
        7520 => array(0 => 'Ramegnies-Chin', 1 => 'Templeuve',),
        7521 => array(0 => 'Chercq',),
        7522 => array(0 => 'Blandain', 1 => 'Hertain', 2 => 'Lamain', 3 => 'Marquain',),
        7530 => array(0 => 'Gaurain-Ramecroix',),
        7531 => array(0 => 'Havinnes',),
        7532 => array(0 => 'Beclers',),
        7533 => array(0 => 'Thimougies',),
        7534 => array(0 => 'Barry', 1 => 'Maulde',),
        7536 => array(0 => 'Vaulx',),
        7538 => array(0 => 'Vezon',),
        7540 => array(0 => 'Kain', 1 => 'Melles', 2 => 'Quartes', 3 => 'Rumillies',),
        7542 => array(0 => 'Mont-Saint-Aubert',),
        7543 => array(0 => 'Mourcourt',),
        7548 => array(0 => 'Warchin',),
        7600 => array(0 => 'PÉRUWELZ',),
        7601 => array(0 => 'Roucourt',),
        7602 => array(0 => 'Bury',),
        7603 => array(0 => 'Bon-Secours',),
        7604 => array(0 => 'Baugnies', 1 => 'Braffe', 2 => 'Brasmenil', 3 => 'Callenelle', 4 => 'Wasmes-Audemez-Briffoeil',),
        7608 => array(0 => 'Wiers',),
        7610 => array(0 => 'RUMES',),
        7611 => array(0 => 'La Glanerie',),
        7618 => array(0 => 'Taintignies',),
        7620 => array(0 => 'Bléharies', 1 => 'BRUNEHAUT', 2 => 'Guignies', 3 => 'Hollain', 4 => 'Jollain-Merlin', 5 => 'Wez-Velvain',),
        7621 => array(0 => 'Lesdain',),
        7622 => array(0 => 'Laplaigne',),
        7623 => array(0 => 'Rongy',),
        7624 => array(0 => 'Howardries',),
        7640 => array(0 => 'ANTOING', 1 => 'Maubray', 2 => 'Péronnes-Lez-Antoing',),
        7641 => array(0 => 'Bruyelle',),
        7642 => array(0 => 'Calonne',),
        7643 => array(0 => 'Fontenoy',),
        7700 => array(0 => 'Luingne', 1 => 'MOUSCRON',),
        7711 => array(0 => 'Dottignies',),
        7712 => array(0 => 'Herseaux',),
        7730 => array(0 => 'Bailleul', 1 => 'Estaimbourg', 2 => 'ESTAIMPUIS', 3 => 'Evregnies', 4 => 'Leers-Nord', 5 => 'Néchin', 6 => 'Saint-Léger',),
        7740 => array(0 => 'PECQ', 1 => 'Warcoing',),
        7742 => array(0 => 'Hérinnes-Lez-Pecq',),
        7743 => array(0 => 'Esquelmes', 1 => 'Obigies',),
        7750 => array(0 => 'Amougies', 1 => 'Anseroeul', 2 => 'MONT-DE-L\'ENCLUS', 3 => 'Orroir', 4 => 'Russeignies',),
        7760 => array(0 => 'CELLES', 1 => 'Escanaffles', 2 => 'Molenbaix', 3 => 'Popuelles', 4 => 'Pottes', 5 => 'Velaines',),
        7780 => array(0 => 'Comines', 1 => 'COMINES-WARNETON',),
        7781 => array(0 => 'Houthem',),
        7782 => array(0 => 'Ploegsteert',),
        7783 => array(0 => 'Bizet',),
        7784 => array(0 => 'Bas-Warneton', 1 => 'Warneton',),
        7800 => array(0 => 'ATH', 1 => 'Lanquesaint',),
        7801 => array(0 => 'Irchonwelz',),
        7802 => array(0 => 'Ormeignies',),
        7803 => array(0 => 'Bouvignies',),
        7804 => array(0 => 'Ostiches', 1 => 'Rebaix',),
        7810 => array(0 => 'Maffle',),
        7811 => array(0 => 'Arbre',),
        7812 => array(0 => 'Houtaing', 1 => 'Ligne', 2 => 'Mainvault', 3 => 'Moulbaix', 4 => 'Villers-Notre-Dame', 5 => 'Villers-Saint-Amand',),
        7822 => array(0 => 'Ghislenghien', 1 => 'Isières', 2 => 'Meslin-L\'Evêque',),
        7823 => array(0 => 'Gibecq',),
        7830 => array(0 => 'Bassilly', 1 => 'Fouleng', 2 => 'Gondregnies', 3 => 'Graty', 4 => 'Hellebecq', 5 => 'Hoves', 6 => 'SILLY', 7 => 'Thoricourt',),
        7850 => array(0 => 'ENGHIEN', 1 => 'Marcq', 2 => 'Petit-Enghien',),
        7860 => array(0 => 'LESSINES',),
        7861 => array(0 => 'Papignies', 1 => 'Wannebecq',),
        7862 => array(0 => 'Ogy',),
        7863 => array(0 => 'Ghoy',),
        7864 => array(0 => 'Deux-Acren',),
        7866 => array(0 => 'Bois-De-Lessines', 1 => 'Ollignies',),
        7870 => array(0 => 'Bauffe', 1 => 'Cambron-Saint-Vincent', 2 => 'LENS', 3 => 'Lombise', 4 => 'Montignies-Lez-Lens',),
        7880 => array(0 => 'FLOBECQ',),
        7890 => array(0 => 'ELLEZELLES', 1 => 'Lahamaide', 2 => 'Wodecq',),
        7900 => array(0 => 'Grandmetz', 1 => 'LEUZE-EN-HAINAUT',),
        7901 => array(0 => 'Thieulain',),
        7903 => array(0 => 'Blicquy', 1 => 'Chapelle-à-Oie', 2 => 'Chapelle-à-Wattines',),
        7904 => array(0 => 'Pipaix', 1 => 'Tourpes', 2 => 'Willaupuis',),
        7906 => array(0 => 'Gallaix',),
        7910 => array(0 => 'Anvaing', 1 => 'Arc-Ainières', 2 => 'Arc-Wattripont', 3 => 'Cordes', 4 => 'Ellignies-Lez-Frasnes', 5 => 'Forest', 6 => 'FRASNES-LEZ-ANVAING', 7 => 'Wattripont',),
        7911 => array(0 => 'Buissenal', 1 => 'Frasnes-Lez-Buissenal', 2 => 'Hacquegnies', 3 => 'Herquegies', 4 => 'Montroeul-Au-Bois', 5 => 'Moustier', 6 => 'Oeudeghien',),
        7912 => array(0 => 'Dergneau', 1 => 'Saint-Sauveur',),
        7940 => array(0 => 'BRUGELETTE', 1 => 'Cambron-Casteau',),
        7941 => array(0 => 'Attre',),
        7942 => array(0 => 'Mévergnies-Lez-Lens',),
        7943 => array(0 => 'Gages',),
        7950 => array(0 => 'CHIÈVRES', 1 => 'Grosage', 2 => 'Huissignies', 3 => 'Ladeuze', 4 => 'Tongre-Saint-Martin',),
        7951 => array(0 => 'Tongre-Notre-Dame',),
        7970 => array(0 => 'BELOEIL',),
        7971 => array(0 => 'Basècles', 1 => 'Ramegnies', 2 => 'Thumaide', 3 => 'Wadelincourt',),
        7972 => array(0 => 'Aubechies', 1 => 'Ellignies-Saint-Anne', 2 => 'Quevaucamps',),
        7973 => array(0 => 'Grandglise', 1 => 'Stambruges',),
        8000 => array(0 => 'BRUGGE', 1 => 'Koolkerke',),
        8020 => array(0 => 'Hertsberge', 1 => 'OOSTKAMP', 2 => 'Ruddervoorde', 3 => 'Waardamme',),
        8200 => array(0 => 'Sint-Andries', 1 => 'Sint-Michiels',),
        8210 => array(0 => 'Loppem', 1 => 'Veldegem', 2 => 'ZEDELGEM',),
        8211 => array(0 => 'Aartrijke',),
        8300 => array(0 => 'Knokke', 1 => 'KNOKKE-HEIST', 2 => 'Westkapelle',),
        8301 => array(0 => 'Heist-Aan-Zee', 1 => 'Ramskapelle',),
        8310 => array(0 => 'Assebroek', 1 => 'Sint-Kruis',),
        8340 => array(0 => 'DAMME', 1 => 'Hoeke', 2 => 'Lapscheure', 3 => 'Moerkerke', 4 => 'Oostkerke', 5 => 'Sijsele',),
        8370 => array(0 => 'BLANKENBERGE', 1 => 'Uitkerke',),
        8377 => array(0 => 'Houtave', 1 => 'Meetkerke', 2 => 'Nieuwmunster', 3 => 'ZUIENKERKE',),
        8380 => array(0 => 'Dudzele', 1 => 'Lissewege', 2 => 'Zeebrugge',),
        8400 => array(0 => 'OOSTENDE', 1 => 'Stene', 2 => 'Zandvoorde',),
        8420 => array(0 => 'DE HAAN', 1 => 'Klemskerke', 2 => 'Wenduine',),
        8421 => array(0 => 'Vlissegem',),
        8430 => array(0 => 'MIDDELKERKE',),
        8431 => array(0 => 'Wilskerke',),
        8432 => array(0 => 'Leffinge',),
        8433 => array(0 => 'Mannekensvere', 1 => 'Schore', 2 => 'Sint-Pieters-Kapelle', 3 => 'Slijpe',),
        8434 => array(0 => 'Lombardsijde', 1 => 'Westende',),
        8450 => array(0 => 'BREDENE',),
        8460 => array(0 => 'Ettelgem', 1 => 'OUDENBURG', 2 => 'Roksem', 3 => 'Westkerke',),
        8470 => array(0 => 'GISTEL', 1 => 'Moere', 2 => 'Snaaskerke', 3 => 'Zevekote',),
        8480 => array(0 => 'Bekegem', 1 => 'Eernegem', 2 => 'ICHTEGEM',),
        8490 => array(0 => 'JABBEKE', 1 => 'Snellegem', 2 => 'Stalhille', 3 => 'Varsenare', 4 => 'Zerkegem',),
        8500 => array(0 => 'KORTRIJK',),
        8501 => array(0 => 'Bissegem', 1 => 'Heule',),
        8510 => array(0 => 'Bellegem', 1 => 'Kooigem', 2 => 'Marke', 3 => 'Rollegem',),
        8511 => array(0 => 'Aalbeke',),
        8520 => array(0 => 'KUURNE',),
        8530 => array(0 => 'HARELBEKE',),
        8531 => array(0 => 'Bavikhove', 1 => 'Hulste',),
        8540 => array(0 => 'DEERLIJK',),
        8550 => array(0 => 'ZWEVEGEM',),
        8551 => array(0 => 'Heestert',),
        8552 => array(0 => 'Moen',),
        8553 => array(0 => 'Otegem',),
        8554 => array(0 => 'Sint-Denijs',),
        8560 => array(0 => 'Gullegem', 1 => 'Moorsele', 2 => 'WEVELGEM',),
        8570 => array(0 => 'ANZEGEM', 1 => 'Gijzelbrechtegem', 2 => 'Ingooigem', 3 => 'Vichte',),
        8572 => array(0 => 'Kaster',),
        8573 => array(0 => 'Tiegem',),
        8580 => array(0 => 'AVELGEM',),
        8581 => array(0 => 'Kerkhove', 1 => 'Waarmaarde',),
        8582 => array(0 => 'Outrijve',),
        8583 => array(0 => 'Bossuit',),
        8587 => array(0 => 'Espierres', 1 => 'ESPIERRES-HELCHIN', 2 => 'Helchin',),
        8600 => array(0 => 'Beerst', 1 => 'DIKSMUIDE', 2 => 'Driekapellen', 3 => 'Esen', 4 => 'Kaaskerke', 5 => 'Keiem', 6 => 'Lampernisse', 7 => 'Leke', 8 => 'Nieuwkapelle', 9 => 'Oostkerke', 10 => 'Oudekapelle', 11 => 'Pervijze', 12 => 'Sint-Jacobs-Kapelle', 13 => 'Stuivekenskerke', 14 => 'Vladslo', 15 => 'Woumen',),
        8610 => array(0 => 'Handzame', 1 => 'KORTEMARK', 2 => 'Werken', 3 => 'Zarren',),
        8620 => array(0 => 'NIEUWPOORT', 1 => 'Ramskapelle', 2 => 'Sint-Joris',),
        8630 => array(0 => 'Avekapelle', 1 => 'Booitshoeke', 2 => 'Bulskamp', 3 => 'De Moeren', 4 => 'Eggewaartskapelle', 5 => 'Houtem', 6 => 'Steenkerke', 7 => 'VEURNE', 8 => 'Vinkem', 9 => 'Wulveringem', 10 => 'Zoutenaaie',),
        8640 => array(0 => 'Oostvleteren', 1 => 'VLETEREN', 2 => 'Westvleteren', 3 => 'Woesten',),
        8647 => array(0 => 'Lo', 1 => 'LO-RENINGE', 2 => 'Noordschote', 3 => 'Pollinkhove', 4 => 'Reninge',),
        8650 => array(0 => 'HOUTHULST', 1 => 'Klerken', 2 => 'Merkem',),
        8660 => array(0 => 'Adinkerke', 1 => 'DE PANNE',),
        8670 => array(0 => 'KOKSIJDE', 1 => 'Oostduinkerke', 2 => 'Wulpen',),
        8680 => array(0 => 'Bovekerke', 1 => 'KOEKELARE', 2 => 'Zande',),
        8690 => array(0 => 'ALVERINGEM', 1 => 'Hoogstade', 2 => 'Oeren', 3 => 'Sint-Rijkers',),
        8691 => array(0 => 'Beveren-Aan-De-Ijzer', 1 => 'Gijverinkhove', 2 => 'Izenberge', 3 => 'Leisele', 4 => 'Stavele',),
        8700 => array(0 => 'Aarsele', 1 => 'Kanegem', 2 => 'Schuiferskapelle', 3 => 'TIELT',),
        8710 => array(0 => 'Ooigem', 1 => 'Sint-Baafs-Vijve', 2 => 'WIELSBEKE',),
        8720 => array(0 => 'DENTERGEM', 1 => 'Markegem', 2 => 'Oeselgem', 3 => 'Wakken',),
        8730 => array(0 => 'BEERNEM', 1 => 'Oedelem', 2 => 'Sint-Joris',),
        8740 => array(0 => 'Egem', 1 => 'PITTEM',),
        8750 => array(0 => 'WINGENE', 1 => 'Zwevezele',),
        8755 => array(0 => 'RUISELEDE',),
        8760 => array(0 => 'MEULEBEKE',),
        8770 => array(0 => 'INGELMUNSTER',),
        8780 => array(0 => 'OOSTROZEBEKE',),
        8790 => array(0 => 'WAREGEM',),
        8791 => array(0 => 'Beveren',),
        8792 => array(0 => 'Desselgem',),
        8793 => array(0 => 'Sint-Eloois-Vijve',),
        8800 => array(0 => 'Beveren', 1 => 'Oekene', 2 => 'ROESELARE', 3 => 'Rumbeke',),
        8810 => array(0 => 'LICHTERVELDE',),
        8820 => array(0 => 'TORHOUT',),
        8830 => array(0 => 'Gits', 1 => 'HOOGLEDE',),
        8840 => array(0 => 'Oostnieuwkerke', 1 => 'STADEN', 2 => 'Westrozebeke',),
        8850 => array(0 => 'ARDOOIE',),
        8851 => array(0 => 'Koolskamp',),
        8860 => array(0 => 'LENDELEDE',),
        8870 => array(0 => 'Emelgem', 1 => 'IZEGEM', 2 => 'Kachtem',),
        8880 => array(0 => 'LEDEGEM', 1 => 'Rollegem-Kapelle', 2 => 'Sint-Eloois-Winkel',),
        8890 => array(0 => 'Dadizele', 1 => 'MOORSLEDE',),
        8900 => array(0 => 'Brielen', 1 => 'Dikkebus', 2 => 'IEPER', 3 => 'Sint-Jan',),
        8902 => array(0 => 'Hollebeke', 1 => 'Voormezele', 2 => 'Zillebeke',),
        8904 => array(0 => 'Boezinge', 1 => 'Zuidschote',),
        8906 => array(0 => 'Elverdinge',),
        8908 => array(0 => 'Vlamertinge',),
        8920 => array(0 => 'Bikschote', 1 => 'Langemark', 2 => 'LANGEMARK-POELKAPELLE', 3 => 'Poelkapelle',),
        8930 => array(0 => 'Lauwe', 1 => 'MENEN', 2 => 'Rekkem',),
        8940 => array(0 => 'Geluwe', 1 => 'WERVIK',),
        8950 => array(0 => 'HEUVELLAND', 1 => 'Nieuwkerke',),
        8951 => array(0 => 'Dranouter',),
        8952 => array(0 => 'Wulvergem',),
        8953 => array(0 => 'Wijtschate',),
        8954 => array(0 => 'Westouter',),
        8956 => array(0 => 'Kemmel',),
        8957 => array(0 => 'MESSINES',),
        8958 => array(0 => 'Loker',),
        8970 => array(0 => 'POPERINGE', 1 => 'Reningelst',),
        8972 => array(0 => 'Krombeke', 1 => 'Proven', 2 => 'Roesbrugge-Haringe',),
        8978 => array(0 => 'Watou',),
        8980 => array(0 => 'Beselare', 1 => 'Geluveld', 2 => 'Passendale', 3 => 'Zandvoorde', 4 => 'ZONNEBEKE',),
        9000 => array(0 => 'GENT',),
        9030 => array(0 => 'Mariakerke',),
        9031 => array(0 => 'Drongen',),
        9032 => array(0 => 'Wondelgem',),
        9040 => array(0 => 'Sint-Amandsberg',),
        9041 => array(0 => 'Oostakker',),
        9042 => array(0 => 'Desteldonk', 1 => 'Mendonk', 2 => 'Sint-Kruis-Winkel',),
        9050 => array(0 => 'Gentbrugge', 1 => 'Ledeberg',),
        9051 => array(0 => 'Afsnee', 1 => 'Sint-Denijs-Westrem',),
        9052 => array(0 => 'Zwijnaarde',),
        9060 => array(0 => 'ZELZATE',),
        9070 => array(0 => 'DESTELBERGEN', 1 => 'Heusden',),
        9075 => array(0 => 'CSM Gent X',),
        9080 => array(0 => 'Beervelde', 1 => 'LOCHRISTI', 2 => 'Zaffelare', 3 => 'Zeveneken',),
        9090 => array(0 => 'Gontrode', 1 => 'MELLE',),
        9099 => array(0 => 'Gent X',),
        9100 => array(0 => 'Nieuwkerken-Waas', 1 => 'SINT-NIKLAAS',),
        9111 => array(0 => 'Belsele',),
        9112 => array(0 => 'Sinaai-Waas',),
        9120 => array(0 => 'BEVEREN-WAAS', 1 => 'Haasdonk', 2 => 'Kallo', 3 => 'Melsele', 4 => 'Vrasene',),
        9130 => array(0 => 'Doel', 1 => 'Kallo', 2 => 'Kieldrecht', 3 => 'Verrebroek',),
        9140 => array(0 => 'Elversele', 1 => 'Steendorp', 2 => 'TEMSE', 3 => 'Tielrode',),
        9150 => array(0 => 'Bazel', 1 => 'KRUIBEKE', 2 => 'Rupelmonde',),
        9160 => array(0 => 'Daknam', 1 => 'Eksaarde', 2 => 'LOKEREN',),
        9170 => array(0 => 'De Klinge', 1 => 'Meerdonk', 2 => 'SINT-GILLIS-WAAS', 3 => 'Sint-Pauwels',),
        9180 => array(0 => 'MOERBEKE-WAAS',),
        9185 => array(0 => 'WACHTEBEKE',),
        9190 => array(0 => 'Kemzeke', 1 => 'STEKENE',),
        9200 => array(0 => 'Appels', 1 => 'Baasrode', 2 => 'DENDERMONDE', 3 => 'Grembergen', 4 => 'Mespelare', 5 => 'Oudegem', 6 => 'Schoonaarde', 7 => 'Sint-Gillis-Dendermonde',),
        9220 => array(0 => 'HAMME', 1 => 'Moerzeke',),
        9230 => array(0 => 'Massemen', 1 => 'Westrem', 2 => 'WETTEREN',),
        9240 => array(0 => 'ZELE',),
        9250 => array(0 => 'WAASMUNSTER',),
        9255 => array(0 => 'BUGGENHOUT', 1 => 'Opdorp',),
        9260 => array(0 => 'Schellebelle', 1 => 'Serskamp', 2 => 'WICHELEN',),
        9270 => array(0 => 'Kalken', 1 => 'LAARNE',),
        9280 => array(0 => 'Denderbelle', 1 => 'LEBBEKE', 2 => 'Wieze',),
        9290 => array(0 => 'BERLARE', 1 => 'Overmere', 2 => 'Uitbergen',),
        9300 => array(0 => 'AALST',),
        9308 => array(0 => 'Gijzegem', 1 => 'Hofstade',),
        9310 => array(0 => 'Baardegem', 1 => 'Herdersem', 2 => 'Meldert', 3 => 'Moorsel',),
        9320 => array(0 => 'Erembodegem', 1 => 'Nieuwerkerken',),
        9340 => array(0 => 'Impe', 1 => 'LEDE', 2 => 'Oordegem', 3 => 'Smetlede', 4 => 'Wanzele',),
        9400 => array(0 => 'Appelterre-Eichem', 1 => 'Denderwindeke', 2 => 'Lieferinge', 3 => 'Nederhasselt', 4 => 'NINOVE', 5 => 'Okegem', 6 => 'Voorde',),
        9401 => array(0 => 'Pollare',),
        9402 => array(0 => 'Meerbeke',),
        9403 => array(0 => 'Neigem',),
        9404 => array(0 => 'Aspelare',),
        9406 => array(0 => 'Outer',),
        9420 => array(0 => 'Aaigem', 1 => 'Bambrugge', 2 => 'Burst', 3 => 'Erondegem', 4 => 'Erpe', 5 => 'ERPE-MERE', 6 => 'Mere', 7 => 'Ottergem', 8 => 'Vlekkem',),
        9450 => array(0 => 'Denderhoutem', 1 => 'HAALTERT', 2 => 'Heldergem',),
        9451 => array(0 => 'Kerksken',),
        9470 => array(0 => 'DENDERLEEUW',),
        9472 => array(0 => 'Iddergem',),
        9473 => array(0 => 'Welle',),
        9500 => array(0 => 'GERAARDSBERGEN', 1 => 'Goeferdinge', 2 => 'Moerbeke', 3 => 'Nederboelare', 4 => 'Onkerzele', 5 => 'Ophasselt', 6 => 'Overboelare', 7 => 'Viane', 8 => 'Zarlardinge',),
        9506 => array(0 => 'Grimminge', 1 => 'Idegem', 2 => 'Nieuwenhove', 3 => 'Schendelbeke', 4 => 'Smeerebbe-Vloerzegem', 5 => 'Waarbeke', 6 => 'Zandbergen',),
        9520 => array(0 => 'Bavegem', 1 => 'Oombergen', 2 => 'SINT-LIEVENS-HOUTEM', 3 => 'Vlierzele', 4 => 'Zonnegem',),
        9521 => array(0 => 'Letterhoutem',),
        9550 => array(0 => 'HERZELE', 1 => 'Hillegem', 2 => 'Sint-Antelinks', 3 => 'Sint-Lievens-Esse', 4 => 'Steenhuize-Wijnhuize', 5 => 'Woubrechtegem',),
        9551 => array(0 => 'Ressegem',),
        9552 => array(0 => 'Borsbeke',),
        9570 => array(0 => 'Deftinge', 1 => 'LIERDE', 2 => 'Sint-Maria-Lierde',),
        9571 => array(0 => 'Hemelveerdegem',),
        9572 => array(0 => 'Sint-Martens-Lierde',),
        9600 => array(0 => 'RENAIX',),
        9620 => array(0 => 'Elene', 1 => 'Erwetegem', 2 => 'Godveerdegem', 3 => 'Grotenberge', 4 => 'Leeuwergem', 5 => 'Oombergen', 6 => 'Sint-Goriks-Oudenhove', 7 => 'Sint-Maria-Oudenhove', 8 => 'Strijpen', 9 => 'Velzeke-Ruddershove', 10 => 'ZOTTEGEM',),
        9630 => array(0 => 'Beerlegem', 1 => 'Dikkele', 2 => 'Hundelgem', 3 => 'Meilegem', 4 => 'Munkzwalm', 5 => 'Paulatem', 6 => 'Roborst', 7 => 'Rozebeke', 8 => 'Sint-Blasius-Boekel', 9 => 'Sint-Denijs-Boekel', 10 => 'Sint-Maria-Latem', 11 => 'ZWALM',),
        9636 => array(0 => 'Nederzwalm-Hermelgem',),
        9660 => array(0 => 'BRAKEL', 1 => 'Elst', 2 => 'Everbeek', 3 => 'Michelbeke', 4 => 'Nederbrakel', 5 => 'Opbrakel', 6 => 'Sint-Maria-Oudenhove', 7 => 'Zegelsem',),
        9661 => array(0 => 'Parike',),
        9667 => array(0 => 'HOREBEKE', 1 => 'Sint-Kornelis-Horebeke', 2 => 'Sint-Maria-Horebeke',),
        9680 => array(0 => 'Etikhove', 1 => 'Maarke-Kerkem', 2 => 'MAARKEDAL',),
        9681 => array(0 => 'Nukerke',),
        9688 => array(0 => 'Schorisse',),
        9690 => array(0 => 'Berchem', 1 => 'KLUISBERGEN', 2 => 'Kwaremont', 3 => 'Ruien', 4 => 'Zulzeke',),
        9700 => array(0 => 'Bevere', 1 => 'Edelare', 2 => 'Eine', 3 => 'Ename', 4 => 'Heurne', 5 => 'Leupegem', 6 => 'Mater', 7 => 'Melden', 8 => 'Mullem', 9 => 'Nederename', 10 => 'Ooike', 11 => 'OUDENAARDE', 12 => 'Volkegem', 13 => 'Welden',),
        9750 => array(0 => 'Huise', 1 => 'Ouwegem', 2 => 'ZINGEM',),
        9770 => array(0 => 'KRUISHOUTEM',),
        9771 => array(0 => 'Nokere',),
        9772 => array(0 => 'Wannegem-Lede',),
        9790 => array(0 => 'Elsegem', 1 => 'Moregem', 2 => 'Ooike', 3 => 'Petegem-Aan-De-Schelde', 4 => 'Wortegem', 5 => 'WORTEGEM-PETEGEM',),
        9800 => array(0 => 'Astene', 1 => 'Bachte-Maria-Leerne', 2 => 'DEINZE', 3 => 'Gottem', 4 => 'Grammene', 5 => 'Meigem', 6 => 'Petegem-Aan-De-Leie', 7 => 'Sint-Martens-Leerne', 8 => 'Vinkt', 9 => 'Wontergem', 10 => 'Zeveren',),
        9810 => array(0 => 'Eke', 1 => 'NAZARETH',),
        9820 => array(0 => 'Bottelare', 1 => 'Lemberge', 2 => 'Melsen', 3 => 'MERELBEKE', 4 => 'Munte', 5 => 'Schelderode',),
        9830 => array(0 => 'SINT-MARTENS-LATEM',),
        9831 => array(0 => 'Deurle',),
        9840 => array(0 => 'DE PINTE', 1 => 'Zevergem',),
        9850 => array(0 => 'Hansbeke', 1 => 'Landegem', 2 => 'Merendree', 3 => 'NEVELE', 4 => 'Poesele', 5 => 'Vosselare',),
        9860 => array(0 => 'Balegem', 1 => 'Gijzenzele', 2 => 'Landskouter', 3 => 'Moortsele', 4 => 'OOSTERZELE', 5 => 'Scheldewindeke',),
        9870 => array(0 => 'Machelen', 1 => 'Olsene', 2 => 'ZULTE',),
        9880 => array(0 => 'AALTER', 1 => 'Lotenhulle', 2 => 'Poeke',),
        9881 => array(0 => 'Bellem',),
        9890 => array(0 => 'Asper', 1 => 'Baaigem', 2 => 'Dikkelvenne', 3 => 'GAVERE', 4 => 'Semmerzake', 5 => 'Vurste',),
        9900 => array(0 => 'EEKLO',),
        9910 => array(0 => 'KNESSELARE', 1 => 'Ursel',),
        9920 => array(0 => 'LOVENDEGEM',),
        9921 => array(0 => 'Vinderhoute',),
        9930 => array(0 => 'ZOMERGEM',),
        9931 => array(0 => 'Oostwinkel',),
        9932 => array(0 => 'Ronsele',),
        9940 => array(0 => 'Ertvelde', 1 => 'EVERGEM', 2 => 'Kluizen', 3 => 'Sleidinge',),
        9950 => array(0 => 'WAARSCHOOT',),
        9960 => array(0 => 'ASSENEDE',),
        9961 => array(0 => 'Boekhoute',),
        9968 => array(0 => 'Bassevelde', 1 => 'Oosteeklo',),
        9970 => array(0 => 'KAPRIJKE',),
        9971 => array(0 => 'Lembeke',),
        9980 => array(0 => 'SINT-LAUREINS',),
        9981 => array(0 => 'Sint-Margriete',),
        9982 => array(0 => 'Sint-Jan-In-Eremo',),
        9988 => array(0 => 'Waterland-Oudeman', 1 => 'Watervliet',),
        9990 => array(0 => 'MALDEGEM',),
        9991 => array(0 => 'Adegem',),
        9992 => array(0 => 'Middelburg',),
    );



    var $faker;


    public function __construct()
    {
        $this->faker = Faker\Factory::create('fr_BE');
    }

    public function load(ObjectManager $manager)
    {
//        generation des categories de services

        for ($i = 0; $i < self::$nbreCategorie; $i++) {
            $categorie = $this->genCategorieDeServices($i);

            $manager->persist($categorie);

        }

        //generation des CP & Localite

        $this->genCPandLocalite($manager);


//        generation des prestataires

        for ($i = 0; $i < self::$nbrePrestataire; $i++) {
            $prestataire = $this->genPrestataires($i);

            $manager->persist($prestataire);
        }

//        generation des stages

        $randQuant = rand(0, self::$maxStagesParPrestataire);
        for ($i = 0; $i < self::$nbrePrestataire; $i++) {
            for ($j = 0; $j < $randQuant; $j++) {
                $stage = $this->genStage($i, $j);
                $manager->persist($stage);
            }
        }

//        generation des promotions

        $randQuant = rand(0, self::$maxPromotionsParPrestataire);
        for ($i = 0; $i < self::$nbrePrestataire; $i++) {
            for ($j = 0; $j < $randQuant; $j++) {
                $promotion = $this->genPromotion($i, $j);
                $manager->persist($promotion);
            }
        }

//        generation des internautes

        for ($i = 0; $i < self::$nbreInternaute; $i++) {
            $internaute = $this->genInternaute($i);

            $manager->persist($internaute);
        }

//        generation des blocs (pas fini car p-e inutile)

        for ($j = 0; $j < 7; $j++) {
            $bloc = $this->genBloc($j);
            $manager->persist($bloc);
        }

//        generation des commentaires

        for ($i = 0; $i < self::$nbreCommentaire; $i++) {
            $commentaire = $this->genCommentaires($i);
            $manager->persist($commentaire);
        }


//        generation des abus

        for ($i = 0; $i < self::$nbreAbus; $i++) {
            $abus = $this->genAbus();
            $manager->persist($abus);
        }

//        generation des newsletter

        for ($i = 0; $i < self::$nbreNewsletter; $i++) {
            $newsletter = $this->genNewsletter($i);
            $manager->persist($newsletter);
        }

//        generation de l'admin

        $admin = $this->genAdmin();
        $manager->persist($admin);


        $manager->flush();
    }

    public function genAdmin()
    {
        $admin = new Admin();
        $admin->setEmail('admin@admin.com');
        $admin->setMotDePasse(self::$encryptedPassword);
        $admin->setInscription(new \DateTime());
        $admin->setNbEssaisInfructueux(0);
        $admin->setBanni(false);
        $admin->setConfInscription(true);

        return $admin;
    }
    public function genCategorieDeServices($i)
    {
        $categorie = new CategorieDeServices();
        $categorie->setNom($this->faker->words(2, true));
        $categorie->setDescription($this->faker->sentences(20, true));

        if ($i == 0) {
            $categorie->setEnAvant(true);
        } else {
            $categorie->setEnAvant(false);
        }

        $categorie->setValide(true);

//        ajout d'une image

        $image = $this->genImage('image', $i);
        $categorie->setImage($this->getReference('image' . $i));

        $this->addReference('categorie' . $i, $categorie);

        return $categorie;
    }

    public function genPrestataires($i)
    {

        $prestataire = new Prestataire();
        $prestataire->setEmail($this->uniqueEmail($i, 'p'));
        $prestataire->setMotDePasse(self::$encryptedPassword);
        $prestataire->setAdresseNum($this->faker->buildingNumber);
        $prestataire->setAdresseRue($this->faker->streetName);
        $prestataire->setInscription($this->faker->dateTimeThisDecade);
        $prestataire->setNbEssaisInfructueux(0);
        $prestataire->setBanni(false);
        $prestataire->setConfInscription(true);

        $prestataire->setNom($this->faker->words(2, true));
        $prestataire->setSiteInternet($this->faker->domainName);
        $prestataire->setEmailContact($this->faker->email);
        $prestataire->setTelephone($this->faker->phoneNumber);
        $prestataire->setNumTVA($this->faker->vat);

//        ajout cp et localite

        $this->addCPandLocalite($prestataire);

//        ajout de categories

        $randArray = $this->randomNumbersArray(rand(1, self::$maxCategoriesParPrestataire), 0, self::$nbreCategorie - 1);
        foreach ($randArray as $id) {
            $prestataire->addCategorie($this->getReference('categorie' . $id));
        }

//        ajout d'un logo

        $logo = $this->genImage('logo', $i);
        $prestataire->setLogo($this->getReference('logo' . $i));

//        ajout des photos

        $randQuant = rand(0, self::$maxPhotosParPrestataire);

        for ($j = 0; $j < $randQuant; $j++) {
            $photo = $this->genImage('photo', ($i . $j));
            $prestataire->addPhoto($this->getReference('photo' . ($i . $j)));
        }


        $this->addReference('prestataire' . $i, $prestataire);
        return $prestataire;
    }

    public function genInternaute($i)
    {
        $internaute = new Internaute();
        $internaute->setEmail($this->uniqueEmail($i, 'i'));
        $internaute->setMotDePasse(self::$encryptedPassword);
        $internaute->setAdresseNum($this->faker->buildingNumber);
        $internaute->setAdresseRue($this->faker->streetName);
        $internaute->setInscription($this->faker->dateTimeThisDecade);
        $internaute->setNbEssaisInfructueux(0);
        $internaute->setBanni(false);
        $internaute->setConfInscription(true);

        $internaute->setNom($this->faker->lastName);
        $internaute->setPrenom($this->faker->firstName);
        $internaute->setNewsletter($this->faker->boolean);

//        ajout cp et localite

        $this->addCPandLocalite($internaute);


//        ajout d'un avatar

        $avatar = $this->genImage('avatar', $i);
        $internaute->setAvatar($this->getReference('avatar' . $i));


//        ajout des favoris

        $randArray = $this->randomNumbersArray(rand(1, self::$maxFavorisParInternaute), 0, self::$nbrePrestataire - 1);
        foreach ($randArray as $id) {
            $internaute->addFavoris($this->getReference('prestataire' . $id));
        }

        $this->addReference('internaute' . $i, $internaute);
        return $internaute;
    }

    public function genImage($type, $i)
    {
        $img = new Image();
        $img->setAlt('tempdev');
        $img->setUrl($type . "_" . $i . ".jpg");
        $img->setActive(1);
        $this->addReference($type . $i, $img);

    }

    public function genPDF($type,$i)
    {
        $pdf = new DocumentPDF();
        $pdf->setUrl($type."_".$i.".jpg");
        $this->addReference($type.$i,$pdf);
    }

    public function genCommentaires($i)
    {
        $commentaire = new Commentaire();
        $randInternauteId = rand(0, self::$nbreInternaute - 1);
        $commentaire->setAuteurCommentaire($this->getReference('internaute' . $randInternauteId));
        $randPrestataireId = rand(0, self::$nbrePrestataire - 1);
        $commentaire->setCibleCommentaire($this->getReference('prestataire' . $randPrestataireId));
        $commentaire->setCote($this->faker->numberBetween(1, 5));
        $commentaire->setTitre($this->faker->sentence());
        $commentaire->setContenu($this->faker->sentences(5, true));
        $commentaire->setEncodage($this->faker->dateTimeThisMonth);
        $this->addReference('commentaire' . $i, $commentaire);
        return $commentaire;
    }

    public function genAbus()
    {
        $abus = new Abus();
        $abus->setDescription($this->faker->sentences(2, true));
        $abus->setEncodage($this->faker->dateTimeBetween('-1weeks', 'now'));
        $randCommentaireId = rand(0, self::$nbreCommentaire - 1);
        $abus->setCommentaire($this->getReference('commentaire' . $randCommentaireId));

        return $abus;
    }

    public function genNewsletter($i)
    {
        $newsletter = new Newsletter();
        $newsletter->setTitre($this->faker->sentence());
        $newsletter->setPublication($this->faker->dateTimeThisYear);

        $pdf = $this->genPDF('newsletter', $i);
        $newsletter->setDocumentPDF($this->getReference('newsletter' . $i));

        return $newsletter;
    }

    public function genBloc($i)
    {
        $bloc = new Bloc();
        $bloc->setNom($this->faker->word);
        $bloc->setDescription($this->faker->word);
        $bloc->setOrdre($this->faker->numberBetween(1, 7));

        return $bloc;
    }

    public function genStage($i, $j)
    {
        $stage = new Stage();
        $stage->setNom($this->faker->words(5, true));
        $stage->setDescription($this->faker->sentences(4, true));
        $stage->setTarif(($this->faker->numberBetween(6, 90)) * 5);
        $stage->setInfoComplementaire($this->faker->sentences(2, true));
        $stage->setDebut($this->faker->dateTimeBetween('-1weeks', '3weeks'));
        $datedebut = $stage->getDebut();
        $stage->setFin($this->faker->dateTimeBetween($datedebut, '4weeks'));
        $stage->setAffichageDe($this->faker->dateTimeBetween('-6weeks', $datedebut));
        $stage->setAffichageJusque($stage->getFin());

        $stage->setPrestataire($this->getReference('prestataire' . $i));

        $this->addReference('stage' . $i . $j, $stage);
        return $stage;
    }

    public function genPromotion($i, $j)
    {
        $promotion = new Promotion();
        $promotion->setNom($this->faker->words(5, true));
        $promotion->setDescription($this->faker->sentences(4, true));

        $pdf = $this->genPDF('promo', $i.$j);
        $promotion->setDocumentPDF($this->getReference('promo' . $i.$j));

        $promotion->setDebut($this->faker->dateTimeBetween('-1weeks', '3weeks'));
        $datedebut = $promotion->getDebut();
        $promotion->setFin($this->faker->dateTimeBetween($datedebut, '4weeks'));
        $promotion->setAffichageDe($this->faker->dateTimeBetween('-6weeks', $datedebut));
        $promotion->setAffichageJusque($promotion->getFin());

        $promotion->setPrestataire($this->getReference('prestataire' . $i));
        //        ajout de categories

        $randArray = $this->randomNumbersArray(rand(1, self::$maxCategoriesParPromotion), 0, self::$nbreCategorie - 1);
        foreach ($randArray as $id) {
            $promotion->addCategorie($this->getReference('categorie' . $id));
        }

        $this->addReference('promotion' . $i . $j, $promotion);
        return $promotion;
    }

    public function genCPandLocalite($manager)
    {
        $i = 0;
        $j = 0;
        foreach(self::$cpLocalite as $codep => $local){

            $cp = new CodePostal();
            $cp->setCodePostal($codep);
            foreach($local as $l){
                $localite = new Localite();
                $localite->setCodePostal($cp);
                $localite->setLocalite($l);
                $this->addReference('localite' .$i.$j, $localite);
                $manager->persist($localite);
                $j++;
            }
            $this->addReference('cp' .$i, $cp);
            $manager->persist($cp);

            $j=0;
            $i++;
        }

    }
//ce code est un peu caca parce que j'ai modifier mon entité très tard dans le projet, mais ça marche et il ne fait que 5 lignes donc ça peut pas être siiii terrible ;)
    public function addCPandLocalite(Utilisateur $user)
    {
        $randCP = rand(0, (count(self::$cpLocalite))-1);
        $codepostal = $this->getReference('cp'.$randCP);
        /**
         * @var CodePostal $codepostal
         */
        $codepostalvalue = $codepostal->getCodePostal();
        $randLocal = rand(0,(count(self::$cpLocalite[$codepostalvalue]))-1);
        $user->setLocalite($this->getReference('localite'.$randCP.$randLocal));


    }

    public function uniqueEmail($i, $type)
    {
        $email = $type . $i . ($this->faker->email);

        return $email;

    }



    //fonction piquée tel quelle sur stackOverflow
    //Generating UNIQUE Random Numbers within a range - PHP
    public function randomNumbersArray($count, $min, $max)
    {
        if ($count > (($max - $min) + 1)) {
            return false;
        }
        $values = range($min, $max);
        shuffle($values);
        return array_slice($values, 0, $count);
    }



}
