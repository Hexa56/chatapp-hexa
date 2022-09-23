<?php
  
namespace App\Http\Controllers;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\User;
use Hash;
use Validator;
use App\Models\Migration;
use App\Events\handler;
use App\Events\Tick;
use App\Events\ghandler;
use App\Events\Status;
use App\Events\msgdel; 
use App\Models\message;
use App\Models\grouppeople;
use App\Models\groups;
use App\Models\groupchat;
use App\Models\emoji;
use Illuminate\Support\Facades\Crypt;

Use Alert;

class AdminController extends Controller
{
    public function dashboard()
    {
        $onlineUsers = User::where('status', '1')->count();
        $offlineUsers = User::where('status', '0')->count();
        $userCount = User::count();
        $users = User::all();
        $name = (request()->session()->get('admin'));
        $recentChat = message::distinct()->where('sender','=', $name)->orwhere('recevier','=', $name)->get('sender');
        $user = User::find(request()->session()->get('admin_id'));
        return view('admin.pages.index',['userr'=> $user, 'users' => $users, 'userCount' => $userCount, 'onlineUsers' => $onlineUsers,'offlineUsers' => $offlineUsers, 'recentChat' => $recentChat]);

    }

    public function online()
    {
        $onlineUsers = User::where('status', '1')->get();
        $offlineUsers = User::where('status', '0')->get();
        $user = User::find(request()->session()->get('admin_id'));
        return view('admin.pages.online',[ 'userr'=> $user,'onlineUsers' => $onlineUsers, 'offlineUsers' => $offlineUsers]);

    }
    
    public function chat($send, $res){
        
        $onlineUsers = User::where('status', '1')->get();
        $offlineUsers = User::where('status', '0')->get();
        $user = User::find(request()->session()->get('admin_id'));
        $resimage = User::where('name','=', $res)->get()->first();
        $message = message::where('sender','=', $send)->where('recevier', '=', $res)->orwhere('recevier', '=', $send)->where('sender','=', $res)->get(); 
        return view('admin.pages.chat',[ 'userr'=> $user,'onlineUsers' => $onlineUsers, 'offlineUsers' => $offlineUsers, 'res' => $res, 'send' => $send, 'message'=> $message, 'resimage' =>$resimage]);
    }
    
    public function group($id){
        
        $onlineUsers = User::where('status', '1')->get();
        $offlineUsers = User::where('status', '0')->get();
        $user = User::find(request()->session()->get('admin_id'));
        $groupchats = groupchat::where('group_id','=', $id)->latest('id')->get();
        $groupname = groups::select('name','image')->find($id);
        return view('admin.pages.group',[ 'userr'=> $user,'onlineUsers' => $onlineUsers, 'offlineUsers' => $offlineUsers, 'groupchats' => $groupchats, 'groupname' => $groupname]);
    }
    
    
    public function msgdelgroup($id)
    {
        $del = groupchat::find($id);
        $del->status = 2;
        $del->save();
        return redirect()->back();
    } 
    
    public function msgdel($id)
    {
        $del = message::find($id);
        $del->status = 2;
        $del->save();
        return redirect()->back();
    } 
    
    public function creategroup()
    {
        $onlineUsers = User::where('status', '1')->get();
        $offlineUsers = User::where('status', '0')->get();
        $user = User::find(request()->session()->get('admin_id'));
        $groupusers = groups::all();
        $users = User::all();
        return view('admin.pages.creategroup',[ 'userr'=> $user,'onlineUsers' => $onlineUsers, 'offlineUsers' => $offlineUsers, 'groupusers' => $groupusers, 'users' => $users]);

    }
    
     public function groupchat(request $request)
    {
        if($request->hasFile('groupimage')){
            $filename = $request->groupimage->getClientOriginalName();
            $request->groupimage->storeAs('images',$filename,'public');
            $add = new groups();
            $add->name = request()->groupname;
            $add->image=$filename;
            $add->save();
        }
        Alert::success('Success', 'Group Created Successfully'); 
        return redirect()->back();
    }
    
    public function groupinsert(request $request){
        
        $users = User::all();
        foreach ($users as $user) {
            $temp = $user->id;
            $grouppeople = grouppeople::where('user_id','=', $temp)->where('group_id','=', $request->group_id)->count();
            if(isset(request()->$temp)){  
                $addcont = new grouppeople();
                $addcont->group_id = $request->group_id;
                $addcont->user_id = $temp;
                if( $grouppeople == 0){
                    $addcont->save();
                    Alert::success('Success', 'Group Members added Successfully'); 
                    }
                    else
                    Alert::error('Error', 'Group Members already exists'); 
                }
        } 
        
       
        return redirect()->back();
    }
    
    public function groupmembersdelete(request $request){
        
        $grouppeople = grouppeople::where('group_id','=', $request->group_id)->where('user_id','=', $request->user_id)->get()->first();
        $grouppeople->delete();
        Alert::success('success', 'Group Member removed Successfully'); 
        return redirect()->back();
    }
    
    public function deletegroup(request $request){
        $group = groups::find($request->id);
        $group->delete();
        $groupmembers = grouppeople::where('group_id','=', $request->id)->delete();
        Alert::success('success', 'Group Member removed Successfully'); 
        return redirect()->back();
    }
   
    public function change()
    {
        $user = User::find(request()->session()->get('admin_id'));
        return view('admin.pages.changepassword',[ 'userr'=> $user ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
          'current_password' => 'required',
          'password' => 'required|string|min:6|confirmed',
          'password_confirmation' => 'required',
        ]);

        $user = User::find($request->session()->get('admin_id'));

        if (!Hash::check($request->current_password, $user->password)) {
            Alert::error('Oops', 'Current Password does not Match');
            // session()->flash('message','Current Password does not Match');
            return redirect()->back();
        }

        $user->password = Hash::make($request->password);
        $user->save();
        Alert::success('Success', 'Password Changed Successfully');
        return redirect()->back();
    }
}

