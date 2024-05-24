<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userId = Auth::check() ? Auth::id() : null;

        $comment = new Comment();
        $comment->user_id = $userId;
        $comment->post_id = $request->post_id;
        $comment->comment = $request->comment;
        $comment->commented_by = $request->commented_by;
        $comment->commented_at = now(); 



        $comment->save();

        return response()->json(['message' => 'Comment created successfully', 'comment' => $comment], 201);
    }
    /**
     * Display the specified resource.
     */
    public function getComment()
    {
        $comments = Comment::active()->get();
    
        if ($comments->isEmpty()) {
            return response()->json(['error' => 'Comment not found'], 404);
        }
    
        $comments->makeHidden(['status', 'slug', 'created_at', 'updated_at']);
    
        return response()->json($comments);
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
