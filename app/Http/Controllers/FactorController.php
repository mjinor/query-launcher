<?php

namespace App\Http\Controllers;

use App\Models\AnotherApp\Factor;
use Illuminate\Http\Request;
use Validator;

class FactorController extends Controller
{
    /**
     * Author : MJavad Amirbeiki
     * Description : make factor state paid from expired
     */
    public function expiredToPaid(Request $request) {
        $valid = Validator::make($request->all(),[
            "factor_id" => "required",
        ]);
        if ($valid->fails())
            return redirect()->back()->withErrors($valid)->withInput();
        $factor = Factor::where("id",$request->factor_id)->where("state",4)->firstOrFail();
        $factor->state = 2;
        $factor->save();
        return view("result")->with("success","Operation Done Successfully!");
    }
}
