<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Http\Requests\UpdateTicketStatusRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Services\TicketService;

class TicketController extends Controller
{
       public function __construct(
        protected TicketService $_ticketService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->_ticketService->getList();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $this->authorize('create',Ticket::class);

        return $this->_ticketService->storeTicket($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $this->authorize('view',$ticket);

        return $this->successResponse(
            data : new TicketResource($ticket)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, int $ticketId)
    {
        $ticket = Ticket::query()->findOrFail($ticketId);
        $this->authorize('update', $ticket);

        return $this->_ticketService->updateTicket(
            $ticket,
            $request->all()
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete',$ticket);

        return $this->_ticketService->deleteTicket($ticket);
    }

    public function updateStatus(UpdateTicketStatusRequest $request , int $ticketId)
    {
        $ticket = Ticket::query()->findOrFail($ticketId);

        $this->authorize('updateStatus',$ticket);
        
        return $this->_ticketService->transition(
            $ticket,
            $request->validated('status')
        );
    }
}
