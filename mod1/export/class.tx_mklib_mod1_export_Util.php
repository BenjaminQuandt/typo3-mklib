<?php
/**
 * 	@package tx_mklib
 *  @subpackage tx_mklib_mod1
 *
 *  Copyright notice
 *
 *  (c) 2012 das MedienKombinat GmbH <kontakt@das-medienkombinat.de>
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

require_once t3lib_extMgm::extPath('rn_base', 'class.tx_rnbase.php');
tx_rnbase::load('tx_rnbase_util_BaseMarker');

/**
 * Base class for Markers.
 *
 * @author Michael Wagner <michael.wagner@das-medienkombinat.de>
 */
class tx_mklib_mod1_export_Util {

	/**
	 * Sendet die Headerdaten
	 *
	 * @param array $options
	 */
	public static function sendHeaders(array $options = array()) {
		$fileName = empty($options['filename']) ? 'export.dat' : $options['filename'];
		$contentType = empty($options['contenttype']) ? 'application/octet-stream' : $options['contenttype'];

		// Ausgabe-Puffer leeren und deaktivieren.
		// Damit wird direkt der Download-Dialig geöffnet
		// und direkt an den Client gestreamt.
		ob_end_clean();

		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: public', false);
		header('Content-Description: File Transfer');
		header('Content-Type: '.$contentType.'');
		header('Accept-Ranges: bytes');
		header('Content-Disposition: attachment; filename="'.$fileName.'"');
		header('Content-Transfer-Encoding: binary');
		// wissen wir vorher nicht!
// 		$contentLength = strlen($template);
// 		header("Content-length: ".$contentLength);

		if (!empty($options['additional.']) && is_array($options['additional.'])) {
			foreach ($options['additional.'] as $name => $value) {
				header($name.': '.$value, NULL, NULL);
			}
		}
	}

	/**
	 * erzeugt direkt den output
	 * @param string $content
	 */
	public static function doOutPut($content) {
		foreach (func_get_args() as $out) {
// 			if (tx_rnbase_util_BaseMarker::containsMarker($out, '')) {
// 				// @TODO: es sind noch Marker enthalten
// 			}
			echo $out;
		}
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mklib/mod1/export/class.tx_mklib_mod1_export_Util.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mklib/mod1/export/class.tx_mklib_mod1_export_Util.php']);
}