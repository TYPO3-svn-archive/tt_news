<?php

########################################################################
# Extension Manager/Repository config file for ext: "tt_news"
# 
# Auto generated 17-11-2004 17:08
# 
# Manual updates:
# Only the data in the array - anything else is removed by next write
########################################################################

$EM_CONF[$_EXTKEY] = Array (
	'title' => 'News',
	'description' => 'Website news with front page teasers and article handling inside.',
	'category' => 'plugin',
	'shy' => 0,
	'dependencies' => 'cms',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'TYPO3_version' => '3.6.3-0.0.3',
	'PHP_version' => '0.0.6-0.0.6',
	'module' => '',
	'state' => 'stable',
	'internal' => 0,
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author' => 'Rupert Germann',
	'author_email' => 'rupi@gmx.li',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'private' => 0,
	'download_password' => '',
	'version' => '1.7.9',	// Don't modify this! Managed automatically during upload to repository.
	'_md5_values_when_last_written' => 'a:104:{s:10:".directory";s:4:"b334";s:9:"ChangeLog";s:4:"66ed";s:20:"class.ext_update.php";s:4:"a692";s:33:"class.tx_ttnews_itemsProcFunc.php";s:4:"c0d7";s:26:"class.ux_tx_cms_layout.php";s:4:"8e0c";s:21:"ext_conf_template.txt";s:4:"761e";s:22:"ext_conf_template.txt~";s:4:"64b4";s:15:"ext_emconf.php~";s:4:"562c";s:12:"ext_icon.gif";s:4:"5e2a";s:15:"ext_icon__h.gif";s:4:"e1bc";s:16:"ext_icon__ht.gif";s:4:"dbd6";s:17:"ext_icon__htu.gif";s:4:"7975";s:16:"ext_icon__hu.gif";s:4:"865e";s:15:"ext_icon__t.gif";s:4:"ef88";s:16:"ext_icon__tu.gif";s:4:"22a2";s:15:"ext_icon__u.gif";s:4:"0fd4";s:15:"ext_icon__x.gif";s:4:"ede5";s:17:"ext_localconf.php";s:4:"772b";s:15:"ext_php_api.dat";s:4:"078e";s:14:"ext_tables.php";s:4:"4c5e";s:15:"ext_tables.php~";s:4:"0c80";s:14:"ext_tables.sql";s:4:"069b";s:15:"flexform_ds.xml";s:4:"a12a";s:16:"flexform_ds.xml~";s:4:"e0e5";s:23:"flexform_ds_no_sPID.xml";s:4:"3904";s:24:"flexform_ds_no_sPID.xml~";s:4:"fa07";s:13:"locallang.php";s:4:"41af";s:24:"locallang_csh_ttnews.php";s:4:"6d8a";s:25:"locallang_csh_ttnewsc.php";s:4:"ebf4";s:17:"locallang_tca.php";s:4:"3f70";s:18:"locallang_tca.php~";s:4:"00e2";s:7:"tca.php";s:4:"7066";s:8:"tca.php~";s:4:"ecaf";s:11:"CVS/Entries";s:4:"870d";s:14:"CVS/Repository";s:4:"3417";s:8:"CVS/Root";s:4:"a264";s:14:"doc/.directory";s:4:"6977";s:14:"doc/manual.sxw";s:4:"ce5e";s:15:"doc/CVS/Entries";s:4:"2bf1";s:18:"doc/CVS/Repository";s:4:"dfbe";s:12:"doc/CVS/Root";s:4:"a264";s:13:"pi/.directory";s:4:"b334";s:13:"pi/ce_wiz.gif";s:4:"da3a";s:22:"pi/class.tx_ttnews.php";s:4:"f182";s:23:"pi/class.tx_ttnews.php~";s:4:"2b6b";s:30:"pi/class.tx_ttnews_wizicon.php";s:4:"cc72";s:16:"pi/locallang.php";s:4:"9b8d";s:10:"pi/new.gif";s:4:"7f00";s:17:"pi/news_conf1.png";s:4:"573b";s:17:"pi/news_help.tmpl";s:4:"1ab4";s:21:"pi/news_template.tmpl";s:4:"e7ff";s:27:"pi/tt_news_v2_template.html";s:4:"0654";s:28:"pi/tt_news_v2_template.html~";s:4:"a074";s:14:"pi/CVS/Entries";s:4:"3b59";s:17:"pi/CVS/Repository";s:4:"f5bc";s:11:"pi/CVS/Root";s:4:"a264";s:14:"res/.cvsignore";s:4:"098f";s:14:"res/.directory";s:4:"b334";s:29:"res/example_amenuUserFunc.php";s:4:"b264";s:31:"res/example_imageMarkerFunc.php";s:4:"2776";s:35:"res/example_itemMarkerArrayFunc.php";s:4:"9c47";s:35:"res/example_userPageBrowserFunc.php";s:4:"72c0";s:27:"res/news_amenuUserFunc2.php";s:4:"a9d8";s:29:"res/realUrl_example_setup.txt";s:4:"9f5f";s:17:"res/rss_0_91.tmpl";s:4:"c24d";s:14:"res/rss_2.tmpl";s:4:"5f30";s:23:"res/tt_news_article.gif";s:4:"91b6";s:22:"res/tt_news_exturl.gif";s:4:"57f6";s:28:"res/tt_news_languageMenu.php";s:4:"2146";s:29:"res/tt_news_languageMenu.php~";s:4:"e9b8";s:27:"res/tt_news_medialinks.html";s:4:"9508";s:22:"res/tt_news_styles.css";s:4:"1214";s:25:"res/tt_news_v2_styles.css";s:4:"85eb";s:15:"res/CVS/Entries";s:4:"67e4";s:18:"res/CVS/Repository";s:4:"b4c6";s:12:"res/CVS/Root";s:4:"a264";s:17:"static/.directory";s:4:"b334";s:18:"static/CVS/Entries";s:4:"d832";s:21:"static/CVS/Repository";s:4:"7751";s:15:"static/CVS/Root";s:4:"a264";s:20:"static/css/setup.txt";s:4:"991d";s:21:"static/css/setup.txt~";s:4:"98f6";s:22:"static/css/CVS/Entries";s:4:"3660";s:25:"static/css/CVS/Repository";s:4:"353b";s:19:"static/css/CVS/Root";s:4:"a264";s:29:"static/rss_feed/constants.txt";s:4:"0359";s:25:"static/rss_feed/setup.txt";s:4:"3796";s:26:"static/rss_feed/setup.txt~";s:4:"891c";s:27:"static/rss_feed/CVS/Entries";s:4:"2e9b";s:30:"static/rss_feed/CVS/Repository";s:4:"77e1";s:24:"static/rss_feed/CVS/Root";s:4:"a264";s:27:"static/ts_new/constants.txt";s:4:"e4a3";s:23:"static/ts_new/setup.txt";s:4:"5695";s:24:"static/ts_new/setup.txt~";s:4:"465e";s:25:"static/ts_new/CVS/Entries";s:4:"86b3";s:28:"static/ts_new/CVS/Repository";s:4:"5e18";s:22:"static/ts_new/CVS/Root";s:4:"a264";s:24:"static/ts_old/.directory";s:4:"b334";s:27:"static/ts_old/constants.txt";s:4:"5a70";s:23:"static/ts_old/setup.txt";s:4:"a4cb";s:24:"static/ts_old/setup.txt~";s:4:"b856";s:25:"static/ts_old/CVS/Entries";s:4:"a83f";s:28:"static/ts_old/CVS/Repository";s:4:"3052";s:22:"static/ts_old/CVS/Root";s:4:"a264";}',
);

?>