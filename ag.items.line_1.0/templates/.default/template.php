<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?if(count($arResult['ITEMS'])>0):?>
	<?if($arParams["DISPLAY_TOP_PAGER"]=='Y'):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>
	<section class="list_elelments nx-flex-row-st" data-ib-element="<?=$arParams["IBLOCKS"][0]?>">
		<?foreach($arResult['ITEMS'] as $cell => $arElement):?>
			<div  class="item_element">
				<figure class="item_element_prw <?if(!$arElement["PREVIEW_PICTURE"]['SRC']):?>no_images<?endif?>">
					<?if($arElement["PREVIEW_PICTURE"]['SRC']):?>
						<img src="<?=$arElement["PREVIEW_PICTURE"]['SRC']?>"/>
					<?endif;?>
					<div class="wrap_item_element_rating nx-flex-row-r-c" data-id-element="<?=$arElement['ID']?>">
						<div class="rating nx-flex-row-r-c">
							<?if($arElement['PROPERTIES']['RATING']['VALUE']):?>
								<?=$arElement['PROPERTIES']['RATING']['VALUE']?>
							<?else:?>
								1
							<?endif?>
						</div>
						<?if($arParams["SHOW_VOTE"]=='Y' && $arElement['NOT_VOTE']!='true'):?>
							<div class="rating_action nx-flex-row-r-c" >
								<a class="rating_action_link down">-</a>
								<a class="rating_action_link up">+</a>
							</div>
						<?endif?>
					</div>
					<div class="item_element_option nx-flex-row-btw-c">
						<div class="item_element_category">
							<?if($arElement['NAME_SECTION']):?><?=$arElement['NAME_SECTION']?><?endif?>
						</div>
						<div class="item_element_prop nx-flex-row-r-c">
							<div class="item_element_prop_item item_element_comment">45</div>
							<div class="item_element_prop_item item_element_view">8900</div>
						</div>
					</div>
				</figure>
				<a href="<?=$arElement['DETAIL_PAGE_URL']?>"  class="item_element_name"><?=$arElement["NAME"]?></a>
				<?if($arElement["PREVIEW_TEXT"]):?>
					<div class="item_element_anons"><?=$arElement["PREVIEW_TEXT"]?></div>
				<?endif;?>
			</div>					
		<?endforeach;?>
	</section>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]=='Y'):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>
<?endif;?>

<?if($arResult["SECTION"]["NAME"]):?>
	<h1><?=$arResult["SECTION"]["NAME"]?></h1>
<?endif?>

<?if($arResult["SECTION"]["DESCRIPTION"]):?>
	<div class="description_block"><?=$arResult["SECTION"]["DESCRIPTION"]?></div>
<?endif?>







