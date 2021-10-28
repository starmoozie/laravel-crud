<?php

namespace Starmoozie\CRUD\app\Models\Traits;

trait CrudTrait
{
    use HasIdentifiableAttribute;
    use HasEnumFields;
    use HasRelationshipFields;
    use HasUploadFields;
    use HasFakeFields;
    use HasTranslatableFields;

    public static function hasCrudTrait()
    {
        return true;
    }
}
