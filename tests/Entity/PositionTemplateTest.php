<?php

namespace Aboalarm\BannerManagerSdk\Test\Entity;

use Aboalarm\BannerManagerSdk\Entity\Banner;
use Aboalarm\BannerManagerSdk\Entity\BannerPosition;
use Aboalarm\BannerManagerSdk\Entity\Campaign;
use Aboalarm\BannerManagerSdk\Entity\PositionTemplate;
use Aboalarm\BannerManagerSdk\Test\TestCase;
use DateTime;
use PHPUnit\Framework\Constraint\IsType;

/**
 * Class BannerPositionTest
 * @package Aboalarm\BannerManagerSdk\Test\Entity
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
        $this->assertEquals($data['static'], $positionTemplate->isStatic());
    }
}
