<?php


namespace Aboalarm\BannerManagerSdk\Test;


use Aboalarm\BannerManagerSdk\Entity\Conversion;
use Aboalarm\BannerManagerSdk\Entity\Session;
use BannerSDK;

/**
 * Class ClientConversionsTest
 * @package Aboalarm\BannerManagerSdk\Test
 */
class ClientConversionsTest extends TestCase
{
    public function testPostConversion()
    {
        //Init session by requesting banner rotation
        BannerSDK::getMultiplePositionsBanner([TestConstants::BANNER_POSITION_WITH_VALID_ROTATION]);

        $conversion = new Conversion();

        $conversion
            ->setType(Conversion::TYPE_PDF_DOWNLOAD)
            ->setExternalIdentifier(TestConstants::CONVERSION_EXTERNAL_IDENTIFIER);

        /** @var Conversion $storedConversion */
        $storedConversion = BannerSDK::postConversion($conversion);

        $this->assertInstanceOf(Conversion::class, $storedConversion);
        $this->assertInstanceOf(Session::class, $storedConversion->getSession());

        $this->assertEquals(Conversion::TYPE_PDF_DOWNLOAD, $storedConversion->getType());
        $this->assertEquals(TestConstants::CONVERSION_EXTERNAL_IDENTIFIER, $storedConversion->getExternalIdentifier());

        return $storedConversion->getSession()->getId();
    }

    /**
     * @depends testPostConversion
     */
    public function testPostConversionWithSessionAlreadySet($sessionId)
    {
        //Init session by requesting banner rotation
        BannerSDK::getMultiplePositionsBanner([TestConstants::BANNER_POSITION_WITH_VALID_ROTATION]);

        $conversion = new Conversion();

        $conversion
            ->setType(Conversion::TYPE_PDF_DOWNLOAD)
            ->setExternalIdentifier(TestConstants::CONVERSION_EXTERNAL_IDENTIFIER)
            ->setSession(new Session(['id' => $sessionId]))
        ;

        /** @var Conversion $storedConversion */
        $storedConversion = BannerSDK::postConversion($conversion);

        $this->assertInstanceOf(Conversion::class, $storedConversion);
        $this->assertInstanceOf(Session::class, $storedConversion->getSession());

        $this->assertEquals(Conversion::TYPE_PDF_DOWNLOAD, $storedConversion->getType());
        $this->assertEquals(TestConstants::CONVERSION_EXTERNAL_IDENTIFIER, $storedConversion->getExternalIdentifier());
        $this->assertEquals($sessionId, $storedConversion->getSession()->getId());
    }

    public function testPostConversionWithoutSession()
    {
        $conversion = new Conversion();

        $conversion
            ->setType(Conversion::TYPE_PDF_DOWNLOAD)
            ->setExternalIdentifier(TestConstants::CONVERSION_EXTERNAL_IDENTIFIER);

        /** @var Conversion $storedConversion */
        $storedConversion = BannerSDK::postConversion($conversion);

        $this->assertInstanceOf(Conversion::class, $storedConversion);
        $this->assertNull($storedConversion->getId());
        $this->assertNull($storedConversion->getSession());
    }

}
