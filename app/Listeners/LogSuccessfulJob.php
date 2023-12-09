<?php

namespace App\Listeners;

use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\Facades\DB;

/**
 * LogSuccessfulJob Listener.
 *
 * This listener is triggered after a job has been processed successfully.
 * It logs the successful execution of a job by inserting a record into the
 * 'successful_jobs' database table. This can be useful for auditing,
 * debugging, or tracking the history of job executions.
 */
class LogSuccessfulJob
{
    /**
     * Handle the job processed event.
     *
     * @param  JobProcessed  $event
     * @return void
     */
    public function handle(JobProcessed $event)
    {
        // Insert a record into the 'successful_jobs' table
        DB::table('successful_jobs')->insert([
            'name' => get_class($event->job),  // Class name of the job
            'job_id' => $event->job->getJobId(),  // Unique identifier of the job
            'payload' => json_encode($event->job->payload()),  // Job payload
            'processed_at' => now(),  // Timestamp when the job was processed
        ]);
    }
}
