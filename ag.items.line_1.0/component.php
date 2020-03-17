<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 300;

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
if(strlen($arParams["IBLOCK_TYPE"]) <= 0)
	$arParams["IBLOCK_TYPE"] = "news";
if($arParams["IBLOCK_TYPE"]=="-")
	$arParams["IBLOCK_TYPE"] = "";
	
if(!is_array($arParams["IBLOCKS"]))
	$arParams["IBLOCKS"] = array($arParams["IBLOCKS"]);
foreach($arParams["IBLOCKS"] as $k=>$v)
	if(!$v)
		unset($arParams["IBLOCKS"][$k]);
		
if(!is_array($arParams["FIELD_CODE"]))
	$arParams["FIELD_CODE"] = array();
foreach($arParams["FIELD_CODE"] as $key=>$val)
	if(!$val)
		unset($arParams["FIELD_CODE"][$key]);

$arParams["SORT_BY1"] = trim($arParams["SORT_BY1"]);
if(strlen($arParams["SORT_BY1"])<=0)
	$arParams["SORT_BY1"] = "ACTIVE_FROM";
if(!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["SORT_ORDER1"]))
	$arParams["SORT_ORDER1"]="DESC";

if(strlen($arParams["SORT_BY2"])<=0)
	$arParams["SORT_BY2"] = "SORT";
if(!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["SORT_ORDER2"]))
	$arParams["SORT_ORDER2"]="ASC";

$arParams["NEWS_COUNT"] = intval($arParams["NEWS_COUNT"]);
if($arParams["NEWS_COUNT"]<=0)
	$arParams["NEWS_COUNT"] = 20;

if(!$arParams["LOG_VOTE"])
	$arParams["LOG_VOTE"] = '/upload/log.csv';

$arParams["DETAIL_URL"]=trim($arParams["DETAIL_URL"]);

if($arParams["ELEMENT_STATUS"]) $arParams["ELEMENT_STATUS"] = intval($arParams["ELEMENT_STATUS"]);

$arParams["ACTIVE_DATE_FORMAT"] = trim($arParams["ACTIVE_DATE_FORMAT"]);
if(strlen($arParams["ACTIVE_DATE_FORMAT"])<=0)
	$arParams["ACTIVE_DATE_FORMAT"] = $DB->DateFormatToPHP(CSite::GetDateFormat("SHORT"));

if($arParams["DISPLAY_TOP_PAGER"] || $arParams["DISPLAY_BOTTOM_PAGER"])
{
	$arNavParams = array(
		"nPageSize" => $arParams["NEWS_COUNT"],
		"bShowAll" => $arParams["PAGER_SHOW_ALL"],
	);
	$arNavigation = CDBResult::GetNavParams($arNavParams);
	if($arNavigation["PAGEN"]==0 && $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"]>0)
		$arParams["CACHE_TIME"] = $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"];
}
else
{
	$arNavParams = array(
		"nTopCount" => $arParams["NEWS_COUNT"],
		"bDescPageNumbering" => $arParams["PAGER_DESC_NUMBERING"],
	);
	$arNavigation = false;
}


if($this->StartResultCache(false, array(($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups()), $bUSER_HAVE_ACCESS, $arrFilter, $arrFilterAdd)))
{
	if(!CModule::IncludeModule("iblock"))
	{
		$this->AbortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	
	$arResult=array(
		"ITEMS"=>array(),
	);
	
	$arSelect = array_merge($arParams["FIELD_CODE"], array(
		"ID",
		"IBLOCK_ID",
		"ACTIVE_FROM",
		"DETAIL_PAGE_URL",
		"NAME",
		
	));
	
	$arFilter = array (
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID"=> $arParams["IBLOCKS"],
		"ACTIVE" => "Y",
		"ACTIVE_DATE" => "Y",
		"CHECK_PERMISSIONS" => "Y",
	
	);
	
	$arOrder = array(
		$arParams["SORT_BY1"]=>$arParams["SORT_ORDER1"],
		$arParams["SORT_BY2"]=>$arParams["SORT_ORDER2"],
	);
	if(!array_key_exists("ID", $arOrder))
		$arOrder["ID"] = "DESC";
	
	
	$resIblock = CIBlock::GetByID($arParams["IBLOCKS"]);
	
	if($arResIblock = $resIblock->GetNext()){
		
		$arResult["SECTION"]["NAME"] = $arResIblock["NAME"];
		$arResult["SECTION"]["DESCRIPTION"] = $arResIblock["DESCRIPTION"];
	
	}
	
	function update_log_file($IblickID, $ElemID, $file_name, $vote){
	
		$str = 	intval($IblickID).';'.intval($ElemID).';'.$_SERVER['REMOTE_ADDR'].';'.date("d.m.Y G:i:s").';'.$vote. "\n";

		$handle = fopen($_SERVER['DOCUMENT_ROOT'].$file_name, "a");

		fwrite($handle, $str);

		fclose($handle);
		
	}

	function  check_opportunity_vote($IblickID, $ElemID, $file_name){
		
		$file_name = $_SERVER['DOCUMENT_ROOT'].$file_name;
		
		if(file_exists($file_name)){
			
			$handle = fopen($file_name, "r");
			
			while(!feof($handle)){
				
				$buffer = fgets($handle);
				$arrStr = explode(";",$buffer);

				if($arrStr[0]==$IblickID && $arrStr[1]==$ElemID && $arrStr[2]==$_SERVER['REMOTE_ADDR']){	
					return true;
				}
				
			}
			fclose($handle);
		}
		
	}

	if(isset($_REQUEST["ID_ELEMENT"]) && isset($_REQUEST["TYPE_ACTION"])){

		$el = new CIBlockElement;
		
		$IdElement = intval($_REQUEST["ID_ELEMENT"]);
		
		$arSelectElement = Array("ID", "IBLOCK_ID", "PROPERTY_RATING");
		$arFilterElement = Array("IBLOCK_ID"=>$arParams["IBLOCKS"][0], "ID"=>$IdElement);
		
		$resElement = CIBlockElement::GetList(false, $arFilterElement, false, false, $arSelectElement);
		
		if($obElement = $resElement->GetNextElement()){
			
			$arPropsElement = $obElement->GetProperties();
			
			if(!$arPropsElement['RATING']['VALUE']){
				$ratingElement=0;
			}else{
				$ratingElement = $arPropsElement['RATING']['VALUE'];
			}
			
			if($_REQUEST["TYPE_ACTION"] == 1){
				
				$PROP['RATING'] = $ratingElement + 1;
				$type_action = '+1';
				
			}else{
				$PROP['RATING'] = $ratingElement - 1;
				$type_action = '-1';
			}
			
			$arLoadProductArray = Array("PROPERTY_VALUES"=> $PROP);
			
			$resElement = $el->Update($IdElement, $arLoadProductArray);
			
			update_log_file($arParams["IBLOCKS"][0], $IdElement, $arParams["LOG_VOTE"], $type_action);
			
		}

	}
	
	$rsItems = CIBlockElement::GetList($arOrder, $arFilter, false, $arNavParams, $arSelect);
	$rsItems->SetUrlTemplates($arParams["DETAIL_URL"]);
	$currentCount  = 0;
	$ids = array();
	
	while($artItem = $rsItems->GetNextElement())
	{   $arItem = $artItem->GetFields();
		$arButtons = CIBlock::GetPanelButtons(
			$arItem["IBLOCK_ID"],
			$arItem["ID"],
			0,
			array("SECTION_BUTTONS"=>false, "SESSID"=>false)
		);
		$arItem["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
		$arItem["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];

		if(strlen($arItem["ACTIVE_FROM"])>0)
			$arItem["DISPLAY_ACTIVE_FROM"] = CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], MakeTimeStamp($arItem["ACTIVE_FROM"], CSite::GetDateFormat()));
		else
			$arItem["DISPLAY_ACTIVE_FROM"] = "";

		if(isset($arItem["PREVIEW_PICTURE"]))
			$arItem["PREVIEW_PICTURE"] = CFile::GetFileArray($arItem["PREVIEW_PICTURE"]);
		if(isset($arItem["DETAIL_PICTURE"]))
			$arItem["DETAIL_PICTURE"] = CFile::GetFileArray($arItem["DETAIL_PICTURE"]);

	    $arItem["PROPERTIES"] = $artItem->GetProperties();
		$ids[] = $arItem['ID']; 
		
		if($arParams["SHOW_VOTE"]=="Y" && $arParams["LOG_VOTE"]){
			
			if (check_opportunity_vote($arItem["IBLOCK_ID"], $arItem["ID"], $arParams["LOG_VOTE"])){
				
				$arItem["NOT_VOTE"] = 'true';

			}
			
		}
		
		$arResult["ITEMS"][]=$arItem;
		$arResult["LAST_ITEM_IBLOCK_ID"]=$arItem["IBLOCK_ID"];
		
		$currentCount ++;
		
	}
	

	$navComponentParameters = array();
	if ($arParams["PAGER_BASE_LINK_ENABLE"] === "Y")
	{
		$pagerBaseLink = trim($arParams["PAGER_BASE_LINK"]);
		if ($pagerBaseLink === "")
		{
			if (
				$arResult["SECTION"]
				&& $arResult["SECTION"]["PATH"]
				&& $arResult["SECTION"]["PATH"][0]
				&& $arResult["SECTION"]["PATH"][0]["~SECTION_PAGE_URL"]
			)
			{
				$pagerBaseLink = $arResult["SECTION"]["PATH"][0]["~SECTION_PAGE_URL"];
			}
			elseif (
				isset($arItem) && isset($arItem["~LIST_PAGE_URL"])
			)
			{
				$pagerBaseLink = $arItem["~LIST_PAGE_URL"];
			}
		}

		if ($pagerParameters && isset($pagerParameters["BASE_LINK"]))
		{
			$pagerBaseLink = $pagerParameters["BASE_LINK"];
			unset($pagerParameters["BASE_LINK"]);
		}

		$navComponentParameters["BASE_LINK"] = CHTTP::urlAddParams($pagerBaseLink, $pagerParameters, array("encode"=>true));
	}

	$arResult["NAV_STRING"] = $rsItems->GetPageNavStringEx(
		$navComponentObject,
		$arParams["PAGER_TITLE"],
		$arParams["PAGER_TEMPLATE"],
		$arParams["PAGER_SHOW_ALWAYS"],
		$this,
		$navComponentParameters
	);
	$arResult["NAV_CACHED_DATA"] = null;
	$arResult["NAV_RESULT"] = $rsItems;
	$arResult["NAV_PARAM"] = $navComponentParameters;	
	
	$this->SetResultCacheKeys(array(
		"LAST_ITEM_IBLOCK_ID",
	));
	$this->IncludeComponentTemplate();
}

if(
	$arResult["LAST_ITEM_IBLOCK_ID"] > 0
	&& $USER->IsAuthorized()
	&& $APPLICATION->GetShowIncludeAreas()
	&& CModule::IncludeModule("iblock")
)
{
	$arButtons = CIBlock::GetPanelButtons($arResult["LAST_ITEM_IBLOCK_ID"], 0, 0, array("SECTION_BUTTONS"=>false));
	$this->AddIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons));
}





















?>
