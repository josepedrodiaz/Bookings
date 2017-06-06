<?php
///////
//Booking functions
////

//HC
function procesarHW(){

	global $mes, $dia, $anio, $mesP, $diaP, $anioP, $lang;


	//acomodo el codigo de lenguaje a HW
	($lang == 'pt-br') ? $lang = "br" : $lang = $lang;

	$hostelId = getHostelId("hw",$_POST["destino"]);
	$in = $mes."/". $dia ."/". $anio; 
	$out = $mesP."/". $diaP ."/". $anioP;
	$noches = getNoches($in,$out);
	$moneda = getMoneda();

	$url = "https://reservation.bookhostels.com/elmistihostels.com/property/";
	$url .= $hostelId . "/?";
	$url .= "dateStart=";
	$url .= $anio."-".$mes."-".$dia;
	$url .= "&numNights=";
	$url .= $noches;
	$url .= "&lang=".$lang;
	$url .= "&currency=".$moneda;

	//header("Location: $url");
	printAnalyticsCode($url);
}


//HQ
function procesarHQ($hostel){

	global $mes, $dia, $anio, $mesP, $diaP, $anioP, $lang;

	$hostelId = getHostelHQId($hostel);



	$in = $anio."-".$mes."-".$dia;
	$out = $anioP."-".$mesP."-".$diaP;

	$url = "https://admin.hqbeds.com.br/";
	$url .= $lang;
	$url .= "/hqb/".$hostelId."/availability?arrival=";
	$url .= $in;
	$url .= "&departure=";
	$url .= $out;


	//header("Location: $url");
	printAnalyticsCodeHQ($hostelId);
}

//Ezee
function procesarEzee($lang){

	global $mes, $dia, $anio, $mesP, $diaP, $anioP, $lang;

	switch ($lang) {
		case 'value':
			$action = 'https://live.ipms247.com/booking/book-rooms-hotelezee'; // ENG URL
			break;	
		default:
			$action = 'https://live.ipms247.com/booking/book-rooms-hotelezee-es-Spanish'; // PT URL
			break;
	}
	

	echo '<form id="formEzee" name="_resBBBox" action="'.$action.'" method="post" style="visibility:hidden">
			<input name="eZ_chkin" id="eZ_chkin" value="'.$dia.'-'.$mes.'-'.$anio.'" type="text">
			<input name="eZ_chkout" id="eZ_chkout"  value="'.$diaP.'-'.$mesP.'-'.$anioP.'" type="text">
			<input name="eZ_Nights" id="eZ_Nights" value="2" type="hidden"> 
			<select name="eZ_adult" id="eZ_adult" style="width:45px;">
				<option value="1" selected>1</option></select>
			<select name="eZ_child" id="eZ_child" style="width:45px;">
				<option value="0" selected>0</option>
			</select>
			<input name="hidBodyLanguage" id="hidBodyLanguage" value="en" type="hidden">
			<input name="calformat" id="calformat" value="dd-mm-yy" type="hidden">
			<input name="ArDt" id="ArDt" value="26-04-2018" type="hidden">
			<input name="acturl" id="acturl" value="https://live.ipms247.com/booking/book-rooms-hotelezee" type="hidden">
			<input name="CHCurrency" value="MXN" type="hidden">
			</form>';

	
		printFbPixel();

		echo "
			<!-- Analytics -->
				<script>
				  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

				  ga('create', 'UA-22408272-1', 'auto', {'allowLinker': true});
				  //Multidomain
				  // Load the plugin.
				  ga('require', 'linker');
				  // Define which domain/s to autoLink.
				  ga('linker:autoLink', ['reservationarea.com']);
				  ga('send', 'pageview', {
				  'hitCallback': function() {
				  	 document.getElementById(\"formEzee\").submit();
				  }
				  });
				</script>
				";
}



//Obtiene la cantidad de noches apartir de fechas de check in/out
function getNoches($in, $out){
	$date1 = new DateTime($in);
	$date2 = new DateTime($out);
	$interval = $date1->diff($date2);
	$noches = $interval->format('%a');
	return $noches;
}

//Obtiene el id correspondiente a un hostel
//dependiendo de la BM usada
function getHostelId($bm,$destino){
	$hostelId;
	if ($bm == "hc"){
		switch ($destino) {
			case 'copa':
				$hostelId = 9772;
				break;
			case 'ipa':
				$hostelId = 33602;
				break;
			case 'rooms':
				$hostelId = 27557;
				break;
			case 'house':
				$hostelId = 21464;
				break;
			case 'rio':
				$hostelId = 27500;
				break;
			case 'bota':
				$hostelId = 783;
				break;
			case 'leme':
				$hostelId = 29486;
				break;
			case 'buzios':
				$hostelId = 27473;
				break;
			default:
				$hostelId = 00000;
				break;
		}
	}else{
		switch ($destino) {
			case 'copa':
					$hostelId = 10875;
					break;
				case 'ipa':
					$hostelId = 264798;
					break;
				case 'rooms':
					$hostelId = 66876;
					break;
				case 'house':
					$hostelId = 46375;
					break;
				case 'rio':
					$hostelId = 51949;
					break;
				case 'bota':
					$hostelId = 2964;
					break;
				case 'leme':
					$hostelId = 80930;
					break;
				default:
					$hostelId = 00000;
					break;
		}
	}
	return $hostelId;
}

function getMoneda(){
	global $lang;

	switch ($lang) {
		case 'es':
			$moneda = "BRL";
			break;
		case 'br':
			$moneda = "BRL";
			break;
		case 'en':
			$moneda = "USD";
			break;
		default:
			$moneda = "EUR";
			break;
	}

	return $moneda;
}

////////
// Imprime el código de Analytics y redirije a HW
///////
function printAnalyticsCode($url){

		printFbPixel();

		echo "
			<!-- Analytics -->
				<script>
				  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

				  ga('create', 'UA-22408272-1', 'auto', {'allowLinker': true});
				  //Multidomain
				  // Load the plugin.
				  ga('require', 'linker');
				  // Define which domain/s to autoLink.
				  ga('linker:autoLink', ['reservationarea.com']);
				  ga('send', 'pageview', {
				  'hitCallback': function() {
				      window.top.location = \"".$url."\";				  	 
				  }
				  });
				</script>
				";

}

////////
// Imprime el formulario de HQ y el código de Analytics
///////
function printAnalyticsCodeHQ($hostelId){

		printHqForm($hostelId);

		printFbPixel();

		echo "
			<!-- Analytics -->
				<script>
				  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

				  ga('create', 'UA-22408272-1', 'auto', {'allowLinker': true});
				  //Multidomain
				  // Load the plugin.
				  ga('require', 'linker');
				  // Define which domain/s to autoLink.
				  ga('linker:autoLink', ['reservationarea.com']);
				  ga('send', 'pageview', {
				  'hitCallback': function() {
				  	 document.getElementById(\"bookingForm\").submit();
				  }
				  });
				</script>
				";

}
 ////////////
// Imprime el pixel de FB
///////
function printFbPixel(){
echo "<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '198003900680528'); // Insert your pixel ID here.
fbq('track', 'PageView');
</script>
<noscript><img height=\"1\" width=\"1\" style=\"display:none\"
src=\"https://www.facebook.com/tr?id=198003900680528&ev=PageView&noscript=1\"
/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->




		<!-- Search Action -->
		<script>
		fbq('track', 'Search', {
		search_string: 'Search Hostels Rooms'
		});
		</script>
";
}

   ////////////
  // Imprime el formualrio que es enviado automaticamente 
 //  por el metodo POST al server de HQBeds
///////
function printHqForm($hostelId){
	global $mes, $dia, $anio, $mesP, $diaP, $anioP, $lang;

	echo '<form action="https://admin.hqbeds.com.br/pt-br/hqb/'.$hostelId.'/availability" id="bookingForm" method="post" name="bookingForm" accept-charset="utf-8">
			
			<input name="arrival" id="arrival" value="'.$dia.'/'.$mes.'/'.$anio.'" type="text" style="display:none">
                            
            <input name="departure" id="departure" value="'.$diaP.'/'.$mesP.'/'.$anioP.'" type="text"style="display:none">


        </form>';


}



   ////////////
  // Devuelve el Id correspondiente a cada hostel
 //  dentro del sistema de HQBeds, sirve para conformar la URL de destino
///////
function getHostelHQId($hostel){

	switch ($hostel) {
		case 'suites':
			$hostelHQId = "GKXgN4zZYx";
			break;
		case 'ilha':
			$hostelHQId = "QqryJeYZ57";
			break;
		default:
			$hostelHQId = "# ERROR # Hostel no encontrado";
			break;
	}


	return $hostelHQId;
}
?>