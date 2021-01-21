<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Like;
use App\Reply;
use Illuminate\Http\Request;
use App\Notifications\ReplyMarkedAsBestReply;
class RepliesController extends Controller
{
    public function like($id)
    {
        Like::create([
            'reply_id' => $id,
            'user_id' => Auth::id()
        ]);

        Session::flash('success', 'You liked the reply.');

        return redirect()->back();
    }
 
    public function edit($id){
        return view('replies.edit',['reply'=>Reply::find($id)]);
    }
    public function update($id){
        $this->validate(request(),[
            'content'=>'required'
        ]);
        $reply=Reply::find($id);
        $reply->content=request()->content;
        $reply->save();
        Session::flash('success', 'Reply updated');  
        return redirect()->route('discussion',['slug'=>$reply->discussion->slug]);     
    }


    public function unlike($id)
    {
        $like = Like::where('reply_id', $id)->where('user_id', Auth::id())->first();

        $like->delete();

        Session::flash('success', 'You unliked the reply.');

        return redirect()->back();
    }

    public function best_answer($id)
    {
        $reply = Reply::find($id);

        $reply->best_answer = 1;
        $reply->save();

        $reply->user->points += 100;
        $reply->user->save();

        $reply->user->notify(new ReplyMarkedAsBestReply($reply->discussion));

        Session::flash('success', 'Reply has been marked as the best answer.');
        return redirect()->back();
    }
    
    public function not_best_answer($id){
        $reply = Reply::find($id);
        $reply->best_answer = 0;
        $reply->save();

        $reply->user->points -= 100;
        $reply->user->save();

        Session::flash('success', 'Reply has been removed as best answer');
        return redirect()->back();      
    }
}
