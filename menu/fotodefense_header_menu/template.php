<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?if(!empty($arResult)):?>
	<nav class="wrap_header_menu to-nx-nav" itemscope itemtype="https://www.schema.org/SiteNavigationElement">
		<ul class="header_menu nx-flex-row-r-c">
			<?foreach($arResult as $arItem):?>
				<?if($arItem['DEPTH_LEVEL']==1):?>
					<li><a itemprop="url" href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a></li>
				<?endif?>
			<?endforeach?>
		</ul>
	</nav>
<?endif?>