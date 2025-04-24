<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PresenceController extends Controller
{
    // Get today's status
    public function getTodayStatus($matricule)
    {
        return Presence::firstOrCreate(
            ['matricule_employer' => $matricule, 'date_p' => Carbon::today()],
            ['status' => 'Post Empty']
        );
    }

    // Update status
    public function updateStatus(Request $request, $matricule)
    {
        $request->validate([
            'status' => 'required|in:Post Empty,In Vacation,At Work'
        ]);

        $presence = Presence::updateOrCreate(
            ['matricule_employer' => $matricule, 'date_p' => Carbon::today()],
            ['status' => $request->status]
        );

        return response()->json($presence);
    }

    // Clock in
    public function clockIn(Request $request, $matricule)
    {
        $presence = Presence::firstOrCreate(
            ['matricule_employer' => $matricule, 'date_p' => Carbon::today()],
            ['status' => 'At Work']
        );

        if (!$presence->time_arrive) {
            $presence->update([
                'time_arrive' => Carbon::now()->toTimeString(),
                'ip_address' => $request->ip(),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);
        }

        return response()->json($presence);
    }

    // Clock out
    public function clockOut(Request $request, $matricule)
    {
        $presence = Presence::where('matricule_employer', $matricule)
            ->where('date_p', Carbon::today())
            ->firstOrFail();

        if (!$presence->time_leave) {
            $presence->update([
                'time_leave' => Carbon::now()->toTimeString()
            ]);
        }

        return response()->json($presence);
    }

    // Get history
    public function getHistory($matricule)
    {
        return Presence::where('matricule_employer', $matricule)
            ->orderBy('date_p', 'desc')
            ->paginate(15);
    }
}