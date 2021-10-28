<?php

namespace Starmoozie\CRUD\Tests\Unit\CrudPanel;

use Starmoozie\CRUD\Tests\Unit\Models\User;

/**
 * @covers Starmoozie\CRUD\app\Library\CrudPanel\CrudPanel
 */
class CrudPanelTablePrefixedTests extends BasePrefixedDBCrudPanelTest
{
    public function testGetColumnTypeFromColumnNameWithPrefixedDatabase()
    {
        $model = new User();

        $this->assertEquals('string', $model->getColumnType('name'));
    }

    public function testGetTableNamePrefixed()
    {
        $model = new User();
        $this->assertEquals('test_users', $model->getTableWithPrefix());
        $this->assertEquals('users', $model->getTable());
    }
}
