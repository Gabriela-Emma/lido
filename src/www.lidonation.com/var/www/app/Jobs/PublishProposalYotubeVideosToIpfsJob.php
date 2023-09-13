<?php

namespace App\Jobs;

use App\Models\Meta;
use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PublishProposalYotubeVideosToIpfsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected Proposal $proposal)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ((bool) $this->proposal->quickpitch && $this->proposal->is_ideafest_proposal) {
            $videoUrl = $this->proposal->videos->where('key', 'youtube')->first()->content; //only once on ideafest

            $directory = 'youtube_videos';
            $outputDirectory = storage_path($directory);
            $fileName = $this->extractVideoId($videoUrl).'.mp4';
            $videoFilePath = $outputDirectory.'/'.$fileName;

            // Path to the Python script
            $pythonScriptPath = app_path('Console/Scripts/youtube-downloader.py');

            // Execute the Python script
            exec("python3 {$pythonScriptPath} {$videoUrl} {$outputDirectory} {$fileName}", $output, $exitCode);

            // Check if the execution was successful
            if ($exitCode === 0) {
                $videoData = file_get_contents($videoFilePath);
                $fileContent = base64_encode($videoData);
                $data = compact('fileName', 'fileContent');

                $res = Http::post(
                    config('cardano.lucidEndpoint').'/ipfs/upload',
                    $data
                )->throw();

                if ($res->successful()) {
                    $r = $res->object();

                    foreach ($r->ipfsPath as $item) {
                        $this->saveMeta($item->path);
                        $this->deleteVideo($videoFilePath);
                    }
                }

            } else {
                Log::info('Video could not be downloaded');
            }
        }
    }

    protected function extractVideoId(string $url)
    {

        // Parse the URL to get the query string
        $query = parse_url($url, PHP_URL_QUERY);

        // Parse the query string to get the parameters
        parse_str($query, $params);

        // Create a request instance with the extracted parameters
        $request = new Request($params);

        // Now, you can access the parameters using the request() helper or the request object
        $videoIdParam = $request->input('v');

        return $videoIdParam;
    }

    protected function deleteVideo($filePath)
    {
        unlink($filePath);
    }

    protected function saveMeta($ipfsPath)
    {
        //meta from response
        $pMeta = new Meta();
        $pMeta->model_type = Proposal::class;
        $pMeta->model_id = $this->proposal->id;
        $pMeta->key = 'ideafest_video_ipfs_cid';
        $pMeta->content = $ipfsPath;

        $pMeta->save();
    }
}
