<?php

namespace Tiketux\Menu\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Tiketux\Core\Models\Permission;

use Tiketux\Core\Responses\BaseResponse;
use Tiketux\Menu\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class MenuApi extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api',"admin"]);
    }

    public function list()
    {
        $data = Menu::list();

        $response["statusCode"] = 200;
        $response["data"] = $data;
        return response()->json($response);
    }

    public function list_halaman(Request $request)
    {
        $data = Menu::all();

        $response["statusCode"]   = 200;
        $response["data"]         = [
            'halaman' => $data
        ];

        return response()->json($response);
    }

    public function detail(Request $request)
    {
        $PageId = $request->input('PageId');

        $response["statusCode"] = 200;
        $response["data"]       = [
            'Page' => Menu::findOrFail($PageId)
        ];

        return response()->json($response);
    }

    public function delete(Request $request)
    {

        $PageId = $request->input('PageId');

        Menu::destroy($PageId);
        return response()->json($PageId);
    }

    public function save(Request $request)
    {
        $request->validate([
            "name" => "required",
            "url" => "required",
            "icon" => "required",
            "is_admin" => "required"
        ]);
        
        if ($request->input("PageId") == null) {
            Menu::create($request->input());
        } else {
            Menu::findOrFail($request->input("PageId"))->update($request->input());
        }
        $response["statusCode"]   = 200;
        $response["data"] = ["data" => $request->input()];
        return response()->json($response);
    }
}
