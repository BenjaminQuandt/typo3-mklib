<?php
/**
 * @author Hannes Bochmann
 *
 *  Copyright notice
 *
 *  (c) 2014 Hannes Bochmann <hannes.bochmann@dmk-ebusiness.de>
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
 * tx_mklib_tests_scheduler_SchedulerTaskFailDetectionTest.
 *
 * @author          Hannes Bochmann <dev@dmk-ebusiness.de>
 * @license         http://www.gnu.org/licenses/lgpl.html
 *                  GNU Lesser General Public License, version 3 or later
 */
class tx_mklib_tests_scheduler_SchedulerTaskFailDetectionTest extends tx_rnbase_tests_BaseTestCase
{
    protected $languageBackup;

    /**
     * @var array
     */
    private $options = array(
        'failDetectionRememberAfter' => 3600,
        'failDetectionReceiver' => 'dev@dmk-ebusiness.de',
    );

    /**
     * (non-PHPdoc).
     *
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        \DMK\Mklib\Utility\Tests::disableDevlog();
        $this->languageBackup = $GLOBALS['LANG']->lang;

        self::markTestIncomplete("Creating default object from empty value");
        $GLOBALS['LANG']->lang = 'default';
    }

    /**
     * (non-PHPdoc).
     *
     * @see PHPUnit_Framework_TestCase::tearDown()
     */
    protected function tearDown()
    {
        $GLOBALS['LANG']->lang = $this->languageBackup;
    }

    /**
     * @group unit
     */
    public function testGetDatabaseConnection()
    {
        self::assertInstanceOf(
            'Tx_Mklib_Database_Connection',
            $this->callInaccessibleMethod(
                tx_rnbase::makeInstance('tx_mklib_scheduler_SchedulerTaskFailDetection'),
                'getDatabaseConnection'
            ),
            'falsche Klasse'
        );
    }

    /**
     * @group unit
     */
    public function testGetOptions()
    {
        self::markTestIncomplete(
            "Uncaught require(typo3-mklib/.Build/Web/typo3conf/LocalConfiguration.php)"
        );

        $scheduler = tx_rnbase::makeInstance('tx_mklib_scheduler_SchedulerTaskFailDetection');
        $scheduler->setOptions($this->options);
        $options = $scheduler->getOptions();

        self::assertEquals(
            array(
                'failDetectionRememberAfter' => '1 Stunde ',
                'failDetectionReceiver' => 'dev@dmk-ebusiness.de',
            ),
            $options
        );
    }

    /**
     * @group unit
     */
    public function testGetFailedTasks()
    {
        $databaseUtility = $this->getDatabaseConnection();

        $selectFields = 'uid,serialized_task_object';
        $databaseUtility->expects(self::once())
            ->method('doSelect')
            ->with(
                $selectFields,
                'tx_scheduler_task',
                array(
                    'enablefieldsoff' => true,
                    'where' => 'uid != 123 AND '.
                                'faildetected = 0 AND '.
                                'lastexecution_failure != "" AND '.
                                'disable = 0',
                )
            )
            ->will(self::returnValue(array('failedTasks')));
        $scheduler = $this->getSchedulerByDbUtil($databaseUtility);
        $scheduler->setTaskUid(123);

        self::assertEquals(
            array('failedTasks'),
            $this->callInaccessibleMethod(
                $scheduler,
                'getFailedTasks'
            )
        );
    }

    /**
     * @group unit
     */
    public function testSetFailDetected()
    {
        $databaseUtility = $this->getDatabaseConnection();

        $databaseUtility->expects(self::once())
            ->method('doUpdate')
            ->with(
                'tx_scheduler_task',
                'uid IN (1,2,3)',
                array('faildetected' => $GLOBALS['EXEC_TIME'])
            );
        $scheduler = $this->getSchedulerByDbUtil($databaseUtility);

        $this->callInaccessibleMethod(
            $scheduler,
            'setFailDetected',
            array(1, 2, 3)
        );
    }

    /**
     * @group unit
     */
    public function testGetMiscUtility()
    {
        self::markTestIncomplete(
            "Uncaught require(typo3-mklib/.Build/Web/typo3conf/LocalConfiguration.php)"
        );

        self::assertEquals(
            'tx_rnbase_util_Misc',
            $this->callInaccessibleMethod(
                tx_rnbase::makeInstance('tx_mklib_scheduler_SchedulerTaskFailDetection'),
                'getMiscUtility'
            ),
            'falsche Klasse'
        );
    }

    /**
     * @group unit
     */
    public function testHandleFailedTasks()
    {
        self::markTestIncomplete(
            "Uncaught require(typo3-mklib/.Build/Web/typo3conf/LocalConfiguration.php)"
        );

        $scheduler = tx_rnbase::makeInstance('tx_mklib_scheduler_SchedulerTaskFailDetection');
        $failedTasks = array(
            0 => array(
                'serialized_task_object' => serialize($scheduler),
                'classname' => 'tx_mklib_scheduler_SchedulerTaskFailDetection',
                'uid' => 123,
            ),
            1 => array(
                'serialized_task_object' => serialize($scheduler),
                'classname' => 'tx_mklib_scheduler_SchedulerTaskFailDetection',
                'uid' => 456,
            ),
        );
        $expectedMessage = 'Die folgenden Scheduler Tasks sind fehlgeschlagen : '.
                            '"tx_mklib_scheduler_SchedulerTaskFailDetection (Task-Uid: 123)"'.
                            ', "tx_mklib_scheduler_SchedulerTaskFailDetection (Task-Uid: 456)"';
        $expectedException = new Exception($expectedMessage, 0);

        $scheduler = $this->getSchedulerByDbUtil(
            null,
            array('getMiscUtility', 'setFailDetected')
        );
        $miscUtility = $this->getMock(
            'stdClass',
            array('sendErrorMail')
        );
        $miscUtility->expects(self::once())
            ->method('sendErrorMail')
            ->with(
                'dev@dmk-ebusiness.de',
                'tx_mklib_scheduler_SchedulerTaskFailDetection',
                $expectedException,
                array('ignoremaillock' => true)
            );
        $scheduler->expects(self::once())
            ->method('getMiscUtility')
            ->will(self::returnValue($miscUtility));

        $scheduler->expects(self::once())
            ->method('setFailDetected')
            ->with(array(123, 456));

        self::assertEquals(
            $expectedMessage,
            $this->callInaccessibleMethod(
                $scheduler,
                'handleFailedTasks',
                $failedTasks
            )
        );
    }

    /**
     * @group unit
     */
    public function testResetFailedTasksDetection()
    {
        $databaseUtility = $this->getDatabaseConnection();

        $databaseUtility->expects(self::once())
            ->method('doUpdate')
            ->with(
                'tx_scheduler_task',
                'faildetected < '.($GLOBALS['EXEC_TIME'] - 3600),
                array('faildetected' => 0)
            );
        $scheduler = $this->getSchedulerByDbUtil($databaseUtility);

        $this->callInaccessibleMethod(
            $scheduler,
            'resetFailedTasksDetection'
        );
    }

    /**
     * @group unit
     */
    public function testExecuteTasksIfNoFailedTasks()
    {
        $scheduler = $this->getSchedulerByDbUtil(
            null,
            array('resetFailedTasksDetection', 'getFailedTasks', 'handleFailedTasks')
        );

        $scheduler->expects(self::once())
            ->method('resetFailedTasksDetection');

        $scheduler->expects(self::once())
            ->method('getFailedTasks');

        $scheduler->expects(self::never())
            ->method('handleFailedTasks');

        $devLog = array();
        $method = new ReflectionMethod(
            'tx_mklib_scheduler_SchedulerTaskFailDetection',
            'executeTask'
        );
        $method->setAccessible(true);
        self::assertEquals(
            'keine fehlgeschlagenen Scheduler entdeckt!',
            $method->invokeArgs($scheduler, array(array(), &$devLog))
        );
        self::assertEmpty($devLog);
    }

    /**
     * @group unit
     */
    public function testExecuteTasksIfFailedTasks()
    {
        $scheduler = $this->getSchedulerByDbUtil(
            null,
            array('resetFailedTasksDetection', 'getFailedTasks', 'handleFailedTasks')
        );

        $scheduler->expects(self::once())
            ->method('resetFailedTasksDetection');

        $scheduler->expects(self::once())
            ->method('getFailedTasks')
            ->will(self::returnValue('failedTasks'));

        $scheduler->expects(self::once())
            ->method('handleFailedTasks')
            ->with('failedTasks')
            ->will(self::returnValue('tasks failed'));

        $devLog = array();
        $method = new ReflectionMethod(
            'tx_mklib_scheduler_SchedulerTaskFailDetection',
            'executeTask'
        );
        $method->setAccessible(true);
        self::assertEquals(
            'tasks failed',
            $method->invokeArgs($scheduler, array(array(), &$devLog))
        );
        self::assertEmpty($devLog);
    }

    /**
     * @param string $databaseUtility
     * @param array  $methods
     *
     * @return tx_mklib_scheduler_SchedulerTaskFailDetection
     */
    private function getSchedulerByDbUtil(
        $databaseUtility,
        $methods = array('getDatabaseConnection')
    ) {
        self::markTestIncomplete(
            "Uncaught require(typo3-mklib/.Build/Web/typo3conf/LocalConfiguration.php)"
        );

        $scheduler = $this->getMock(
            'tx_mklib_scheduler_SchedulerTaskFailDetection',
            $methods
        );

        if ($databaseUtility) {
            $scheduler->expects(self::any())
                ->method('getDatabaseConnection')
                ->will(self::returnValue($databaseUtility));
        }

        $scheduler->setOptions($this->options);

        return $scheduler;
    }

    /**
     * @return Tx_Mklib_Database_Connection
     */
    private function getDatabaseConnection()
    {
        return $this->getMock(
            'Tx_Mklib_Database_Connection',
            array('doSelect', 'doUpdate')
        );
    }
}
