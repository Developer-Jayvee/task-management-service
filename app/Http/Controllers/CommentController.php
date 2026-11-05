<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Ticket;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function __construct(
        protected CommentService $service
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,int $ticketId)
    {
        return $this->service->ticketComments(
            ticket: Ticket::query()->findOrFail($ticketId),
            perPage: $request->query('perPage',5)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, int $ticketId)
    {
        return $this->service->storeComment(
            ticket: Ticket::query()->findOrFail($ticketId),
            content: $request->validated('content')
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, int $commentId)
    {
        return $this->service->updateComment(
            comment: Comment::query()->firstOrFail($commentId),
            content: $request->validated('content')
        );
    }

  
}
