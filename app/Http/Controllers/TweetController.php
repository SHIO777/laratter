<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 🔽 2行追加
use Validator;
use App\Models\Tweet;

// 🔽 追加
use Auth;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 🔽 編集
        // $tweets = [];
        // DBからTweetを取得する
        $tweets = Tweet::getAllOrderByUpdated_at();
        // compact('変数名')
        // ddd($tweets);
        return view('tweet.index', compact('tweets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 🔽 追加
        return view('tweet.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'tweet' => 'required | max:191',
            'description' => 'required',
        ]);
        // バリデーション:エラー
        if ($validator->fails()) {
            return redirect()
                ->route('tweet.create')
                ->withInput()
                ->withErrors($validator);
        }
        // create()は最初から用意されている関数
        // Databaseにデータを保存
        // 戻り値は挿入されたレコードの情報
        // 🔽 編集 フォームから送信されてきたデータとユーザIDをマージし，DBにinsertする
        
        $data = $request->merge(['user_id' => Auth::user()->id])->all();
        $result = Tweet::create($request->all());
        // ddd(Auth::user());   for debug
        // ddd($result);        for debug
        // ルーティング「todo.index」にリクエスト送信（一覧ページに移動）
        return redirect()->route('tweet.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tweet = Tweet::find($id);
        ### debug
        // ddd($tweet->all()); # 全て表示
        return view('tweet.show', compact('tweet'));
        // ddd($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tweet = Tweet::find($id);
        return view('tweet.edit', compact('tweet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //バリデーション
        $validator = Validator::make($request->all(), [
            'tweet' => 'required | max:191',
            'description' => 'required',
        ]);
        //バリデーション:エラー
        if ($validator->fails()) {
            return redirect()
            ->route('tweet.edit', $id)
            ->withInput()
            ->withErrors($validator);
        }
        //データ更新処理
        $result = Tweet::find($id)->update($request->all());
        // ddd($result);
        return redirect()->route('tweet.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $result = Tweet::find($id)->delete();
        return redirect()->route('tweet.index');
    }
}
