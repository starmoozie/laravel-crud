<?php

namespace Starmoozie\CRUD\Tests\Unit\CrudPanel;

use Starmoozie\CRUD\app\Library\CrudPanel\CrudPanel;
use Starmoozie\CRUD\Tests\BaseTest;
use Starmoozie\CRUD\Tests\Unit\Models\TestModel;

abstract class BaseCrudPanelTest extends BaseTest
{
    /**
     * @var CrudPanel
     */
    protected $crudPanel;

    protected $model;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->singleton('crud', function ($app) {
            return new CrudPanel($app);
        });
        $this->crudPanel = app('crud');
        $this->crudPanel->setModel(TestModel::class);
        $this->model = $this->crudPanel->getModel();
    }
}
