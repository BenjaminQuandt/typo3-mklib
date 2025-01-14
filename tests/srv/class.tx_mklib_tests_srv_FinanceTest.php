<?php
/**
 * @author Hannes Bochmann
 * @author Michael Wagner
 *
 *  Copyright notice
 *
 *  (c) 2010-2015 DMK-EBUSINESS GmbH <dev@dmk-ebusiness.de>
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
 * Generic form view test.
 *
 * @author Hannes Bochmann
 * @author Michael Wagner
 */
class tx_mklib_tests_srv_FinanceTest extends tx_rnbase_tests_BaseTestCase
{
    /**
     * This method is called before the first test of this test class is run.
     */
    public static function setUpBeforeClass()
    {
        if (tx_rnbase_util_Extensions::isLoaded('static_info_tables')) {
            self::prepareLegacyTypo3DbGlobal();
        }
    }

    public function testGetCurrency()
    {
        self::markTestIncomplete(
          "GeneralUtility::devLog() will be removed with TYPO3 v10.0."
        );

        $oSrv = tx_mklib_util_ServiceRegistry::getFinanceService();
        $oCurrency = $oSrv->getCurrency();

        self::assertTrue(is_object($oCurrency));
        self::assertEquals('tx_mklib_model_Currency', get_class($oCurrency));
    }

    public function testGetFormattedCurrency()
    {
        self::markTestIncomplete(
            "GeneralUtility::devLog() will be removed with TYPO3 v10.0."
        );

        $oSrv = tx_mklib_util_ServiceRegistry::getFinanceService();

        self::assertEquals('54.587,96 €', $oSrv->getFormattedCurrency('54587.957', false));
        self::assertEquals('5,78 &euro;', $oSrv->getFormattedCurrency('5.7825', true));
        self::assertEquals('6,00 €', $oSrv->getFormattedCurrency('6', false));
        self::assertEquals('-3,60 &euro;', $oSrv->getFormattedCurrency('-3.6'));
    }

    /**
     * Prüft ob richtig gerundet wird.
     */
    public function testRoundDouble()
    {
        self::markTestIncomplete(
            "GeneralUtility::devLog() will be removed with TYPO3 v10.0."
        );

        $oSrv = tx_mklib_util_ServiceRegistry::getFinanceService();
        self::assertEquals(2.54, $oSrv->roundUpDouble(2.5316, 2, false), 'Die Zahl wurde nicht korrekt gerundet!');
        self::assertEquals(2.54, $oSrv->roundUpDouble(2.5356, 2, false), 'Die Zahl wurde nicht korrekt gerundet!');
        self::assertEquals(2.536, $oSrv->roundUpDouble(2.5356, 3, false), 'Die Zahl wurde nicht korrekt gerundet!');
        self::assertEquals('2,20', $oSrv->roundUpDouble('2.2000', 2, true, ','), 'Die Zahl wurde nicht korrekt gerundet!');
    }

    /**
     * test the getJoins method.
     *
     * @param string $tableAliases
     * @param string $expectedJoin
     *
     * @group unit
     * @test
     * @dataProvider getValidateVatRegNoData
     */
    public function testValidateVatRegNo($country, $vatregno, $expected)
    {
        self::markTestIncomplete(
            "GeneralUtility::devLog() will be removed with TYPO3 v10.0."
        );

        $srv = tx_mklib_util_ServiceRegistry::getFinanceService();
        self::assertSame(
            $expected,
            $srv->validateVatRegNo($country, $vatregno)
        );
    }

    /**
     * Liefert die Daten für den testValidateVatRegNo testcase.
     *
     * @return array
     */
    public function getValidateVatRegNoData()
    {
        return array(
            // test country by uid
            __LINE__ => array('country' => tx_rnbase_util_Extensions::isLoaded('static_info_tables') ? '54' : 'de', 'vatregno' => 'DE123456789', 'expected' => true),
            // test country model
            __LINE__ => array('country' => $this->getModel(array('cn_iso_2' => 'DE')), 'vatregno' => 'DE123456789', 'expected' => true),
            // all the other static tests
            __LINE__ => array('country' => 'de', 'vatregno' => 'DE123456789', 'expected' => true),
            __LINE__ => array('country' => 'de', 'vatregno' => 'DE12345', 'expected' => false),
            __LINE__ => array('country' => 'de', 'vatregno' => 'DE12ABG', 'expected' => false),
            __LINE__ => array('country' => 'PL', 'vatregno' => 'PL1234567890', 'expected' => true),
            __LINE__ => array('country' => 'PL', 'vatregno' => 'PL12345', 'expected' => false),
            __LINE__ => array('country' => 'PL', 'vatregno' => 'PL12ABG', 'expected' => false),
            __LINE__ => array('country' => 'FR', 'vatregno' => 'FR1A 123456789', 'expected' => true),
            __LINE__ => array('country' => 'FR', 'vatregno' => 'FR1A 123', 'expected' => false),
            __LINE__ => array('country' => 'FR', 'vatregno' => 'FR12A 123456789', 'expected' => false),
            __LINE__ => array('country' => 'LU', 'vatregno' => 'LU12345678', 'expected' => true),
            __LINE__ => array('country' => 'LU', 'vatregno' => 'LU123', 'expected' => false),
            __LINE__ => array('country' => 'LU', 'vatregno' => 'LU123456789', 'expected' => false),
            __LINE__ => array('country' => 'LU', 'vatregno' => 'LU123ABG', 'expected' => false),
            __LINE__ => array('country' => 'BE', 'vatregno' => 'BE1234567890', 'expected' => true),
            __LINE__ => array('country' => 'BE', 'vatregno' => 'BE12345', 'expected' => false),
            __LINE__ => array('country' => 'BE', 'vatregno' => 'BE12ABG', 'expected' => false),
            __LINE__ => array('country' => 'NL', 'vatregno' => 'NL123ABG456z', 'expected' => true),
            __LINE__ => array('country' => 'NL', 'vatregno' => 'NL123ABG', 'expected' => false),
            __LINE__ => array('country' => 'NL', 'vatregno' => 'NL123456ASDFGH', 'expected' => false),
            __LINE__ => array('country' => 'DK', 'vatregno' => 'DK12 34 56 78', 'expected' => true),
            __LINE__ => array('country' => 'DK', 'vatregno' => 'DK12 34 56 78 90', 'expected' => false),
            __LINE__ => array('country' => 'DK', 'vatregno' => 'DK12345678', 'expected' => false),
            __LINE__ => array('country' => 'DK', 'vatregno' => 'DKAB CD EF GH', 'expected' => false),
            __LINE__ => array('country' => 'CZ', 'vatregno' => 'CZ12345678', 'expected' => true),
            __LINE__ => array('country' => 'cz', 'vatregno' => 'CZ123456789', 'expected' => true),
            __LINE__ => array('country' => 'CZ', 'vatregno' => 'CZ1234567890', 'expected' => true),
            __LINE__ => array('country' => 'CZ', 'vatregno' => 'CZ12345', 'expected' => false),
            __LINE__ => array('country' => 'CZ', 'vatregno' => 'CZ123456ASDFGH', 'expected' => false),
            __LINE__ => array('country' => 'AT', 'vatregno' => 'ATU123ABG4z', 'expected' => true),
            __LINE__ => array('country' => 'AT', 'vatregno' => 'ATU123ABG', 'expected' => false),
            __LINE__ => array('country' => 'AT', 'vatregno' => 'ATU123456ASDFGH', 'expected' => false),
        );
    }
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mklib/tests/srv/class.tx_mklib_tests_srv_FinanceTest.php']) {
    include_once $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mklib/tests/srv/class.tx_mklib_tests_srv_FinanceTest.php'];
}
