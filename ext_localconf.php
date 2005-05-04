<?php
if (!defined ("TYPO3_MODE")) 	die ("Access denied.");

// extends the "wizard_add" script to set default values in new created records (used for: "create new subcategory" in hte category record)
$TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['typo3/wizard_add.php']=t3lib_extMgm::extPath($_EXTKEY).'class.ux_SC_wizard_add.php';


// Register a hook in TCEmain: This hook is used to make news categories in the tt_news record non-selectable.
// The list of allowed categories can be set with 'tt_news_cat.allowedItems' in user/group TSconfig.
// This check will be disabled until 'options.useListOfAllowedItems' (user/group TSconfig) is set to a value.
$GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:tt_news/class.tx_ttnews_tcemain.php:tx_ttnews_tcemain';


?>