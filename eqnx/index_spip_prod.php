<?php
if(!isset($_COOKIE['eqnxLanguage'])){
	$expire=time()+60*60*24*30;
	setcookie('eqnxLanguage','FR',$expire);
	header("Location: index.php");
	exit;
}


include_once 'class/DBConnection.php';
include_once 'class/Event.php';
include_once 'class/EventData.php';
include_once 'class/NewsData.php';
include_once 'class/News.php';
include_once 'class/Language.php';
include_once 'class/Menu.php';
include_once 'class/MenuData.php';
include_once 'class/MessageNews.php';
include_once 'class/MessageNewsExternal.php';

include_once 'class/PageSubMenu.php';
include_once 'class/PartecipateEvent.php';
include_once 'class/SubMenu.php';
include_once 'class/SubMenuData.php';
include_once 'class/User.php';
include_once 'class/SlideShow.php';
include_once 'class/SettingsInfo.php';
include_once 'class/SettingsInfoData.php';

$userLanguage = $_COOKIE['eqnxLanguage'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<!-- meta -->
<meta charset="utf-8" />
<meta name="description" content="description" />
<meta name="author" content="auteur">
<link rel="stylesheet" type="text/css" href="css/design.css">
<link href='http://fonts.googleapis.com/css?family=Armata'
	rel='stylesheet' type='text/css'>
<link rel="shortcut icon" href="img/favicon.ico" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.history.js"></script>
<script type="text/javascript" src="js/slide.js"></script>
<script type="text/javascript" src="js/modernizr-2.0.6.min.js"></script>
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script> -->
<script
	src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
<script type="text/javascript">

/*$(window).resize(function(){
    var height_window = $(document).height();
    var width_window = $(document).width();
            console.log(width_window+ ' x '+ height_window);
});*/


/*SLIDE SHOW*/



	function sliderPhoto(){
	$('#slider').crossSlide({
    	sleep: 5,
    	fade: 1
    }, [<?php 
			$resultIdsSlideShow = SlideShow::getIdsFromCodeLanguage($_COOKIE['eqnxLanguage']);
			$lengthSlideShow = mysql_num_rows($resultIdsSlideShow);
			$i = 1;
			while($infoIdsSlideShow = mysql_fetch_assoc($resultIdsSlideShow)){
				if($i < $lengthSlideShow){
	 				echo "{ src: 'images/slideShow/".$_COOKIE['eqnxLanguage']."/".$infoIdsSlideShow['fkSlideShow'].".jpg'},";
				}
				else{
					echo "{ src: 'images/slideShow/".$_COOKIE['eqnxLanguage']."/".$infoIdsSlideShow['fkSlideShow'].".jpg'}";
				}
			$i++;
			}
			
			?>
]);
}




/*AJAX FOR MENU*/

function load(url) {
	var tableUrl = url.split("_");
	
	//if typeOfMenu == 0 -> url Menu, else if typeOfMenu == 1 -> url SubMenu

  if(url != "menu_home"){
	
	  $("#mainContentLeft").show();
	  $("#mainContentRight").show();

		$.get("subMenu.php",{"table": tableUrl[0], "url": tableUrl[1]},function(data){
			$("#mainContentLeft").show();
        	$("#mainContentLeft").html(data);
           	 return false;
   	 	});
		
		$("#mainContentRight").hide();
			if(tableUrl[0] == "menu"){
				$.get("request/isFirstSubMenuPage.php",{"urlMenu": url},function(url2){	
					$.get("contentSubMenu.php",{"urlMenu": url2},function(data2){
    					$("#slider").html("<img src='images/"+url2+".jpg' />");
    					$("#slider").fadeIn(10);

						$("#mainContentRight").fadeOut(0);
            			$("#mainContentRight").html(data2);
            			$("#mainContentRight").fadeIn(750);

						return false;
					}); 
					return false;
    			});
			}
			else if(tableUrl[0] == "submenu"){
				$.get("contentSubMenu.php",{"urlMenu": url},function(data3){
					$("#slider").html("<img src='images/"+url+".jpg' />");
					$("#slider").fadeIn(10);
					
					$("#mainContentRight").fadeOut(0);
					$("#mainContentRight").html(data3);
					$("#mainContentRight").fadeIn(750);
		

				return false;
				});
			}
			
			else if(tableUrl[0] == "event"){
				$.get("contentEvent.php",{"urlMenu": url},function(data4){
					$("#slider").html("<img src='images/event.jpg' />");
					$("#slider").fadeIn(10);
					
					$("#mainContentRight").fadeOut(0);
					$("#mainContentRight").html(data4);
					$("#mainContentRight").fadeIn(750);
				return false;
				});
			}
			
			else if(tableUrl[0] == "news"){
				$.get("contentNews.php",{"urlMenu": url},function(data5){
					$("#slider").html("<img src='images/news.jpg' />");
					$("#slider").fadeIn(10);

					$("#mainContentRight").fadeOut(0);
					$("#mainContentRight").html(data5);
					$("#mainContentRight").fadeIn(750);

				return false;
				});
			}
			
    		
}
  else{
	  $("#mainContentRight").hide();
		  $("#mainContentLeft").fadeOut(0);
			$.get("firstPage.php",function(data6){
				 $("#mainContentLeft").show();
		        $("#mainContentLeft").html(data6);
	   	     return false;
		});
	    $("#mainContentRight").hide();
	    
	    <?php 
	    	if($lengthSlideShow > 0){
	    		echo "sliderPhoto();";
	    	}
	    ?>
	    
	  }


  /*return name of current menu*/
  $.get("request/getCurrentMenu.php",{"urlMenu": url, "lang":'<?php echo $userLanguage; ?>'},function(currentMenu){
		$(".labelSectionFont").text(currentMenu);
	return false;
	});

    
}

			$(function() {
				  var collapsed = true;
				  $('nav#menu>h2').click(function() {
				    collapsed = !collapsed;
				    formatSidebar();
				  });
				  $('.list_top').click(function() {
					    collapsed = !collapsed;
					    formatSidebar();
					  });
				  $(window).resize(formatSidebar);
				  formatSidebar();

				  function formatSidebar() {
				    if ($(document).width() > 767) {
				      $('nav#menu').removeClass('collapsible');
				      $('nav#menu ul#mainMenu').show();
				    } 
				    else {
				      $('nav#menu').addClass('collapsible');
				      if (collapsed) { 
				        $('nav#menu ul#mainMenu').hide();
				        $('nav#menu > h2').removeClass('minus');
				        
				      } else {
				        $('nav#menu ul#mainMenu').show();
				        $('nav#menu > h2').addClass('minus');
				        
				      }
				    }
				  };
				});
		

$(document).ready(function() {
    var x;
    var y;
    for(i=0;i<100;i++){
        x = Math.floor(Math.random()*(screen.width));
        y = Math.floor(Math.random()*(screen.height));
	var o = {left: x, top: y};
	$("#redThing"+i).show(2000).offset(o);
    }

	
   
	$.history.init(function(url) {
		if(url){
		  load(url);
		}
		else{
			load("menu_home");
		}
	});

	
	$('#menu a').live('click', function(e) {
		var url = $(this).attr('href');
		//url = url.replace('/', '');
		$.history.load(url);
		return false;
	});


	$('#submenu a').live('click', function(e) {
		var url = $(this).attr('href');
		//url = url.replace('/', '');
		$.history.load(url);
		return false;
	});

	//sliderPhoto();

	/*SEARCH BOX*/
	$("#searchBox").hide();
	affiche=true;
	$("#logoSearch").click(function(){
		if (affiche){
			$("#searchBox").show();
			$("#inputSearch").focus();
			affiche=!affiche;
		}
		else{
			$("#searchBox").hide();
			affiche=!affiche;
		}
	}); 
	$("#searchBox").hide();

	affiche=true;

	/*SEARCH - MOBILE LOGO*/
	$("#mobileLogoSearch").click(function(){
		if (affiche){
			$("#searchBox").show();
			$("#inputSearch").focus();
			affiche=!affiche;
		}
		else{
			$("#searchBox").hide();
			affiche=!affiche;
		}
	});

	 
});


</script>
<title>Equinoxe MIS Development</title>
<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
<link rel="stylesheet" media="all" href="css/design.css" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->
</head>

<body lang="en">

	<div id="content">
		<div id="logo">
		<?php
		include "fix_code/logo.php";
		?>
		</div>
		<nav id="menu" class="menuPlus">
		<?php
		include "fix_code/menu.php";
		?>
		</nav>
		<div id="pulitore"></div>

		<div id="superiorContent">
			<div id="slider"></div>
			<div id="nextEvents">
			<?php
			include "fix_code/eventsList2.php";
			?>
			</div>
			<div id="pulitore"></div>
		</div>

		<div class="blankSpace21"></div>
		<div id="labelSection">
			<div class="labelSectionFont"></div>
		</div>
		<div id="userInfoArea"></div>
		<div id="pulitore"></div>
		<div class="blankSpace21"></div>
		<div id="mainContentLeft"></div>
		<div id="blankSpace"></div>
		<div id="mainContentRight"></div>
		<div id="pulitore"></div>
		<div class="blankSpace"></div>
		<div id="footer">
		<?php
		include "fix_code/footer.php";
		?>
		</div>
	</div>
</body>

</html>
