<?php

namespace App\Http\Controllers;

use App\Models\AnotherApp\Book;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Validator;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    const DYNAMIC_MODE = "dynamic";
    const SEPARATE_MODE = "separate";

    private mixed $query_struct;
    private mixed $mode;

    public function __construct() {
        $this->mode = Config::get("query.mode");
        switch ($this->mode) {
            case self::SEPARATE_MODE:
                $this->query_struct = Config::get("query.structure");
                break;
            case self::DYNAMIC_MODE:
                $this->query_struct = Config::get("query.dynamic-structure");
                break;
            default :
                abort(404);
        }
    }

    /**
     * Author : MJavad Amirbeiki
     * Description : defined queries returned
     */
    public function index() {
        $query_struct = $this->query_struct;
        switch ($this->mode) {
            case self::SEPARATE_MODE:
                $response = view("dashboard",compact("query_struct"));
                break;
            case self::DYNAMIC_MODE:
                $response = view("dynamic-query-dashboard",compact("query_struct"));
                break;
            default :
                abort(404);
        }
        return $response;
    }

    /**
     * Author : MJavad Amirbeiki
     * Description : execute selected query
     */
    public function execute(Request $request) {
        $valid = Validator::make($request->all(),[
            "query_name" => "required",
        ]);
        if ($valid->fails())
            return redirect()->back()->withErrors($valid)->withInput();
        $query_name = $request->get("query_name");
        [$class,$method] = explode(".",$query_name);
        $params = $this->query_struct[$class][$method]["params"];
        $params = array_values(Arr::sort($params, function ($value) {
            return $value['priority'];
        }));
        $rules = [];
        $n = 1;
        foreach ($params as $param) {
            $rules[$method."_param_" . $n] = $param["validation"];
            $n++;
        }
        $valid = Validator::make($request->all(),$rules);
        if ($valid->fails())
            return redirect()->back()->withErrors($valid)->withInput();
        $params = $this->keyMatches($method."_param_*",$request->all());
        $params = array_values($params);
        $result = call_user_func([$class,$method],$params)->get();
        $book = new Book();
        $columns = $book->getTableColumns();
        $response_type = $this->query_struct[$class][$method]["response"];
        $response = match ($response_type) {
            Collection::class => view("result", compact("result", "columns")),
            default => view("result")->with("success", "Operation done successfully."),
        };
        return $response;
    }

    /**
     * Provides wild card search for array keys.
     *
     * @param string $search
     * @param array $arr
     * @param bool $keyValue
     * @return array
     */
    public function keyMatches($search, $arr, $keyValue = true) {
        $search = str_replace('\*', '(.*)?', preg_quote($search, '/'));
        $result = preg_grep("/^{$search}$/i", array_keys($arr));
        if ($keyValue)
            $result = array_intersect_key($arr, array_flip($result));
        return $result;
    }
}
