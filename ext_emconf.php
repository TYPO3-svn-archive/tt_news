<?php

########################################################################
# Extension Manager/Repository config file for ext: "tt_news"
#
# Auto generated 29-02-2008 15:23
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
	'modify_tables' => 'be_groups,be_users',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author' => 'Rupert Germann',
	'author_email' => 'rupi@gmx.li',
	'author_company' => 'www.rgData.de',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'version' => '2.5.1',
	'_md5_values_when_last_written' => 'a:115:{s:9:"ChangeLog";s:4:"c15a";s:5:"Icon";s:4:"d41d";s:20:"class.ext_update.php";s:4:"ccab";s:27:"class.tx_ttnews_catmenu.php";s:4:"2e8e";s:30:"class.tx_ttnews_cms_layout.php";s:4:"d9f2";s:23:"class.tx_ttnews_div.php";s:4:"bbe3";s:33:"class.tx_ttnews_itemsProcFunc.php";s:4:"b657";s:27:"class.tx_ttnews_tcemain.php";s:4:"08ae";s:28:"class.tx_ttnews_treeview.php";s:4:"cb14";s:21:"ext_conf_template.txt";s:4:"a86d";s:12:"ext_icon.gif";s:4:"5e2a";s:15:"ext_icon__f.gif";s:4:"8b98";s:15:"ext_icon__h.gif";s:4:"e1bc";s:16:"ext_icon__ht.gif";s:4:"dbd6";s:17:"ext_icon__htu.gif";s:4:"7975";s:16:"ext_icon__hu.gif";s:4:"865e";s:15:"ext_icon__t.gif";s:4:"ef88";s:16:"ext_icon__tu.gif";s:4:"22a2";s:15:"ext_icon__u.gif";s:4:"0fd4";s:15:"ext_icon__x.gif";s:4:"ede5";s:26:"ext_icon_ttnews_folder.gif";s:4:"7a48";s:17:"ext_localconf.php";s:4:"7b54";s:15:"ext_php_api.dat";s:4:"2cae";s:14:"ext_tables.php";s:4:"2bc1";s:14:"ext_tables.sql";s:4:"7ba2";s:15:"flexform_ds.xml";s:4:"fcd2";s:13:"locallang.xml";s:4:"035f";s:31:"locallang_csh_beusersgroups.xml";s:4:"df4d";s:24:"locallang_csh_manual.xml";s:4:"582c";s:24:"locallang_csh_ttnews.xml";s:4:"a192";s:27:"locallang_csh_ttnewscat.xml";s:4:"a0c9";s:17:"locallang_tca.xml";s:4:"40fb";s:7:"tca.php";s:4:"bace";s:41:"cshimages/tt_news_cat_recursive_error.png";s:4:"ceca";s:39:"cshimages/tt_news_cat_title_lang_ol.png";s:4:"7271";s:29:"cshimages/tt_news_categoy.png";s:4:"dc4f";s:33:"cshimages/tt_news_categoy_msg.png";s:4:"fc82";s:14:"doc/manual.sxw";s:4:"c0af";s:42:"modfunc1/class.tx_ttnewscatmanager_cm1.php";s:4:"d501";s:47:"modfunc1/class.tx_ttnewscatmanager_modfunc1.php";s:4:"05c3";s:22:"modfunc1/locallang.xml";s:4:"80a8";s:13:"pi/ce_wiz.gif";s:4:"da3a";s:22:"pi/class.tx_ttnews.php";s:4:"454c";s:30:"pi/class.tx_ttnews_wizicon.php";s:4:"1c57";s:16:"pi/locallang.xml";s:4:"0ac9";s:10:"pi/new.gif";s:4:"7f00";s:17:"pi/news_conf1.png";s:4:"7c1e";s:17:"pi/news_help.tmpl";s:4:"2ef3";s:21:"pi/news_template.tmpl";s:4:"7764";s:27:"pi/tt_news_v2_template.html";s:4:"7575";s:15:"res/add_cat.gif";s:4:"f7fb";s:18:"res/add_subcat.gif";s:4:"745e";s:13:"res/arrow.gif";s:4:"0ee8";s:17:"res/atom_0_3.tmpl";s:4:"54c9";s:17:"res/atom_1_0.tmpl";s:4:"b097";s:29:"res/example_amenuUserFunc.php";s:4:"835e";s:31:"res/example_imageMarkerFunc.php";s:4:"ae93";s:35:"res/example_itemMarkerArrayFunc.php";s:4:"0277";s:35:"res/example_userPageBrowserFunc.php";s:4:"10e7";s:27:"res/news_amenuUserFunc2.php";s:4:"c8c0";s:12:"res/rdf.tmpl";s:4:"ba4a";s:29:"res/realUrl_example_setup.txt";s:4:"6728";s:17:"res/rss_0_91.tmpl";s:4:"c2e0";s:14:"res/rss_2.tmpl";s:4:"378e";s:23:"res/tt_news_article.gif";s:4:"91b6";s:26:"res/tt_news_article__h.gif";s:4:"d29b";s:27:"res/tt_news_article__ht.gif";s:4:"d092";s:28:"res/tt_news_article__htu.gif";s:4:"412b";s:27:"res/tt_news_article__hu.gif";s:4:"a2c8";s:26:"res/tt_news_article__t.gif";s:4:"3df2";s:27:"res/tt_news_article__tu.gif";s:4:"9690";s:26:"res/tt_news_article__u.gif";s:4:"4ffc";s:26:"res/tt_news_article__x.gif";s:4:"2e15";s:19:"res/tt_news_cat.gif";s:4:"2efd";s:22:"res/tt_news_cat__d.gif";s:4:"0bdf";s:26:"res/tt_news_cat__f.gif.gif";s:4:"1dc9";s:23:"res/tt_news_cat__fu.gif";s:4:"9dfa";s:22:"res/tt_news_cat__h.gif";s:4:"d98b";s:23:"res/tt_news_cat__hf.gif";s:4:"d98b";s:24:"res/tt_news_cat__hfu.gif";s:4:"d422";s:23:"res/tt_news_cat__ht.gif";s:4:"e4ea";s:24:"res/tt_news_cat__htf.gif";s:4:"e4ea";s:25:"res/tt_news_cat__htfu.gif";s:4:"f324";s:24:"res/tt_news_cat__htu.gif";s:4:"f324";s:27:"res/tt_news_cat__hu.gif.gif";s:4:"d422";s:22:"res/tt_news_cat__t.gif";s:4:"f2c9";s:23:"res/tt_news_cat__tf.gif";s:4:"f2c9";s:24:"res/tt_news_cat__tfu.gif";s:4:"dd60";s:23:"res/tt_news_cat__tu.gif";s:4:"dd60";s:22:"res/tt_news_cat__u.gif";s:4:"1b40";s:22:"res/tt_news_cat__x.gif";s:4:"a08d";s:22:"res/tt_news_exturl.gif";s:4:"57f6";s:25:"res/tt_news_exturl__h.gif";s:4:"7465";s:26:"res/tt_news_exturl__ht.gif";s:4:"9199";s:27:"res/tt_news_exturl__htu.gif";s:4:"7019";s:26:"res/tt_news_exturl__hu.gif";s:4:"467e";s:25:"res/tt_news_exturl__t.gif";s:4:"0fd0";s:26:"res/tt_news_exturl__tu.gif";s:4:"2659";s:25:"res/tt_news_exturl__u.gif";s:4:"260e";s:25:"res/tt_news_exturl__x.gif";s:4:"4ebe";s:28:"res/tt_news_languageMenu.php";s:4:"0e61";s:27:"res/tt_news_medialinks.html";s:4:"82c3";s:22:"res/tt_news_styles.css";s:4:"1214";s:25:"res/tt_news_v2_styles.css";s:4:"7056";s:30:"res/main/tt_news_tut_main.html";s:4:"9c71";s:43:"res/main/images/tt_news_tut_headerimage.jpg";s:4:"ccfd";s:46:"res/main/images/tt_news_tut_menubackground.jpg";s:4:"c63f";s:44:"res/main/res/tt_news_tut_main_stylesheet.css";s:4:"e8fb";s:20:"static/css/setup.txt";s:4:"dcc5";s:29:"static/rss_feed/constants.txt";s:4:"22bd";s:25:"static/rss_feed/setup.txt";s:4:"e328";s:27:"static/ts_new/constants.txt";s:4:"5d5a";s:23:"static/ts_new/setup.txt";s:4:"54a9";s:27:"static/ts_old/constants.txt";s:4:"9954";s:23:"static/ts_old/setup.txt";s:4:"cf84";}',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'php' => '4.2.2-5.2.99',
			'typo3' => '3.8.0-4.1.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'xajax' => '',
		),
	),
	'suggests' => array(
		'xajax' => '',
	),
);

?>