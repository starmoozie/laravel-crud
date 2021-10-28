<?php

namespace Starmoozie\CRUD\Tests\Unit\Models;

use Starmoozie\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use CrudTrait;

    protected $table = 'addresses';
    protected $fillable = ['city', 'street', 'number'];

    /**
     * Get the author for the article.
     */
    public function accountDetails()
    {
        return $this->belongsTo('Starmoozie\CRUD\Tests\Unit\Models\AccountDetails', 'account_details_id');
    }
}
