<?php
/**
 * 	@package tx_mklib
 *  @subpackage tx_mklib_tests_validator
 *  @author Hannes Bochmann
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
tx_rnbase::load('tx_mklib_validator_WordList');
tx_rnbase::load('tx_rnbase_tests_BaseTestCase');
/**
 * Testfälle für tx_mklib_validator_WordList
 *
 * @author hbochmann
 * @package tx_mklib
 * @subpackage tx_mklib_tests_validator
 *
 * @group unit
 */
class tx_mklib_tests_validator_WordList_testcase extends tx_rnbase_tests_BaseTestCase {

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		$property = new ReflectionProperty('tx_mklib_validator_WordList', 'wordlistService');
		$property->setAccessible(TRUE);
		$property->setValue(NULL, NULL);
	}

	/**
	 * @group unit
	 */
	public function testGetWordlistServiceIfPropertyNotAlreadySet() {
		$method = new ReflectionMethod('tx_mklib_validator_WordList', 'getWordlistService');
		$method->setAccessible(TRUE);
		$this->assertInstanceOf(
			'tx_mklib_srv_Wordlist',
			$method->invoke(NULL)
		);
	}

	/**
	 * @group unit
	 */
	public function testGetWordlistServiceIfPropertyAlreadySet() {
		$method = new ReflectionMethod('tx_mklib_validator_WordList', 'getWordlistService');
		$method->setAccessible(TRUE);
		$property = new ReflectionProperty('tx_mklib_validator_WordList', 'wordlistService');
		$property->setAccessible(TRUE);
		$property->setValue(NULL, $this);
		$this->assertInstanceOf(
			'tx_mklib_tests_validator_WordList_testcase',
			$method->invoke(NULL)
		);
	}

  	/**
   	 * Prüft das stringContainsNoBlacklistedWords() true zurück gibt wenn kein Wort gegeben wurde
   	 * @group unit
   	 */
  	public function testStringContainsNoBlacklistedWordsRetrunsTrueIfNoWordGiven() {
  		$this->setWordlistService(NULL, '');
  		$this->assertTrue(
  			tx_mklib_validator_WordList::stringContainsNoBlacklistedWords(''),
  			'Kein Wort gegeben und es wurde nicht true zurück gegeben!'
  		);
  	}

  	/**
   	 * Prüft das stringContainsNoBlacklistedWords() true zurück gibt wenn kein Wort gegeben wurde
   	 * @group unit
   	 */
  	public function testStringContainsNoBlacklistedWordsRetrunsTrueWhenWordNotBlacklsited() {
  		$this->setWordlistService('', 'nice', FALSE);
  		$this->assertTrue(
  			tx_mklib_validator_WordList::stringContainsNoBlacklistedWords('nice',false),
  			'Kein Wort gegeben und es wurde nicht true zurück gegeben!'
  		);
  		$this->setWordlistService('', 'alles sehr schön', FALSE);
  		$this->assertTrue(
  			tx_mklib_validator_WordList::stringContainsNoBlacklistedWords('alles sehr schön',false),
  			'Kein Wort gegeben und es wurde nicht true zurück gegeben!'
  		);
  	}

  	/**
   	 * Prüft das stringContainsNoBlacklistedWords() true zurück gibt wenn kein Wort gegeben wurde
   	 * @group unit
   	 */
  	public function testStringContainsNoBlacklistedWordsRetrunsTrueInGreedyModeWhenWordNotBlacklsited() {
  		$this->setWordlistService('', 'nice');
  		$ret = tx_mklib_validator_WordList::stringContainsNoBlacklistedWords('nice');
  		$this->assertTrue($ret,'Es wurde ein Treffer zurück gegeben!');

  		$this->setWordlistService('', 'alles sehr schön');
  		$ret = tx_mklib_validator_WordList::stringContainsNoBlacklistedWords('alles sehr schön');
  		$this->assertTrue($ret,'Es wurde ein Treffer zurück gegeben!');
  	}

  	/**
   	 * Prüft das stringContainsNoBlacklistedWords() true zurück gibt wenn kein Wort gegeben wurde
   	 * @group unit
   	 */
  	public function testStringContainsNoBlacklistedWordsRetrunsMatchesIfWordsAreBlacklisted() {
  		$this->setWordlistService(array('fuck', 'shit'), 'sfuck fuck shit');
  		$ret = tx_mklib_validator_WordList::stringContainsNoBlacklistedWords('sfuck fuck shit');

  		$this->assertEquals(2,count($ret),'Das Treffer Array hat nicht die korrekte Größe!');
  		$this->assertEquals('fuck',$ret[0],'Das geblacklisted Wort wurde nicht zurück gegeben!');
  		$this->assertEquals('shit',$ret[1],'Das geblacklisted Wort wurde nicht zurück gegeben!');

  		//non greedy
  		$this->setWordlistService('fuck', 'who the fuck is alice? shit', FALSE);
  		$ret = tx_mklib_validator_WordList::stringContainsNoBlacklistedWords('who the fuck is alice? shit', FALSE);
  		$this->assertEquals('fuck',$ret,'Das geblacklisted Wort wurde nicht zurück gegeben!');
  	}

  	/**
  	 * @param array $returnValue
  	 * @param string $word
  	 * @param boolean $greedy
  	 * @param boolean $sanitizeWord
  	 *
  	 * @return void
  	 */
  	protected function setWordlistService($returnValue, $word, $greedy = TRUE, $sanitizeWord = TRUE) {
  		$wordlistServiceMock = $this->getMock(
  			'tx_mklib_srv_Wordlist', array('getBlacklistEntryByWord')
  		);
  		if ($returnValue === NULL) {
  			$wordlistServiceMock->expects($this->never())
  				->method('getBlacklistEntryByWord');
  		} else {
  			$wordlistServiceMock->expects($this->once())
	  			->method('getBlacklistEntryByWord')
	  			->with($word,$greedy,$sanitizeWord)
	  			->will($this->returnValue($returnValue));
  		}

  		$property = new ReflectionProperty('tx_mklib_validator_WordList', 'wordlistService');
  		$property->setAccessible(TRUE);
  		$property->setValue(NULL, $wordlistServiceMock);
  	}
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mklib/tests/validator/class.tx_mklib_tests_validator_WordList_testcase.php']) {
  include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mklib/tests/validator/class.tx_mklib_tests_validator_WordList_testcase.php']);
}
