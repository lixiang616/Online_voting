<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TopicsOptionsModel;

class TopicsModel extends Model
{
    //
    protected $table = "topics";
    
    public $timestamps = false;

    public function topics_list() {
    	return $this->hasMany(TopicsOptionsModel::class, 'topic_id');
    }

}
