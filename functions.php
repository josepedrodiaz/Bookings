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
function procesarHQ(){

	global $mes, $dia, $anio, $mesP, $diaP, $anioP, $lang;

	$in = $anio."-".$mes."-".$dia;
	$out = $anioP."-".$mesP."-".$diaP;

	$url = "https://admin.hqbeds.com.br/";
	$url .= $lang;
	$url .= "/hqb/GKXgN4zZYx/availability?arrival=";
	$url .= $in;
	$url .= "&departure=";
	$url .= $out;

	//header("Location: $url");
	printAnalyticsCode($url);
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
// Imprime el código de Analytics
///////
function printAnalyticsCode($url){

		printFbPixel();

		echo "<!-- Analytics -->
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
?>