<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "mklib".
 *
 * Auto generated 09-12-2014 15:57
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'MK Lib',
	'description' => 'Utilities for extensions',
	'category' => 'misc',
	'author' => 'DMK E-BUSINESS GmbH',
	'author_email' => 'dev@dmk-ebusiness.de',
	'author_company' => 'DMK E-BUSINESS GmbH',
	'shy' => '',
	'dependencies' => 'rn_base',
	'version' => '0.9.86',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'constraints' => array(
		'depends' => array(
			'rn_base' => '0.14.22-',
			'typo3' => '4.3.0-6.2.99',
			'scheduler' => '1.0.0-6.2.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'xajax' => '',
		),
	),
	'suggests' => array(
	),
	'_md5_values_when_last_written' => 'a:253:{s:9:"ChangeLog";s:4:"22b8";s:29:"class.abstract_ext_update.php";s:4:"00e2";s:20:"class.ext_update.php";s:4:"5a0f";s:16:"ext_autoload.php";s:4:"58d6";s:21:"ext_conf_template.txt";s:4:"0acf";s:12:"ext_icon.gif";s:4:"1bdc";s:17:"ext_localconf.php";s:4:"732b";s:14:"ext_tables.php";s:4:"b18d";s:14:"ext_tables.sql";s:4:"3c67";s:28:"ext_tables_static_update.sql";s:4:"bff1";s:17:"flexform_main.xml";s:4:"cbfb";s:13:"locallang.xml";s:4:"8510";s:16:"locallang_db.xml";s:4:"d5c2";s:10:"README.txt";s:4:"ee2d";s:26:"Documentation/Includes.txt";s:4:"ef74";s:23:"Documentation/Index.rst";s:4:"a91e";s:26:"Documentation/Settings.yml";s:4:"9c0f";s:33:"Documentation/ChangeLog/Index.rst";s:4:"8b13";s:36:"Documentation/Introduction/Index.rst";s:4:"1b57";s:35:"Documentation/UsersManual/Index.rst";s:4:"4551";s:61:"Documentation/UsersManual/Actions and Views/Abstract List.rst";s:4:"b6d5";s:60:"Documentation/UsersManual/Actions and Views/Generic List.rst";s:4:"fb23";s:53:"Documentation/UsersManual/Actions and Views/Index.rst";s:4:"cd1e";s:57:"Documentation/UsersManual/Actions and Views/List Base.rst";s:4:"a0bb";s:57:"Documentation/UsersManual/Backend Module/AbstractBase.rst";s:4:"e036";s:58:"Documentation/UsersManual/Backend Module/ExportHandler.rst";s:4:"9fc6";s:50:"Documentation/UsersManual/Backend Module/Index.rst";s:4:"833f";s:65:"Documentation/UsersManual/Backend Module/Images/ExportHandler.png";s:4:"806a";s:45:"Documentation/UsersManual/CLI/Clear Cache.rst";s:4:"bd34";s:39:"Documentation/UsersManual/CLI/Index.rst";s:4:"f8d0";s:42:"Documentation/UsersManual/Filter/Index.rst";s:4:"285e";s:47:"Documentation/UsersManual/Filter/SingleItem.rst";s:4:"b911";s:43:"Documentation/UsersManual/Filter/Sorter.rst";s:4:"82f4";s:41:"Documentation/UsersManual/Hooks/Index.rst";s:4:"0931";s:52:"Documentation/UsersManual/Hooks/TCASelectRequire.rst";s:4:"2c8e";s:56:"Documentation/UsersManual/Scheduler/CleanUpTempFiles.rst";s:4:"6996";s:58:"Documentation/UsersManual/Scheduler/DeleteFromDatabase.rst";s:4:"ee49";s:47:"Documentation/UsersManual/Scheduler/Generic.rst";s:4:"dafb";s:45:"Documentation/UsersManual/Scheduler/Index.rst";s:4:"9044";s:68:"Documentation/UsersManual/Scheduler/SchedulerTaskFreezeDetection.rst";s:4:"a0de";s:46:"Documentation/UsersManual/Services/Finance.rst";s:4:"77eb";s:44:"Documentation/UsersManual/Services/Index.rst";s:4:"285e";s:47:"Documentation/UsersManual/Services/Wordlist.rst";s:4:"c4a6";s:43:"Documentation/UsersManual/TreeLib/Index.rst";s:4:"bc37";s:46:"Documentation/UsersManual/TreeLib/TreeView.rst";s:4:"1a82";s:45:"Documentation/UsersManual/Utilities/Array.rst";s:4:"25b7";s:48:"Documentation/UsersManual/Utilities/Database.rst";s:4:"5f2e";s:44:"Documentation/UsersManual/Utilities/Date.rst";s:4:"c336";s:44:"Documentation/UsersManual/Utilities/File.rst";s:4:"6698";s:51:"Documentation/UsersManual/Utilities/HttpRequest.rst";s:4:"c5d9";s:45:"Documentation/UsersManual/Utilities/Index.rst";s:4:"69b1";s:46:"Documentation/UsersManual/Utilities/Models.rst";s:4:"cad1";s:46:"Documentation/UsersManual/Utilities/Number.rst";s:4:"c3f7";s:53:"Documentation/UsersManual/Utilities/SearchSorting.rst";s:4:"b478";s:47:"Documentation/UsersManual/Utilities/Session.rst";s:4:"417e";s:51:"Documentation/UsersManual/Utilities/StaticCache.rst";s:4:"1747";s:47:"Documentation/UsersManual/Utilities/Strings.rst";s:4:"6fe7";s:43:"Documentation/UsersManual/Utilities/Tca.rst";s:4:"a70d";s:50:"Documentation/UsersManual/Utilities/TypoScript.rst";s:4:"aae6";s:49:"Documentation/UsersManual/Utilities/Variables.rst";s:4:"cf74";s:43:"Documentation/UsersManual/Utilities/Xml.rst";s:4:"a52c";s:46:"Documentation/UsersManual/Validators/Index.rst";s:4:"f891";s:48:"Documentation/UsersManual/Validators/ZipCode.rst";s:4:"2611";s:56:"abstract/class.tx_mklib_abstract_ObservableT3Service.php";s:4:"87f7";s:45:"abstract/class.tx_mklib_abstract_Observer.php";s:4:"e1a8";s:54:"abstract/class.tx_mklib_abstract_SoapClientWrapper.php";s:4:"1918";s:45:"action/class.tx_mklib_action_AbstractList.php";s:4:"e0d1";s:44:"action/class.tx_mklib_action_GenericList.php";s:4:"3582";s:41:"action/class.tx_mklib_action_ListBase.php";s:4:"8ed9";s:31:"cli/class.tx_mklib_cli_main.php";s:4:"9674";s:19:"doc/wizard_form.dat";s:4:"cdff";s:20:"doc/wizard_form.html";s:4:"6b39";s:59:"exception/class.tx_mklib_exception_InvalidConfiguration.php";s:4:"7aae";s:47:"exception/class.tx_mklib_exception_NoBeUser.php";s:4:"d46b";s:47:"exception/class.tx_mklib_exception_NoFeUser.php";s:4:"f5e4";s:43:"filter/class.tx_mklib_filter_SingleItem.php";s:4:"1022";s:39:"filter/class.tx_mklib_filter_Sorter.php";s:4:"84e6";s:65:"hooks/class.tx_mklib_hooks_t3lib_tceforms_getSingleFieldClass.php";s:4:"127c";s:23:"hooks/ext_localconf.php";s:4:"16e1";s:31:"icon/icon_tx_mklib_wordlist.gif";s:4:"475a";s:50:"interface/class.tx_mklib_interface_IObservable.php";s:4:"916a";s:48:"interface/class.tx_mklib_interface_IObserver.php";s:4:"202c";s:50:"interface/class.tx_mklib_interface_IZipCountry.php";s:4:"4e02";s:49:"interface/class.tx_mklib_interface_Repository.php";s:4:"67bf";s:42:"marker/class.tx_mklib_marker_DAMRecord.php";s:4:"c462";s:44:"marker/class.tx_mklib_marker_MediaRecord.php";s:4:"afce";s:18:"mod1/locallang.xml";s:4:"1c17";s:53:"mod1/decorator/class.tx_mklib_mod1_decorator_Base.php";s:4:"c703";s:50:"mod1/export/class.tx_mklib_mod1_export_Handler.php";s:4:"7788";s:57:"mod1/export/class.tx_mklib_mod1_export_IInjectHandler.php";s:4:"987d";s:51:"mod1/export/class.tx_mklib_mod1_export_IModFunc.php";s:4:"aed3";s:52:"mod1/export/class.tx_mklib_mod1_export_ISearcher.php";s:4:"3f57";s:54:"mod1/export/class.tx_mklib_mod1_export_ListBuilder.php";s:4:"0e57";s:53:"mod1/export/class.tx_mklib_mod1_export_ListMarker.php";s:4:"dde6";s:47:"mod1/export/class.tx_mklib_mod1_export_Util.php";s:4:"a360";s:47:"mod1/linker/class.tx_mklib_mod1_linker_Base.php";s:4:"91b3";s:54:"mod1/linker/class.tx_mklib_mod1_linker_ShowDetails.php";s:4:"213c";s:59:"mod1/searcher/class.tx_mklib_mod1_searcher_abstractBase.php";s:4:"d5eb";s:51:"mod1/searcher/class.tx_mklib_mod1_searcher_Base.php";s:4:"0a91";s:45:"mod1/util/class.tx_mklib_mod1_util_Helper.php";s:4:"0b25";s:52:"mod1/util/class.tx_mklib_mod1_util_SearchBuilder.php";s:4:"e431";s:47:"mod1/util/class.tx_mklib_mod1_util_Selector.php";s:4:"0b66";s:39:"model/class.tx_mklib_model_Constant.php";s:4:"8ed7";s:39:"model/class.tx_mklib_model_Currency.php";s:4:"68ab";s:34:"model/class.tx_mklib_model_Dam.php";s:4:"3308";s:36:"model/class.tx_mklib_model_Media.php";s:4:"a997";s:35:"model/class.tx_mklib_model_Page.php";s:4:"40e8";s:44:"model/class.tx_mklib_model_StaticCountry.php";s:4:"dc44";s:48:"model/class.tx_mklib_model_StaticCountryZone.php";s:4:"0862";s:40:"model/class.tx_mklib_model_TtAddress.php";s:4:"b93e";s:44:"model/class.tx_mklib_model_WordlistEntry.php";s:4:"96f7";s:49:"repository/class.tx_mklib_repository_Abstract.php";s:4:"e9d2";s:28:"res/error_reporting_test.php";s:4:"457a";s:20:"res/help/ext_csh.php";s:4:"96a6";s:53:"res/help/locallang_csh_scheduler_cleanupTempFiles.xml";s:4:"e2bf";s:35:"res/help/locallang_csh_wordlist.xml";s:4:"e2f7";s:21:"res/hugrid/hugrid.css";s:4:"bd75";s:20:"res/hugrid/hugrid.js";s:4:"b423";s:28:"res/js/emailFieldProvider.js";s:4:"6a0f";s:29:"res/template/genericlist.html";s:4:"8ee5";s:55:"scheduler/class.tx_mklib_scheduler_cleanupTempFiles.php";s:4:"49e9";s:68:"scheduler/class.tx_mklib_scheduler_cleanupTempFilesFieldProvider.php";s:4:"ed57";s:57:"scheduler/class.tx_mklib_scheduler_DeleteFromDatabase.php";s:4:"4bc0";s:70:"scheduler/class.tx_mklib_scheduler_DeleteFromDatabaseFieldProvider.php";s:4:"384c";s:57:"scheduler/class.tx_mklib_scheduler_EmailFieldProvider.php";s:4:"edd1";s:46:"scheduler/class.tx_mklib_scheduler_Generic.php";s:4:"68d9";s:59:"scheduler/class.tx_mklib_scheduler_GenericFieldProvider.php";s:4:"7625";s:67:"scheduler/class.tx_mklib_scheduler_SchedulerTaskFreezeDetection.php";s:4:"b6d4";s:80:"scheduler/class.tx_mklib_scheduler_SchedulerTaskFreezeDetectionFieldProvider.php";s:4:"477f";s:27:"scheduler/ext_localconf.php";s:4:"56a7";s:23:"scheduler/locallang.xml";s:4:"52b1";s:41:"search/class.tx_mklib_search_Constant.php";s:4:"0d03";s:48:"search/class.tx_mklib_search_StaticCountries.php";s:4:"618c";s:51:"search/class.tx_mklib_search_StaticCountryZones.php";s:4:"032e";s:41:"search/class.tx_mklib_search_Wordlist.php";s:4:"f5c9";s:42:"soap/class.tx_mklib_soap_ClientWrapper.php";s:4:"d479";s:31:"srv/class.tx_mklib_srv_Base.php";s:4:"9b80";s:35:"srv/class.tx_mklib_srv_Constant.php";s:4:"8677";s:34:"srv/class.tx_mklib_srv_Finance.php";s:4:"cc71";s:42:"srv/class.tx_mklib_srv_StaticCountries.php";s:4:"7607";s:45:"srv/class.tx_mklib_srv_StaticCountryZones.php";s:4:"8cac";s:35:"srv/class.tx_mklib_srv_Wordlist.php";s:4:"023d";s:21:"srv/ext_localconf.php";s:4:"f399";s:26:"static/basic/constants.txt";s:4:"246b";s:22:"static/basic/setup.txt";s:4:"33bf";s:32:"static/development/constants.txt";s:4:"18f2";s:28:"static/development/setup.txt";s:4:"ca6d";s:18:"tca/ext_tables.php";s:4:"f678";s:25:"tca/tx_mklib_wordlist.php";s:4:"34c1";s:44:"tca/eval/class.tx_mklib_tca_eval_isoDate.php";s:4:"943e";s:58:"tca/eval/class.tx_mklib_tca_eval_priceDecimalSeperator.php";s:4:"a2e9";s:49:"tests/class.tx_mklib_tests_DBTestCaseSkeleton.php";s:4:"c97a";s:45:"tests/class.tx_mklib_tests_MarkerTestcase.php";s:4:"58a6";s:43:"tests/class.tx_mklib_tests_TCA_testcase.php";s:4:"fa78";s:35:"tests/class.tx_mklib_tests_Util.php";s:4:"fee2";s:17:"tests/phpunit.xml";s:4:"f1fa";s:71:"tests/abstract/class.tx_mklib_abstract_ObservableT3Service_testcase.php";s:4:"d5f7";s:62:"tests/action/class.tx_mklib_tests_action_ListBase_testcase.php";s:4:"d424";s:64:"tests/filter/class.tx_mklib_tests_filter_SingleItem_testcase.php";s:4:"b43a";s:60:"tests/filter/class.tx_mklib_tests_filter_Sorter_testcase.php";s:4:"b93f";s:36:"tests/fixtures/project.dmknet.de.crt";s:4:"3fdf";s:70:"tests/fixtures/classes/class.tx_mklib_tests_fixtures_classes_Dummy.php";s:4:"206d";s:76:"tests/fixtures/classes/class.tx_mklib_tests_fixtures_classes_DummyFilter.php";s:4:"2713";s:91:"tests/fixtures/classes/class.tx_mklib_tests_fixtures_classes_DummyFilterWithReturnFalse.php";s:4:"c0a0";s:76:"tests/fixtures/classes/class.tx_mklib_tests_fixtures_classes_DummyLinker.php";s:4:"716b";s:73:"tests/fixtures/classes/class.tx_mklib_tests_fixtures_classes_DummyMod.php";s:4:"8369";s:78:"tests/fixtures/classes/class.tx_mklib_tests_fixtures_classes_DummySearcher.php";s:4:"53d6";s:78:"tests/fixtures/classes/class.tx_mklib_tests_fixtures_classes_FirstObserver.php";s:4:"b83e";s:84:"tests/fixtures/classes/class.tx_mklib_tests_fixtures_classes_ObservableInterface.php";s:4:"428a";s:84:"tests/fixtures/classes/class.tx_mklib_tests_fixtures_classes_ObservableT3Service.php";s:4:"3fa8";s:79:"tests/fixtures/classes/class.tx_mklib_tests_fixtures_classes_SecondObserver.php";s:4:"e52e";s:77:"tests/fixtures/classes/class.tx_mklib_tests_fixtures_classes_SorterFilter.php";s:4:"1284";s:25:"tests/fixtures/db/dam.xml";s:4:"5e3c";s:29:"tests/fixtures/db/dam_ref.xml";s:4:"cad3";s:30:"tests/fixtures/db/wordlist.xml";s:4:"018a";s:37:"tests/fixtures/db/wordlist_hidden.xml";s:4:"5032";s:86:"tests/hooks/class.tx_mklib_tests_hooks_t3lib_tceforms_getSingleFieldClass_testcase.php";s:4:"3193";s:45:"tests/mod1/class.tx_mklib_tests_mod1_Util.php";s:4:"dcfe";s:74:"tests/mod1/decorator/class.tx_mklib_tests_mod1_decorator_Base_testcase.php";s:4:"e31b";s:68:"tests/mod1/linker/class.tx_mklib_tests_mod1_linker_Base_testcase.php";s:4:"e3cc";s:80:"tests/mod1/searcher/class.tx_mklib_tests_mod1_searcher_abstractBase_testcase.php";s:4:"cc60";s:73:"tests/mod1/util/class.tx_mklib_tests_mod1_util_SearchBuilder_testcase.php";s:4:"0bb4";s:68:"tests/mod1/util/class.tx_mklib_tests_mod1_util_Selector_testcase.php";s:4:"3cc6";s:70:"tests/repository/class.tx_mklib_tests_repository_Abstract_testcase.php";s:4:"1c1b";s:78:"tests/scheduler/class.tx_mklib_tests_scheduler_DeleteFromDatabase_testcase.php";s:4:"78b2";s:63:"tests/soap/class.tx_mklib_tests_soap_ClientWrapper_testcase.php";s:4:"3bba";s:55:"tests/srv/class.tx_mklib_tests_srv_Finance_testcase.php";s:4:"d315";s:66:"tests/srv/class.tx_mklib_tests_srv_StaticCountryZones_testcase.php";s:4:"3988";s:56:"tests/srv/class.tx_mklib_tests_srv_Wordlist_testcase.php";s:4:"5228";s:55:"tests/util/class.tx_mklib_tests_util_Array_testcase.php";s:4:"0def";s:53:"tests/util/class.tx_mklib_tests_util_DAM_testcase.php";s:4:"ea6b";s:54:"tests/util/class.tx_mklib_tests_util_Date_testcase.php";s:4:"11f4";s:61:"tests/util/class.tx_mklib_tests_util_DB_database_testcase.php";s:4:"3022";s:52:"tests/util/class.tx_mklib_tests_util_DB_testcase.php";s:4:"a134";s:58:"tests/util/class.tx_mklib_tests_util_Encoding_testcase.php";s:4:"f440";s:72:"tests/util/class.tx_mklib_tests_util_ExtensionConfiguration_testcase.php";s:4:"7e45";s:54:"tests/util/class.tx_mklib_tests_util_File_testcase.php";s:4:"4ffa";s:61:"tests/util/class.tx_mklib_tests_util_HttpRequest_testcase.php";s:4:"5ab4";s:59:"tests/util/class.tx_mklib_tests_util_MiscTools_testcase.php";s:4:"71b1";s:55:"tests/util/class.tx_mklib_tests_util_Model_testcase.php";s:4:"e441";s:56:"tests/util/class.tx_mklib_tests_util_Number_testcase.php";s:4:"2456";s:62:"tests/util/class.tx_mklib_tests_util_RTFGenerator_testcase.php";s:4:"afde";s:59:"tests/util/class.tx_mklib_tests_util_RTFParser_testcase.php";s:4:"f68e";s:63:"tests/util/class.tx_mklib_tests_util_SearchSorting_testcase.php";s:4:"5173";s:57:"tests/util/class.tx_mklib_tests_util_Session_testcase.php";s:4:"7966";s:56:"tests/util/class.tx_mklib_tests_util_String_testcase.php";s:4:"385b";s:53:"tests/util/class.tx_mklib_tests_util_TCA_testcase.php";s:4:"01d7";s:52:"tests/util/class.tx_mklib_tests_util_TS_testcase.php";s:4:"07a8";s:53:"tests/util/class.tx_mklib_tests_util_Var_testcase.php";s:4:"ee01";s:68:"tests/validator/class.tx_mklib_tests_validator_WordList_testcase.php";s:4:"27e6";s:67:"tests/validator/class.tx_mklib_tests_validator_ZipCode_testcase.php";s:4:"b1d4";s:41:"treelib/class.tx_mklib_treelib_Config.php";s:4:"c555";s:43:"treelib/class.tx_mklib_treelib_Renderer.php";s:4:"97b4";s:38:"treelib/class.tx_mklib_treelib_TCE.php";s:4:"84ed";s:43:"treelib/class.tx_mklib_treelib_TreeView.php";s:4:"7d30";s:34:"util/class.tx_mklib_util_Array.php";s:4:"8cdc";s:32:"util/class.tx_mklib_util_Csv.php";s:4:"ab57";s:32:"util/class.tx_mklib_util_DAM.php";s:4:"921c";s:33:"util/class.tx_mklib_util_Date.php";s:4:"36c8";s:31:"util/class.tx_mklib_util_DB.php";s:4:"733d";s:34:"util/class.tx_mklib_util_Debug.php";s:4:"7d0b";s:37:"util/class.tx_mklib_util_Encoding.php";s:4:"8fd6";s:51:"util/class.tx_mklib_util_ExtensionConfiguration.php";s:4:"fc45";s:33:"util/class.tx_mklib_util_File.php";s:4:"a541";s:40:"util/class.tx_mklib_util_HttpRequest.php";s:4:"c049";s:35:"util/class.tx_mklib_util_Logger.php";s:4:"0733";s:38:"util/class.tx_mklib_util_MiscTools.php";s:4:"8787";s:34:"util/class.tx_mklib_util_Model.php";s:4:"0a85";s:35:"util/class.tx_mklib_util_Number.php";s:4:"9ea8";s:41:"util/class.tx_mklib_util_RTFGenerator.php";s:4:"8173";s:38:"util/class.tx_mklib_util_RTFParser.php";s:4:"0da1";s:42:"util/class.tx_mklib_util_SearchSorting.php";s:4:"5393";s:44:"util/class.tx_mklib_util_ServiceRegistry.php";s:4:"be96";s:36:"util/class.tx_mklib_util_Session.php";s:4:"7f1f";s:40:"util/class.tx_mklib_util_StaticCache.php";s:4:"340e";s:35:"util/class.tx_mklib_util_String.php";s:4:"4315";s:32:"util/class.tx_mklib_util_TCA.php";s:4:"44ce";s:31:"util/class.tx_mklib_util_TS.php";s:4:"edec";s:32:"util/class.tx_mklib_util_Var.php";s:4:"deb2";s:36:"util/class.tx_mklib_util_WizIcon.php";s:4:"ffa6";s:43:"util/csv/class.tx_mklib_util_csv_reader.php";s:4:"8fbb";s:43:"util/csv/class.tx_mklib_util_csv_writer.php";s:4:"5863";s:61:"util/httprequest/class.tx_mklib_util_httprequest_Responce.php";s:4:"bbfd";s:73:"util/httprequest/adapter/class.tx_mklib_util_httprequest_adapter_Curl.php";s:4:"ceb9";s:78:"util/httprequest/adapter/class.tx_mklib_util_httprequest_adapter_Interface.php";s:4:"477e";s:46:"util/list/class.tx_mklib_util_list_Builder.php";s:4:"625a";s:45:"util/list/class.tx_mklib_util_list_Marker.php";s:4:"ad0b";s:57:"util/list/output/class.tx_mklib_util_list_output_File.php";s:4:"ff57";s:62:"util/list/output/class.tx_mklib_util_list_output_Interface.php";s:4:"ae5a";s:44:"util/xml/class.tx_mklib_util_xml_Element.php";s:4:"82d1";s:47:"validator/class.tx_mklib_validator_WordList.php";s:4:"dd7f";s:46:"validator/class.tx_mklib_validator_ZipCode.php";s:4:"e5e1";s:40:"view/class.tx_mklib_view_GenericList.php";s:4:"f04b";}',
);

?>
