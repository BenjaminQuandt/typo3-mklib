<?php
/**
 * @package tx_mklib
 * @subpackage tx_mklib_util
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 *
 *
 * Copyright notice
 *
 * (c) 2013 das MedienKombinat GmbH <kontakt@das-medienkombinat.de>
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 */

require_once t3lib_extMgm::extPath('rn_base', 'class.tx_rnbase.php');

/**
 * HttpRequest
 *
 * @package tx_mklib
 * @subpackage tx_mklib_util
 * @author Michael Wagner <michael.wagner@das-medienkombinat.de>
 */
interface tx_mklib_util_httprequest_adapter_Interface {


	/**
	 * Set the configuration array for the adapter
	 *
	 * @param array $config
	 */
	public function setConfig(array $config = array());


	/**
	 * Connect to the remote server
	 *
	 * @param string  $host
	 * @param int	 $port
	 * @param boolean $secure
	 */
	public function connect($host, $port = 80, $secure = false);


	/**
	 * Send request to the remote server
	 *
	 * @param string $method
	 * @param string $url
	 * @param array $headers
	 * @param string $body
	 * @return string Request as text
	 */
	public function write($method, $url, $headers = array(), $body = '');


	/**
	 * Read response from server
	 *
	 * @return string
	 */
	public function read();

	/**
	 * Close the connection to the server
	 *
	 */
	public function close();

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mklib/util/class.tx_mklib_util_httprequest_adapter_Interface.php']) {
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mklib/util/class.tx_mklib_util_httprequest_adapter_Interface.php']);
}
