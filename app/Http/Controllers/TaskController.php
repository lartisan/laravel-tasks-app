<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $filter = $request->has('filter')
            ? $request->get('filter')
            : 'priority';

        $order = $request->has('order')
            ? $request->get('order')
            : 'desc';

        $tasks = Task::with(['owner', 'assignee'])
            ->assignedToMe()
            ->orderBy($filter, $order)
            ->get();

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return TaskResource
     */
    public function store(Request $request)
    {
        $task = Task::create($request->all());

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return TaskResource
     */
    public function update(Request $request, Task $task)
    {
        $task->update($request->all());

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * Gate defined in \App\Providers\AuthServiceProvider
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete-task', $task);

        $task->delete();

        return response()->json([
            'status' => 'ok'
        ]);
    }
}
