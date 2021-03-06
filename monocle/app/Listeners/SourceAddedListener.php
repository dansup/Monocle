<?php

namespace App\Listeners;

use App\Events\SourceAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class SourceAddedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  SourceAdded  $event
     * @return void
     */
    public function handle(SourceAdded $event)
    {
        Log::info("Source added: ".$event->source->url." to channel: ".$event->channel->name);
        $channels = $event->source->channels();
        Log::info("Source now belongs to ".$channels->count()." channels");

        // If this was a newly added source (belongs to just one channel), subscribe to updates
        if($event->source->url && $channels->count() == 1) {
            $http = new \p3k\HTTP();
            $response = $http->post(env('WATCHTOWER_URL'), http_build_query([
                'hub.mode' => 'subscribe',
                'hub.topic' => $event->source->url,
                'hub.callback' => env('WATCHTOWER_CB').'/websub/source/'.$event->source->token
            ]), [
                'Authorization: Bearer '.env('WATCHTOWER_TOKEN')
            ]);
            Log::info($response['body']);
        }
    }
}
