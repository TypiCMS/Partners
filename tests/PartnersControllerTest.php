<?php

use TypiCMS\Modules\Partners\Models\Partner;

class PartnersControllerTest extends TestCase
{
    public function testAdminIndex()
    {
        $response = $this->call('GET', 'admin/partners');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStoreFails()
    {
        $input = ['fr.title' => 'test', 'fr.slug' => ''];
        $this->call('POST', 'admin/partners', $input);
        $this->assertRedirectedToRoute('admin.partners.create');
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $object = new Partner();
        $object->id = 1;
        Partner::shouldReceive('create')->once()->andReturn($object);
        $input = ['fr.title' => 'test', 'fr.slug' => 'test', 'fr.body' => '', 'position' => '1'];
        $this->call('POST', 'admin/partners', $input);
        $this->assertRedirectedToRoute('admin.partners.edit', ['id' => 1]);
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new Partner();
        $object->id = 1;
        Partner::shouldReceive('create')->once()->andReturn($object);
        $input = ['fr.title' => 'test', 'fr.slug' => 'test', 'fr.body' => '', 'position' => '1', 'exit' => true];
        $this->call('POST', 'admin/partners', $input);
        $this->assertRedirectedToRoute('admin.partners.index');
    }
}
