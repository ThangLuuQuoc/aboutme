<?php
@session_start();
header ("Content-type: image/png");

mt_srand((double)microtime()*1000000);
$strinSeg = '';

for ($i = 0; $i < 6; $i++) {

	if( mt_rand(2,100000) % 2 ){
		$strinSeg .= chr( mt_rand(65, 90) ); 		
	}
	else
		$strinSeg .= mt_rand(1,9);
   
}
  
$_SESSION['codigoVal'] = $strinSeg;

define ("HEIGHT", 95);
define ("WIDTH", 25);

$im = @ImageCreate (HEIGHT, WIDTH);
//$color_fondo = ImageColorAllocate ($im, 240, 240, 240);
$color_fondo = imagecolorallocate ($im, mt_rand(200,255), mt_rand(200,255), mt_rand(200,255));
//$color_texto = ImageColorAllocate ($im, 233+mt_rand(10,19), 14+mt_rand(10,190), 91+mt_rand(10,119));
$color_texto = imagecolorallocate ($im, mt_rand(1,120), mt_rand(1,120), mt_rand(1,120));
$black = imagecolorallocate($im, 0, 0, 0);
imagerectangle($im, 0, 0, HEIGHT-1, WIDTH-1, $black);
/*if( isset($_SESSION['nvo_pass']) && $_SESSION['nvo_pass'] != '' )
	ImageString ($im, 12, 20, 10, $_SESSION['nvo_pass'], $color_texto);
else*/
imagestring ($im, 12, 20, 5, $_SESSION['codigoVal'], $color_texto);
//ImageTTFText($im, 12, 11, 22, 24, $color_texto, "arial.ttf", $_SESSION['codigo']);
//imageline ($im, 15, 10, 80, 25, $color_texto);
imageline($im, mt_rand(1,30), mt_rand(5,15), mt_rand(70,90), mt_rand(20,30), $color_texto);
imageline($im, mt_rand(40,60), mt_rand(20,30), mt_rand(60,80), mt_rand(1,10), $black);
imagepng($im);
?>