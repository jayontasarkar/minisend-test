<?php

namespace App\Jobs;

use Illuminate\Support\Arr;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class StoreEmailAndDependenciesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $payload;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = \App\Models\Email::create([
            'user_id' => $this->payload['userId'],
            'recipient' => $this->payload['recipient'],
            'sender'    => $this->payload['sender'],
            'subject'      => $this->payload['subject'],
            'html_content' => $this->payload['html_content'],
            'text_content' => $this->payload['text_content']
        ]);

        $email->activities()->create(
            ['status' => 'POSTED', 'user_id' => $this->payload['userId']]
        ); 

        if (isset($this->payload['paths']) && count($this->payload['paths']) > 0) {
            $collection = collect($this->payload['paths'])->map(function($item) use ($email) {
                return [
                    'path' => $item['path'],
                    'email_id' => $email['id']
                ];
            });
            DB::table('attachments')->insert($collection->toArray());
        }
        
        SendTransactionalEmail::dispatch(
            $email->load('attachments')
        );
    }
}
