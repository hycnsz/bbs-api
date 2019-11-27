<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;
// 表单请求 UserRequest

// 第一个修改是引入了 App\Models\User 用户模型，因为将要在 show() 方法中使用到 User 模型，所以我们必须先引用。
class UsersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }
    public function show (User $user)
    {
        return view('users.show',compact('user'));
        // 由于 show() 方法传参时声明了类型 —— Eloquent 模型 User，对应的变量名 $user 会匹配路由片段中的 {user}，这样，Laravel 会自动注入与请求 URI 中传入的 ID 对应的用户模型实例。
        // 我们将用户对象变量 $user 通过 compact 方法转化为一个关联数组，并作为第二个参数传递给 view 方法，将变量数据传递到视图中。
        // show 方法添加完成之后，在视图中，我们即可直接使用 $user 变量来获取 view 方法传递给视图的用户数据。
    }
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
        // edit() 方法接受 $user 用户作为传参，也就是说当 URL 是 http://blog2.test/users/1/edit 时，读取的是 ID 为 1 的用户
    }
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
