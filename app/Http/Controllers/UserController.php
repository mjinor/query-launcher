<?php

namespace App\Http\Controllers;

use App\Models\AnotherApp\HealthProvider;
use App\Models\AnotherApp\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    /**
     * Author : MJavad Amirbeiki
     * Description : Find Doctor By Medical Code
     */
    public function findByMedicalCode(Request $request) {
        $valid = Validator::make($request->all(),[
            "medical_code" => "required",
        ]);
        if ($valid->fails())
            return redirect()->back()->withErrors($valid)->withInput();
        $doctors = HealthProvider::where("medical_code",$request->medical_code)->pluck("user_id");
        $doctors = User::whereIn("user_id",$doctors)->get();
        $user = new User();
        $result = ["doctors" => [
            "columns" => $user->getTableColumns(),
            "data" => $doctors
        ]];
        return view("result", compact("result"));
    }
}
