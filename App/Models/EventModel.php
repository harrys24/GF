<?php
namespace App\Models;
use App\Core\Model;
class EventModel extends Model{
    protected $isPK='id',
        $isAI=false;
    var $id,
        $title,
        $description,
        $overlap,
        $color,
        $start,
        $end;
    public function __construct(){
        parent::__construct();
    }
}