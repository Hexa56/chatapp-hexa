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
use App\Models\note;
use App\Models\bug;
use Illuminate\Support\Facades\Crypt;
Use Alert;
use Str;
class UserController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('auth.login');
    }  
    
    public function report(Request $req)
    {
        $add = new bug;
        $add->name = $req->user;
        $add->bug = $req->bug;
        $add->save();
        Alert::success('Success', 'Thanks For Reporting');
        return redirect()->back();
    }
    function guserDel(Request $req)
    {
        $check = grouppeople::where('group_id','=',$req->gid)->where('role','=','admin')->count();
        $checkuser = grouppeople::where('group_id','=',$req->gid)->where('role','=','admin')->where('user_id','=',$req->uid)->count();
        if($check > 1 || $checkuser == 0)
        {
            $del = grouppeople::where('user_id','=',$req->uid)->where('group_id','=',$req->gid)->delete();
            Alert::success('Success', 'Successfully Deleted');
        }
        else
            Alert::warning('Alert', 'Atleast One Admin Should be there in Group!');
        return redirect()->back(); 
    }
    function guseradd(Request $req)
    {
        $flag = false;
        $users = User::get('id');
        foreach($users as $user)
        {
            if($req[$user->id])
            {
                $gadd = new grouppeople;
                $gadd->group_id = $req->gid;
                $gadd->user_id = $user->id;
                $gadd->save();
                $flag = true;
            }
        }
        if($flag)
        Alert::success('Success', 'Successfully Added');
        else
        Alert::error('Oops!', 'Something Went Wrong');
        
        return redirect()->back();
    }
    
    function gmakeAdmin(Request $req)
    {
        $uadmin = grouppeople::where('group_id','=',$req->gid)->where('user_id','=',$req->uid)->get()->first();
        $check = grouppeople::where('group_id','=',$req->gid)->where('role','=','admin')->count();

        if($uadmin && $uadmin->role == "admin")
        {
            if($check >1)
            $uadmin->role = "member";
            else
            {
                Alert::warning('Alert', 'Atleast one admin should be there');
                return redirect()->back();
            }
        }
        else
        $uadmin->role = "admin";
        
        $uadmin->save();
        Alert::success('Success', 'Successfully Updated');
        return redirect()->back();
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function spectator(Request $req)
    {
        if(isset($req->status))
        {
            $online = User::find($req->session()->get('user_id'));
            $online->status = 0;
            $online->lastlogin = date('d-m-Y | h:i:s A');
            $online->save();
            return event(new Status('away',$req->session()->get('user_id')));
        }
        else
        {
            $online = User::find($req->session()->get('user_id'));
            $online->status = 1;
            $online->save();
            return event(new Status('online',$req->session()->get('user_id')));
        }


    }
    public function registration()
    {
        return view('auth.registration');
    }
    public function reset(Request $req)
    {
        $validatemail = User::where('email','=',$req->email)->get()->first();
        if($validatemail)
        {
           
            $details = [
                'title' => 'Reset Password link',
                'body' => 'Reset Your Password by below provided link'
            ];
            $id = Crypt::encrypt($validatemail->id);
            \Mail::to($validatemail->email)->send(new \App\Mail\ResetLink($details,$id));
            return redirect("/")->with('status',"Reset link is sent to your mail id");
        }
    }

    public function resetpassword(Request $req)
    {
      
            $decrypted = Crypt::decrypt($req->id);
            $reset = User::find($decrypted);
            $reset->password = Hash::make($req->password);
            $reset->save();
            return redirect('/')->with("status", "Password SuccessFully Resetted");
       
        
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
   
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember');
        $ch = User::where('email', $email)->first();
        
        $ch = User::where('email','=',$request->email)->get()->first();
        if ($ch && Hash::check($password, $ch->password))
        {
            if($ch->role == 'admin'){
                $request->session()->put('admin', $ch->name);
                $request->session()->put('admin_id', $ch->id);
                return redirect("/admin/dashboard");
            }
            $request->session()->put('user', $ch->name);
            $request->session()->put('user_id', $ch->id);
            event(new Status('online',$ch->id));
           if($remember == "on"){
                $token = Str::random(40);
                $entoken = Crypt::encrypt($token);
                $ch->remember_token = $token;
                $request->session()->put('token',$entoken);
           }
            $ch->status = 1;
            $ch->save();
            if($ch->role == 'admin'){
                return redirect("/admin/dashboard");
            }
            return redirect("/home");
        }
        session()->flash('message','Opps! You have entered invalid credentials');
        return redirect("/");
        
        
        
        // $request->validate([
        //     'email' => 'required',
        //     'password' => 'required',
        // ]);
   
        // $credentials = $request->only('email', 'password');
        // if (Auth::attempt($credentials)) {
        //     return redirect('/home')->withSuccess('You have Successfully logged In');
        // }
        // session()->flash('message','Oppes! You have entered invalid credentials');
        // return redirect("/");
        
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
     
    public function tokenCheck(Request $request)
    {
        $request->validate([
           "token" => "required" 
        ]);
        
        $check = user::where('remember_token','=',Crypt::decrypt($request->token))->get()->first();
        if($check)
        {
            $request->session()->put('user', $check->name);
            $request->session()->put('user_id', $check->id);
            return 1;
        }
    }
    public function postRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users,fname',
            'email' => 'required|email|unique:users|ends_with:thesiliconreview.com,ciobulletin.com,apsensys.com',
            'password' => 'required|min:6',
            
        ]);
        $reg = new User;
        $reg->fname = $request->name;
        $reg->email = strtolower($request->email);
        $reg->password = Hash::make($request->password);
        $reg->name = strtolower((explode(" ",str_replace(".",'',$reg->fname)))[0]);
        $reg->save();
        $up = User::find($reg->id);
        $up->name = $up->name.$reg->id;
        $up->save();
        return redirect()->back()->with('status','Registration Successfull');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
   
    public function home()
    {
        $pinnedchats = array();
        $obj = new UserController;
        $users = user::orderby('name')->get();
        $munseen = message::where('recevier','=',request()->session()->get('user'))->where('seen','=',0)->count();
        $data = $obj->getRecentUsers(); 
        $usergroups = groups::join('grouppeoples','groupss.id','=','grouppeoples.group_id')->where('user_id','=',request()->session()->get('user_id'))->get();
        $profile = User::find(request()->session()->get('user_id'));
        $pnotes = note::where('user_id','=',request()->session()->get('user_id'))->where('receiver_id','=',0)->get();
        return view('chat', ['munseen'=>$munseen,'pinnedchats' => $pinnedchats, 'users'=>$users,'pnotes'=>$pnotes, 'data' => $data, 'profile' => $profile, 'usergroups' => $usergroups ]);

    }
    public function getRecentUsers()
    {
        $data =  user::select('users.id as user_id','users.name','messages.id')->join('messages', function($join){
            $join->on('users.name','=','messages.sender');
            $join->orOn('users.name','=','messages.recevier');
        })->where('sender','=',request()->session()->get('user'))->orwhere('recevier','=',request()->session()->get('user'))->latest('messages.id')->distinct()->get('user.id');
        $arr = array();
       foreach($data as $key=>$i)
       {
               if(!in_array($i->user_id, $arr) && $key > 0)
               {
                   array_push($arr,$i->user_id);
               }
               else if($key == 0)
               array_push($arr,$i->user_id);
       }
       $users = array();
       foreach($arr as $item)
       {
           $data = user::find($item);
           array_push($users,$data);
       }
       return $users;
    }
    public function select($id)
    {
        $id = Crypt::decrypt($id);
        $usergroups = groups::join('grouppeoples','groupss.id','=','grouppeoples.group_id')->where('user_id','=',request()->session()->get('user_id'))->get();
        $selecteduser = User::find($id);
        $pinnedchats = message::where('pin','=', '1')->where('sender','=',request()->session()->get('user'))->where('recevier','=',$selecteduser->name)->orwhere('pin','=', '1')->where('recevier','=',request()->session()->get('user'))->where('sender','=',$selecteduser->name)->get();
        $obj = new UserController;
        $data = $obj->getRecentUsers();
        $users = user::orderby('name')->get();
        $emojis = emoji::all();
        $emojiGroup = emoji::select('emoji','groups')->where('groups','!=','Component')->groupBy('groups')->orderByRaw("FIELD(groups, 'Smileys & Emotion', 'People & Body', 'Animals & Nature', 'Activities','Flags','Food & Drink','Objects','Travel & Places','Symbols')")->get();
        $profile = User::find(request()->session()->get('user_id'));
        $select = User::find(request()->session()->get('user_id'));
        $select->selected = $id;
        $select->save();
        $check = User::where('id','=',$id)->where('selected','=',request()->session()->get('user_id'))->get()->first();
        if($check)
        $double = 1;
        else
        $double = '';
        
        $munseen = message::where('recevier','=',request()->session()->get('user'))->where('seen','=',0)->count();
        $seen = message::where("sender",'=',$selecteduser->name)->where("recevier",'=',request()->session()->get('user'))->update(['seen'=>1]);
        event(new Tick($id, request()->session()->get('user_id')));
        $notes = note::where('user_id','=',$profile->id)->where('receiver_id','=',$id)->orwhere('user_id','=',$id)->where('receiver_id','=',$profile->id)->get();
        $pnotes = note::where('user_id','=',$profile->id)->where('receiver_id','=',0)->get();
        return view('chat', ['munseen'=>$munseen,'pinnedchats' => $pinnedchats,'users'=>$users,'pnotes'=>$pnotes,'notes'=>$notes,'emojis'=>$emojis, 'emojigroup'=>$emojiGroup, 'data' => $data, 'user' => $selecteduser, 'double'=>$double, 'profile' => $profile, 'usergroups' => $usergroups]);
    }

    public function gselect($id)
    {
        $id = Crypt::decrypt($id);
        $usergroups = groups::join('grouppeoples','groupss.id','=','grouppeoples.group_id')->where('user_id','=',request()->session()->get('user_id'))->get();
        $selecteduser = groups::find($id);     
        $pinnedchats = groupchat::where('pin','=', '1')->where('group_id','=',$id)->get();
        $gmembers = grouppeople::select('users.*','grouppeoples.*','grouppeoples.role as grole')->join("users",'users.id','=',"grouppeoples.user_id")->where('group_id','=',$id)->orderby('fname')->get();
        $obj = new UserController;
        $data = $obj->getRecentUsers();
        $users = user::orderby('name')->get();
        $emojis = emoji::all();
        $emojiGroup = emoji::select('emoji','groups')->where('groups','!=','Component')->groupBy('groups')->orderByRaw("FIELD(groups, 'Smileys & Emotion', 'People & Body', 'Animals & Nature', 'Activities', 'Component','Flags','Food & Drink','Objects','Travel & Places','Symbols')")->get();
        $gchats = groupchat::where('group_id','=',$selecteduser->id)->where('status','=',0)->get();
        $profile = User::select('users.*','grouppeoples.role')->join('grouppeoples','users.id','=','grouppeoples.user_id')->where('grouppeoples.group_id','=',$id)->where('users.id','=',request()->session()->get('user_id'))->get()->first();
        $notes = note::where('user_id','=',$profile->id)->where('receiver_id','=',$id)->orwhere('user_id','=',$id)->where('receiver_id','=',$profile->id)->get();
        $pnotes = note::where('user_id','=',$profile->id)->where('receiver_id','=',0)->get();
        $munseen = message::where('recevier','=',request()->session()->get('user'))->where('seen','=',0)->count();
        return view('chat', ['munseen'=>$munseen,'pinnedchats' => $pinnedchats,'pnotes'=>$pnotes,'notes'=>$notes,'members'=>$gmembers,'emojis'=>$emojis, 'emojigroup'=>$emojiGroup, 'data' => $data, 'users' => $users, 'user' => $selecteduser,'group'=>'on', 'profile' => $profile,'gchats'=>$gchats, 'usergroups' => $usergroups]);
    }


    public function settings()
    {
        $pinnedchats = groupchat::where('pin','=', '1')->get();
        $user = User::find(request()->session()->get('user_id'));
        return view('settings',['pinnedchats' => $pinnedchats,'user' => $user]);
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
   

    public function change()
    {

      return view('auth.changepwd');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
          'current_password' => 'required',
          'password' => 'required|string|min:6|confirmed',
          'password_confirmation' => 'required',
        ]);

        $user = User::find($request->session()->get('user_id'));

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

    public function upload(Request $request)
    {
        if($request->hasFile('image')){
            $filename = $request->image->getClientOriginalName();
            $request->image->storeAs('images',$filename,'public');
            // Auth()->user()->update(['image'=>$filename]);
            $update = User::find($request->session()->get('user_id'));
            $update->image=$filename;
            $update->save();
            Alert::success('Success', 'Profile Picture Updated Successfully');
            return redirect()->back();
        }
        else{
             Alert::error('Oops', 'No Changes were made');
             return redirect()->back();
        }
       
    }
    
     public function update(Request $request)
    {
        $user = User::find($request->session()->get('user_id'));
        $emailCheck = User::where('email','=',$request->email)->get()->first();
        if($user->fname == $request[ 'name' ] && $user->email == $request[ 'email' ] && $user->designation == $request->designation && $user->bio == $request->bio) {
            Alert::error('Oops', 'No Changes were made');
             return redirect()->back();  
        }
        else if($user->email != $request[ 'email' ] && $emailCheck)
        {
           Alert::warning('Warning', 'Email Id Already Taken!');
        return redirect()->back(); 
        }
        else{
             $request->validate([
            'name' =>'required|min:4|string|max:255',
            'email'=>'required|email|string|max:255',
            'designation' =>'required|string|max:255',
            'bio' =>'required|string'
            ]);
            $user->fname = $request['name'];
            $user->email = $request['email'];
            $user->designation = $request['designation'];
            $user->bio = $request['bio'];
            $user->save();
            Alert::success('Success', 'Account Settings Updated Successfully');
            return redirect()->back();  
        }
       

    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        
        $s = User::find(request()->session()->get('user_id'));
        event(new Status('away',$s->id));
        $s->status = 0;
        $s->selected = 0;
        $s->lastlogin = date('d-m-Y | h:i:s A');
        $s->save();
        Session::flush();
        Auth::logout();
        
        return Redirect('/')->withSuccess('Logout Successfull');
    }
    
    public function groupchat()
    {
        $flag = false;
        $users = User::all();
        $add = new groups();
        if(request()->gname)
        $add->name = request()->gname;
        else{
            Alert::Error('Error', 'Group Name Cannot be Empty!');
            return redirect()->back();
        }
        $add->save();
        foreach ($users as $user) {
            $temp = $user->id;
            if(isset(request()->$temp)){  
                $addcont = new grouppeople();
                $addcont->group_id = $add->id;
                $addcont->user_id = $temp;
                $addcont->save();
                $flag = true;
            }
        }
        if(!$flag){
            $del = groups::find($add->id);
            $del->delete();
            Alert::Error('Error', 'Group Members Not Selected!');
        }
        else{
            Alert::success('Success', 'Group Created Successfully'); 
        }
        return redirect()->back();
    }

    public function chat()
    {
        $arr = emoji::pluck('emoji')->toArray();
        if(isset(request()->gid))
        {
            $add =  new groupchat();
            $add->sender = request()->sname;
            $add->group_id = request()->gid;
            if(request()->reply)
            {
                $add->reply = request()->reply;
                $reply = groupchat::find($add->reply);
                $rid = $reply->id;
                if($reply->forwarded == 1)
                {
                    $reply = message::find($reply->message);
                    if(request()->session()->get('user') == $reply->sender)
                    $rmessage = "You: ".$reply->message;
                    else
                    $rmessage = $reply->sender.": ".$reply->message;
                }
                else if($reply->forwarded == 2)
                {
                    $reply = groupchat::find($reply->message);

                    if(request()->session()->get('user') == $reply->sender)
                    $rmessage = "You: ".$reply->message;
                    else
                    $rmessage = $reply->sender.": ".$reply->message;
                }
                else
                {
                    if(request()->session()->get('user') == $reply->sender)
                    $rmessage = "You: ".$reply->message;
                    else
                    $rmessage = $reply->sender.": ".$reply->message;
                }
            }
            else
            {
                $rmessage = '';
                $rid = '';
            }
            $gmsg = request()->gmsg;
            preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $gmsg, $arr_gmsg);
            if(count($arr_gmsg[0]) > 0)
            {
                foreach($arr_gmsg[0] as $garr)
                {
                    $gmsg = str_replace($garr,"<a target='_blank' rel='noopener noreferrer' class='fw-bold' href='".$garr."'>".$garr."</a>",$gmsg);
                }
            }
            if(request()->hasFile('file'))
            {
                $imgcheck = ['jpg', 'JPG', 'jpeg', 'png', 'webp','gif'];
                $video = ['mp4','mkv'];
                $audio = ['mp3','wav'];
                $msg = '';
                foreach(request()->file as $key=>$img)
                {
                    $temp = $img->getClientOriginalName();
                    $name = str_replace(' ','-',$temp);
                    $extension = $img->getClientOriginalExtension();
                    $img->storeAs('public/docs', $name);
                    if($key > 0)
                    {
                         $msg .= "<div class='w-100 border-top pt-3 border-white'></div>";
                    }
                    if(in_array($extension, $imgcheck))
                    $msg .= "<div class='w-image'>
                        <img width='100%' src=/storage/docs/".$name.">
                            <div class='d-flex justify-content-between py-2'>".$name."
                                <span class='d-flex justify-content-center align-items-center'><i onclick='viewImage(`/storage/docs/".$name."`)' class='fa-solid fa-eye mx-2' style='color: currectColor;font-size: 25px;'></i>
                                <a download='".$name."' href='/storage/docs/".$name."' style='color: currectColor;'><i class='fa-solid fa-download' style='font-size: 22px;'></i></a></span>
                            </div>
                    </div>
                    <div class='fs-5'> ".$gmsg."</div>";
                    else if(in_array($extension, $video))
                    {
                    $msg .= '<div class="w-image">
                        <video width="100%" controls>
                            <source src="/storage/docs/'.$name.'" type="video/mp4">
                        </video>
                        <div class="d-flex justify-content-between py-2">'.$name.'
                            <span class="d-flex justify-content-center align-items-center"><i onclick="viewDocs(`/storage/docs/'.$name.'`)" class="fa-solid fa-eye mx-2" style="color: currectColor;font-size: 25px;"></i>
                            <a download="'.$name.'" href="/storage/docs/'.$name.'" style="color: currectColor;"><i class="fa-solid fa-download" style="font-size: 22px;"></i></a></span>
                        </div>
                    </div>
                    <div class="fs-5"> '.$gmsg.'</div>';
                    }
                    else if(in_array($extension, $audio))
                    {
                    $msg .= '<div class="w-image"> <audio width="100%" controls>
                    <source src=/storage/docs/'.$name.' type="video/mp4">
                    </audio></div><div class="fs-5">'.$gmsg.'</div>';
                    }
                    else
                    {
                        $msg .= "<div class='w-image'>
                    <img width='100' src=/icons/doc.png>
                        <div class='d-flex justify-content-between py-2'>".$name."
                                <span class='d-flex justify-content-center align-items-center'><i onclick='viewDocs(`/storage/docs/".$name."`)' class='fa-solid fa-eye mx-2' style='color: currectColor;font-size: 25px;'></i>
                                <a download='".$name."' href='/storage/docs/".$name."' style='color: currectColor;'><i class='fa-solid fa-download' style='font-size: 22px;'></i></a></span>
                        </div>
                    </div><div class='fs-5'> ".$gmsg."</div>";
                    }
                } 
                $add->message = $msg;
            }
            else
            {
                $add->message = $gmsg;
                $msg = $gmsg;
            }
        $add->save();
        $time = date('d-m-Y | h:i:s A');
        if(request()->hasFile('file'))
        {
            $imgmsg[] = ["/storage/docs/".$name, $gmsg];
            return event(new ghandler(request()->sname, $msg, $add->id, request()->gname, $time,$rmessage, $rid,$add->group_id));
        }
        else
            return event(new ghandler(request()->sname, $gmsg, $add->id, request()->gname, $time,$rmessage, $rid, $add->group_id));
        }
        else
        {
            $add =  new message();
            $add->sender = request()->name;
            $add->recevier = request()->reciver;
            $user = User::where('name','=',request()->name)->get()->first();
            if(request()->reply)
            {
                $add->reply = request()->reply;
                $reply = message::find($add->reply);
                $rid = $reply->id;
                if($reply->forwarded == 1)
                {
                    $reply = message::find($reply->message);
                    if(request()->session()->get('user') == $reply->sender)
                    $rmessage = "You: ".$reply->message;
                    else
                    $rmessage = $reply->sender.": ".$reply->message;
                }
                else if($reply->forwarded == 2)
                {
                    $reply = groupchat::find($reply->message);

                    if(request()->session()->get('user') == $reply->sender)
                    $rmessage = "You: ".$reply->message;
                    else
                    $rmessage = $reply->sender.": ".$reply->message;
                }
                else
                {
                    if(request()->session()->get('user') == $reply->sender)
                    $rmessage = "You: ".$reply->message;
                    else
                    $rmessage = $reply->sender.": ".$reply->message;
                }
                
            }
            else
            {
                $rmessage = '';
                $rid = '';
            }
            $msg = request()->msg;
            
            preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $msg, $arr_msg);
            if(count($arr_msg[0]) > 0)
            {
                foreach($arr_msg[0] as $arr)
                {
                    $msg = str_replace($arr,"<a target='_blank' rel='noopener noreferrer' class='fw-bold' href='".$arr."'>".$arr."</a>",$msg);
                }
            }

            // if(in_array($msg, $arr))
            // {
            //     $msg = "<span class='fs-1'>".$msg."</span>";
            // }
            if(request()->hasFile('file'))
            {
                $imgcheck = ['jpg', 'JPG', 'jpeg', 'png', 'webp','gif'];
                $video = ['mp4','mkv'];
                $audio = ['mp3','wav'];
                foreach(request()->file as $key=>$img)
                {
                    $temp = $img->getClientOriginalName();
                    $name = str_replace(' ','-',$temp);
                    $extension = $img->getClientOriginalExtension();
                    $img->storeAs('public/docs', $name);
                    if($key > 0)
                    {
                         $msg .= "<div class='w-100 border-top pt-3 border-white'></div>";
                    }
                    if(in_array($extension, $imgcheck))
                    {
                        $msg .= "<div class='w-image'>
                        <img width='100%' src=/storage/docs/".$name.">
                            <div class='d-flex justify-content-between py-2'>".$name."
                                <span class='d-flex justify-content-center align-items-center'><i onclick='viewImage(`/storage/docs/".$name."`)' class='fa-solid fa-eye mx-2' style='color: currectColor;font-size: 25px;'></i>
                                <a download='".$name."' href='/storage/docs/".$name."' style='color: currectColor;'><i class='fa-solid fa-download' style='font-size: 22px;'></i></a></span>
                            </div>
                    </div>
                    <div class='fs-5'> ".request()->msg."</div>";
                    }
                    else if(in_array($extension, $video))
                    {
                    $msg .= '<div class="w-image">
                        <video width="100%" controls>
                            <source src="/storage/docs/'.$name.'" type="video/mp4">
                        </video>
                        <div class="d-flex justify-content-between py-2">'.$name.'
                            <span class="d-flex justify-content-center align-items-center"><i onclick="viewDocs(`/storage/docs/'.$name.'`)" class="fa-solid fa-eye mx-2" style="color: currectColor;font-size: 25px;"></i>
                            <a download="'.$name.'" href="/storage/docs/'.$name.'" style="color: currectColor;"><i class="fa-solid fa-download" style="font-size: 22px;"></i></a></span>
                        </div>
                    </div>
                    <div class="fs-5"> '.request()->msg.'</div>';
                    }
                    else if(in_array($extension, $audio))
                    {
                    $msg .= '<div class="w-image"> <audio width="100%" controls>
                    <source src=/storage/docs/'.$name.' type="video/mp4">
                    </audio></div><div class="fs-5"> '.request()->msg.'</div>';
                    }
                    else
                    {
                        $msg .= "<div class='w-image'>
                    <img width='100' src=/icons/doc.png>
                        <div class='d-flex justify-content-between py-2'>".$name."
                            <span class='d-flex justify-content-center align-items-center'><i onclick='viewDocs(`/storage/docs/".$name."`)' class='fa-solid fa-eye mx-2' style='color: currectColor;font-size: 25px;'></i>
                            <a download='".$name."' href='/storage/docs/".$name."' style='color: currectColor;'><i class='fa-solid fa-download' style='font-size: 22px;'></i></a></span>
                        </div>
                    </div><div class='fs-5'> ".request()->msg."</div>";
                    }
                    $add->message = $msg;
                }
            }
            else
            {
                $add->message = $msg;
                $msg = $msg;
            }
        
        $ch = User::where('id','=',request()->rev)->where('selected','=',request()->session()->get('user_id'))->get()->first();
        if($ch)
        $add->seen = 1;

        $add->save();
        $time = date('d-m-Y | h:i:s A');

        if(request()->hasFile('file'))
        {
            $imgmsg[] = ["/storage/docs/".$name, $msg];
            return event(new handler(request()->name, $user->fname, $msg, request()->reciver, $time, $add->id,request()->dd, request()->session()->get('user_id'),$rmessage, $rid));
        }
        else
            return event(new handler(request()->name, $user->fname, $msg, request()->reciver, $time, $add->id,request()->dd, request()->session()->get('user_id'),$rmessage, $rid));

    }
    }
    public function msgdel($id)
    {
        $del = message::find($id);
        $del->status = 1;
        $del->save();
        event(new msgdel($id));
        return redirect()->back();
    } 
    public function gmsgdel($id)
    {
        $del = groupchat::find($id);
        $del->status = 1;
        $del->save();
        event(new msgdel("g".$id));
        return redirect()->back();
    }
    public function typing($id)
    {
        event(new Status('typing', $id));
    }
    public function notyping($id)
    {
        event(new Status('notyping', $id));
    }
    
    public function searchmsg(Request $req)
    {
        $data = message::where('sender','=',$req->session()->get('user'))->where('recevier','=',$req->other)->where('message','REGEXP',$req->key)->orwhere('sender','=',$req->other)->where('recevier','=',$req->session()->get('user'))->where('message','REGEXP',$req->key)->get();
        return redirect()->back()->with('result',$data);
        
    }
    public function addnote(Request $req)
    {
        $user_id = Crypt::decrypt($req->user_id);
        if($req->receiver_id && !$req->type)
        $receiver_id = Crypt::decrypt($req->receiver_id);
        else
        $receiver_id = 0;
        
        $notes = $req->note;
        $addnote = new note();
        $addnote->user_id = $user_id;
        $addnote->receiver_id = $receiver_id;
        $addnote->notes = $notes;
        $addnote->save();
        Alert::success('Success', 'Successfully Noted');
        return redirect()->back();
    }
    public function notedelete(Request $req)
    {
        $notedel = note::find(Crypt::decrypt($req->id));
        $notedel->delete();
        Alert::success('Success', 'Successfully Note Deleted');
        return redirect()->back();
    }
    
    public function addpin($id){
        
        if(strpos($id,'g')!== false)
        $addpin = groupchat::find(str_replace('g','',$id));
        else
        $addpin = message::find(str_replace('u','',$id));
        
        $addpin->pin = 1;
        $addpin->save();
        Alert::success('Success', 'Message Pinned Successfully');
        return redirect()->back();
    }
    
    public function unpin($id){

        if(strpos($id,'g')!== false)
        $addpin = groupchat::find(str_replace('g','',$id));
        else
        $addpin = message::find($id);
        
        $addpin->pin = 0;
        $addpin->save();
        Alert::success('Success', 'Message Unpinned Successfully');
        return redirect()->back();
    }
    
    // function test()
    // {
    //     $obj = new UserController;
    //     $data = $obj->getRecentUsers();
    //     $gdata = grouppeople::join('groupss','groupss.id','=','grouppeoples.group_id')->where('grouppeoples.user_id','=',request()->session()->get('user_id'))->get();
    //     return $data->reverse()->get();
    // }
    
    function forward(Request $req)
    {
        if(strpos($req->msg_id, 'g') !== false)
        {
            $users = user::all();
            $m_id = str_replace('g','',$req->msg_id);
            foreach($users as $user)
            {
                if(isset($req[$user->name]))
                {
                    $add = new message();
                    $add->sender = $req->session()->get('user');
                    $add->recevier = $user->name;
                    $add->message = $m_id;
                    $add->forwarded = 2;
                    $add->save();
                    $msg = groupchat::find($m_id);
                    event(new handler($req->session()->get('user'), $user->fname, "<div class='d-flex flex-column'><span
                  style='font-size: 11px; text-transform: capitalize;'>forwarded</span>".$msg->message."</div>", $user->name, date('d-m-Y | h:i:s A'), $msg->id,$add->seen, request()->session()->get('user_id'),'',''));
                }
            }
            $groups = groups::all();
            foreach($groups as $group)
            {
                if(isset($req["group".$group->id]))
                {
                    $add = new groupchat();
                    $add->group_id = $group->id;
                    $add->sender = $req->session()->get('user');
                    $add->message = $m_id;
                    $add->forwarded = 2;
                    $add->save();
                    $msg = groupchat::find($m_id);
                    event(new ghandler($req->session()->get('user'), "<div class='d-flex flex-column'><span
                  style='font-size: 11px; text-transform: capitalize;'>forwarded</span>".$msg->message."</div>", $msg->id, $group->name, date('d-m-Y | h:i:s A'),'','',''));
                }
            }
            
            Alert::success('Success', 'Message Successfully Forwarded');
            return redirect()->back();
        }
        else if(strpos($req->msg_id, 'u') !== false)
        {
            $users = user::all();
            $m_id = str_replace('u','',$req->msg_id);
            foreach($users as $user)
            {
                if(isset($req[$user->name]))
                {
                    $add = new message();
                    $add->sender = $req->session()->get('user');
                    $add->recevier = $user->name;
                    $add->message = $m_id;
                    $add->forwarded = 1;
                    $add->save();
                    $msg = message::find($m_id);
                    event(new handler($req->session()->get('user'), $user->fname, "<div class='d-flex flex-column'><span
                  style='font-size: 11px; text-transform: capitalize;'>forwarded</span>".$msg->message."</div>", $user->name, date('d-m-Y | h:i:s A'), $msg->id,$add->seen, request()->session()->get('user_id'),'',''));
                }
            }
            $groups = groups::all();
            foreach($groups as $group)
            {
                if(isset($req["group".$group->id]))
                {
                    $add = new groupchat();
                    $add->group_id = $group->id;
                    $add->sender = $req->session()->get('user');
                    $add->message = $m_id;
                    $add->forwarded = 1;
                    $add->save();
                    $msg = message::find($m_id);
                    event(new ghandler($req->session()->get('user'), "<div class='d-flex flex-column'><span
                  style='font-size: 11px; text-transform: capitalize;'>forwarded</span>".$msg->message."</div>", $msg->id, $group->name, date('d-m-Y | h:i:s A'),'','',''));
                }
            }
           
            Alert::success('Success', 'Message Successfully Forwarded');
            return redirect()->back();
        }
    }
    
   function test()
   {
       return $emojiGroup = emoji::select('emoji','groups')->where('groups','!=','Component')->groupBy('groups')->orderByRaw("FIELD(groups, 'Smileys & Emotion', 'People & Body', 'Animals & Nature', 'Activities', 'Component','Flags','Food & Drink','Objects','Travel & Places','Symbols')")->get();
    //   $emojis = json_decode(file_get_contents("https://unpkg.com/emoji.json@13.1.0/emoji.json"));
    //   foreach($emojis as $emoji)
    //   {
    //       $add = new emoji;
    //       $add->emoji = json_encode($emoji->char);
    //       $add->description = $emoji->name;
    //       $add->category = $emoji->category;
    //       $add->groups = $emoji->group;
    //       $add->save();
    //   }
   }
}

