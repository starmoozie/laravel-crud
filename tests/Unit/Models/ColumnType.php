<?php

namespace Starmoozie\CRUD\Tests\Unit\Models;

use Starmoozie\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class ColumnType extends Model
{
    use CrudTrait;

    protected $table = 'column_types';
}
