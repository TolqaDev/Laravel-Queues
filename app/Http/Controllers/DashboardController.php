<?php

namespace App\Http\Controllers;

use App\Mail\SendWelcomeEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with lists of jobs, failed jobs, and successful jobs.
     */
    public function index()
    {
        $jobsList = DB::table('jobs')->latest()->take(10)->get();
        $jobsFailList = DB::table('failed_jobs')->take(10)->get();
        $jobsSuccessList = DB::table('successful_jobs')->take(10)->get();

        // Collect user IDs
        $userIds = $this->getUserIds($jobsList, $jobsFailList, $jobsSuccessList);

        // Query users
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        // Process each list with the processJob function
        $jobsList = $jobsList->map(function ($job) use ($users) {
            return $this->processJob($job, $users);
        });

        $jobsFailList = $jobsFailList->map(function ($job) use ($users) {
            return $this->processJob($job, $users);
        });

        $jobsSuccessList = $jobsSuccessList->map(function ($job) use ($users) {
            return $this->processJob($job, $users);
        });

        return view('dashboard', [
            'jobsList' => $jobsList,
            'jobsFailList' => $jobsFailList,
            'jobsSuccessList' => $jobsSuccessList
        ]);
    }

    /**
     * Collect user IDs from the jobs, failed_jobs, and successful_jobs tables.
     */
    private function getUserIds($jobsList, $jobsFailList, $jobsSuccessList)
    {
        $userIds = [];
        foreach ([$jobsList, $jobsFailList, $jobsSuccessList] as $jobs) {
            foreach ($jobs as $job) {
                $payload = json_decode($job->payload, true);
                if (isset($payload['data']['command'])) {
                    $command = unserialize($payload['data']['command']);
                    if (isset($command->mailable) && isset($command->mailable->data->id)) {
                        $userIds[] = $command->mailable->data->id;
                    }
                }
            }
        }
        return array_unique($userIds);
    }

    /**
     * Process each job to extract and assign email and user name.
     */
    private function processJob($job, $users)
    {
        $payload = json_decode($job->payload, true);

        if (isset($payload['data']['command'])) {
            $command = unserialize($payload['data']['command']);
            if (isset($command->mailable)) {
                $job->email = $command->mailable->to[0]['address'];
                $userId = $command->mailable->data->id;
                $job->userName = isset($users[$userId]) ? $users[$userId]->name : 'User Not Found';
            }
        }

        return $job;
    }

    /**
     * Cancel a job and move it to the failed_jobs table.
     */
    public function cancelJob($jobId)
    {
        // Cancel a job from the 'jobs' table
        $job = DB::table('jobs')->where('id', $jobId)->first();

        if ($job) {
            // Add the job to the 'failed_jobs' table
            DB::table('failed_jobs')->insert([
                'uuid' => Str::uuid(),
                'connection' => 'database',
                'queue' => $job->queue,
                'payload' => $job->payload,
                'exception' => 'The job was manually cancelled.',
                'failed_at' => now(),
            ]);

            // Delete the job from the 'jobs' table
            DB::table('jobs')->where('id', $jobId)->delete();

            return back()->with('status', 'The job was cancelled and added to the failed_jobs table.');
        }

        return back()->with('error', 'The job was not found.');
    }

    /**
     * Retry a failed job by moving it back to the jobs queue.
     */
    public function retryFailedJob($id)
    {
        // Retry a failed job from the 'failed_jobs' table
        $job = DB::table('failed_jobs')->where('id', $id)->first();

        if ($job) {
            // Use Laravel's retry command to requeue the job
            Artisan::call('queue:retry', ['id' => [$job->uuid]]);

            // Delete the job from the 'failed_jobs' table
            DB::table('failed_jobs')->where('id', $id)->delete();

            return back()->with('status', 'The job was successfully requeued.');
        }

        return back()->with('error', 'The job was not found.');
    }

    /**
     * Restart a successful job by moving it back to the jobs queue.
     */
    public function restartSuccessfulJob($id)
    {
        $job = DB::table('successful_jobs')->where('id', $id)->first();

        if ($job) {
            // Re-add the job to the 'jobs' table
            DB::table('jobs')->insert([
                'queue' => "default",
                'payload' => $job->payload,
                'attempts' => 0,
                'reserved_at' => null,
                'available_at' => now()->timestamp,
                'created_at' => now()->timestamp,
            ]);

            return back()->with('status', 'The job was successfully restarted.');
        }

        return back()->with('error', 'The job was not found.');
    }

    /**
     * Delete a failed job from the failed_jobs table.
     */
    public function deleteFailedJob($id)
    {
        $jobDeleted = DB::table('failed_jobs')->where('id', $id)->delete();

        if ($jobDeleted) {
            return back()->with('status', 'The failed job was successfully deleted.');
        }

        return back()->with('error', 'The job was not found or already deleted.');
    }

    /**
     * Schedule a welcome email to be sent after a specified delay.
     */
    public function registerJob(Request $request)
    {
        Mail::to($request->user()->email)->later(Carbon::now()->addMinutes(5), new SendWelcomeEmail($request->user()));
        return back();
    }
}
