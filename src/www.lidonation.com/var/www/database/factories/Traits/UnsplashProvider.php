<?php

namespace Database\Factories\Traits;

use Salopot\ImageGenerator\ImageProvider;
use Salopot\ImageGenerator\ImageSources\Remote\UnsplashSource;

trait UnsplashProvider
{
    public function getImageUrl()
    {
        //            $this->faker->addProvider(new PicsumPhotosProvider($this->faker));
        //            $url = $this->faker->imageUrl(2048,2048);

        //            $imageProvider->addImageSource(new \Salopot\ImageGenerator\ImageSources\Local\SolidColorSource($imageProvider));
        //            $imageProvider->addImageSource(new \Salopot\ImageGenerator\ImageSources\Remote\LoremPixelSource($imageProvider));
        return $this->generateImage()->getDataUrl();
    }

    public function getFilePath()
    {
        return $this->generateImage()->getFilePath();
    }

    protected function generateImage()
    {
        $imageProvider = new ImageProvider($this->faker);
        $imageProvider->addImageSource(new UnsplashSource($imageProvider));
        $this->faker->addProvider($imageProvider);

        return $this->faker->imageGenerator(2048, 2048, null, 'Unsplash');
    }

    /**
     * @throws \Exception
     */
    public function getRandomImageLink(int $width, int $height): string
    {
        $random = random_int(11111, 99999);

        return "https://source.unsplash.com/random/{$width}x{$height}?sig={$random}";
    }
}
