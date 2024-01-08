<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends Controller
{
    public function index()
    {
        $todos = auth()->user()->todos;

        return response()->json([
            'data' => $todos,
        ]);
    }

    public function show(Todo $todo)
    {
        if (auth()->user()->id !== $todo->user_id) {
            throw new UnauthorizedException();
        }

        return response()->json([
            'data' => $todo,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $todo = new Todo();
        $todo->title = $request->get('title');
        $todo->description = $request->get('description');
        $todo->user_id = auth()->user()->id;

        $todo->save();

        return response()->json([
            'data' => $todo,
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, Todo $todo)
    {
        if (auth()->user()->id !== $todo->user_id) {
            throw new UnauthorizedException();
        }

        $this->validate($request, [
            'title' => 'sometimes',
            'description' => 'sometimes',
            'status' => 'sometimes|bool',
        ]);

        if ($request->has('title')) {
            $todo->title = $request->get('title');
        }

        if ($request->has('description')) {
            $todo->description = $request->get('description');
        }

        if ($request->has('status')) {
            $todo->status = $request->get('status');
        }

        $todo->save();

        return response()->json([
            'data' => $todo,
        ]);
    }
}
