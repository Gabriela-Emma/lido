<?php

use App\Models\Category;
use App\Models\ModelCategory;
use App\Models\News;
use App\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    protected $trackedChanges = [
        'category_created' => false,
        'updated_ids' => []
    ];
    protected $directory = 'news_model_deprecation_tracker';
    protected $fileName = 'news_updated_with_news-and-interviews_category.json';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // check if category "News and Interviews" exists else create
        $category = Category::where('slug', 'news-and-interviews')->first();

        if (empty($category)) {
            $category = new Category();
            $category->title = "news and interviews";
            $category->meta_title = "";
            $category->slug = 'news-and-interviews';
            $category->content = '';

            $category->save();

            $this->trackedChanges['category_created'] = true; // assign true to trackedChanges on new category creation
        } else {
            $this->trackedChanges['category_created'] = false; // assign false if category already exists
        }

        // assign every existing news model "news and interviews" category
        $newsColl = Post::where('type', News::class)->get();
        $newsColl->each(function($news) use($category){
            $modelCategory = ModelCategory::where('model_type', News::class)
                ->where('model_id', $news->id)
                ->where('category_id', $category->id)
                ->first();

                
            // if news don't have the category attached then attach it and track the changed id
            if (empty($modelCategory)) {
                $news->categories()->attach([
                    $category->id => [
                        'model_id' => $news->id,
                        'model_type' => News::class,
                        ] 
                    ]);

                array_push($this->trackedChanges['updated_ids'], $news->id);
            }
        });

       $fileStoragePath = $this->directory.'/'.$this->fileName;
       $fileFullPath = Storage::path($fileStoragePath);
    
       // if a tracking file already exists then delete it
       $fileExists = Storage::exists($fileStoragePath);
       if ($fileExists) {
           File::delete($fileFullPath);
        }

        // Write JSON trackedChanges to a file
        $jsonData = json_encode($this->trackedChanges);
        Storage::put($fileStoragePath, $jsonData);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $fileStoragePath = $this->directory.'/'.$this->fileName;

        // fetch the trackedChanges from the saved file
        $trackedData = Storage::get($fileStoragePath);
        $trackedJsonData = json_decode($trackedData);

        // delete ModelCategories that were updated
        $category = Category::where('slug', 'news-and-interviews')->get()[0];
        if ($trackedJsonData->updated_id ?? false) {
            foreach ($trackedJsonData->updated_ids as $key => $value) {
                $mt = ModelCategory::where('category_id', $category->id)
                    ->where('model_id', $value)
                    ->where('model_type', News::class)
                    ->first();

                $mt->forceDelete();
            }
            // if the category instance never existed prior to this migration we therefore delete it
            if ($trackedJsonData->category_created) {
                $category->forceDelete();
            }
    
            // delete the directory where we are tracking these changes
            Storage::deleteDirectory($this->directory);
        }
    }
};
