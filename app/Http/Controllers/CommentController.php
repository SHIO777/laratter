<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 忘れないように注意
use App\Models\Tweet;
use App\Models\Comment;
use Validator;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::getAllOrderByUpdated_at();
        ddd($comments);
        return view('comment.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $tweet = Tweet::find($id);
        // ddd($tweet);
        return view('comment.create', compact('tweet'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ddd($request);
        // バリデーション
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
        ]);
        
        // バリデーション:エラー
        if ($validator->fails()) {
            return redirect()
            ->route('comment.create', $request->tweet_id)
            ->withInput()
            ->withErrors($validator);
        }
        // ここよくわかってない
        // create()はデータベース(今回はCommentテーブル)にデータを追加するメソッド
        // ddd($request->tweet_id);
        // $result = Comment::create($request->all()); // $requestの中にはcreate.bladeのformタグの中のid=comment, tweet_idが入ってる
        // return redirect()->route('tweet.show', $request->tweet_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
    }
}
