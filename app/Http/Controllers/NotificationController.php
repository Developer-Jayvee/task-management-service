<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBulkReadReqest;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(
        protected readonly NotificationService $notifService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->notifService->userNotifications();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $notifId)
    {
        return $this->notifService->setUnreadNotification(
            notifId: $notifId
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $notifId)
    {
        return $this->notifService->deleteNotification(
            notifId: $notifId
        );
    }

    public function bulkRead(UpdateBulkReadReqest $request)
    {
        return $this->notifService->bulkReadNotification(
            notifIds: $request->validated('notifIds')
        );
    }

    public function bulkDestroy(UpdateBulkReadReqest $request)
    {
        return $this->notifService->bulkDeleteNotification(
            notifIds: $request->validated('notifIds')
        );
    }

    public function notifCount()
    {
        return $this->notifService->notifCount();
    }
}
