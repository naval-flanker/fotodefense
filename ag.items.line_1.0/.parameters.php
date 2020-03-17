<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

$arTypesEx = CIBlockParameters::GetIBlockTypes();

$arIBlocks = Array();
$db_iblock = CIBlock::GetList(Array("SORT"=>"ASC"), Array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch())
{
	$arIBlocks[$arRes["ID"]] = $arRes["NAME"];
}

$arSorts = Array(
	"ASC" => GetMessage("T_IBLOCK_DESC_ASC"),
	"DESC" => GetMessage("T_IBLOCK_DESC_DESC"),
);

$arSortFields = Array(
		"ID" => GetMessage("T_IBLOCK_DESC_FID"),
		"NAME" => GetMessage("T_IBLOCK_DESC_FNAME"),
		"ACTIVE_FROM" => GetMessage("T_IBLOCK_DESC_FACT"),
		"SORT" => GetMessage("T_IBLOCK_DESC_FSORT"),
		"TIMESTAMP_X" => GetMessage("T_IBLOCK_DESC_FTSAMP")
);

$arComponentParameters = array(
	"GROUPS" => array(
		"VOTE" => array(
			 "NAME" => GetMessage("CP_VOTE"),
		),	
	),
	"PARAMETERS"  =>  array(
		"IBLOCK_TYPE"  =>  Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("T_IBLOCK_DESC_LIST_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arTypesEx,
			"DEFAULT" => "news",
			"REFRESH" => "Y",
		),
		"IBLOCKS"  =>  Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("T_IBLOCK_DESC_LIST_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '',
			"MULTIPLE" => "Y",
		),
		
		"NEWS_COUNT"  =>  Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("T_IBLOCK_DESC_LIST_CONT"),
			"TYPE" => "STRING",
			"DEFAULT" => "8",
		),
		
		"FIELD_CODE" => CIBlockParameters::GetFieldCode(GetMessage("CP_BNL_FIELD_CODE"), "DATA_SOURCE"),
		
		"SHOW_VOTE" =>array(
			"PARENT" => "VOTE",
			"NAME" => GetMessage("CP_VOTE_NAME"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => 'N',
			"REFRESH" => "Y",
		),		
		"LOG_VOTE" => Array(
			"PARENT" => "VOTE",
			"NAME" => GetMessage("CP_LOGE_VOTE_NAME"),
			"TYPE" => "TEXT",
			"DEFAULT" => "/upload/log.csv",
		),
		"SORT_BY1"  =>  Array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("T_IBLOCK_DESC_IBORD1"),
			"TYPE" => "LIST",
			"DEFAULT" => "ACTIVE_FROM",
			"VALUES" => $arSortFields,
			"ADDITIONAL_VALUES" => "Y",
		),
		"SORT_ORDER1"  =>  Array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("T_IBLOCK_DESC_IBBY1"),
			"TYPE" => "LIST",
			"DEFAULT" => "DESC",
			"VALUES" => $arSorts,
			"ADDITIONAL_VALUES" => "Y",
		),
		"SORT_BY2"  =>  Array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("T_IBLOCK_DESC_IBORD2"),
			"TYPE" => "LIST",
			"DEFAULT" => "SORT",
			"VALUES" => $arSortFields,
			"ADDITIONAL_VALUES" => "Y",
		),
		"SORT_ORDER2"  =>  Array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("T_IBLOCK_DESC_IBBY2"),
			"TYPE" => "LIST",
			"DEFAULT" => "ASC",
			"VALUES" => $arSorts,
			"ADDITIONAL_VALUES" => "Y",
		),
		"DETAIL_URL" => CIBlockParameters::GetPathTemplateParam(
			"DETAIL",
			"DETAIL_URL",
			GetMessage("IBLOCK_DETAIL_URL"),
			"",
			"URL_TEMPLATES"
		),
		
		"ACTIVE_DATE_FORMAT" => CIBlockParameters::GetDateFormat(GetMessage("T_IBLOCK_DESC_ACTIVE_DATE_FORMAT"), "ADDITIONAL_SETTINGS"),
		"CACHE_TIME"  =>  Array("DEFAULT"=>300),
		"CACHE_GROUPS" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("CP_BNL_CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
	),
);

CIBlockParameters::AddPagerSettings(
	$arComponentParameters,
	GetMessage("T_IBLOCK_DESC_PAGER_NEWS"), //$pager_title
	true, //$bDescNumbering
	true, //$bShowAllParam
	true, //$bBaseLink
	$arCurrentValues["PAGER_BASE_LINK_ENABLE"]==="Y" //$bBaseLinkEnabled
);

CIBlockParameters::Add404Settings($arComponentParameters, $arCurrentValues);
?>
