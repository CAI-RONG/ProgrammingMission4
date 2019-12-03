<?php
header("Content-type: image/png");
$xml=simplexml_load_file("./plotMe.xml");
$png=@imagecreatetruecolor(600, 600)or die("failed to export image!");

// parse the line
foreach($xml->Line as $line){
	$XStart = (double)($line->XStart);
	$YStart = (double)($line->YStart);
	$XEnd = (double)($line->XEnd);
	$YEnd = (double)($line->YEnd);
	
	$Color = 'white'; //defult color
	$ColorVal = 0; 

	if(isset($line->Color)){
		$Color = $line->Color;
	}

	if($Color == 'red'){
		$ColorVal = imagecolorallocate($png, 255, 0, 0);
	}
	elseif($Color == 'green'){
		$ColorVal = imagecolorallocate($png, 0, 255, 0);
	}
	elseif($Color == 'blue'){
		$ColorVal = imagecolorallocate($png, 0, 0, 255);
	}
	elseif($Color == 'yellow'){
		$ColorVal = imagecolorallocate($png, 255, 255, 0);
	}
	else{
		$ColorVal = imagecolorallocate($png, 255, 255, 255);
	}
	//draw the line 
	imageline($png, $XStart, 600-$YStart, $XEnd, 600-$YEnd, $ColorVal);
} 

// parse the Arcs
foreach($xml->Arc as $arc){
	$width = (double)($arc->Radius)*2;
	$XCenter = (double)($arc->XCenter);
	$YCenter = (double)($arc->YCenter);
	$ArcStart = (int)($arc->ArcStart);
	$ArcExtend = (int)($arc->ArcExtend);

	$Color = 'white';
	$ColorVal = 0;

	if(isset($arc->Color))
		$Color = $arc->Color;

	if($Color == 'red'){
		$ColorVal = imagecolorallocate($png, 255, 0, 0);
	}
	elseif($Color=='green'){
		$ColorVal=imagecolorallocate($png,0,255,0);
	}
	elseif($Color=='blue'){
		$ColorVal=imagecolorallocate($png,0,0,255);
	}
	elseif($Color=='yellow'){
		$ColorVal=imagecolorallocate($png,255,255,0);
	}
	else{
		$ColorVal=imagecolorallocate($png,255,255,255);
	}
	//draw
	imagearc($png,$XCenter,600-$YCenter,$width,$width,360-($ArcStart+$ArcExtend),360-$ArcStart,$ColorVal);
}
imagepng($png);
imagedestroy($png);
?>