<?php
/**
 * Created by PhpStorm.
 * User: ps
 * Date: 16/10/18
 * Time: 04:14 AM
 * Update: May 17, 2021
 * Updated By Alan Garduño
 */

namespace Punksolid\Wialon\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Orchestra\Testbench\TestCase;
use Punksolid\Wialon\Account;
use Punksolid\Wialon\Resource;
use Punksolid\Wialon\Wialon;


class ResourceTest extends TestCase
{


    /**
     * Define environment setup.
     *
     * @param Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set(
            'services.wialon.token',
            '5dce19710a5e26ab8b7b8986cb3c49e58C291791B7F0A7AEB8AFBFCEED7DC03BC48FF5F8'
        );
    }

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

    }


    public function test_create_and_destroy_resource()
    {
        /**
         * Punksolid\Wialon\Resource {#233
         * +nm: "punksolid_test3"
         * +cls: 3
         * +id: 18158941
         * +mu: 0
         * +uacl: 60606282529791
         * }
         */
        $resource = Resource::make('new_one_new12'); // you cant use a resource already defined
        $this->assertObjectHasAttribute("nm", $resource);


        $this->assertTrue($resource->destroy());
    }

    public function test_find_resource_by_name()
    {
        $resource = Resource::findByName('punksolid@twitter.com');
        $this->assertEquals("punksolid@twitter.com", $resource->nm);
        $this->assertObjectHasAttribute("id", $resource);
    }

    public function test_find_resource_by_id()
    {
        $resource = Resource::find(19227899); // resource 'punksolid@twitter.com'
        $this->assertEquals("punksolid@twitter.com", $resource->nm);
        $this->assertObjectHasAttribute("id", $resource);
    }

    public function test_get_info_account()
    {

        $account = Account::details();
        $this->assertObjectHasAttribute("parentAccountName", $account);
    }

    public function test_list_resources()
    {
        $resources = Resource::all();

        $this->assertInstanceOf(Collection::class, $resources);
    }

    public function test_assert_filter()
    {
        $resources = Resource::all();

        $filtered = $resources->whereIn(
            "nm",
            [

                "punksolid@twitter.com",
            ]
        );

        $account = $filtered->first();

        $this->assertEquals("punksolid@twitter.com", $account->nm);

    }

    public function test_firstOrCreate()
    {
        $random_name = random_int(1111111111, 9999999999);
        $resource = Resource::firstOrCreate(['name' => $random_name]);
        $this->assertInstanceOf(Resource::class,$resource);

        $now_it_will_find = Resource::firstOrCreate(['name' => $random_name]);

        $this->assertEquals($resource->id, $now_it_will_find->id);
    }
}