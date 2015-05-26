<?php
/**
 * 	@package TYPO3
 *  @subpackage tx_mklib
 *  @author Hannes Bochmann <hannes.bochmann@dmk-ebusiness.de>
 *
 *  Copyright notice
 *
 *  (c) 2010 Hannes Bochmann <hannes.bochmann@dmk-ebusiness.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 */

/**
 * benötigte Klassen einbinden
 */
require_once(t3lib_extMgm::extPath('rn_base') . 'class.tx_rnbase.php');

/**
 * @package TYPO3
 * @subpackage tx_mklib
 * @author Hannes Bochmann <hannes.bochmann@dmk-ebusiness.de>
 */
class tx_mklib_tests_filter_Sorter_testcase extends tx_phpunit_testcase {

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		tx_rnbase::load('tx_rnbase_util_Misc');
		tx_rnbase_util_Misc::prepareTSFE(array('force' => TRUE));

		//tq_seo extension hat einen hook der auf das folgende feld zugreift.
		//wenn dieses nicht da ist bricht der test mit einer php warnung ab, was
		//wir verhindern wollen!
		$GLOBALS['TSFE']->rootLine[0]['uid'] = 1;
	}

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		unset($GLOBALS['TSFE']->rootLine[0]['uid']);
	}

	/**
	 * @group unit
	 * @dataProvider getExpectedParsedLinks
	 */
	public function testParseTemplateParsesLinksCorrect(
		$template, $expectedParsedTemplate, $sortBy, $sortOrder
	) {
		$parameters = $this->getParameters();
		$configurations = $this->getConfigurations(true);

		if($sortBy) {
			$parameters->offsetSet('sortBy', $sortBy);
		}

		if($sortOrder) {
			$parameters->offsetSet('sortOrder', $sortOrder);
		}

		$confId = 'myConfId.filter.';
		$filter = tx_rnbase::makeInstance(
			'tx_mklib_filter_Sorter',
			$parameters,$configurations,$confId
		);

		$fields = array();
		$options = array();
		$filter->init($fields,$options);

		$formatter = $configurations->getFormatter();
		$parsedTemplate = $filter->parseTemplate($template, $formatter, $confId);

		// leerzeichen ab 6.2.3 nicht mehr vorhanden
		if (tx_rnbase_util_TYPO3::isTYPO62OrHigher()) {
			$expectedParsedTemplate = str_replace('" >', '">', $expectedParsedTemplate);
		}

		$this->assertEquals($expectedParsedTemplate, $parsedTemplate, 'link falsch');
	}

	/**
	 * @return array
	 */
	public function getExpectedParsedLinks() {
		return array(
			// auf grund der default config sollte das orderBy nicht auf asc sondern auf desc stehen
			array(
				'###SORT_FIRSTFIELD_LINK###link###SORT_FIRSTFIELD_LINK###',
				'<a href="?id=1&amp;mklib%5BsortBy%5D=firstField&amp;mklib%5BsortOrder%5D=desc" >link</a>',
				'',
				''
			),
			// da nach dem feld asc sortiert wurde, sollte sich die sortOrder auf desc ändern
			array(
				'###SORT_FIRSTFIELD_LINK###link###SORT_FIRSTFIELD_LINK###',
				'<a href="?id=1&amp;mklib%5BsortBy%5D=firstField&amp;mklib%5BsortOrder%5D=desc" >link</a>',
				'firstField',
				'asc'
			),
			//normaler Link mit asc wenn anderes sortBy gewählt
			array(
				'###SORT_FIRSTFIELD_LINK###link###SORT_FIRSTFIELD_LINK###',
				'<a href="?id=1&amp;mklib%5BsortBy%5D=firstField&amp;mklib%5BsortOrder%5D=asc" >link</a>',
				'unknownField',
				'asc'
			),
			// Links werden ohne default config immer asc sortiert
			array(
				'###SORT_SECONDFIELD_LINK###link###SORT_SECONDFIELD_LINK###',
				'<a href="?id=1&amp;mklib%5BsortBy%5D=secondField&amp;mklib%5BsortOrder%5D=asc" >link</a>',
				'',
				''
			),
			// da nach dem feld asc sortiert wurde, sollte sich die sortOrder auf desc ändern
			array(
				'###SORT_SECONDFIELD_LINK###link###SORT_SECONDFIELD_LINK###',
				'<a href="?id=1&amp;mklib%5BsortBy%5D=secondField&amp;mklib%5BsortOrder%5D=desc" >link</a>',
				'secondField',
				'asc'
			),
			// unbekannte Felder werden nicht geparsed
			array(
				'###SORT_UNKNOWN_LINK###link###SORT_UNKNOWN_LINK###',
				'###SORT_UNKNOWN_LINK###link###SORT_UNKNOWN_LINK###',
				'',
				''
			),
		);
	}

	/**
	 * @return tx_rnbase_parameters
	 */
	private function getParameters() {
		$parameters = tx_rnbase::makeInstance('tx_rnbase_parameters');
		$parameters->setQualifier('mklib');

		return $parameters;
	}

	/**
	 * @param boolean $defaultConfig
	 *
	 * @return tx_rnbase_configurations
	 */
	private function getConfigurations($defaultConfig = false) {
		tx_rnbase_util_Misc::prepareTSFE();

		$configurations = new tx_rnbase_configurations();
		$cObj = t3lib_div::makeInstance('tslib_cObj');
		$config = array(
			'myConfId.' => array(
				'filter.' => array(
					'sort.' => array(
						'fields' => 'firstField,secondField',
						'link.' => array(
							'noHash' => 1
						)
					)
				)
			)
		);

		if($defaultConfig) {
			$config['myConfId.']['filter.']['sort.']['default.'] = array(
				'field' 	=> 'firstField',
				'sortOrder'	=> 'asc'
			);
		}

	    $configurations->init($config, $cObj, 'mklib', 'mklib');

		return $configurations;
	}

	/**
	 * @group unit
	 */
	public function testFilterSetsOrderByEmptyIfNoDefaultConfigurationAndNoSortingViaParameter() {
		$parameters = $this->getParameters();
		$configurations = $this->getConfigurations();

		$confId = 'myConfId.filter.';
		$filter = tx_rnbase::makeInstance(
			'tx_mklib_tests_fixtures_classes_SorterFilter',
			$parameters,$configurations,$confId
		);

		$fields = array();
		$options = array();
		$filterReturn = $filter->init($fields,$options);
		$this->assertEquals('0  ',$filterReturn, 'orderby und sortby nicht korrekt gesetzt.');
	}

	/**
	 * @group unit
	 */
	public function testFilterSetsOrderByCorrectFromParametersIfNoDefaultConfigurationButSortingViaParameter() {
		$parameters = $this->getParameters();
		$configurations = $this->getConfigurations();

		$parameters->offsetSet('sortBy', 'firstField');
		$parameters->offsetSet('sortOrder', 'desc');

		$confId = 'myConfId.filter.';
		$filter = tx_rnbase::makeInstance(
			'tx_mklib_tests_fixtures_classes_SorterFilter',
			$parameters,$configurations,$confId
		);

		$fields = array();
		$options = array();
		$filterReturn = $filter->init($fields,$options);
		$this->assertEquals('1 firstField desc',$filterReturn, 'orderby und sortby nicht korrekt gesetzt.');
	}

	/**
	 * @group unit
	 */
	public function testFilterSetsOrderByCorrectFromDefaultConfigIfDefaultConfigurationAndNoSortingViaParameter() {
		$parameters = $this->getParameters();
		$configurations = $this->getConfigurations(true);

		$confId = 'myConfId.filter.';
		$filter = tx_rnbase::makeInstance(
			'tx_mklib_tests_fixtures_classes_SorterFilter',
			$parameters,$configurations,$confId
		);

		$fields = array();
		$options = array();
		$filterReturn = $filter->init($fields,$options);
		$this->assertEquals('1 firstField asc',$filterReturn, 'orderby und sortby nicht korrekt gesetzt.');
	}

	/**
	 * @group unit
	 */
	public function testFilterSetsOrderByCorrectDromParametersIfDefaultConfigurationAndSortingViaParameter() {
		$parameters = $this->getParameters();
		$configurations = $this->getConfigurations(true);

		$parameters->offsetSet('sortBy', 'firstField');
		$parameters->offsetSet('sortOrder', 'desc');

		$confId = 'myConfId.filter.';
		$filter = tx_rnbase::makeInstance(
			'tx_mklib_tests_fixtures_classes_SorterFilter',
			$parameters,$configurations,$confId
		);

		$fields = array();
		$options = array();
		$filterReturn = $filter->init($fields,$options);
		$this->assertEquals('1 firstField desc',$filterReturn, 'orderby und sortby nicht korrekt gesetzt.');
	}
}