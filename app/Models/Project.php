<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ["title", "url", "content", "type_id"];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }

    public function getTypeBadge()
    {
        return $this->type ? "<span class='badge' style='background-color: {$this->type->color}'>{$this->type->label}</span>" : "";
    }

    public function getTechnologyBadges()
    {
        $badges_html = "";
        foreach ($this->technologies as $technology) {
            $badges_html .= "<span class='badge rounded-pill' style='background-color: {$technology->color}'>{$technology->label}</span>";
        }
        return $badges_html;
    }
}