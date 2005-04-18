<?php

########################################################################
# Extension Manager/Repository config file for ext: "tt_news"
# 
# Auto generated 14-04-2005 23:29
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
	'TYPO3_version' => '3.6.0-3.8.0',
	'PHP_version' => '4.2.2-5.0.3',
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
	'version' => '2.1.5',	// Don't modify this! Managed automatically during upload to repository.
	'_md5_values_when_last_written' => 'a:135:{s:10:".cvsignore";s:4:"4586";s:9:"ChangeLog";s:4:"efc4";s:8:"Doxyfile";s:4:"51ba";s:20:"class.ext_update.php";s:4:"34ee";s:33:"class.tx_ttnews_itemsProcFunc.php";s:4:"6360";s:21:"ext_conf_template.txt";s:4:"761e";s:12:"ext_icon.gif";s:4:"5e2a";s:15:"ext_icon__h.gif";s:4:"e1bc";s:16:"ext_icon__ht.gif";s:4:"dbd6";s:17:"ext_icon__htu.gif";s:4:"7975";s:16:"ext_icon__hu.gif";s:4:"865e";s:15:"ext_icon__t.gif";s:4:"ef88";s:16:"ext_icon__tu.gif";s:4:"22a2";s:15:"ext_icon__u.gif";s:4:"0fd4";s:15:"ext_icon__x.gif";s:4:"ede5";s:26:"ext_icon_ttnews_folder.gif";s:4:"7a48";s:17:"ext_localconf.php";s:4:"0cfd";s:15:"ext_php_api.dat";s:4:"0b50";s:14:"ext_tables.php";s:4:"be07";s:14:"ext_tables.sql";s:4:"7765";s:15:"flexform_ds.xml";s:4:"f11f";s:23:"flexform_ds_no_sPID.xml";s:4:"cd61";s:13:"locallang.php";s:4:"f8c5";s:24:"locallang_csh_ttnews.php";s:4:"af8f";s:25:"locallang_csh_ttnewsc.php";s:4:"c6f1";s:17:"locallang_tca.php";s:4:"9cad";s:7:"tca.php";s:4:"ec22";s:16:"tt_news.kdevelop";s:4:"ae6c";s:15:"tt_news.kdevses";s:4:"7eac";s:17:"res/atom_0_3.tmpl";s:4:"54c9";s:18:"res/atom_0_3.tmpl~";s:4:"475b";s:29:"res/example_amenuUserFunc.php";s:4:"150e";s:31:"res/example_imageMarkerFunc.php";s:4:"c221";s:35:"res/example_itemMarkerArrayFunc.php";s:4:"abe1";s:35:"res/example_userPageBrowserFunc.php";s:4:"036f";s:27:"res/news_amenuUserFunc2.php";s:4:"7437";s:12:"res/rdf.tmpl";s:4:"ba4a";s:13:"res/rdf.tmpl~";s:4:"37ba";s:29:"res/realUrl_example_setup.txt";s:4:"de8c";s:30:"res/realUrl_example_setup.txt~";s:4:"c6d0";s:17:"res/rss_0_91.tmpl";s:4:"2864";s:18:"res/rss_0_91.tmpl~";s:4:"c355";s:14:"res/rss_2.tmpl";s:4:"a9d3";s:15:"res/rss_2.tmpl~";s:4:"dfb1";s:23:"res/tt_news_article.gif";s:4:"91b6";s:19:"res/tt_news_cat.gif";s:4:"2efd";s:22:"res/tt_news_cat__d.gif";s:4:"0bdf";s:26:"res/tt_news_cat__f.gif.gif";s:4:"1dc9";s:23:"res/tt_news_cat__fu.gif";s:4:"9dfa";s:22:"res/tt_news_cat__h.gif";s:4:"d98b";s:23:"res/tt_news_cat__hf.gif";s:4:"d98b";s:24:"res/tt_news_cat__hfu.gif";s:4:"d422";s:23:"res/tt_news_cat__ht.gif";s:4:"e4ea";s:24:"res/tt_news_cat__htf.gif";s:4:"e4ea";s:25:"res/tt_news_cat__htfu.gif";s:4:"f324";s:24:"res/tt_news_cat__htu.gif";s:4:"f324";s:27:"res/tt_news_cat__hu.gif.gif";s:4:"d422";s:22:"res/tt_news_cat__t.gif";s:4:"f2c9";s:23:"res/tt_news_cat__tf.gif";s:4:"f2c9";s:24:"res/tt_news_cat__tfu.gif";s:4:"dd60";s:23:"res/tt_news_cat__tu.gif";s:4:"dd60";s:22:"res/tt_news_cat__u.gif";s:4:"1b40";s:22:"res/tt_news_cat__x.gif";s:4:"a08d";s:22:"res/tt_news_exturl.gif";s:4:"57f6";s:28:"res/tt_news_languageMenu.php";s:4:"6b3f";s:27:"res/tt_news_medialinks.html";s:4:"3707";s:22:"res/tt_news_styles.css";s:4:"4f61";s:25:"res/tt_news_v2_styles.css";s:4:"3e9e";s:26:"res/tt_news_v2_styles.css~";s:4:"c6ef";s:30:"res/main/tt_news_tut_main.html";s:4:"7a23";s:43:"res/main/images/tt_news_tut_headerimage.jpg";s:4:"ccfd";s:46:"res/main/images/tt_news_tut_menubackground.jpg";s:4:"c63f";s:27:"res/main/images/CVS/Entries";s:4:"a38f";s:30:"res/main/images/CVS/Repository";s:4:"4b37";s:24:"res/main/images/CVS/Root";s:4:"4a1d";s:44:"res/main/res/tt_news_tut_main_stylesheet.css";s:4:"de80";s:24:"res/main/res/CVS/Entries";s:4:"8dd9";s:27:"res/main/res/CVS/Repository";s:4:"eeed";s:21:"res/main/res/CVS/Root";s:4:"4a1d";s:20:"res/main/CVS/Entries";s:4:"c578";s:23:"res/main/CVS/Repository";s:4:"56e4";s:17:"res/main/CVS/Root";s:4:"4a1d";s:15:"res/CVS/Entries";s:4:"ce4c";s:18:"res/CVS/Repository";s:4:"4a9a";s:12:"res/CVS/Root";s:4:"4a1d";s:13:"pi/ce_wiz.gif";s:4:"da3a";s:22:"pi/class.tx_ttnews.php";s:4:"cda2";s:23:"pi/class.tx_ttnews.php~";s:4:"2703";s:30:"pi/class.tx_ttnews_wizicon.php";s:4:"0b9b";s:16:"pi/locallang.php";s:4:"4246";s:10:"pi/new.gif";s:4:"7f00";s:17:"pi/news_conf1.png";s:4:"573b";s:17:"pi/news_help.tmpl";s:4:"1cc1";s:21:"pi/news_template.tmpl";s:4:"6c28";s:27:"pi/tt_news_v2_template.html";s:4:"ba78";s:28:"pi/tt_news_v2_template.html~";s:4:"fe1b";s:14:"pi/CVS/Entries";s:4:"234c";s:17:"pi/CVS/Repository";s:4:"6242";s:11:"pi/CVS/Root";s:4:"4a1d";s:20:"static/css/setup.txt";s:4:"09d8";s:21:"static/css/setup.txt~";s:4:"0009";s:22:"static/css/CVS/Entries";s:4:"dcab";s:25:"static/css/CVS/Repository";s:4:"082b";s:19:"static/css/CVS/Root";s:4:"4a1d";s:29:"static/rss_feed/constants.txt";s:4:"c31b";s:30:"static/rss_feed/constants.txt~";s:4:"1200";s:25:"static/rss_feed/setup.txt";s:4:"cade";s:26:"static/rss_feed/setup.txt~";s:4:"884e";s:27:"static/rss_feed/CVS/Entries";s:4:"60fd";s:30:"static/rss_feed/CVS/Repository";s:4:"ae81";s:24:"static/rss_feed/CVS/Root";s:4:"4a1d";s:27:"static/ts_new/constants.txt";s:4:"6944";s:28:"static/ts_new/constants.txt~";s:4:"f993";s:23:"static/ts_new/setup.txt";s:4:"cecb";s:24:"static/ts_new/setup.txt~";s:4:"e7aa";s:25:"static/ts_new/CVS/Entries";s:4:"181d";s:28:"static/ts_new/CVS/Repository";s:4:"f4fd";s:22:"static/ts_new/CVS/Root";s:4:"4a1d";s:27:"static/ts_old/constants.txt";s:4:"fb17";s:28:"static/ts_old/constants.txt~";s:4:"59a5";s:23:"static/ts_old/setup.txt";s:4:"00a7";s:24:"static/ts_old/setup.txt~";s:4:"9bfe";s:25:"static/ts_old/CVS/Entries";s:4:"c599";s:28:"static/ts_old/CVS/Repository";s:4:"12f8";s:22:"static/ts_old/CVS/Root";s:4:"4a1d";s:18:"static/CVS/Entries";s:4:"d832";s:21:"static/CVS/Repository";s:4:"9386";s:15:"static/CVS/Root";s:4:"4a1d";s:14:"doc/manual.sxw";s:4:"4a9a";s:15:"doc/CVS/Entries";s:4:"d003";s:18:"doc/CVS/Repository";s:4:"a191";s:12:"doc/CVS/Root";s:4:"4a1d";s:11:"CVS/Entries";s:4:"c491";s:14:"CVS/Repository";s:4:"0281";s:8:"CVS/Root";s:4:"4a1d";}',
);

?>