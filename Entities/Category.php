<?php

namespace Modules\Igamification\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Illuminate\Support\Str;
use Modules\Media\Support\Traits\MediaRelation;

class Category extends CrudModel
{
    use Translatable,MediaRelation;

    protected $table = 'igamification__categories';
    public $transformer = 'Modules\Igamification\Transformers\CategoryTransformer';
    public $requestValidation = [
        'create' => 'Modules\Igamification\Http\Requests\CreateCategoryRequest',
        'update' => 'Modules\Igamification\Http\Requests\UpdateCategoryRequest',
      ];
    public $translatedAttributes = [
        'title',
        'description',
        'slug'
    ];
    protected $fillable = [
        'system_name',
        'parent_id'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    // Esto es solo para probar por api q los eventos stuviesen disparandoc
    /*
    public $dispatchesEventsWithBindings = [
        'created' => [
            [
              'path' => 'Modules\Igamification\Events\ActivityWasCompleted',
              'extraData' => ['systemNameActivity' => 'availability-organize']
            ]
        ]
        
    ];
    */
    
    //============== RELATIONS ==============//

    public function activities()
    {
        return $this->belongsToMany(Category::class, 'igamification__activity_category');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    //============== MUTATORS / ACCESORS ==============//

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }

    public function setSystemNameAttribute($value)
    {

        if(empty($value) || is_null($value)){
            $this->attributes['system_name'] = Str::slug($this->title, '-');
        }else{
            $this->attributes['system_name'] = $value;
        }

    }


}
