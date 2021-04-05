<?php

namespace App\Jobs;

use Throwable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Storage;

class SendTransactionalEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->email;
        Mail::send([], [], function($message) use ($email) {
            $attachments = $email->attachments;
            if (count($attachments) > 0) {
                foreach($attachments as $index => $attachment) {
                    $message->attachData('Attachment ' . $index + 1, $attachment->path);
                }
            }
            $message->to($email->recipient);
            $message->from($email->sender);
            $message->subject($email->subject);
            $message->setBody($email->html_content, 'text/html');
        });
        $email->status = 'SENT';
        $email->save();
        $email->activities()->create([
            'status' => 'SENT',
            'user_id' => $email->user_id
        ]);
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        $email = $this->email;
        $email->status = 'FAILED';
        $email->save();
        $email->activities()->create([
            'status' => 'FAILED',
            'user_id' => $email->user_id
        ]);
    }
}
