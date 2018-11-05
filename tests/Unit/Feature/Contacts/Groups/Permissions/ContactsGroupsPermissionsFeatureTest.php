<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Feature\Contacts\Groups\Permissions;

use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\CreateGroupPermissionBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\DeleteGroupPermissionBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\FindGroupPermissionBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\FindGroupPermissionsBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\UpdateGroupPermissionBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Data\GroupPermission;
use Smsapi\Client\Infrastructure\ResponseHttpCode;
use Smsapi\Client\Tests\Fixture;
use Smsapi\Client\Tests\SmsapiClientUnitTestCase;
use stdClass;

class ContactsGroupsPermissionsFeatureTest extends SmsapiClientUnitTestCase
{

    /**
     * @test
     */
    public function it_should_add_group_permission()
    {
        $body = Fixture::getJson('contact_group_permission_response');
        $this->mockResponse(ResponseHttpCode::CREATED, $body);
        $expectedPermission = json_decode($body);

        $permissionsFeature = self::$smsapiService->contactsFeature()->groupsFeature()->permissionsFeature();
        $permission = $permissionsFeature->createPermission(new CreateGroupPermissionBag('any', 'any'));

        $this->assertPermission($expectedPermission, $permission);
    }

    /**
     * @test
     */
    public function it_should_delete_user_group_permission()
    {
        $this->mockResponse(ResponseHttpCode::NO_CONTENT, '');

        $permissionsFeature = self::$smsapiService->contactsFeature()->groupsFeature()->permissionsFeature();
        $response = $permissionsFeature->deletePermission(new DeleteGroupPermissionBag('any', 'any'));

        $this->assertEmpty($response);
    }

    /**
     * @test
     */
    public function it_should_update_user_group_permission()
    {
        $body = Fixture::getJson('contact_group_permission_response');
        $this->mockResponse(ResponseHttpCode::OK, $body);
        $expectedPermission = json_decode($body);

        $permissionsFeature = self::$smsapiService->contactsFeature()->groupsFeature()->permissionsFeature();
        $permission = $permissionsFeature->updatePermission(new UpdateGroupPermissionBag('any', 'any'));

        $this->assertPermission($expectedPermission, $permission);
    }

    /**
     * @test
     */
    public function it_should_find_user_group_permission()
    {
        $body = Fixture::getJson('contact_group_permission_response');
        $this->mockResponse(ResponseHttpCode::OK, $body);
        $expectedPermission = json_decode($body);

        $permissionsFeature = self::$smsapiService->contactsFeature()->groupsFeature()->permissionsFeature();
        $permission = $permissionsFeature->findPermission(new FindGroupPermissionBag('any', 'any'));

        $this->assertPermission($expectedPermission, $permission);
    }

    /**
     * @test
     */
    public function it_should_find_user_group_permissions()
    {
        $body = Fixture::getJson('contact_group_permissions_response');
        $this->mockResponse(ResponseHttpCode::OK, $body);
        $expectedPermission = json_decode($body);

        $permissionsFeature = self::$smsapiService->contactsFeature()->groupsFeature()->permissionsFeature();
        $permissions = $permissionsFeature->findPermissions(new FindGroupPermissionsBag('any'));

        $this->assertPermissions($expectedPermission, $permissions);
    }

    private function assertPermissions(stdClass $expected, array $permissions)
    {
        $this->assertPermission($expected->collection[0], $permissions[0]);
    }

    private function assertPermission(stdClass $expected, GroupPermission $permission)
    {
        $expectedPermission = new GroupPermission();
        $expectedPermission->username = $expected->username;
        $expectedPermission->groupId = $expected->group_id;
        $expectedPermission->read = $expected->read;
        $expectedPermission->write = $expected->write;
        $expectedPermission->send = $expected->send;

        $this->assertEquals($expectedPermission, $permission);
    }
}
