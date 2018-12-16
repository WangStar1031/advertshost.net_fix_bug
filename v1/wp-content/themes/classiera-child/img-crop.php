<?php

$_imgUrl = "";
if(isset($_GET['imgUrl'])) $_imgUrl = $_GET['imgUrl'];
if(isset($_POST['imgUrl'])) $_imgUrl = $_POST['imgUrl'];

if( $_imgUrl == ""){
	$response = array(
		"status" => 'error',
		"message" => 'There is no image url.',
	);
	print json_encode($response);
	exit();
}
$imgPath = __DIR__ . "/temp/" . basename($_imgUrl);
if( !file_exists($imgPath)){
	$response = array(
		"status" => 'error',
		"message" => 'There is no image file.',
	);
	print json_encode($response);
	exit();
}

$path_parts = pathinfo($imgPath);
$type = $path_parts['extension'];

if( $type ==  'jpeg') $type = 'jpg';
$_imgInitW = 0;
if(isset($_GET['imgInitW'])) $_imgInitW = intval( $_GET['imgInitW']);
if(isset($_POST['imgInitW'])) $_imgInitW = intval( $_POST['imgInitW']);
$_imgInitH = 0;
if(isset($_GET['imgInitH'])) $_imgInitH = intval( $_GET['imgInitH']);
if(isset($_POST['imgInitH'])) $_imgInitH = intval( $_POST['imgInitH']);
$_imgW = 0;
if(isset($_GET['imgW'])) $_imgW = intval( $_GET['imgW']);
if(isset($_POST['imgW'])) $_imgW = intval( $_POST['imgW']);
$_imgH = 0;
if(isset($_GET['imgH'])) $_imgH = intval( $_GET['imgH']);
if(isset($_POST['imgH'])) $_imgH = intval( $_POST['imgH']);
$_imgW = 0;
if(isset($_GET['imgW'])) $_imgW = intval( $_GET['imgW']);
if(isset($_POST['imgW'])) $_imgW = intval( $_POST['imgW']);
$_imgX1 = 0;
if(isset($_GET['imgX1'])) $_imgX1 = intval( $_GET['imgX1']);
if(isset($_POST['imgX1'])) $_imgX1 = intval( $_POST['imgX1']);
$_imgY1 = 0;
if(isset($_GET['imgY1'])) $_imgY1 = intval( $_GET['imgY1']);
if(isset($_POST['imgY1'])) $_imgY1 = intval( $_POST['imgY1']);
$_cropW = 0;
if(isset($_GET['cropW'])) $_cropW = intval( $_GET['cropW']);
if(isset($_POST['cropW'])) $_cropW = intval( $_POST['cropW']);
$_cropH = 0;
if(isset($_GET['cropH'])) $_cropH = intval( $_GET['cropH']);
if(isset($_POST['cropH'])) $_cropH = intval( $_POST['cropH']);
$_rotation = 0;
if(isset($_GET['rotation'])) $_rotation = $_GET['rotation'];
if(isset($_POST['rotation'])) $_rotation = $_POST['rotation'];
if( $_imgInitW == 0 || $_imgInitH == 0 || $_imgW == 0 || $_imgH == 0 || $_imgW == 0 || $_cropH == 0 || $_cropW == 0){
	$response = array(
		"status" => 'error',
		"message" => 'Invalid parameter.',
	);
	print json_encode($response);
	exit();
}

switch($type){
	case 'bmp': $_imgSrc = imagecreatefromwbmp($imgPath); break;
	case 'gif': $_imgSrc = imagecreatefromgif($imgPath); break;
	case 'jpg': $_imgSrc = imagecreatefromjpeg($imgPath); break;
	case 'png': $_imgSrc = imagecreatefrompng($imgPath); break;
	default : $_imgSrc = false; break;
}

if( $_imgSrc == false){
	$response = array(
		"status" => 'error',
		"message" => 'Source Image Error.',
	);
	print json_encode($response);
	exit();
}

$_imgDst = imagecreatetruecolor($_cropW, $_cropH);

$_scaleW = floatval($_imgInitW / $_imgW);
$_scaleH = floatval($_imgInitH / $_imgH);

if( !imagecopyresampled($_imgDst, $_imgSrc, 0, 0, $_imgX1 * $_scaleW, $_imgY1 * $_scaleH, $_cropW, $_cropH, $_cropW * $_scaleW, $_cropH * $_scaleH)){
	$response = array(
		"status" => 'error',
		"message" => 'Error on cropping image.'
	);
	print_r($response);
	exit();
}


$dstImgPath = __DIR__ . "/temp/" . $path_parts['filename'] . "_crop." . $type;

switch($type){
	case 'bmp': $retVal = imagewbmp( $_imgDst, $dstImgPath); break;
	case 'gif': $retVal = imagegif( $_imgDst, $dstImgPath); break;
	case 'jpg': $retVal = imagejpeg( $_imgDst, $dstImgPath); break;
	case 'png': $retVal = imagepng( $_imgDst, $dstImgPath); break;
	default : $retVal = false; break;
}


$response = array(
	"status" => 'success',
	"url" => $baseDir = dirname($_SERVER['REQUEST_URI']) . "/temp/" . $path_parts['filename'] . "_crop." . $type,
	"width" => $_cropW,
	"height" => $_cropH,
	"dstImgPath" => $dstImgPath
);
print_r($response);
?>