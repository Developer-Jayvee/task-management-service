<?php

namespace App\Services;

use App\Events\TicketCommentEvent;
use App\Models\Comment;
use App\Models\Ticket;
use App\Traits\ResponseTrait;

class CommentService
{
    use ResponseTrait;

    public function ticketComments(Ticket $ticket, int $perPage = 5)
    {
        try {
            return $ticket->comments()
                ->orderByDesc('created_at')
                ->paginate(page: 1, perPage: $perPage);
        } catch (\Exception $ex) {
            return $this->errorResponse($ex);
        }
    }

    public function storeComment(Ticket $ticket, string $content)
    {
        try {
            
            $store = $ticket->comments()->create([
                'content' => $content,
            ]);

            TicketCommentEvent::dispatch($store, request()->user());

            return $this->successResponse(
                data: $store
            );
        } catch (\Exception $ex) {
            return $this->errorResponse($ex);
        }
    }

    public function updateComment(Comment $comment, string $content)
    {
        try {
            $update = $comment->update(['content' => $content ]);

            return $this->successResponse( data: $comment->fresh() );
        } catch (\Exception $ex) {
            return $this->errorResponse($ex);
        }
    }
}
