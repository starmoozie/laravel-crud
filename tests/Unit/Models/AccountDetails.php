<?php

namespace Starmoozie\CRUD\Tests\Unit\Models;

use Starmoozie\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class AccountDetails extends Model
{
    use CrudTrait;

    protected $table = 'account_details';
    protected $fillable = ['user_id', 'nickname', 'profile_picture', 'article_id'];

    /**
     * Get the user for the account details.
     */
    public function user()
    {
        return $this->belongsTo('Starmoozie\CRUD\Tests\Unit\Models\User');
    }

    public function addresses()
    {
        return $this->hasMany('Starmoozie\CRUD\Tests\Unit\Models\Address');
    }

    public function getNicknameComposedAttribute()
    {
        return $this->nickname.'++';
    }

    public function article()
    {
        return $this->belongsTo('Starmoozie\CRUD\Tests\Unit\Models\Article');
    }
}
