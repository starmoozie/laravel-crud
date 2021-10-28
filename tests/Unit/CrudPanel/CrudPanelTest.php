<?php

namespace Starmoozie\CRUD\Tests\Unit\CrudPanel;

use Starmoozie\CRUD\Tests\Unit\Models\TestModel;
use Illuminate\Database\Eloquent\Builder;

/**
 * @covers Starmoozie\CRUD\app\Library\CrudPanel\CrudPanel
 */
class CrudPanelTest extends BaseCrudPanelTest
{
    public function testSetModelFromModelClass()
    {
        $this->crudPanel->setModel(TestModel::class);

        $this->assertEquals($this->model, $this->crudPanel->model);
        $this->assertInstanceOf(TestModel::class, $this->crudPanel->model);
        $this->assertInstanceOf(Builder::class, $this->crudPanel->query);
    }

    public function testSetModelFromModelClassName()
    {
        $modelClassName = '\Starmoozie\CRUD\Tests\Unit\Models\TestModel';

        $this->crudPanel->setModel($modelClassName);

        $this->assertEquals($this->model, $this->crudPanel->model);
        $this->assertInstanceOf($modelClassName, $this->crudPanel->model);
        $this->assertInstanceOf(Builder::class, $this->crudPanel->query);
    }

    public function testSetUnknownModel()
    {
        $this->expectException(\Exception::class);

        $this->crudPanel->setModel('\Foo\Bar');
    }

    public function testSetUnknownRouteName()
    {
        $this->expectException(\Exception::class);

        $this->crudPanel->setRouteName('unknown.route.name');
    }

    public function testSync()
    {
        $this->markTestIncomplete();

        // TODO: the sync method should not be in the CrudPanel class and should not be exposed in the public API.
        //       it is a utility method and should be refactored.
    }
}
