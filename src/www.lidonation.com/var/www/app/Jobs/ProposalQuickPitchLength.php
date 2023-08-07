<?php

namespace App\Jobs;

use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProposalQuickPitchLength implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $proposal;

    public function __construct(Proposal $proposal)
    {
        $this->proposal = $proposal;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->proposal->quickpitch) {
            return;
        }

        $videoUrl = $this->proposal->quickpitch;

        $youtubeId = $this->youtubeId($videoUrl);
        $vimeoId = $this->vimeoId($videoUrl);

        $youtubePattern = '/^[a-zA-Z0-9_-]{11}$/';
        if (preg_match($youtubePattern, $youtubeId)) {
            $videoDuration = $this->getYoutubeVideoDuration($videoUrl);
        }

        $vimeoPattern = '/^\d+$/';
        if (preg_match($vimeoPattern, $vimeoId)) {
            $videoDuration = $this->getVimeoVideoDuration($videoUrl);
        }

        if ($videoDuration !== null) {
            $this->proposal->quickpitch_length = $videoDuration;
            $this->proposal->save();
            Log::info('ProposalQuickPitchLength job success for Proposal ID: ' . $this->proposal->id);
        } else {
            return;
        }
    }

    /**
     * Get the duration of a YouTube video.
     *
     * @param  string  $url
     * @return int|null
     */
    private function getYoutubeVideoDuration(string $url)
    {
        $id = $this->youtubeId($url);

        if (!$id) {
            return null;
        }

        // Make an API request to get video information from YouTube
        $response = Http::get("https://www.googleapis.com/youtube/v3/videos", [
            'id' => $id,
            'part' => 'contentDetails',
            'key' => env('YOUTUBE_API_KEY'),
        ]);


        $responseData = json_decode($response->body());

        if (isset($responseData->items) && !empty($responseData->items)) {
            $videoDuration = $responseData->items[0]->contentDetails->duration;

            if (preg_match('/PT((\d+)H)?((\d+)M)?((\d+)S)?/', $videoDuration, $matches)) {
                $hours = isset($matches[2]) ? (int) $matches[2] : 0;
                $minutes = isset($matches[4]) ? (int) $matches[4] : 0;
                $seconds = isset($matches[6]) ? (int) $matches[6] : 0;

                return $hours * 3600 + $minutes * 60 + $seconds;
            }
        }

        return null;
    }

    /**
     * Get the duration of a Vimeo video.
     *
     * @param  string  $url
     * @return int|null
     */
    private function getVimeoVideoDuration(string $url)
    {
        $id = $this->vimeoId($url);

        if (!$id) {
            return null;
        }

        $response = Http::get("https://vimeo.com/api/oembed.json?url=https://vimeo.com/{$id}");

        $videoDuration = json_decode($response->body())->duration;

        return $videoDuration;
    }

    private function youtubeId(string $url)
    {
        $videoId = null;
        if (strpos($url, 'youtu.be/') !== false) {
            $videoId = substr($url, strrpos($url, '/') + 1);
        } elseif (strpos($url, 'youtube.com/watch?v=') !== false) {
            parse_str(parse_url($url, PHP_URL_QUERY), $query);
            $videoId = $query['v'] ?? null;
        }
        return $videoId;
    }

    private function vimeoId(string $url)
    {
        $videoId = substr(parse_url($url, PHP_URL_PATH), 1);
        return $videoId;
    }
}
