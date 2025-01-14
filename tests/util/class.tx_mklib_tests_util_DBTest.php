<?php
/**
 * @author Michael Wagner
 *
 *  Copyright notice
 *
 *  (c) 2011 Michael Wagner <michael.wagner@dmk-ebusiness.de>
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
 * benötigte Klassen einbinden.
 */

/**
 * DB util tests.
 */
class tx_mklib_tests_util_DBTest extends tx_rnbase_tests_BaseTestCase
{
    /**
     * @var string
     */
    protected $databaseConnectionClassBackup = '';

    /**
     * {@inheritdoc}
     *
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->databaseConnectionClassBackup = $this->getDatabaseConnectionClassReflectionProperty()->getValue(null);
    }

    /**
     * @return $property
     */
    protected function getDatabaseConnectionClassReflectionProperty()
    {
        $property = new ReflectionProperty('tx_mklib_util_DB', 'databaseConnectionClass');
        $property->setAccessible(true);

        return $property;
    }

    /**
     * {@inheritdoc}
     *
     * @see PHPUnit_Framework_TestCase::tearDown()
     */
    protected function tearDown()
    {
        $this->getDatabaseConnectionClassReflectionProperty()->setValue(null, $this->databaseConnectionClassBackup);
    }

    /**
     * @group unit
     */
    public function testDefaultDatabaseConnectionClassProperty()
    {
        self::assertEquals(
            'Tx_Mklib_Database_Connection',
            $this->getDatabaseConnectionClassReflectionProperty()->getValue(null)
        );
    }

    /**
     * @group unit
     */
    public function testClassHasNoMoreMethodsExceptCallStatic()
    {
        self::assertEquals(array('__callstatic'), get_class_methods('tx_mklib_util_DB'));
    }

    /**
     * @group unit
     */
    public function testMethodClassAreRedirectedToDatabaseConnectionClass()
    {
        $this->getDatabaseConnectionClassReflectionProperty()->setValue(null, 'Tx_Mklib_Database_ConnectionMock');

        self::assertEquals(array('first', 'second'), tx_mklib_util_DB::nonStaticTestMethod('first', 'second'));
    }
}

class Tx_Mklib_Database_ConnectionMock extends Tx_Mklib_Database_Connection
{
    /**
     * Zugriff darauf würde scheitern wenn die Methode doch
     * statisch aufgerufen wird.
     *
     * @var array
     */
    protected $returnProperty = array();

    /**
     * @param string $firstParameter
     * @param string $secondParameter
     *
     * @return array
     */
    public function nonStaticTestMethod($firstParameter, $secondParameter)
    {
        $this->returnProperty = array($firstParameter, $secondParameter);

        return $this->returnProperty;
    }
}
