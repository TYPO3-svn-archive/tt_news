<?php

########################################################################
# Extension Manager/Repository config file for ext: "tt_news"
# 
# Auto generated 05-02-2005 14:11
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
	'TYPO3_version' => '3.6.0-3.7.0',
	'PHP_version' => '4.2.0-4.3.9',
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
	'version' => '2.0.6',	// Don't modify this! Managed automatically during upload to repository.
	'_md5_values_when_last_written' => 'a:140:{s:10:".directory";s:4:"b334";s:8:".project";s:4:"150a";s:9:"ChangeLog";s:4:"2966";s:8:"Doxyfile";s:4:"51ba";s:20:"class.ext_update.php";s:4:"a692";s:33:"class.tx_ttnews_itemsProcFunc.php";s:4:"9bbd";s:26:"class.ux_tx_cms_layout.php";s:4:"6b21";s:21:"ext_conf_template.txt";s:4:"761e";s:22:"ext_conf_template.txt~";s:4:"64b4";s:15:"ext_emconf.php~";s:4:"7e67";s:12:"ext_icon.gif";s:4:"5e2a";s:15:"ext_icon__h.gif";s:4:"e1bc";s:16:"ext_icon__ht.gif";s:4:"dbd6";s:17:"ext_icon__htu.gif";s:4:"7975";s:16:"ext_icon__hu.gif";s:4:"865e";s:15:"ext_icon__t.gif";s:4:"ef88";s:16:"ext_icon__tu.gif";s:4:"22a2";s:15:"ext_icon__u.gif";s:4:"0fd4";s:15:"ext_icon__x.gif";s:4:"ede5";s:17:"ext_localconf.php";s:4:"a104";s:18:"ext_localconf.php~";s:4:"826e";s:15:"ext_php_api.dat";s:4:"c809";s:14:"ext_tables.php";s:4:"d9b7";s:15:"ext_tables.php~";s:4:"d6d3";s:14:"ext_tables.sql";s:4:"8b26";s:15:"ext_tables.sql~";s:4:"29a6";s:15:"flexform_ds.xml";s:4:"491c";s:16:"flexform_ds.xml~";s:4:"e0e5";s:23:"flexform_ds_no_sPID.xml";s:4:"6bfc";s:24:"flexform_ds_no_sPID.xml~";s:4:"fa07";s:13:"locallang.php";s:4:"8ef6";s:24:"locallang_csh_ttnews.php";s:4:"47df";s:25:"locallang_csh_ttnewsc.php";s:4:"c3a0";s:17:"locallang_tca.php";s:4:"b886";s:18:"locallang_tca.php~";s:4:"7d6c";s:13:"project.index";s:4:"5dfc";s:7:"tca.php";s:4:"6acf";s:8:"tca.php~";s:4:"a989";s:14:"CVS/.directory";s:4:"b334";s:11:"CVS/Entries";s:4:"4f16";s:14:"CVS/Repository";s:4:"0281";s:8:"CVS/Root";s:4:"5559";s:14:"doc/.directory";s:4:"b334";s:14:"doc/manual.sxw";s:4:"abf5";s:15:"doc/CVS/Baserev";s:4:"7e14";s:15:"doc/CVS/Entries";s:4:"43a2";s:18:"doc/CVS/Repository";s:4:"a191";s:12:"doc/CVS/Root";s:4:"5559";s:13:"pi/.directory";s:4:"bb85";s:13:"pi/ce_wiz.gif";s:4:"da3a";s:22:"pi/class.tx_ttnews.php";s:4:"606c";s:27:"pi/class.tx_ttnews.php.orig";s:4:"5c91";s:27:"pi/class.tx_ttnews.php.test";s:4:"96d0";s:23:"pi/class.tx_ttnews.php~";s:4:"d555";s:30:"pi/class.tx_ttnews_wizicon.php";s:4:"0b9b";s:31:"pi/class.tx_ttnews_wizicon.php~";s:4:"cc72";s:16:"pi/locallang.php";s:4:"50b0";s:10:"pi/new.gif";s:4:"7f00";s:17:"pi/news_conf1.png";s:4:"573b";s:17:"pi/news_help.tmpl";s:4:"1cc1";s:18:"pi/news_help.tmpl~";s:4:"1ab4";s:21:"pi/news_template.tmpl";s:4:"6c28";s:22:"pi/news_template.tmpl~";s:4:"e7ff";s:27:"pi/tt_news_v2_template.html";s:4:"ba27";s:28:"pi/tt_news_v2_template.html~";s:4:"db5a";s:14:"pi/CVS/Baserev";s:4:"d41d";s:14:"pi/CVS/Entries";s:4:"59ed";s:17:"pi/CVS/Repository";s:4:"6242";s:11:"pi/CVS/Root";s:4:"5559";s:14:"res/.directory";s:4:"b334";s:29:"res/example_amenuUserFunc.php";s:4:"150e";s:30:"res/example_amenuUserFunc.php~";s:4:"b264";s:31:"res/example_imageMarkerFunc.php";s:4:"f528";s:32:"res/example_imageMarkerFunc.php~";s:4:"2776";s:35:"res/example_itemMarkerArrayFunc.php";s:4:"abe1";s:36:"res/example_itemMarkerArrayFunc.php~";s:4:"9c47";s:35:"res/example_userPageBrowserFunc.php";s:4:"ec32";s:36:"res/example_userPageBrowserFunc.php~";s:4:"72c0";s:27:"res/news_amenuUserFunc2.php";s:4:"7437";s:28:"res/news_amenuUserFunc2.php~";s:4:"a9d8";s:29:"res/realUrl_example_setup.txt";s:4:"a016";s:30:"res/realUrl_example_setup.txt~";s:4:"4413";s:17:"res/rss_0_91.tmpl";s:4:"c355";s:18:"res/rss_0_91.tmpl~";s:4:"c24d";s:14:"res/rss_2.tmpl";s:4:"e590";s:15:"res/rss_2.tmpl~";s:4:"5f30";s:23:"res/tt_news_article.gif";s:4:"91b6";s:22:"res/tt_news_exturl.gif";s:4:"57f6";s:28:"res/tt_news_languageMenu.php";s:4:"6b3f";s:29:"res/tt_news_languageMenu.php~";s:4:"2146";s:27:"res/tt_news_medialinks.html";s:4:"3707";s:28:"res/tt_news_medialinks.html~";s:4:"9508";s:22:"res/tt_news_styles.css";s:4:"4f61";s:23:"res/tt_news_styles.css~";s:4:"1214";s:25:"res/tt_news_v2_styles.css";s:4:"85eb";s:26:"res/tt_news_v2_styles.css~";s:4:"85eb";s:15:"res/CVS/Entries";s:4:"bf18";s:18:"res/CVS/Repository";s:4:"4a9a";s:12:"res/CVS/Root";s:4:"5559";s:30:"res/main/tt_news_tut_main.html";s:4:"7a23";s:20:"res/main/CVS/Entries";s:4:"baa7";s:23:"res/main/CVS/Repository";s:4:"56e4";s:17:"res/main/CVS/Root";s:4:"5559";s:43:"res/main/images/tt_news_tut_headerimage.jpg";s:4:"ccfd";s:46:"res/main/images/tt_news_tut_menubackground.jpg";s:4:"c63f";s:27:"res/main/images/CVS/Entries";s:4:"a38f";s:30:"res/main/images/CVS/Repository";s:4:"4b37";s:24:"res/main/images/CVS/Root";s:4:"5559";s:44:"res/main/res/tt_news_tut_main_stylesheet.css";s:4:"de80";s:24:"res/main/res/CVS/Entries";s:4:"8dd9";s:27:"res/main/res/CVS/Repository";s:4:"eeed";s:21:"res/main/res/CVS/Root";s:4:"5559";s:17:"static/.directory";s:4:"1323";s:18:"static/CVS/Entries";s:4:"319f";s:21:"static/CVS/Repository";s:4:"9386";s:15:"static/CVS/Root";s:4:"5559";s:21:"static/css/.directory";s:4:"b334";s:20:"static/css/setup.txt";s:4:"44b8";s:21:"static/css/setup.txt~";s:4:"9227";s:22:"static/css/CVS/Entries";s:4:"f9ec";s:25:"static/css/CVS/Repository";s:4:"082b";s:19:"static/css/CVS/Root";s:4:"5559";s:29:"static/rss_feed/constants.txt";s:4:"0359";s:25:"static/rss_feed/setup.txt";s:4:"e79f";s:26:"static/rss_feed/setup.txt~";s:4:"3796";s:27:"static/rss_feed/CVS/Entries";s:4:"be10";s:30:"static/rss_feed/CVS/Repository";s:4:"ae81";s:24:"static/rss_feed/CVS/Root";s:4:"5559";s:27:"static/ts_new/constants.txt";s:4:"e4a3";s:23:"static/ts_new/setup.txt";s:4:"8304";s:24:"static/ts_new/setup.txt~";s:4:"4682";s:25:"static/ts_new/CVS/Entries";s:4:"62f9";s:28:"static/ts_new/CVS/Repository";s:4:"f4fd";s:22:"static/ts_new/CVS/Root";s:4:"5559";s:27:"static/ts_old/constants.txt";s:4:"59a5";s:23:"static/ts_old/setup.txt";s:4:"9f8a";s:24:"static/ts_old/setup.txt~";s:4:"a4cb";s:25:"static/ts_old/CVS/Entries";s:4:"4966";s:28:"static/ts_old/CVS/Repository";s:4:"12f8";s:22:"static/ts_old/CVS/Root";s:4:"5559";}',
);

?>