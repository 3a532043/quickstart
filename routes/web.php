<?php

use App\Task;
use Illuminate\Http\Request;
Route::get('/', function () {
    $tasks = Task::orderBy('created_at', 'asc')->get();
    //利用model Task由DB的tasks資料表取出資料
    return view('tasks', [
        'tasks' => $tasks
    ]);       //將tasks資料表取出的資料傳遞給tasks視圖
});


// 增加新的任務
Route::post('/task', function (Request $request) {
    // 驗證輸入
    $validator = Validator::make( $request->all(), [
        'name' => 'required|max:255',      //驗證規則
    ]);

    if ($validator->fails()) {      //驗證失敗處理
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    // 建立該任務...
    //新增任務存入DB的程式碼 (see next page)
    $task = new Task;
    $task->name = $request->name;
    $task->save();
    return redirect('/');

});

// 刪除任務
Route::delete('/task/{task}', function (Task $task) {
    $task->delete();
    return redirect('/');
});

