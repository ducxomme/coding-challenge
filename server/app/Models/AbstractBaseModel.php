<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AbstractBaseModel
 * @package App\Models
 */
abstract class AbstractBaseModel extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
}
