<?php


namespace aboalarm\BannerManagerSdk\Test;


use aboalarm\BannerManagerSdk\Entity\Conversion;
use aboalarm\BannerManagerSdk\Entity\Session;
use BannerSDK;

class ClientConversionsTest extends TestCase
{
    public function testPostConversion()
    {
        //Init session by requesting banner rotation
        BannerSDK::getPositionBanner(TestConstants::BANNER_POSITION_WITH_VALID_ROTATION);

        $conversion = new Conversion();

        $conversion->setType(Conversion::TYPE_PDF_DOWNLOAD)
            ->setExternalIdentifier(TestConstants::CONVERSION_EXTERNAL_IDENTIFIER);

        /** @var Conversion $storedConversion */
        $storedConversion = BannerSDK::postConversion($conversion);

        $this->assertInstanceOf(Conversion::class, $storedConversion);
        $this->assertInstanceOf(Session::class, $storedConversion->getSession());

        $this->assertEquals(Conversion::TYPE_PDF_DOWNLOAD, $storedConversion->getType());
        $this->assertEquals(TestConstants::CONVERSION_EXTERNAL_IDENTIFIER, $storedConversion->getExternalIdentifier());
    }
}
