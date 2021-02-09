<?
header('Content-type: text/plain; charset=utf-8');


if(!isset($_GET['ip']) || !isset($_GET['method']))
{
	echo 'ua';
	exit;
}

include ('SxGeo.php');

$SxGeo = new SxGeo('SxGeoCity.dat', SXGEO_BATCH); // $_SERVER['DOCUMENT_ROOT'].'SxGeo/SxGeoCity.dat', SXGEO_BATCH | SXGEO_MEMORY  // SXGEO_MEMORY // SXGEO_FILE

$method = &$_GET['method'];

echo $data = strtolower($SxGeo->$method($_GET['ip'])); // getCountry
//echo __DIR__.'log.txt';
//file_put_contents(__DIR__.'log.txt', $_GET['ip']."/n".$data."/n/n", FILE_APPEND);

exit;

