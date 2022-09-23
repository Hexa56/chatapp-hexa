<?php
  
use Illuminate\Support\Facades\Route;  
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Events\handler;
use App\Models\message;
use App\Models\groupchat;
use App\Events\ghandler;
use App\Http\Middleware\UserCheck;
/*LOGIN & REGISTRATION*/
  
Route::get('/', [UserController::class, 'index'])->name('login');
Route::get('/test', [UserController::class, 'test']);
Route::post('post-login', [UserController::class, 'postLogin'])->name('login.post');
Route::post('tokenCheck', [UserController::class, 'tokenCheck']);
Route::get('sign-up', [UserController::class, 'registration'])->name('register');
Route::post('post-registration', [UserController::class, 'postRegistration'])->name('register.post');
Route::view('/password-reset', 'auth.reset');
Route::get('password-reset/{id}', function($id){
   return view('auth.resetpassword',['id'=>$id]);
});
Route::post('reset', [UserController::class, 'reset'])->name('reset');
Route::post('resetpassword', [UserController::class, 'resetpassword'])->name('resetpassword');

Route::middleware([AdminCheck::class])->group(function () 
{
     // Admin
    Route::post('/group/make-admin', [UserController::class, "gmakeAdmin"]);
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/online', [AdminController::class, 'online'])->name('admin.online');
    Route::get('admin/chat', [AdminController::class, 'chat'])->name('admin.chat');
    Route::get('admin/groupchat/{id}', [AdminController::class, 'group'])->name('admin.group');
    Route::get('admin/chat/{send}/{res}', [AdminController::class, 'chat']);
    Route::get('admin/changepassword', [AdminController::class, 'change']);
    Route::post('admin/changepassword', [AdminController::class, 'changePassword'])->name('admin.changepassword');
    Route::get('admin/msgdel/{id}', [AdminController::class, "msgdel"]);
    Route::get('admin/msgdelgroup/{id}', [AdminController::class, "msgdelgroup"]);
    Route::get('admin/creategroup', [AdminController::class, 'creategroup'])->name('admin.creategroup');
    Route::post('admin/group', [AdminController::class, "groupchat"])->name('admin.groupchat');
    Route::post('admin/groupinsert', [AdminController::class, "groupinsert"])->name('admin.groupinsert');
    Route::post('admin/groupmembersdelete', [AdminController::class, "groupmembersdelete"])->name('admin.groupmembersdelete');
    Route::post('admin/deletegroup', [AdminController::class, "deletegroup"])->name('admin.deletegroup');

});



Route::middleware([UserCheck::class])->group(function () 
{
    
    // User
    Route::get('spectator', [UserController::class, "spectator"]);
    Route::post('report', [UserController::class, "report"]);
    Route::post('/group/adduser', [UserController::class, "guseradd"]);
    Route::post('/group/make-admin', [UserController::class, "gmakeAdmin"]);
    Route::post('/group/user-delete', [UserController::class, "guserDel"]);
    Route::post('spectator', [UserController::class, "spectator"]);
    Route::get('addpin/{id}', [UserController::class, "addpin"]);
    Route::get('unpinchat/{id}', [UserController::class, "unpin"]);
    Route::post('forward', [UserController::class, 'forward']);
    Route::get('message/{id}', [UserController::class, 'message']);
    Route::get('dashboard', [UserController::class, 'dashboard']);
    Route::post('searchmsg', [UserController::class, 'searchmsg']);
    Route::post('/add-note', [UserController::class, 'addnote']);
    Route::post('/note-delete', [UserController::class, 'notedelete']);
    Route::get('logout', [UserController::class, 'logout'])->name('logout');
    Route::get('change-password', [UserController::class, 'change']);
    Route::post('change-password', [UserController::class, 'changePassword'])->name('change.password');
    Route::post('upload', [UserController::class, 'upload'])->name('upload');
    Route::post('update', [UserController::class, 'update'])->name('update');
    Route::post('add-contact', [UserController::class, 'addContact'])->name('add.contact');
    Route::get('/search', [UserController::class, 'search'])->name('this.search');
    Route::get('/autocomplete-search-query', [UserController::class, 'query'])->name('autocomplete.search.query');
    Route::get('/settings',[UserController::class, "settings"])->name('settings');
    Route::get('/home',[UserController::class, "home"]);
    Route::get('/select/{id}',[UserController::class, "select"]);
    Route::get('/group/{id}',[UserController::class, "gselect"]);
    Route::post('/chat', [UserController::class, "chat"]);
    Route::post('/file', function (){
        $name = request()->file->getClientOriginalName();
        request()->file->storeAs('public/docs', $name);
        return "<img src=/storage/docs/".$name.">";
    });
    Route::get('msgdel/{id}', [UserController::class, "msgdel"]);
    Route::get('gmsgdel/{id}', [UserController::class, "gmsgdel"]);
    // Route::view('/test', 'test');
    Route::get('typing/{id}', [UserController::class, "typing"]);
    Route::get('notyping/{id}', [UserController::class, "notyping"]);
    Route::post('groupinsert', [UserController::class, "groupchat"]);
});
Route::get("/link", function()
{
    return Artisan::call("storage:link");
});

Route::get('test', [UserController::class, "test"]);


