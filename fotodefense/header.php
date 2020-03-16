<!DOCTYPE html>
<html class="no-js" xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>

<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><!<![endif]-->

<title><?=$APPLICATION->ShowTitle();?></title>


<?
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/jquery-3.4.1.min.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/jquery-ui-1.12.1.min.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/jquery-migrate-1.4.1.min.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/jquery-migrate-3.0.0.min.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/modernizr.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/nx_plugins.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/hyphenate.js');
?>

<?=$APPLICATION->ShowHead();?>


<link rel="apple-touch-icon" sizes="180x180" href="icon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="icon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="icon/favicon-16x16.png">
<link rel="manifest" href="icon/site.webmanifest">
<link rel="mask-icon" href="icon/safari-pinned-tab.svg" color="#5bbad5">
<link rel="shortcut icon" href="icon/favicon.ico">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-config" content="icon/browserconfig.xml">
<meta name="theme-color" content="#ffffff">

</head>

<body>
<div class="panel"><?=$APPLICATION->ShowPanel();?></div>

<div class="container">
	<!-- HEADER --> 
	<header class="header">
		<div class="header_content nx-flex-row-btw-c">
			<a class="logo" href="/" id = "NXTel" data-tel="+7 (831) 2960-920">Женский журнал</a>
			
			<?$APPLICATION->IncludeComponent(
				"bitrix:menu", 
				"fotodefense_header_menu", 
				array(
					"ALLOW_MULTI_SELECT" => "N",
					"CHILD_MENU_TYPE" => "left",
					"DELAY" => "N",
					"MAX_LEVEL" => "1",
					"MENU_CACHE_GET_VARS" => array(
					),
					"MENU_CACHE_TIME" => "3600",
					"MENU_CACHE_TYPE" => "N",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"ROOT_MENU_TYPE" => "header",
					"USE_EXT" => "N",
					"COMPONENT_TEMPLATE" => "fotodefense_header_menu",
					"MENU_TITLE" => "Информация"
				),
				false
			);?>
		</div>	
		<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"fotodefense_top_menu", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"DELAY" => "N",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "top",
		"USE_EXT" => "Y",
		"COMPONENT_TEMPLATE" => "fotodefense_top_menu"
	),
	false
);?>
	
		
	
	</header>

	<!-- CENTRAL BLOCK -->	
	<div class="main-outer">

	<!-- MAIN -->
		<main class="main">