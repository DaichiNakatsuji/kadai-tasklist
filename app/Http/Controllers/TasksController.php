<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // タスク一覧を取得
        $tasks = Task::orderBy('id')->paginate(25);

        // タスク一覧ビューでそれを表示
        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = new Task;

        // タスク作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|max:16',
            'status' => 'required|max:10',
            'content' => 'required',
        ]);

        // タスクを作成
        $task = new Task;
        $task->user_id = $request->user_id;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);

        // タスク詳細ビューでそれを表示
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);

        // タスク編集ビューでそれを表示
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|max:16',
            'status' => 'required|max:10',
            'content' => 'required',
        ]);

        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        $task->user_id = $request->user_id;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        // タスクを削除
        $task->delete();

        // トップページへリダイレクトさせる
        return redirect('/');
    }
}
