<?php

namespace App\Models;

use App\Services\Builder\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'majors';
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($q) {
            $q->contests()->delete();
        });
    }

    public function contests()
    {
        return $this->hasMany(Contest::class, 'major_id');
    }

    public function Skill()
    {
        return $this->belongsToMany(Skills::class, 'major_skills', 'major_id', 'skill_id');
    }

    public function sliders()
    {
        return $this->morphOne(Slider::class, 'sliderable');
    }
    // public function parent_chils()
    // {
    //     return $this->hasMany(Major::class, 'parent_id', 'id');
    // }
    public function parent()
    {
        return $this->hasOne(Major::class, 'id', 'parent_id')->with('parent');
    }

    public function majorChils()
    {
        return $this->hasMany(Major::class, 'parent_id', '')->with('majorChils');
    }
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}
    // public static function tree() {

    //     return static::with('parent_chils')->where('parent_id', '=', 0)->orderByDesc('id');

    // }