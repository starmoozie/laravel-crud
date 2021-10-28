<?php

namespace Starmoozie\CRUD\Tests\Unit\Models;

use Starmoozie\CRUD\app\Models\Traits\CrudTrait;

class TestModel extends \Illuminate\Database\Eloquent\Model
{
    use CrudTrait;
}
