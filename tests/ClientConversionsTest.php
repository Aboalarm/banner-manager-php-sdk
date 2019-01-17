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
        $data = BannerSDK::getPositionBanner(TestConstants::BANNER_POSITION_WITH_VALID_ROTATION);

        $session = new Session(['id' => $data['session']]);
        $conversion = new Conversion();

        $conversion->setType(TestConstants::CONVERSION_TYPE)
            ->setExternalIdentifier(TestConstants::CONVERSION_EXTERNAL_IDENTIFIER)
            ->setSession($session);

        /** @var Conversion $storedConversion */
        $storedConversion = BannerSDK::postConversion($conversion);

        $this->assertInstanceOf(Conversion::class, $storedConversion);
        $this->assertInstanceOf(Session::class, $storedConversion->getSession());

        $this->assertEquals(TestConstants::CONVERSION_TYPE, $storedConversion->getType());
        $this->assertEquals(TestConstants::CONVERSION_EXTERNAL_IDENTIFIER, $storedConversion->getExternalIdentifier());
    }
}
