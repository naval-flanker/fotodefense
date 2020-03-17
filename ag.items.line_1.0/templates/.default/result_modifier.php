<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?
foreach($arResult['ITEMS'] as $keyItem => &$valItem){
	
	if($valItem['IBLOCK_SECTION_ID']){
		
		$resSection = CIBlockSection::GetByID($valItem['IBLOCK_SECTION_ID']);
		
		if($arResSection = $resSection->GetNext()){
			
			$valItem['NAME_SECTION'] = $arResSection['NAME'];
			
		}
		
	}
	
}

?>