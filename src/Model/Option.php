<?php

namespace Larapp\Options\Model;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'options';

    /**
     * Primary key name
     *
     * @var string
     */
    protected $primaryKey = 'name';

    /**
     * Set primary key incrementing to false
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Set primary key type
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'value' => '',
    ];
}
