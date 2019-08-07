<?php

namespace Tiketux\Menu\Models;

use Illuminate\Database\Eloquent\Model;

use DB;
use Tiketux\Core\Models\Permission;
use Illuminate\Support\Facades\Auth;

class Menu extends Model
{
    protected $table = 'menu';

    protected $guarded = ["PageId"];
    public $incrementing = false;

    public $timestamps = false;

    public static function list()
    {
        if (!Auth::user()->is_admin) {
            $data = Menu::where("is_admin", 0)->orderBy("name")->get();
        } else {
            $data = Menu::orderBy("name")->get();
        }

        return $data;
    }
}
