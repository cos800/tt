<?php


namespace tt;


use think\Model;
use think\model\concern\SoftDelete;

class BaseModel extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;

    protected $autoWriteTimestamp = true;

//    protected $name = 'user';
//
//    protected $type = [
//        'scope_list' => 'array',
//    ];
}