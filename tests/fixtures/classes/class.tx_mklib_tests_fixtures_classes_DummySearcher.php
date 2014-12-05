<?php
/**
 * 	@package tx_mktegut
 *  @subpackage tx_mktegut_mod1
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
tx_rnbase::load('tx_mklib_util_ServiceRegistry');
tx_rnbase::load('tx_mklib_mod1_searcher_abstractBase');
tx_rnbase::load('tx_mklib_mod1_util_SearchBuilder');

/**
 * Hilfsklassen um nach Gewinnspielen im BE zu suchen
 *
 * @package tx_mktegut
 * @subpackage tx_mktegut_mod1
 */
class tx_mklib_tests_fixtures_classes_DummySearcher extends tx_mklib_mod1_searcher_abstractBase {
	
/**
	 * @return string
	 */
	protected function getSearcherId(){
		return 'dummySearcher';
	}
	
	/**
	 * Liefert den Service.
	 * 
	 * @return tx_mklib_srv_Base
	 */
	protected function getService() {
		return tx_rnbase::makeInstance('tx_mklib_tests_fixtures_classes_Dummy');
	}

	/**
	 * @return 	tx_mklib_mod1_decorator_Base
	 */
	protected function getDecorator(&$mod){
		return tx_rnbase::makeInstance('tx_mklib_mod1_decorator_Base', $mod);		
	}
	
	/**
	 * Liefert die Spalten für den Decorator.
	 * @param 	tx_mklib_mod1_decorator_Base 	$oDecorator
	 * @return 	array
	 */
	protected function getDecoratorColumns(&$oDecorator){
		return array(
				'uid' => array(
					'title' => 'label_tableheader_uid',
					'decorator' => &$oDecorator,
					'sortable' => 'WORDLIST.'
				),
				'actions' => array(
					'title' => 'label_tableheader_actions',
					'decorator' => &$oDecorator,
				)
			);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see tx_mklib_mod1_searcher_abstractBase::getCols()
	 */
	protected function getCols() {
		return array('WORDLIST.uid');
	}
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mktegut/mod1/searcher/class.tx_mktegut_mod1_searcher_Regions.php'])
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mktegut/mod1/searcher/class.tx_mktegut_mod1_searcher_Regions.php']);