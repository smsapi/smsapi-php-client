<?php
declare(strict_types=1);

namespace Smsapi\Client\Tests\Integration\Feature\Subusers;

use Smsapi\Client\Feature\Subusers\Bag\DeleteSubuserBag;
use Smsapi\Client\Tests\Assert\SubuserAssert;
use Smsapi\Client\Tests\Fixture\Subusers\CreateSubuserBagMother;
use Smsapi\Client\Tests\Fixture\Subusers\SubuserMother;
use Smsapi\Client\Tests\Fixture\Subusers\UpdateSubuserBagMother;
use Smsapi\Client\Tests\SmsapiClientIntegrationTestCase;

class SubusersFeatureTest extends SmsapiClientIntegrationTestCase
{
    /** @var SubuserAssert */
    private $subUserAssert;

    /**
     * @before
     */
    public function given()
    {
        $this->subUserAssert = new SubuserAssert();
    }

    /**
     * @test
     */
    public function it_should_create_subuser(): string
    {
        $subuser = SubuserMother::createAnySubuser();
        $createSubuserBag = CreateSubuserBagMother::createWithSubuserName($subuser->username);

        $result = self::$smsapiService->subusersFeature()->createSubuser($createSubuserBag);

        $this->subUserAssert->assertSubuser($subuser, $result);

        return $result->id;
    }

    /**
     * @test
     * @depends it_should_create_subuser
     */
    public function it_should_find_subusers()
    {
        $result = self::$smsapiService->subusersFeature()->findSubusers();

        $this->subUserAssert->assertContainsSubuser(SubuserMother::createAnySubuser(), $result);
    }

    /**
     * @test
     * @depends it_should_create_subuser
     */
    public function it_should_update_subuser(string $subuserId)
    {
        $updateSubuserBag = UpdateSubuserBagMother::createWithId($subuserId);

        $result = self::$smsapiService->subusersFeature()->updateSubuser($updateSubuserBag);

        $this->subUserAssert->assertSubuserUpdated($updateSubuserBag, $result);
    }

    /**
     * @test
     * @depends it_should_create_subuser
     */
    public function it_should_delete_subuser(string $subuserId)
    {
        $deleteSubuserBag = new DeleteSubuserBag($subuserId);

        self::$smsapiService->subusersFeature()->deleteSubuser($deleteSubuserBag);

        $this->assertTrue(true);
    }
}
