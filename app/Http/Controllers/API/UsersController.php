<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\DailyStep;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsersController extends Controller
{
    /**
     * Retrieve all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Create or update a user.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param int|null $userId The ID of the user to update (optional).
     * @return \Illuminate\Http\JsonResponse The JSON response containing the result of the operation.
     */
    public function createOrUpdate(Request $request, $userId = null)
    {
        $request->validate([
            "avatarId" => 'required',
            "code" => 'required',
            'password' => $userId ? 'nullable' : 'required',
        ]);

        $user = $userId ? User::find($userId) : new User;

        if (!$user && $userId) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $user->avatarId = $request->input('avatarId');
        $user->code = $request->input('code');
        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return response()->json(['message' => 'User saved successfully', 'user' => $user], Response::HTTP_OK);
    }

    /**
     * Add a badge to the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addBadge(Request $request)
    {
        var_dump("addBadge");
        $request->validate([
            'badgeId' => 'required',
        ]);

        $badgeId = $request->input('badgeId');
        $badge = Badge::find($badgeId);
        if (!$badge) {
            return response()->json(['error' => 'Badge not found'], Response::HTTP_NOT_FOUND);
        }

        $userId = $request->user()->id;
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        if ($user->badges()->where('badgeId', $badgeId)->exists()) {
            return response()->json(['error' => 'Badge already assigned to this user'], Response::HTTP_CONFLICT);
        }

        $user->badges()->attach($badgeId);

        return response()->json(['message' => 'Badge added to user successfully'], Response::HTTP_OK);
    }

    /**
     * Display all badges for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showUserBadges(Request $request)
    {
        $user = $request->user();
        $badges = $user->badges;

        if ($badges->isEmpty()) {
            return response()->json(['message' => 'No badges found for this user'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($badges, Response::HTTP_OK);
    }

    /**
     * Display the specified user.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Delete a user.
     *
     * @param int $userId The ID of the user to delete.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $user->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove a badge from a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $userId
     * @param  int  $badgeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeBadge(Request $request, $userId, $badgeId)
    {
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $badge = Badge::find($badgeId);
        if (!$badge) {
            return response()->json(['error' => 'Badge not found'], Response::HTTP_NOT_FOUND);
        }

        if (!$user->badges()->where('badgeId', $badgeId)->exists()) {
            return response()->json(['error' => 'Badge not assigned to this user'], Response::HTTP_CONFLICT);
        }

        $user->badges()->detach($badgeId);

        return response()->json(['message' => 'Badge removed from user successfully'], Response::HTTP_OK);
    }

    /**
     * Display all daily steps for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAllUserSteps(Request $request)
    {
        $dailySteps = DailyStep::where('userId', $request->user()->id)
            ->orderBy('day', 'desc')
            ->get();

        if ($dailySteps->isEmpty()) {
            return response()->json(['message' => 'No daily steps found for this user'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($dailySteps, Response::HTTP_OK);
    }

    /**
     * Retrieve the last recorded daily steps for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function lastUserSteps(Request $request)
    {
        $dailyStep = DailyStep::where('userId', $request->user()->id)
            ->orderBy('day', 'desc')
            ->first();

        if ($dailyStep) {
            return response()->json($dailyStep, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No daily steps found for this user'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display the daily step count for a specific date.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showUserStepsAtDate(Request $request)
    {
        $request->validate([
            'day' => 'required|date',
        ]);

        $dailyStep = DailyStep::where('day', $request->day)
            ->where('userId', $request->user()->id)
            ->first();

        if (!$dailyStep) {
            return response()->json(['message' => 'DailyStep not found for this date'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($dailyStep, Response::HTTP_OK);
    }

    /**
     * Import users from a CSV file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(Request $request)
    {
        $file = $request->file('csv');
        // check if the file is a csv or if there is a file at all
        if (!$file) {
            return response()->json(['message' => 'No file uploaded']);
        }
        // $fileType = $file->getClientMimeType();
        // if ($fileType !== 'text/csv' || $fileType != 'application/vnd.ms-excel' || $fileType !== 'application/csv' || $fileType !== 'application/x-csv' || $fileType !== 'text/x-csv' || $fileType !== 'text/plain') {
        //     return response()->json(['message' => 'Invalid file type', 'fileType' => $fileType, 'requiredType' => 'text/csv']);
        // }
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

    /**
     * Export the steps data of users who have participated in a challenge as a CSV file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        $challengeId = $request->challengeId;

        // Convert Unix timestamps from request to DateTime objects
        $startDate = (new \DateTime())->setTimestamp($request->startDate);
        $endDate = (new \DateTime())->setTimestamp($request->endDate);

        // Get the users that have participated in the challenge
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

        // Generate the CSV file content
        $csvContent = '';
        foreach ($data as $row) {
            $csvContent .= implode(',', $row) . "\n";
        }

        // Set the response headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        // Return the CSV file as a response
        return response($csvContent, 200, $headers);
    }
}