<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Mswebdesign
 * @package    Mswebdesign_Mswebdesign_CustomOrderNumber
 * @copyright  Copyright (c) 2013 münster-webdesign.net (http://www.muenster-webdesign.net)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Christian Grugel <cgrugel@muenster-webdesign.net>
 */
class Mswebdesign_CustomOrderNumber_Test_Model_Eav_Entity_Type extends EcomDev_PHPUnit_Test_Case
{

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @loadFixture dateIncrement
     */
    public function testFetchNewIncrementIdCaseDateIncrement()
    {
        $fixture = $this->getModelMockBuilder('mswebdesign_customordernumber/eav_entity_type')->setMethods(array('_convertDatePrefixToDate'))->getMock();
        $fixture->loadByCode('invoice');
        $fixture->expects($this->exactly(4))->method('_convertDatePrefixToDate')->will($this->returnValue('2013'));
        $this->assertSame('201300009', $fixture->fetchNewIncrementId());
    }

    /**
     * @loadFixture changeDatePrefixWithDatePrefixResetDisabled
     */
    public function testFetchNewIncrementIdCaseChangeDatePrefixWithDatePrefixResetDisabled()
    {
        $fixture = $this->getModelMockBuilder('mswebdesign_customordernumber/eav_entity_type')->setMethods(array('_convertDatePrefixToDate'))->getMock();
        $fixture->loadByCode('invoice');
        $fixture->expects($this->exactly(4))->method('_convertDatePrefixToDate')->will($this->returnValue('2013'));
        $this->assertSame('201300013', $fixture->fetchNewIncrementId());
    }

    /**
     * @loadFixture changeDatePrefixWithDatePrefixResetEnabled
     */
    public function testFetchNewIncrementIdCaseChangeDatePrefixWithDatePrefixResetEnabled()
    {
        $fixture = $this->getModelMockBuilder('mswebdesign_customordernumber/eav_entity_type')->setMethods(array('_convertDatePrefixToDate'))->getMock();
        $fixture->loadByCode('invoice');
        $fixture->expects($this->exactly(4))->method('_convertDatePrefixToDate')->will($this->returnValue('2013'));
        $this->assertSame('201300001', $fixture->fetchNewIncrementId());
    }

    /**
     * @loadFixture regularIncrement
     */
    public function testFetchNewIncrementIdCaseRegularIncrement()
    {
        $fixture = Mage::getModel('mswebdesign_customordernumber/eav_entity_type');
        $fixture->loadByCode('invoice');
        $this->assertSame('300013', $fixture->fetchNewIncrementId());
    }

    /**
     * @loadFixture replaceExistingRegularPrefixWithLongerPrefix
     */
    public function testFetchNewIncrementIdCaseReplaceExistingRegularPrefixWithLongerPrefix()
    {
        $fixture = Mage::getModel('mswebdesign_customordernumber/eav_entity_type');
        $fixture->loadByCode('invoice');
        $this->assertSame('XYZ00013', $fixture->fetchNewIncrementId());
    }

    /**
     * @loadFixture replaceExistingRegularPrefixWithShorterPrefix
     */
    public function testFetchNewIncrementIdCaseReplaceExistingRegularPrefixWithShorterPrefix()
    {
        $fixture = Mage::getModel('mswebdesign_customordernumber/eav_entity_type');
        $fixture->loadByCode('invoice');
        $this->assertSame('A00013', $fixture->fetchNewIncrementId());
    }

    /**
     * @loadFixture noPrefix
     */
    public function testFetchNewIncrementIdCaseNoPrefix()
    {
        $fixture = Mage::getModel('mswebdesign_customordernumber/eav_entity_type');
        $fixture->loadByCode('invoice');
        $this->assertSame('00013', $fixture->fetchNewIncrementId());
    }

    /**
     * @loadFixture shortenPaddingLength
     */
    public function testFetchNewIncrementIdCaseShortenPaddingLength()
    {
        $fixture = Mage::getModel('mswebdesign_customordernumber/eav_entity_type');
        $fixture->loadByCode('invoice');
        $this->assertSame('XYZ013', $fixture->fetchNewIncrementId());
    }

    /**
     * @loadFixture enlargePaddingLength
     */
    public function testFetchNewIncrementIdCaseEnlargePaddingLength()
    {
        $fixture = Mage::getModel('mswebdesign_customordernumber/eav_entity_type');
        $fixture->loadByCode('invoice');
        $this->assertSame('XYZ00000013', $fixture->fetchNewIncrementId());
    }

    /**
     * @loadFixture regularIncrement
     */
    public function testFetchNewIncrementIdCaseUniqueness()
    {
        $fixture = $this->getModelMockBuilder('mswebdesign_customordernumber/eav_entity_type')->setMethods(array('_isIncrementIdUinique'))->getMock();
        $fixture->loadByCode('invoice');
        $fixture->expects($this->exactly(3))->method('_isIncrementIdUinique')->will($this->onConsecutiveCalls(false, false, true));
        $this->assertSame('300015', $fixture->fetchNewIncrementId());
    }

    /**
     * @loadFixture defaultNumber
     */
    public function testAppendDefaultNumberWithRegularIncrement()
    {
        $fixture = Mage::getModel('mswebdesign_customordernumber/eav_entity_type');
        $fixture->loadByCode('invoice');
        $this->assertSame('XXX00960', $fixture->fetchNewIncrementId());
    }

    /**
     * @loadFixture defaultNumberDateIncrement
     */
    public function testAppendDefaultNumberWithDateIncrement()
    {
        $fixture = $this->getModelMockBuilder('mswebdesign_customordernumber/eav_entity_type')->setMethods(array('_convertDatePrefixToDate'))->getMock();
        $fixture->loadByCode('invoice');
        $fixture->expects($this->exactly(5))->method('_convertDatePrefixToDate')->will($this->returnValue('2013'));
        $this->assertSame('201300960', $fixture->fetchNewIncrementId());
    }
}