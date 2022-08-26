<?php

namespace App\Http\Controllers;

use App\Models\AnotherApp\Book;
use App\Models\AnotherApp\Factor;
use App\Models\AnotherApp\FactorItem;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Validator;
use DB;

class BookController extends Controller
{
    /**
     * Author : MJavad Amirbeiki
     * Description : Find Book By Ref ID
     */
    public function findByRefId(Request $request) {
        $valid = Validator::make($request->all(),[
            "ref_id" => "required",
        ]);
        if ($valid->fails())
            return redirect()->back()->withErrors($valid)->withInput();
        $book = new Book();
        $result = Book::findByRefId([$request->ref_id])->get();
        $result = ["book" => [
            "columns" => $book->getTableColumns(),
            "data" => $result
        ]];
        if (sizeof($result) == 0)
            return redirect()->back()->with("error","Not Found!");
        return view("result", compact("result"));
    }

    /**
     * Author : MJavad Amirbeiki
     * Description : Fetch book and Factor by Ref ID
     */
    public function fetchFactor(Request $request) {
        $valid = Validator::make($request->all(),[
            "ref_id" => "required",
        ]);
        if ($valid->fails())
            return redirect()->back()->withErrors($valid)->withInput();
        $book = Book::findByRefId([$request->ref_id])->get();
        $book_object = new Book();
        $factor_items = FactorItem::whereIn("type_id",Arr::pluck($book,"id"))->get();
        $fi_object = new FactorItem();
        $result = ["book" => [
            "columns" => $book_object->getTableColumns(),
            "data" => $book
        ],"factor_items" => [
            "columns" => $fi_object->getTableColumns(),
            "data" => $factor_items
        ]];
        return view("result", compact("result"));
    }

    /**
     * Author : MJavad Amirbeiki
     * Description : return Deleted book (with payment factor - optional)
     */
    public function cancelDelete(Request $request) {
        $valid = Validator::make($request->all(),[
            "ref_id" => "required",
        ]);
        if ($valid->fails())
            return redirect()->back()->withErrors($valid)->withInput();
        $book = Book::findByRefId([$request->ref_id])->where("center_id",Book::CENTER)->firstOrFail();
        $book->delete = 0;
        $book->payment_status = 3;
        $book->last_update = strtotime("now");
        DB::beginTransaction();
        try {
            $book->save();
            if ($request->with_factor) {
                $book->payment_status = 2;
                $factor_ids = $book->factorItems()->pluck("factor_id");
                $factor = Factor::whereIn("id",$factor_ids)->firstOrFail();
                $factor->state = 2;
                $factor->expire_date = strtotime("now") + (60 * 30);
                $factor->pay_expire_date = strtotime("now") + (60 * 30);
                $factor->last_update = strtotime("now");
                $factor->save();
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            if (env('APP_DEBUG'))
                return view("result")->with("error",$exception->getMessage());
            return view("result")->with("error","ERROR!");
        }
        return view("result")->with("success","Delete Canceled Successfully!");
    }
}
