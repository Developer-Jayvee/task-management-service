<?php

namespace App\Services;

use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Models\TicketStatusHistory;
use App\Traits\ResponseTrait;
use Carbon\Carbon;

class TicketService
{
    use ResponseTrait;


    public function getList()
    {
        $ticket = Ticket::query()->paginate(perPage : 10, page : 1);

        return TicketResource::collection($ticket);
    }

    public function storeTicket(array $data)
    {
        try {

            $ticket = Ticket::query()->create([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'status' => $data['status'],
                'priority' => $data['priority'],
                'due_date' => Carbon::createFromFormat('Y-m-d',$data['due_date']),
                'assignee_id' => $data['assignee_id'] ?? null,
                'project_id' => $data['project_id'],
            ]);
    
            return $this->successResponse(
                data: new TicketResource($ticket)
            );
        } catch (\Exception $exception) {
            dd($exception);
            return $this->errorResponse($exception);
        }
    }
    public function deleteTicket(Ticket $ticket) 
    {
        try {
            $ticket?->delete();    

            return $this->successResponse(
                message: "Successfully deleted"
            );

        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }

    public function updateTicket(Ticket $ticket, array $data)
    {
        try {
            if(! $ticket ) {
                throw new \Exception("This ticket does not exist", 404);
            }
    
            $ticket->update($data);
    
            return $this->successResponse( data : $ticket->fresh() );
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }

    public function showTicket(int $id) 
    {
        try {
            $ticket = Ticket::query()->findOrFail($id);
    
            return $this->successResponse(
                data : $ticket
            );
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }

    public function transition(TIcket $ticket , string $status)
    {
        try {
            
            TicketStatusHistory::query()->create([
                'ticket_id' => $ticket->id,
                'status' => $status
            ]);        
    
    
            $ticket->update([ 'status' => $status ]);
    
            return $this->successResponse([
                'ticket' => $ticket->fresh(),
                'status' => $ticket->status
            ]);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }
}
