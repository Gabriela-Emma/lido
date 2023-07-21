<?php

namespace App\Jobs;

use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

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
        if (!$this->proposal->quick_pitch) {
            return;
        }

        $videoUrl = $this->proposal->quick_pitch;

        // Check if it's a YouTube or Vimeo URL
        if (strpos($videoUrl, 'youtube.com') !== false || strpos($videoUrl, 'youtu.be') !== false) {
            $videoDuration = $this->getYoutubeVideoDuration($videoUrl);
        } elseif (strpos($videoUrl, 'vimeo.com') !== false) {
            $videoDuration = $this->getVimeoVideoDuration($videoUrl);
        } else {
            $videoDuration = null;
        }

        $this->proposal->saveMeta('quickpitch_length', $videoDuration, $this->proposal, true);
    }

    /**
     * Get the duration of a YouTube video.
     *
     * @param  string  $url
     * @return int|null
     */
    private function getYoutubeVideoDuration(string $url)
    {
        // Extract the video ID from the URL
        parse_str(parse_url($url, PHP_URL_QUERY), $query);
        $videoId = $query['v'] ?? null;

        if (!$videoId) {
            return null;
        }

        // Make an API request to get video information from YouTube
        $response = Http::get("https://www.googleapis.com/youtube/v3/videos", [
            'id' => $videoId,
            'part' => 'contentDetails',
            'key' => env('YOUTUBE_API_KEY'),
        ]);

        $videoDuration = json_decode($response->body())->items[0]->contentDetails->duration;

        if (preg_match('/PT((\d+)H)?((\d+)M)?((\d+)S)?/', $videoDuration, $matches)) {
            $hours = isset($matches[2]) ? (int) $matches[2] : 0;
            $minutes = isset($matches[4]) ? (int) $matches[4] : 0;
            $seconds = isset($matches[6]) ? (int) $matches[6] : 0;

            return $hours * 3600 + $minutes * 60 + $seconds;
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
        $videoId = substr(parse_url($url, PHP_URL_PATH), 1);

        if (!$videoId) {
            return null;
        }

        $response = Http::get("https://vimeo.com/api/oembed.json?url=https://vimeo.com/{$videoId}");

        $videoDuration = json_decode($response->body())->duration;

        return $videoDuration;
    }
}
