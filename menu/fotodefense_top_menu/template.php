<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
<nav class="nx-up-menu-outer <?if($arParams["NO_ADD_ADAPTIVE_MENU"]!='Y'):?>to-nx-nav<?else:?>no_adaptive_menu<?endif?>" itemscope itemtype="https://www.schema.org/SiteNavigationElement">
<ul class="nx-up-menu" itemscope itemtype="http://schema.org/ItemList">
<?$previousLevel = 0;
foreach($arResult as $arItem):?>
	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
	<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>
	<?if ($arItem["IS_PARENT"]):?>
	<?if ($arItem["DEPTH_LEVEL"] == 1):?>
	<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ItemList" 
		class="root parent-root<?if($arItem["SELECTED"]):?> selected<?endif?><?if($arItem["PARAMS"]["class"]):?> <?=$arItem["PARAMS"]["class"]?><?endif?>" 
	>
		<?if($arItem["PARAMS"]["noindex"]):?><!--noindex--><?endif?>
		<meta itemprop="name" content="<?=$arItem["TEXT"]?>" />
		<a itemprop="url" href="<?=$arItem["LINK"]?>" <?if($arItem["PARAMS"]["nofollow"]):?>rel="nofollow"<?endif?> class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?></a>
		<?if($arItem["PARAMS"]["noindex"]):?><!--/noindex--><?endif?>
	<ul>
	<?else:?>
	<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ItemList" 
		<?if($arItem["PARAMS"]["class"]):?> <?=$arItem["PARAMS"]["class"]?><?endif?>
	>
		<?if($arItem["PARAMS"]["noindex"]):?><!--noindex--><?endif?>
		<meta itemprop="name" content="<?=$arItem["TEXT"]?>" />
		<a itemprop="url" href="<?=$arItem["LINK"]?>" <?if($arItem["PARAMS"]["nofollow"]):?>rel="nofollow"<?endif?> class="parent<?if ($arItem["SELECTED"]):?> item-selected<?endif?>"><?=$arItem["TEXT"]?></a>
		<?if($arItem["PARAMS"]["noindex"]):?><!--/noindex--><?endif?>
	<ul>
	<?endif?>
	<?else:?>
	<?if ($arItem["PERMISSION"] > "D"):?>
	<?if ($arItem["DEPTH_LEVEL"] == 1):?>
	<li itemprop="itemListElement" class="root <?if($arItem["SELECTED"]):?> selected<?endif?> <?if($arItem["PARAMS"]["class"]):?> <?=$arItem["PARAMS"]["class"]?><?endif?>" >
		<?if($arItem["PARAMS"]["noindex"]):?><!--noindex--><?endif?>
		<a itemprop="url" href="<?=$arItem["LINK"]?>" <?if($arItem["PARAMS"]["nofollow"]):?>rel="nofollow"<?endif?> class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?></a>
		<?if($arItem["PARAMS"]["noindex"]):?><!--/noindex--><?endif?>
	</li>
	<?else:?>
	<li itemprop="itemListElement" <?if($arItem["PARAMS"]["class"]):?> <?=$arItem["PARAMS"]["class"]?><?endif?>>
		<?if($arItem["PARAMS"]["noindex"]):?><!--noindex--><?endif?>
		<a itemprop="url" href="<?=$arItem["LINK"]?>" <?if($arItem["PARAMS"]["nofollow"]):?>rel="nofollow"<?endif?> <?if ($arItem["SELECTED"]):?> class="item-selected"<?endif?>><?=$arItem["TEXT"]?></a>
		<?if($arItem["PARAMS"]["noindex"]):?><!--/noindex--><?endif?>
	</li>
	<?endif?>
	<?endif?>
	<?endif?>
	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>
<?endforeach?>
<?if ($previousLevel > 1)://close last item tags?>
<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>
</ul>
</nav>
<?endif?>