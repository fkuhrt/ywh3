<script type="text/javascript">
document.addEventListener( 'wpcf7mailsent', function( event ) {
	// ga( 'send', 'event', 'Workshopformular', 'submit' );
<?php

// $value = 'something from somewhere';
// setcookie("TestCookie", $value);

if (get_field('capacity') ){
	$cap = get_field('capacity');
	if (get_field('amount') ){
		$anz = get_field('amount');
		$atmp = ($anz*100)/$cap;
		$ausl = floor($atmp);
	}
}
?>
<?php

	$loc="vielen-dank";

	if (!get_field('keinerechnung') && $ausl!=100) $loc="jetzt-bezahlen";	 		// WORKSHOP MIT RECHNUNG UND NICHT AUSGEBUCHT
	if (get_field('keinerechnung') && $ausl!=100) $loc="jetzt-bedanken";		 	// KEINE RECHNUNG UND NICHT AUSGEBUCHT bzw. Auf Anfrage
	if (get_field('ausgebucht') || $ausl==100)  $loc="vielen-dank";						// AUSGEBUCHT ODER WARTELISTE

	echo "location = 'https://ywh.de/".$loc."/';";
?>
}, false );


cookie = {

    set: function (name, value, days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            var expires = "; expires=" + date.toGMTString();
        }
        else
            var expires = "";
        document.cookie = name + "=" + JSON.stringify(value) + expires + "; path=/";
    },

    get : function(name){
        var nameEQ = name + "=",
            ca = document.cookie.split(';');

        for(var i=0;i < ca.length;i++) {
          var c = ca[i];
          while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0)
              return  JSON.parse(c.substring(nameEQ.length,c.length));
        }

        return null;
    }

}

</script>


<?php

//LADE Calc Funktionen
include_once(ABSPATH.'wp-content/themes/uncode-child/inc/calc.php');

// Zeige von bis Datum anhand von Modulen

$tage = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");

$monate = array(1=>"Januar",
                2=>"Februar",
                3=>"M&auml;rz",
                4=>"April",
                5=>"Mai",
                6=>"Juni",
                7=>"Juli",
                8=>"August",
                9=>"September",
                10=>"Oktober",
                11=>"November",
                12=>"Dezember");


$sd             = get_field('sortdate');
$tag            = date("w", strtotime($sd));
$tagz           = date("d", strtotime($sd));
$monat          = date("n", strtotime($sd));
$jahr           = date("Y", strtotime($sd));

if (get_field('customdate'))  $ws_datum = get_field('customdate');
if (!get_field('customdate')) $ws_datum  = $tage[$tag].", ".$tagz.". ".$monate[$monat]." ".$jahr;
if (get_field('modul2_datum')) $ws_datum = get_field('modul1_datum')." - ".get_field('modul2_datum');
if (get_field('modul3_datum')) $ws_datum =get_field('modul1_datum')." - ".get_field('modul3_datum');
if (get_field('modul4_datum')) $ws_datum =get_field('modul1_datum')." - ".get_field('modul4_datum');


?>

<script type="text/javascript">
	jQuery.noConflict();
		(function($) {
		  	$(function() {
					// alert('<?php echo $_SESSION["warteliste"];?>');
	 			setTimeout(function(){
		  		/* Füge Datum Button im Header hinzu */
	 			$( ".header-title" ).append( '<span id="showdatum" class="btn btn-accent btn-circle btn-flat" style="width:auto;display:inline-block!important;cursor:crosshair; opacity:1!important;font-size:18px;letter-spacing:0;text-shadow:none!important;"><?php the_field('customdate');?></span>' );
			}, 2200);
	   });
	})(jQuery);
</script>

<?php

$cl1 = "class_1"; if (get_field('modul2_title')) $cl1 = "class1";

$createModule ="";
$allModule = "";
$createagb  ="";
$m1_hide="";
$m1_titel="";


/* AUSLASTUNG MODUL 1 */
if (get_field('capacity') ){
	$cap = get_field('capacity');
	if (get_field('amount') ){
		$anz = get_field('amount');
		$atmp = ($anz*100)/$cap;
		$ausl = floor($atmp);
	}
}

/* AUSLASTUNG MODUL 2 */
if ( get_field('capacity2') ){
	$cap2 = get_field('capacity2');
	if (get_field('amount2') ){
		$anz2 = get_field('amount2');
		$atmp2 = ($anz2*100)/$cap2;
		$ausl2 = floor($atmp2);
	}
}

/* AUSLASTUNG MODUL 3 */
if ( get_field('capacity3') ){
	$cap3 = get_field('capacity3');
	if (get_field('amount3') ){
		$anz3 = get_field('amount3');
		$atmp3 = ($anz3*100)/$cap3;
		$ausl3 = floor($atmp3);
	}
}

/* AUSLASTUNG MODUL 4 */
if ( get_field('capacity4') ){
	$cap4 = get_field('capacity4');
	if (get_field('amount4') ){
		$anz4 = get_field('amount4');
		$atmp4 = ($anz4*100)/$cap4;
		$ausl4 = floor($atmp4);
	}
}

$allModule ="";
$dis = "";
$isaus = "";
$span_isaus = '<small style="line-height:.1; float:right;color:yellow"> 100% AUSGEBUCHT</small>';
$hausl ="";

// Erlaube keine Umlaute, Leerzeichen
$regex_title_tmp = preg_replace("/[^A-Za-z]/i", "", get_the_title());
// $regex_title_tmp = preg_replace("/[^A-Za-z]/i", "", get_the_title());
$regex_title = preg_replace("/[#038]/i", "",$regex_title_tmp);

echo '<style>#required input[type=checkbox]:not(old) + label > span.hausl {opacity:0;margin-left:-30px}</style>';

if ($ausl ==100) { 	$dis=" disabled=disabled"; $isaus  = $span_isaus;  $hausl = 'hausl';}
if ($ausl2==100) { 	$dis2=" disabled=disabled"; $isaus2 = $span_isaus;  $hausl2 = 'hausl';}
if ($ausl3==100) { 	$dis3=" disabled=disabled"; $isaus3 = $span_isaus;  $hausl3 = 'hausl';}
if ($ausl4==100) { 	$dis4=" disabled=disabled"; $isaus4 = $span_isaus;  $hausl4 = 'hausl';}

if (!get_field('modul2_title')) {
		$mheadline = ""; $m1_chk ='  checked="checked" '; $m1_hide="m1_hide"; $m1_titel= get_field('modul1_title');
}
if (get_field('modul2_title')) $mheadline = '<h2 style="color:#FFF;padding:30px 0 10px 0;">Bitte auswählen</h2>';


	// GESAMTPREIS ERMITTTELN
	$totalpreis = get_field('modul1_preis');
	if (get_field('modul2_preis')) $totalpreis = get_field('modul1_preis')+get_field('modul2_preis');
	if (get_field('modul3_preis')) $totalpreis = get_field('modul1_preis')+get_field('modul2_preis')+get_field('modul3_preis');
	if (get_field('modul4_preis')) $totalpreis = get_field('modul1_preis')+get_field('modul2_preis')+get_field('modul3_preis')+get_field('modul4_preis');

	// MODUL 1
	if (get_field('modul1_title')) {
		$createModule .='<div '.$dis.' class="'.$m1_hide.'"><input '.$m1_chk.' 	type="checkbox" class="'.$cl1.'" id="checkbox100" value="'.get_field('modul1_title').' |'.get_field('modul1_preis').'" name="module[]"></input><label for="checkbox100"><span class="'.$hausl.'"></span>'.get_field('modul1_title').$isaus.'</label><input type="hidden" id="storeM1" name="storeM1" class="cbs" value="'.$m1_titel.'"><input type="hidden" name="pdf_folder"  value="'.strtolower($regex_title).'"></div>';
	}

	// MODUL 2
	if (get_field('modul2_title')) {
	$createModule .='<input '.$dis2.' type="checkbox" class="class1" id="checkbox101" value="'.get_field('modul2_title').' |'.get_field('modul2_preis').'" name="module[]"></input><label for="checkbox101"><span class="'.$hausl2.'"></span>'.get_field('modul2_title').$isaus2.'</label><input type="hidden" id="storeM2" name="storeM2" class="cbs" value="">';

//	if (($ausl!=100) && ($ausl2!=100) && ($ausl3!=100) && ($ausl4!=100)) {
	if ($ausl!=100 AND $ausl2!=100 AND $ausl3!=100 AND $ausl4!=100) {

		$allModule ='<input type="checkbox" class="class2" id="checkboxall" value="GESAMTER WORKSHOP | '.$totalpreis .'" name="module[]"></input><label for="checkboxall"><span></span>Gesamter Workshop</label><input type="hidden" id="storeALL" name="storeALL" class="cbs2" value="">';
	}

	}

	// MODUL 3
	if (get_field('modul3_title')) {
	$createModule .='<input '.$dis3.' type="checkbox" class="class1" id="checkbox102" value="'.get_field('modul3_title').' |'.get_field('modul3_preis').'" name="module[]"></input><label for="checkbox102"><span class="'.$hausl3.'"></span>'.get_field('modul3_title').$isaus3.'</label><input type="hidden" id="storeM3" name="storeM3" class="cbs" value="">';
	}

	// MODUL 4
	if (get_field('modul4_title')) {
	$createModule .='<input '.$dis4.' type="checkbox" class="class1" id="checkbox103" value="'.get_field('modul4_title').' |'.get_field('modul4_preis').'" name="module[]"></input><label for="checkbox103"><span class="'.$hausl4.'"></span>'.get_field('modul4_title').$isaus4.'</label><input type="hidden" id="storeM4" name="storeM4" class="cbs" value="">';
	}

	// AGBs
	$createagb ='<span id="radiorequired"><input type="radio" id="gutagbs" name="gutagbs"><label for="gutagbs"><span></span>Ja, ich akzeptiere die <strong><a class="js-toggle-agb pink">AGBs</a></strong> <strong>'.$_SESSION["warteliste"].$_SESSION["workform"].'</strong></label></span><br>';

	// Retreat
	// if (get_field('retreat')) $createagb ='RETREAT';

?>

<script>
jQuery.noConflict();
	(function($) {
	  	$(function() {

				 // Verstecke Tag Cloud row-comntainer
				 $('.tagcloud').parent().parent().parent().hide();

				 // passe Abstand von Tag, Worksop, Lehrer an - oben links
				 $('.ws-lehrer').parent().css('margin-top','-10px');
				 $('.kurztext').parent().css('margin-top','-10px');


	  		// FÜGE WS MODULE ZUM FORMULAR HINZU
	  		$('#formular #required').html('<?php echo $mheadline.$createModule.$allModule.$createagb;?>'); //

				// $('#formular #anfrage').html('<?php echo $mheadline;?>'); //

	  		setTimeout(function(){
		  		// AGB BUTTON
	  			$("#formular #send").val("Bitte AGBs akzeptieren ↑");
	  			$("#formular #send").attr("disabled", "disabled");

	  		}, 1);

				<?php
					// wenn zB geswitched werden muss
					// => detoxyoga: Monatsbo vs. Punktekarte
					if (get_field('modul_single')) {
				?>
						// alert ('modul_single');
							// Remove Gesamter Workshop Zeile
							$('input[type="checkbox"]#checkboxall').remove();
							$('label[for=checkboxall]').remove();

							// Modul 1 toggle with M 2
							$('input[type="checkbox"]#checkbox100').change(function () {
								 if ($(this).is(':checked')) {
									var $s1 = $(this).val();
									var result=$s1.split('|');
									$('#storeM1')[0].value = result[0];
									$('input[type="checkbox"]#checkbox101').prop({ disabled: true, checked: false });
									$('#storeM2')[0].value ="";
								 } else {
								 		$('#storeM1')[0].value ="";
										$('input[type="checkbox"]#checkbox101').prop({ disabled: false, checked: true });
								 }
							});
							// Modul 2 toggle with M1
							$('input[type="checkbox"]#checkbox101').change(function () {
								 if ($(this).is(':checked')) {
									 var $s1 = $(this).val();
			 						var result=$s1.split('|');
			 						$('#storeM2')[0].value = result[0];
									$('input[type="checkbox"]#checkbox100').prop({ disabled: true, checked: false });
									$('#storeM1')[0].value ="";
								 } else {
								 		$('#storeM2')[0].value ="";
										$('input[type="checkbox"]#checkbox100').prop({ disabled: false, checked: true });

								 }
							});

				<?php } // ende switch mode ?>

				<?php
					if (!get_field('modul_single')) {
				?>
				// Modul 1
				$('input[type="checkbox"]#checkbox100').change(function () {
					 if ($(this).is(':checked')) {
						var $s1 = $(this).val();
						var result=$s1.split('|');
						$('#storeM1')[0].value = result[0];

					 } else {
					 		$('#storeM1')[0].value ="";
					 }
				});
				// Modul 2
				$('input[type="checkbox"]#checkbox101').change(function () {
					 if ($(this).is(':checked')) {
						 var $s1 = $(this).val();
 						var result=$s1.split('|');
 						$('#storeM2')[0].value = result[0];
					 } else {
					 		$('#storeM2')[0].value ="";
					 }
				});
				// Modul 3
				$('input[type="checkbox"]#checkbox102').change(function () {
					 if ($(this).is(':checked')) {
						 var $s1 = $(this).val();
 					 var result=$s1.split('|');
 					 $('#storeM3')[0].value = result[0];
					 } else {
					 		$('#storeM3')[0].value ="";
					 }
				});
				// Modul 4
				$('input[type="checkbox"]#checkbox103').change(function () {
					 if ($(this).is(':checked')) {
						 var $s1 = $(this).val();
 					 var result=$s1.split('|');
 					 $('#storeM4')[0].value = result[0];
					 } else {
					 		$('#storeM4')[0].value ="";
					 }
				});

				$('input[type="checkbox"]#checkboxall').change(function () {

					if ($(this).is(':checked')) {
					 var $s1 = $(this).val();
					 var result=$s1.split('|');
					 $('#storeALL')[0].value = result[0];

					 	$('#storeM1')[0].value="";
					 	$('#storeM2')[0].value="";
					 	$('#storeM3')[0].value="";
					 	$('#storeM4')[0].value="";

					 } else {
					 	$('.cbs2')[0].value="";
					 }
				});




			 // PRÜFE MODULE , WENN ALLE GECHECKED DANN SWITCHE AUF GESAMT
				$('input[class^="class"]').click(function() {

					var a = $(".class1");
					var b = $(".class2");
						 if(a.length == a.filter(":checked").length){
								 // console.log ('all checked');
								$(a).prop({ disabled: true, checked: false });
								$(b).prop({ disabled: false, checked: true });

								$('#storeM1')[0].value=""; // Modul 1
								$('#storeM2')[0].value=""; // Modul 2
								$('#storeM3')[0].value=""; // Modul 3
								$('#storeM4')[0].value=""; // Modul 4
								$('#storeALL')[0].value="GESAMTER WORKSHOP ";
						 }

					var $this = $(this);
							if ($this.is(b)) {
									if ($(".class2:checked").length > 0) {
											$(a).prop({ disabled: true, checked: false, });
									} else {
											$(a).prop("disabled", false);
									}
							}
				});
				<?php } // not modul_single ?>


				// AGBs
				$('input[type="radio"]#gutagbs').click(function () {
						var $rb = $(this);

						if ($rb.val() === 'on') {
								$rb.val('off');
								this.checked = false;
								$("#formular #send").attr("disabled", "disabled");
								$("#formular #send").val("Bitte AGBs akzeptieren ↑");
						}
						else {
								$rb.val('on');
								this.checked = true;
							 $("#formular #send").removeAttr("disabled");
							 $("#formular #send").val("Abschicken & bezahlen");
						}
				});

			// Filter the given class out of the array
			function filterArray(array, exclude) {
				var newArray = array.slice(0); // clone array (sort of)
				for (var i=newArray.length-1; i>=0; i--) {
					if (newArray[i] === exclude) {
						newArray.splice(i, 1);
					}
				}
				return newArray;
			}

			// Switch body classes for layout changing modals
			var bodyClasses = ['open-neu','open-agb'];

			function switchBodyClass(className) {
				var delay = 0;
				var classArray = filterArray(bodyClasses, className);

				for (var i=0; i<classArray.length; i++) {
					if (document.body.classList.contains(classArray[i])) delay = 300;
					document.body.classList.remove(classArray[i]);
				}

				window.setTimeout( function() {
					document.body.classList.toggle(className);
				}, delay);
			}


			$('.js-toggle-agb').on('click', function() {
				switchBodyClass('open-agb');
				 // Verstecke Menu + Logo wenn NEW angeklickt wird
 			})

 		$("#send").before( '<div class="is_required">Mind. 1 Modul auswählen.</div>' );


		// /* Verstecke CF7 error "Alle Pflichtfelder ausgefüllt wenn hover Formular */
	 $(".form-control").hover(function(){
			 $('.wpcf7-validation-errors').fadeOut('1000');
	 });


		/* MINDESTENS EIN MODUL  */
		$('#send').click(function(){
				 console.log('CLICK SEND');
		    if ( $('#required').length){

					 console.log('required length');

				 amIChecked = false;
		        $('#required input[type="checkbox"]').each(function() {
		            if (this.checked) {
		                console.log('amIChecked=true')
		                amIChecked = true;
		            }
		        });

		        if (!amIChecked) {
							 console.log('amIChecked=false')
								$(".is_required").show (20);
								$(".is_required").delay( 2000 ).hide (500);
								return false;
		        }
			}
		});




		// cookie.get('cookie_key'); // {foo: 'bar'}
		//
		// cookie.set('cookie_key', 'baz', 30);

		// var gc = cookie.get('ywh_spi'); // 'baz'
		//
		// if (cookie.get('ywh_spi')) {
		// 	console.log(gc);
		// 	$.each( gc, function( key, value ) {
		// 		console.log( key + ": " + value );
		// 	});
		// 	$('#wsname').val(cookie.get('wsname'))
		// 	$('#mailme').val(cookie.get('mailme'))
		// } else {
		// 	wsname = $('#wsname').val();
		// 	mailme = $('#mailme').val();
		// 	// Create Cookie
		// 	cookie.set('ywh_spi', wsname,mailme, 30);
		// }



	  	});
})(jQuery);


</script>
