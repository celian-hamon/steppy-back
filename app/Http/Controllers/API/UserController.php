<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    public function import(Request $request)
    {
        $file = $request->file('csv');
        // check if the file is a csv or if there is a file at all
        if (!$file) {
            return response()->json(['message' => 'No file uploaded']);
        }
        $fileType = $file->getClientMimeType();
        if ($fileType !== 'text/csv') {
            return response()->json(['message' => 'Invalid file type']);
        }
        switch ($file->getClientOriginalExtension()) {
            case 'csv':
                break;
            default:
                return response()->json(['message' => 'Invalid file type']);
        }
        $fileContents = file($file->getPathname());
        $lineProgress = 0;
        foreach ($fileContents as $line) {
            $data = str_getcsv($line);
            // ignore the first line of the csv
            if ($lineProgress === 0) {
                $lineProgress++;
                continue;
            }
            // the import might be done multiple times, so we need to check if the user already exists
            if (User::where('code', $data[0])->first()) {
                continue;
            }
            User::create([
                'code' => $data[0],
                'password' => bcrypt($data[1]),
            ]);
        }
        return response()->json(['message' => 'File imported successfully']);
    }

    public function export(Request $request)
    {
        $challengeId = $request->challengeId;

        // Convert Unix timestamps from request to DateTime objects
        $startDate = (new \DateTime())->setTimestamp($request->startDate);
        $endDate = (new \DateTime())->setTimestamp($request->endDate);

        // Format the dates to be used in the query
        $formattedStartDate = $startDate->format('Y-m-d H:i:s');
        $formattedEndDate = $endDate->format('Y-m-d H:i:s');

        // Get the users that have participated in the challenge
        // $users = User::with([
        //     'daily_steps' => function ($query) use ($challengeId, $formattedStartDate, $formattedEndDate) {
        //         $query->join('challenge_user', 'challenge_user.userId', '=', 'daily_steps.userId')
        //             ->where('challenge_user.challengeId', $challengeId)
        //             ->whereBetween('daily_steps.day', [$formattedStartDate, $formattedEndDate]);
        //     }
        // ])->whereHas('challenges', function ($query) use ($challengeId) {
        //     $query->where('challenge_user.challengeId', $challengeId);
        // })->get();
        $users = User::with('daily_steps')
            ->whereHas('challenges', function ($query) use ($challengeId) {
                $query->where('challenge_user.challengeId', $challengeId);
            })
            ->get();
        // Prepare the header with dynamic date columns
        $header = ['Code'];
        $period = new \DatePeriod(
            $startDate,
            new \DateInterval('P1D'),
            $endDate
        );

        foreach ($period as $date) {
            $header[] = $date->format('Y-m-d');
        }

        $data[] = $header;

        // Get the steps for each user for each day
        foreach ($users as $user) {
            $userRow = ['code' => $user->code];
            foreach ($period as $date) {
                // Format the date to start at 00:00:00 of the day
                $startOfDay = $date->format('Y-m-d') . ' 00:00:00';
                // Format the date to end at 23:59:59 of the day
                $endOfDay = $date->format('Y-m-d') . ' 23:59:59';

                // Sum the steps within the start and end of the day
                $steps = $user->daily_steps
                    ->where('userId', $user->id)
                    ->whereBetween('day', [$startOfDay, $endOfDay])
                    ->sum('stepCount');
                $userRow[$date->format('Y-m-d')] = $steps;
            }
            $data[] = $userRow;
        }


        // Create the csv file
        $csvFileName = 'challenge_' . $challengeId . '_steps.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        $handle = fopen('php://output', 'w');
        foreach ($data as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);

        return Response::make('', 200, $headers);
    }
}