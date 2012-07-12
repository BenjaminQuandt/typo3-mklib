<?php
/*
 *
 *  Copyright notice
 *
 *  (c) 2011 das MedienKombinat GmbH <kontakt@das-medienkombinat.de>
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

require_once(t3lib_extMgm::extPath('rn_base') . 'class.tx_rnbase.php');
tx_rnbase::load('tx_mklib_abstract_SoapClientWrapper');
tx_rnbase::load('tx_mklib_tests_Util');

/**
 * @author Hannes Bochmann
 */
class tx_mklib_tests_abstract_SoapClientWrapper_testcase extends tx_phpunit_testcase{
	
	const SOAP_TEST_METHOD = 'mySoapTestMethod';
	const SOAP_TEST_METHOD_RETURN_VALUE = 'myTestSoapMethodResult';

	public function setUp() {
		tx_mklib_tests_Util::disableDevlog();
	}

	/**
	 * @group unit
	 */
	public function testCallSoapMethodWithValidMethodReturnsExpectedResult() {
		$soapClientWrapper = $this->getSoapClientWrapper();
		$soapMethodReturnValue = $soapClientWrapper->callSoapMethod(self::SOAP_TEST_METHOD);
		
		$this->assertEquals(self::SOAP_TEST_METHOD_RETURN_VALUE,$soapMethodReturnValue);
	}
	
	/**
	 * @group unit
	 */
	public function testCallSoapMethodWithValidMethodAndParamsReturnsExpectedResult() {
		$expectedSoapMethodParams = array('someParam' => 'usedInSoapMethod');
		$soapClientWrapper = $this->getSoapClientWrapper($expectedSoapMethodParams);
		$soapMethodReturnValue = $soapClientWrapper->callSoapMethod(
			self::SOAP_TEST_METHOD, $expectedSoapMethodParams
		);
		
		$this->assertEquals(self::SOAP_TEST_METHOD_RETURN_VALUE,$soapMethodReturnValue);
	}
	
	/**
	 * @group unit
	 * @expectedException RuntimeException
	 * @expectedExceptionCode 987654321
	 * @expectedExceptionMessage There was a Soap Fault
	 */
	public function testCallSoapMethodWithInvalidMethodThrowsCorrectException() {
		$expectedSoapMethodParams = array('someParam' => 'usedInSoapMethod');
		$soapException = new Exception('There was a Soap Fault', 987654321);
		$soapClientWrapper = $this->getSoapClientWrapper(
			$expectedSoapMethodParams,
			$soapException,
			$this->exactly(2)
		);
		$soapMethodReturnValue = $soapClientWrapper->callSoapMethod(
			self::SOAP_TEST_METHOD, $expectedSoapMethodParams
		);
	}
	
	/**
	 * @param string $soapMethodReturnValue
	 * @param array $expectedParams
	 * @return tx_mklib_abstract_SoapClientWrapper
	 */
	private function getSoapClientWrapper(
		array $expectedParams = array(), $exceptionToThrow = null, 
		$getSoapClientInvocationCount = null
	) {
		$soapClient = $this->getSoapClientMock($expectedParams, $exceptionToThrow);
		
		$soapClientWrapper = $this->getMockForAbstractClass('tx_mklib_abstract_SoapClientWrapper');
		
		if(!$getSoapClientInvocationCount)	
			$getSoapClientInvocationCount = $this->once();
			
		$soapClientWrapper->expects($getSoapClientInvocationCount)
			->method('getSoapClient')
			->will($this->returnValue($soapClient));
			
		return $soapClientWrapper;
	}

	/**
	 * @param string $soapMethodReturnValue
	 * @param array $expectedParams
	 * @return SoapClient
	 */
	private function getSoapClientMock(
		array $expectedParams = array(), $exceptionToThrow = null
	) {
		$soapClient = $this->getMock(
			'SoapClient',
			array(self::SOAP_TEST_METHOD),
			array(),
			'',
			false
		);
		
		if(!is_null($exceptionToThrow))
			$methodAction = $this->throwException($exceptionToThrow);
		else
			$methodAction = $this->returnValue(self::SOAP_TEST_METHOD_RETURN_VALUE);
			
		if(!empty($expectedParams)){
			$soapClient->expects($this->once())
				->method(self::SOAP_TEST_METHOD)
				->will($methodAction)
				->with($expectedParams);
		}else{
			$soapClient->expects($this->once())
				->method(self::SOAP_TEST_METHOD)
				->will($methodAction);
		}
			
		return $soapClient;
	}
}