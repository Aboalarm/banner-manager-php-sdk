<?php
/**
 * Created by Evis Bregu <evis.bregu@gmail.com>.
 * Date: 11/12/18
 * Time: 9:47 AM
 */

namespace aboalarm\BannerManagerSdk\Test;
use aboalarm\BannerManagerSdk\Entity\Campaign;
use aboalarm\BannerManagerSdk\Pagination\PaginatedCollection;

use BannerSDK;

class ClientCampaignsTest extends TestCase
{
    public function testGetCampaigns()
    {
        /** @var PaginatedCollection $campaignsCollection */
        $campaignsCollection = BannerSDK::getCampaigns();

        $this->assertInstanceOf(PaginatedCollection::class, $campaignsCollection);

        foreach ($campaignsCollection->getItems() as $campaign) {
            $this->assertInstanceOf(Campaign::class, $campaign);
        }
    }

    public function testCampaignCRUD()
    {
        $campaign = new Campaign();

        $campaign->setWeight(1)
            ->setDescription('test')
            ->setName('test');

        /** @var Campaign $storedCampaign */
        $storedCampaign = BannerSDK::postCampaign($campaign);
        $this->assertInstanceOf(Campaign::class, $storedCampaign);

        $storedCampaign->setName('EDITED BY PUT');

        /** @var Campaign $updatedCampaign */
        $updatedCampaign = BannerSDK::putCampaign($storedCampaign);
        $this->assertEquals('EDITED BY PUT', $updatedCampaign->getName());

        $this->assertTrue(BannerSDK::deleteCampaign($updatedCampaign->getId()));
    }
}
