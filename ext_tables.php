<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
t3lib_div::loadTCA('tt_content');
$TCA['tt_news'] = Array (
	'ctrl' => Array (
		'title' => 'LLL:EXT:tt_news/locallang_tca.php:tt_news',
		'label' => 'title',
		'default_sortby' => 'ORDER BY datetime DESC',
		'tstamp' => 'tstamp',
		'delete' => 'deleted',
		'prependAtCopy' => 'LLL:EXT:lang/locallang_general.php:LGL.prependAtCopy',
		'crdate' => 'crdate',
		'type' => 'type',
		'enablecolumns' => Array (
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			'fe_group' => 'fe_group',
		),
		'typeicon_column' => 'type',
		'typeicons' => Array (
			'1' => 'tt_news_article.gif',
			'2' => 'tt_news_exturl.gif',
		),
		'thumbnail' => 'image',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon.gif',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php'
	)
);
$TCA['tt_news_cat'] = Array (
	'ctrl' => Array (
		'title' => 'LLL:EXT:tt_news/locallang_tca.php:tt_news_cat',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'delete' => 'deleted',
		'prependAtCopy' => 'LLL:EXT:lang/locallang_general.php:LGL.prependAtCopy',
		'crdate' => 'crdate',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php'
	)
);

$TCA['tt_content']['types']['list']['subtypes_excludelist'][9]='layout,select_key,pages,recursive';
$TCA['tt_content']['types']['list']['subtypes_addlist'][9]='pi_flexform';
t3lib_extMgm::addPlugin(Array('LLL:EXT:tt_news/locallang_tca.php:tt_news', '9'));

t3lib_extMgm::allowTableOnStandardPages('tt_news');
t3lib_extMgm::addToInsertRecords('tt_news');


// adds the possiblity to switch the use of the "StoragePid"(general record Storage Page) for tt_news categories
$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['tt_news']);
if ($confArr['useStoragePid']) {
    t3lib_extMgm::addPiFlexFormValue(9, 'FILE:EXT:tt_news/flexform_ds.xml');
} else {
	t3lib_extMgm::addPiFlexFormValue(9, 'FILE:EXT:tt_news/flexform_ds_no_sPID.xml');
}






// comment this out, if you don't want users to create news_categories on normal pages
t3lib_extMgm::allowTableOnStandardPages('tt_news_cat');

t3lib_extMgm::addLLrefForTCAdescr('tt_news','EXT:tt_news/locallang_csh_ttnews.php');
t3lib_extMgm::addLLrefForTCAdescr('tt_news_cat','EXT:tt_news/locallang_csh_ttnewsc.php');

	
if (TYPO3_MODE=='BE')	{
	// Adds wizard icon to the content element wizard.
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_ttnews_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'pi/class.tx_ttnews_wizicon.php';
	// add extra 'codes' to the 'what to display' selector
	include_once(t3lib_extMgm::extPath('tt_news').'class.tx_ttnews_itemsProcFunc.php');
	
}

?>