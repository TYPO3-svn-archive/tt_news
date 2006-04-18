<?php

########################################################################
# Extension Manager/Repository config file for ext: "tt_news"
#
# Auto generated 17-04-2006 12:30
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'News',
	'description' => 'Website news with front page teasers and article handling inside.',
	'category' => 'plugin',
	'shy' => 0,
	'dependencies' => 'cms',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
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
	'version' => '2.3.2',
	'_md5_values_when_last_written' => 'a:152:{s:9:"ChangeLog";s:4:"e2b2";s:10:"ChangeLog~";s:4:"005a";s:20:"class.ext_update.php";s:4:"1085";s:27:"class.tx_ttnews_catmenu.php";s:4:"8156";s:33:"class.tx_ttnews_itemsProcFunc.php";s:4:"6360";s:27:"class.tx_ttnews_tcemain.php";s:4:"c3ad";s:28:"class.tx_ttnews_treeview.php";s:4:"04dd";s:21:"ext_conf_template.txt";s:4:"efba";s:15:"ext_emconf.php~";s:4:"6b7a";s:12:"ext_icon.gif";s:4:"5e2a";s:15:"ext_icon__f.gif";s:4:"8b98";s:15:"ext_icon__h.gif";s:4:"e1bc";s:16:"ext_icon__ht.gif";s:4:"dbd6";s:17:"ext_icon__htu.gif";s:4:"7975";s:16:"ext_icon__hu.gif";s:4:"865e";s:15:"ext_icon__t.gif";s:4:"ef88";s:16:"ext_icon__tu.gif";s:4:"22a2";s:15:"ext_icon__u.gif";s:4:"0fd4";s:15:"ext_icon__x.gif";s:4:"ede5";s:26:"ext_icon_ttnews_folder.gif";s:4:"7a48";s:17:"ext_localconf.php";s:4:"3e8c";s:15:"ext_php_api.dat";s:4:"2cae";s:14:"ext_tables.php";s:4:"ba5e";s:14:"ext_tables.sql";s:4:"3656";s:15:"flexform_ds.xml";s:4:"3b07";s:23:"flexform_ds_no_sPID.xml";s:4:"c06c";s:13:"locallang.xml";s:4:"ca46";s:24:"locallang_csh_manual.xml";s:4:"6f9c";s:24:"locallang_csh_ttnews.xml";s:4:"9396";s:27:"locallang_csh_ttnewscat.xml";s:4:"c02a";s:17:"locallang_tca.xml";s:4:"e560";s:7:"tca.php";s:4:"b118";s:16:"tt_news.kdevelop";s:4:"ad4a";s:15:"tt_news.kdevses";s:4:"539c";s:15:"res/add_cat.gif";s:4:"f7fb";s:18:"res/add_subcat.gif";s:4:"745e";s:13:"res/arrow.gif";s:4:"0ee8";s:17:"res/atom_0_3.tmpl";s:4:"e4f7";s:17:"res/atom_1_0.tmpl";s:4:"7788";s:29:"res/example_amenuUserFunc.php";s:4:"5298";s:31:"res/example_imageMarkerFunc.php";s:4:"9741";s:35:"res/example_itemMarkerArrayFunc.php";s:4:"de48";s:35:"res/example_userPageBrowserFunc.php";s:4:"7cc6";s:27:"res/news_amenuUserFunc2.php";s:4:"48e7";s:12:"res/rdf.tmpl";s:4:"4546";s:29:"res/realUrl_example_setup.txt";s:4:"b043";s:17:"res/rss_0_91.tmpl";s:4:"2864";s:14:"res/rss_2.tmpl";s:4:"5766";s:23:"res/tt_news_article.gif";s:4:"91b6";s:26:"res/tt_news_article__h.gif";s:4:"d29b";s:27:"res/tt_news_article__ht.gif";s:4:"d092";s:28:"res/tt_news_article__htu.gif";s:4:"412b";s:27:"res/tt_news_article__hu.gif";s:4:"a2c8";s:26:"res/tt_news_article__t.gif";s:4:"3df2";s:27:"res/tt_news_article__tu.gif";s:4:"9690";s:26:"res/tt_news_article__u.gif";s:4:"4ffc";s:26:"res/tt_news_article__x.gif";s:4:"2e15";s:19:"res/tt_news_cat.gif";s:4:"2efd";s:22:"res/tt_news_cat__d.gif";s:4:"0bdf";s:26:"res/tt_news_cat__f.gif.gif";s:4:"1dc9";s:23:"res/tt_news_cat__fu.gif";s:4:"9dfa";s:22:"res/tt_news_cat__h.gif";s:4:"d98b";s:23:"res/tt_news_cat__hf.gif";s:4:"d98b";s:24:"res/tt_news_cat__hfu.gif";s:4:"d422";s:23:"res/tt_news_cat__ht.gif";s:4:"e4ea";s:24:"res/tt_news_cat__htf.gif";s:4:"e4ea";s:25:"res/tt_news_cat__htfu.gif";s:4:"f324";s:24:"res/tt_news_cat__htu.gif";s:4:"f324";s:27:"res/tt_news_cat__hu.gif.gif";s:4:"d422";s:22:"res/tt_news_cat__t.gif";s:4:"f2c9";s:23:"res/tt_news_cat__tf.gif";s:4:"f2c9";s:24:"res/tt_news_cat__tfu.gif";s:4:"dd60";s:23:"res/tt_news_cat__tu.gif";s:4:"dd60";s:22:"res/tt_news_cat__u.gif";s:4:"1b40";s:22:"res/tt_news_cat__x.gif";s:4:"a08d";s:22:"res/tt_news_exturl.gif";s:4:"57f6";s:25:"res/tt_news_exturl__h.gif";s:4:"7465";s:26:"res/tt_news_exturl__ht.gif";s:4:"9199";s:27:"res/tt_news_exturl__htu.gif";s:4:"7019";s:26:"res/tt_news_exturl__hu.gif";s:4:"467e";s:25:"res/tt_news_exturl__t.gif";s:4:"0fd0";s:26:"res/tt_news_exturl__tu.gif";s:4:"2659";s:25:"res/tt_news_exturl__u.gif";s:4:"260e";s:25:"res/tt_news_exturl__x.gif";s:4:"4ebe";s:28:"res/tt_news_languageMenu.php";s:4:"d78c";s:27:"res/tt_news_medialinks.html";s:4:"3707";s:22:"res/tt_news_styles.css";s:4:"4f61";s:25:"res/tt_news_v2_styles.css";s:4:"4503";s:30:"res/main/tt_news_tut_main.html";s:4:"7a23";s:43:"res/main/images/tt_news_tut_headerimage.jpg";s:4:"ccfd";s:46:"res/main/images/tt_news_tut_menubackground.jpg";s:4:"c63f";s:27:"res/main/images/CVS/Entries";s:4:"a38f";s:30:"res/main/images/CVS/Repository";s:4:"4b37";s:24:"res/main/images/CVS/Root";s:4:"4a1d";s:44:"res/main/res/tt_news_tut_main_stylesheet.css";s:4:"de80";s:24:"res/main/res/CVS/Entries";s:4:"8dd9";s:27:"res/main/res/CVS/Repository";s:4:"eeed";s:21:"res/main/res/CVS/Root";s:4:"4a1d";s:20:"res/main/CVS/Entries";s:4:"c578";s:23:"res/main/CVS/Repository";s:4:"56e4";s:17:"res/main/CVS/Root";s:4:"4a1d";s:15:"res/CVS/Entries";s:4:"87e1";s:18:"res/CVS/Repository";s:4:"4a9a";s:12:"res/CVS/Root";s:4:"4a1d";s:13:"pi/ce_wiz.gif";s:4:"da3a";s:22:"pi/class.tx_ttnews.php";s:4:"9d82";s:30:"pi/class.tx_ttnews_wizicon.php";s:4:"5c93";s:16:"pi/locallang.xml";s:4:"efbd";s:10:"pi/new.gif";s:4:"7f00";s:17:"pi/news_conf1.png";s:4:"7c1e";s:17:"pi/news_help.tmpl";s:4:"6d27";s:21:"pi/news_template.tmpl";s:4:"c955";s:27:"pi/tt_news_v2_template.html";s:4:"b00e";s:14:"pi/CVS/Entries";s:4:"ecf3";s:17:"pi/CVS/Repository";s:4:"6242";s:11:"pi/CVS/Root";s:4:"4a1d";s:20:"static/css/setup.txt";s:4:"bc19";s:22:"static/css/CVS/Entries";s:4:"429e";s:25:"static/css/CVS/Repository";s:4:"082b";s:19:"static/css/CVS/Root";s:4:"4a1d";s:29:"static/rss_feed/constants.txt";s:4:"0a86";s:25:"static/rss_feed/setup.txt";s:4:"7e34";s:27:"static/rss_feed/CVS/Entries";s:4:"74b0";s:30:"static/rss_feed/CVS/Repository";s:4:"ae81";s:24:"static/rss_feed/CVS/Root";s:4:"4a1d";s:27:"static/ts_new/constants.txt";s:4:"2668";s:23:"static/ts_new/setup.txt";s:4:"bbf9";s:25:"static/ts_new/CVS/Entries";s:4:"9cec";s:28:"static/ts_new/CVS/Repository";s:4:"f4fd";s:22:"static/ts_new/CVS/Root";s:4:"4a1d";s:27:"static/ts_old/constants.txt";s:4:"ecf4";s:23:"static/ts_old/setup.txt";s:4:"2c74";s:25:"static/ts_old/CVS/Entries";s:4:"7792";s:28:"static/ts_old/CVS/Repository";s:4:"12f8";s:22:"static/ts_old/CVS/Root";s:4:"4a1d";s:18:"static/CVS/Entries";s:4:"d832";s:21:"static/CVS/Repository";s:4:"9386";s:15:"static/CVS/Root";s:4:"4a1d";s:14:"doc/manual.sxw";s:4:"bd4a";s:15:"doc/CVS/Entries";s:4:"c033";s:18:"doc/CVS/Repository";s:4:"a191";s:12:"doc/CVS/Root";s:4:"4a1d";s:11:"CVS/Entries";s:4:"acb1";s:14:"CVS/Repository";s:4:"0281";s:8:"CVS/Root";s:4:"4a1d";s:41:"cshimages/tt_news_cat_recursive_error.png";s:4:"ceca";s:39:"cshimages/tt_news_cat_title_lang_ol.png";s:4:"7271";s:29:"cshimages/tt_news_categoy.png";s:4:"dc4f";s:33:"cshimages/tt_news_categoy_msg.png";s:4:"fc82";s:21:"cshimages/CVS/Entries";s:4:"3600";s:24:"cshimages/CVS/Repository";s:4:"d6aa";s:18:"cshimages/CVS/Root";s:4:"5559";}',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'php' => '4.2.2-5.1.99',
			'typo3' => '3.6.0-4.0.2',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
);

?>