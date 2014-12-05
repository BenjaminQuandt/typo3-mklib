<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 DMK E-BUSINESS GmbH (dev@dmk-ebusiness.de)
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
 ***************************************************************/

require_once(t3lib_extMgm::extPath('rn_base') . 'class.tx_rnbase.php');
tx_rnbase::load('tx_rnbase_configurations');

/**
 * Soap Client um auf das CRM von tegut zuzugreifen
 *
 * @author Hannes Bochmann
 */
class tx_mklib_util_ExtensionConfiguration{

	/**
	 * @var string
	 */
	protected $extKey = 'mklib';
	
	/**
	 * @return mixed
	 */
	protected function getExtensionCfgValue($key) {
		return tx_rnbase_configurations::getExtensionCfgValue(
			$this->extKey, $key
		);
	}
}