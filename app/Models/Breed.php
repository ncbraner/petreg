<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Breed extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'breeds';

    /**
     * Get breeds by type.
     *
     * @param string $type
     * @return Collection
     */
    public static function getByType(string $type): Collection
    {
        return DB::table('breeds')->where('type', $type)->get();
    }
}
