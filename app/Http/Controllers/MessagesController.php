<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\User;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //use this so its mandatory for the user to log into the system.
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $messages = Message::with('userFrom')->where('user_id_to', Auth::id())->notDeleted()->get();

        return view('home')->with('messages', $messages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $id = 0, String $subject = '')
    {
        if ($id === 0) {
            $users = User::where('id', '!=', Auth::id())->get();
        } else {
            $users = User::where('id', $id)->get();
        }
        if($subject !== '') $subject = 'Re:' . $subject;

        return view('create')->with(['users' => $users, 'subject' => $subject] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required',
            'message' => 'required'
        ]);


        $message = new Message();
        $message->user_id_from = Auth::id();
        $message->user_id_to = $request->input('to');
        $message->subject = $request->input('subject');
        $message->body = $request->input('message');
        $message->save();

        return redirect()->to('/home')->with('status', 'Message sent successfully');
    }

    /**
     * Display the sent
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sent()
    {
        $messages = Message::with('userTo')->where('user_id_from', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('sent')->with('messages', $messages);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function read(int $id)
    {
        $message = Message::with('userFrom')->find($id);
        $message->read = true;
        $message->save();
        return view('read')->with('message', $message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleted()
    {
        $messages = Message::with('userFrom')->where('user_id_to', Auth::id())->deleted()->get();
        return view('deleted')->with('messages', $messages);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $message = Message::find($id);
        $message->deleted = true;
        $message->save();
        return redirect()->to('/home')->with('status', 'Message deleted successfully');
    }
    public function return(int $id) {
        $message = Message::find($id);
        $message->deleted = false;
        $message->save();

        return redirect()->to('/home');
    }
}
