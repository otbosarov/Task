<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendTaskRequest;
use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\UpdateRejectionTaskRequest;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index()
    {
        $finished = request('finished');
        $unfinished = request('unfinished');
        $outdatedUnfinished = request('outdated_unfinished');
        $date = request('time', date(now()->format('Y-m-d')));

        return Task::where('user_id', auth()->id())

            ->when($finished, function ($query) {
                $query->where('project_completed_time', null);
            })
            ->when($unfinished, function ($query) {
                $query->where('project_completed_time', '!=', null);
            })
            ->when($outdatedUnfinished, function ($query) use ($date) {
                $query->where('project_completed_time', null)
                    ->where('expiration_date', '<', $date);
            })
            ->get();
    }
    public function store(TaskCreateRequest $request)
    {
        try {
            Task::create([
                'projectname' => $request->projectname,
                'dascription' => $request->dascription,
                'start_date' => now(),
                'expiration_date' => $request->expiration_date,
                'user_id' => auth()->id()
            ]);
            return  response()->json(["message" => "Yangi loyiha qabul qilindi"], 201);
        } catch (Exception $exception) {
            return response()->json([
                "message" => ['errors' => ["No'to'g'ri so'rov"]],
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ], 500);
        }
    }
    public function finish(int $id)
    {
        $task = Task::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$task) {
            return response()->json(["message" => 'Bu ID li loyiha mavjud emas yoki Sizga tegishli emas'], 403);
        }
        $task->update([
            'project_completed_time' => date(now()->format('Y-m-d H:i:s'))
        ]);
        return response()->json(["message" => 'Loyiha yakunlandi!'], 200);
    }
    public function sendTaskToParnter(SendTaskRequest $request)
    {

        $task = Task::where('id', $request->task_id)
            ->where('active', true)
            ->where('project_completed_time', null)
            ->whereIn('status', [Task::ADDED , Task::REJECT])
            ->where('user_id', auth()->id())
            ->first();
        if (!$task) {
            return response()->json(["message" => "Amaliyot bajarish uchun ma'lumot topilmadi"], 404);
        }
        $task->update([
            'partner_id' => $request->partner_id,
            'status' => Task::SEND,
            'comment' => null
        ]);
        return response()->json(["message" => "Vazifa muvaffaqqiyatli yuborildi"], 200);
    }
    public function getForMeTasks()
    {
        $userId = auth()->id();
        return Task::where('partner_id', $userId)
            ->where('status', Task::SEND)
            ->where('active', true)
            ->get();
    }
    public function acceptTask(Request $request)
    {
        //  $user_id = auth()->id();
        //  $task_id = $request->task_id;
        //  $partner_id = $request->partner_id;

        $userId = auth()->id();
         $taskId = $request->taskId;


        DB::beginTransaction();
        try {
            $task = Task::where('id', $taskId)
                ->where('status', Task::SEND)
                ->orWhere('status',Task::REJECT)
                ->where('partner_id', $userId)
                ->first();
            if (!$task) {
                return response()->json(['message' => "Amaliyot bajarish uchun ma'lumot topilmadi"]);
            }
            $task->update([
                "status" => Task::ACCEPT,
                'partner_id' => null,
                'comment' => null
            ]); 
            Task::create([
                'projectname' => $task->projectname,
                'dascription' => $task->dascription,
                'start_date' => $task->start_date,
                'expiration_date' => $task->expiration_date,
                'active' => $task->active,
                'project_completed_time' => $task->project_completed_time,
                'user_id' => $userId
            ]);
            DB::commit();
            return response()->json(['message' => "Vazifa qabul qilindi"], 201);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                "message" => 'Amaliyot bajarishda xatolik yuz berdi',
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }
    }
    public function rejectionTask(UpdateRejectionTaskRequest $request)
    {
        $userId = auth()->id();
        $taskId = $request->task_id;
        $taskComment = $request->task_comment;
 try{
        $task = Task::where('id', $taskId)
            ->where('status', Task::SEND)
            ->where('partner_id', $userId)
            ->first();
        if (!$task) {
            return response()->json(['message' => 'Amaliyot bajarish uchun ma\'lumot topilmadi']);
        }
        $task->update([
            "status" => Task::REJECT,
            "comment" => $taskComment,
            // "partner_id" => null
        ]);

        return response()->json(['message' => 'Vazifa rad etildi']);
    }catch(Exception $e){
        return response()->json([
            "message" => "dasturda xatolik",
            "error" => $e->getMessage(),
            "file" => $e->getFile(),
            "line" => $e->getLine()
        ]);
    }
    }
    // public function deleteTask(int $taskId)
    // {
    //     $task = Task::where('id', $taskId)->where('created_user_id', auth()->id())->first();
    //     if ($task) {
    //         $task->delete();
    //         return response()->json(['message' => "Task ochirildi"]);
    //     } else {
    //         return response()->json(['message' => "Task topilmadi"], 404);
    //     }
    // }
}
