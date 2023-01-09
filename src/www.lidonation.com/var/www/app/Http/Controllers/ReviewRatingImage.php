<?php

namespace App\Http\Controllers;

use App\Invokables\GenerateModelRatingImage;
use App\Models\Review;
use Illuminate\Support\Facades\Response;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class ReviewRatingImage extends Controller
{
    /**
     * @throws CouldNotTakeBrowsershot
     */
    protected function show(Review $review): \Illuminate\Http\Response
    {
        $image = ((new GenerateModelRatingImage)($review))
            ->windowSize(580, 1200);
        $image = base64_decode(str_replace('data:image/png;base64,', '', $image->base64Screenshot()));
        $response = Response::make($image, 200);
        $response->header('Content-Type', 'image/png');

        return $response;
    }
}
