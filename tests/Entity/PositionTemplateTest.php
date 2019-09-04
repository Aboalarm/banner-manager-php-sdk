<?php

namespace aboalarm\BannerManagerSdk\Test\Entity;

use aboalarm\BannerManagerSdk\Entity\Banner;
use aboalarm\BannerManagerSdk\Entity\BannerPosition;
use aboalarm\BannerManagerSdk\Entity\Campaign;
use aboalarm\BannerManagerSdk\Entity\PositionTemplate;
use aboalarm\BannerManagerSdk\Test\TestCase;
use DateTime;
use PHPUnit\Framework\Constraint\IsType;

/**
 * Class BannerPositionTest
 * @package aboalarm\BannerManagerSdk\Test\Entity
 */
class PositionTemplateTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testCreate()
    {
        $data = $this->getPositionTemplateMock();

        $positionTemplate = new PositionTemplate($data);

        $this->assertEquals($data['id'], $positionTemplate->getId());
        $this->assertInstanceOf(DateTime::class, $positionTemplate->getCreatedAt());
        $this->assertEquals($positionTemplate->getCreatedAt()->format('Y-m-d H:i:s'), $data['created_at']);
        $this->assertInternalType(IsType::TYPE_INT, $positionTemplate->getWidth());
        $this->assertInternalType(IsType::TYPE_INT, $positionTemplate->getHeight());
        $this->assertFalse($positionTemplate->isStatic());

        $positionTemplate->setDynamicKey(null);
        $this->assertTrue($positionTemplate->isStatic());
    }
}
