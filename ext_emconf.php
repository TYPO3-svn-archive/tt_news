<?php

########################################################################
# Extension Manager/Repository config file for ext: "tt_news"
#
# Auto generated 20-04-2008 15:57
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
	'module' => 'mod1',
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
	'version' => '3.0.0',
	'_md5_values_when_last_written' => 'a:143:{s:9:"ChangeLog";s:4:"8c4e";s:20:"class.ext_update.php";s:4:"190d";s:21:"ext_conf_template.txt";s:4:"9494";s:12:"ext_icon.gif";s:4:"5e2a";s:15:"ext_icon__f.gif";s:4:"8b98";s:15:"ext_icon__h.gif";s:4:"e1bc";s:16:"ext_icon__ht.gif";s:4:"dbd6";s:17:"ext_icon__htu.gif";s:4:"7975";s:16:"ext_icon__hu.gif";s:4:"865e";s:15:"ext_icon__t.gif";s:4:"ef88";s:16:"ext_icon__tu.gif";s:4:"22a2";s:15:"ext_icon__u.gif";s:4:"0fd4";s:15:"ext_icon__x.gif";s:4:"ede5";s:26:"ext_icon_ttnews_folder.gif";s:4:"7a48";s:17:"ext_localconf.php";s:4:"1b48";s:14:"ext_tables.php";s:4:"27b7";s:14:"ext_tables.sql";s:4:"4a7a";s:15:"flexform_ds.xml";s:4:"aab0";s:23:"flexform_ds_no_sPID.xml";s:4:"27e9";s:13:"locallang.xml";s:4:"035f";s:17:"locallang_tca.xml";s:4:"d920";s:7:"tca.php";s:4:"8163";s:14:"doc/manual.sxw";s:4:"c0af";s:27:"doc/tt_news_3.0_changes.sxw";s:4:"07b2";s:13:"pi/ce_wiz.gif";s:4:"da3a";s:22:"pi/class.tx_ttnews.php";s:4:"6a95";s:30:"pi/class.tx_ttnews_wizicon.php";s:4:"2d96";s:15:"pi/fe_index.php";s:4:"f064";s:16:"pi/locallang.xml";s:4:"cf57";s:30:"pi/static/ts_new/constants.txt";s:4:"2dae";s:26:"pi/static/ts_new/setup.txt";s:4:"a113";s:30:"pi/static/ts_old/constants.txt";s:4:"ed3c";s:26:"pi/static/ts_old/setup.txt";s:4:"aee0";s:23:"pi/static/css/setup.txt";s:4:"278f";s:32:"pi/static/rss_feed/constants.txt";s:4:"2c26";s:28:"pi/static/rss_feed/setup.txt";s:4:"26ad";s:26:"compat/be_axax_for_4.1.php";s:4:"1745";s:38:"compat/tceformsCategoryTree_for_4.1.js";s:4:"45e6";s:30:"compat/tree_styles_for_4.0.css";s:4:"8d1c";s:15:"res/add_cat.gif";s:4:"f7fb";s:18:"res/add_subcat.gif";s:4:"745e";s:13:"res/arrow.gif";s:4:"0ee8";s:17:"res/atom_0_3.tmpl";s:4:"e4f7";s:17:"res/atom_1_0.tmpl";s:4:"7788";s:29:"res/example_amenuUserFunc.php";s:4:"0faf";s:31:"res/example_imageMarkerFunc.php";s:4:"563f";s:35:"res/example_itemMarkerArrayFunc.php";s:4:"f279";s:35:"res/example_userPageBrowserFunc.php";s:4:"6781";s:11:"res/new.gif";s:4:"7f00";s:27:"res/news_amenuUserFunc2.php";s:4:"3095";s:18:"res/news_conf1.png";s:4:"7c1e";s:18:"res/news_help.tmpl";s:4:"6d27";s:22:"res/news_template.tmpl";s:4:"c955";s:16:"res/noedit_1.gif";s:4:"2717";s:16:"res/noedit_2.gif";s:4:"3f51";s:12:"res/rdf.tmpl";s:4:"4546";s:29:"res/realUrl_example_setup.txt";s:4:"b043";s:17:"res/rss_0_91.tmpl";s:4:"2864";s:14:"res/rss_2.tmpl";s:4:"ff8a";s:23:"res/tt_news_article.gif";s:4:"91b6";s:26:"res/tt_news_article__h.gif";s:4:"d29b";s:27:"res/tt_news_article__ht.gif";s:4:"d092";s:28:"res/tt_news_article__htu.gif";s:4:"412b";s:27:"res/tt_news_article__hu.gif";s:4:"a2c8";s:26:"res/tt_news_article__t.gif";s:4:"3df2";s:27:"res/tt_news_article__tu.gif";s:4:"9690";s:26:"res/tt_news_article__u.gif";s:4:"4ffc";s:26:"res/tt_news_article__x.gif";s:4:"2e15";s:19:"res/tt_news_cat.gif";s:4:"2efd";s:22:"res/tt_news_cat__d.gif";s:4:"0bdf";s:26:"res/tt_news_cat__f.gif.gif";s:4:"1dc9";s:23:"res/tt_news_cat__fu.gif";s:4:"9dfa";s:22:"res/tt_news_cat__h.gif";s:4:"d98b";s:23:"res/tt_news_cat__hf.gif";s:4:"d98b";s:24:"res/tt_news_cat__hfu.gif";s:4:"d422";s:23:"res/tt_news_cat__ht.gif";s:4:"e4ea";s:24:"res/tt_news_cat__htf.gif";s:4:"e4ea";s:25:"res/tt_news_cat__htfu.gif";s:4:"f324";s:24:"res/tt_news_cat__htu.gif";s:4:"f324";s:27:"res/tt_news_cat__hu.gif.gif";s:4:"d422";s:22:"res/tt_news_cat__t.gif";s:4:"f2c9";s:23:"res/tt_news_cat__tf.gif";s:4:"f2c9";s:24:"res/tt_news_cat__tfu.gif";s:4:"dd60";s:23:"res/tt_news_cat__tu.gif";s:4:"dd60";s:22:"res/tt_news_cat__u.gif";s:4:"1b40";s:22:"res/tt_news_cat__x.gif";s:4:"a08d";s:22:"res/tt_news_exturl.gif";s:4:"57f6";s:25:"res/tt_news_exturl__h.gif";s:4:"7465";s:26:"res/tt_news_exturl__ht.gif";s:4:"9199";s:27:"res/tt_news_exturl__htu.gif";s:4:"7019";s:26:"res/tt_news_exturl__hu.gif";s:4:"467e";s:25:"res/tt_news_exturl__t.gif";s:4:"0fd0";s:26:"res/tt_news_exturl__tu.gif";s:4:"2659";s:25:"res/tt_news_exturl__u.gif";s:4:"260e";s:25:"res/tt_news_exturl__x.gif";s:4:"4ebe";s:28:"res/tt_news_languageMenu.php";s:4:"675f";s:27:"res/tt_news_medialinks.html";s:4:"3707";s:22:"res/tt_news_styles.css";s:4:"4f61";s:27:"res/tt_news_v2.6_styles.css";s:4:"9374";s:30:"res/tt_news_v2.6_template.html";s:4:"be3f";s:25:"res/tt_news_v2_styles.css";s:4:"e894";s:28:"res/tt_news_v2_template.html";s:4:"a6e3";s:30:"res/main/tt_news_tut_main.html";s:4:"7a23";s:43:"res/main/images/tt_news_tut_headerimage.jpg";s:4:"ccfd";s:46:"res/main/images/tt_news_tut_menubackground.jpg";s:4:"c63f";s:44:"res/main/res/tt_news_tut_main_stylesheet.css";s:4:"de80";s:42:"modfunc1/class.tx_ttnewscatmanager_cm1.php";s:4:"d501";s:47:"modfunc1/class.tx_ttnewscatmanager_modfunc1.php";s:4:"020a";s:22:"modfunc1/locallang.xml";s:4:"80a8";s:37:"cm1/class.tx_ttnewscatmanager_cm1.php";s:4:"28a3";s:17:"cm1/locallang.xml";s:4:"ba7a";s:35:"csh/locallang_csh_beusersgroups.xml";s:4:"f235";s:28:"csh/locallang_csh_manual.xml";s:4:"cbde";s:35:"csh/locallang_csh_mod_newsadmin.xml";s:4:"a590";s:28:"csh/locallang_csh_ttnews.xml";s:4:"d658";s:31:"csh/locallang_csh_ttnewscat.xml";s:4:"a50d";s:35:"csh/tt_news_cat_recursive_error.png";s:4:"ceca";s:33:"csh/tt_news_cat_title_lang_ol.png";s:4:"7271";s:23:"csh/tt_news_categoy.png";s:4:"dc4f";s:27:"csh/tt_news_categoy_msg.png";s:4:"fc82";s:26:"js/tceformsCategoryTree.js";s:4:"83eb";s:21:"js/tt_news_catmenu.js";s:4:"1c9e";s:18:"js/tt_news_mod1.js";s:4:"df3d";s:42:"lib/class.tx_ttnews_TCAform_selectTree.php";s:4:"e606";s:36:"lib/class.tx_ttnews_categorytree.php";s:4:"acd6";s:31:"lib/class.tx_ttnews_catmenu.php";s:4:"bf7c";s:34:"lib/class.tx_ttnews_cms_layout.php";s:4:"f7a4";s:27:"lib/class.tx_ttnews_div.php";s:4:"dbcc";s:37:"lib/class.tx_ttnews_itemsProcFunc.php";s:4:"50f0";s:31:"lib/class.tx_ttnews_realurl.php";s:4:"d6a3";s:34:"lib/class.tx_ttnews_recordlist.php";s:4:"9a53";s:31:"lib/class.tx_ttnews_tcemain.php";s:4:"caf0";s:36:"lib/class.tx_ttnews_templateeval.php";s:4:"2bc4";s:33:"lib/class.tx_ttnews_typo3ajax.php";s:4:"1a2f";s:13:"mod1/ajax.php";s:4:"24b0";s:14:"mod1/clear.gif";s:4:"cc11";s:13:"mod1/conf.php";s:4:"2cf1";s:14:"mod1/index.php";s:4:"7ffc";s:18:"mod1/locallang.xml";s:4:"b72a";s:22:"mod1/locallang_mod.xml";s:4:"452b";s:26:"mod1/mod_ttnews_admin.html";s:4:"1ad7";s:33:"mod1/mod_ttnews_admin_forRC1.html";s:4:"9b98";s:19:"mod1/moduleicon.gif";s:4:"7a48";}',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'php' => '4.2.2-5.2.99',
			'typo3' => '4.1.0-4.2.99',
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