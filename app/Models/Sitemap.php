<?php
namespace App\Models;

use Illuminate\Console\Command;
use DateTime;


class Sitemap extends Command {

/**
* The console command name.
*
* @var string
*/
protected $name = 'xmlsitemap'; //название нашей команды

/**
* The console command description.
*
* @var string
*/
protected $description = 'Generation Sitemap.xml';//описание нашей команды

/**
* Create a new command instance.
*
* @return void
*/
public function __construct()
{
parent::__construct();
}

/**
* Execute the console command.
*
* @return mixed
*/
  /*Проверяет битые ссылки*/
    public static function checkLink($link){
        $ch = curl_init($link);
        $headers = array (
            '(Request-Line): GET /work-serf.php HTTP/1.1',
            'User-Agent: Opera/9.80 (Windows NT 5.1; U; MRA 5.9 (build 4876); ru) Presto/2.10.229 Version/11.60',
            'Accept:text/html, application/xml;q=0.9, application/xhtml+xml, image/png, image/webp, image/jpeg, image/gif, image/x-xbitmap, */*;q=0.1',
            'Accept-Language:ru-RU,ru;q=0.9,en;q=0.8',
            'Accept-Encoding: identity',
            'Referer: http://seosprint.net/work-serf.php', );

        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $http_code=curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return $http_code == 200 ? true : false;
    }

    /*Генерируе sitemap.xml*/
public static function fire($table,$check_link = true)
{
    $products = Products::leftJoin('products_loc', 'products_loc.product_id', '=', 'products.id')
        ->where('products_loc.lang', 'ru')
        ->where('products_images.main','=',1)
        ->leftJoin('products_images','products_images.product_id','=','products.id')
        ->select('products.*','products_loc.lang','products_loc.name','products_loc.description','products_images.image')
        ->get();
//тут тело как-раз нашей функции
$site_url = "http://test/";//уберите лишние пробелы
$base = "<?xml version='1.0' encoding='UTF-8'?>";
$base .= "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'></urlset>";
$xmlbase = new \SimpleXMLElement($base);
$row  = $xmlbase->addChild("url");
$row->addChild("loc",$site_url);
$row->addChild("lastmod",date("c"));
$row->addChild("changefreq","monthly");
$row->addChild("priority","1");
//выбираем нужные нам записи из базы данных
foreach ($products as $result) {
    if ($check_link){
        if(self::checkLink($site_url.$result->slug)){
            $row  = $xmlbase->addChild("url");
            $row->addChild("loc",$site_url.$result->slug);
            $date = new DateTime($result->created_at);
            $row->addChild("lastmod",$date->format("Y-m-d\TH:i:sP"));
            $row->addChild("changefreq","monthly");
            $row->addChild("priority","1");
        }
    }
    else {
        $row  = $xmlbase->addChild("url");
        $row->addChild("loc",$site_url.$result->slug);
        $date = new DateTime($result->created_at);
        $row->addChild("lastmod",$date->format("Y-m-d\TH:i:sP"));
        $row->addChild("changefreq","monthly");
        $row->addChild("priority","1");
    }
}
//укажите путь куда нужно сохранять файл
$xmlbase->saveXML(base_path()."/sitemap.xml");
}
}