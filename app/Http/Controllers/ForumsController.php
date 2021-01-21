<?php

namespace App\Http\Controllers;

use Auth;
use App\Channel;
use App\Discussion;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
class ForumsController extends Controller
{
    public function index()
    {

        switch (request('filter')) {
            case 'me':
                $results=Discussion::where('user_id',Auth::id())->paginate(3);
                break;
            case 'solved':
                $answered=array();
                foreach (Discussion::all() as $d) {
                    if($d->hasBestAnswer()){
                        array_push($answered,$d);
                    }
                }
                // $results=new Paginator($answered,3);
            $results= $this->paged($answered);
            $results->withPath('/forum?filter=solved');                
            break;
            case 'unsolved':
                $unanswered=array();
                foreach (Discussion::all() as $d) {
                    if(!$d->hasBestAnswer()){
                        array_push($unanswered,$d);
                    }
                }

            // $results=new Paginator($unanswered,3);
            $results= $this->paged($unanswered);
            $results->withPath('/forum?filter=unsolved');
            break;
            default:
                $results = Discussion::orderBy('created_at', 'desc')->paginate(3);
                break;
        }

        

        return view('forum', ['discussions' => $results]);
    }

    public function channel($slug)
    {
        $channel = Channel::where('slug', $slug)->first();

        return view('channel')->with('discussions', $channel->discussions()->paginate(5));
    }


    public function paged($items, $perPage = 3, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
