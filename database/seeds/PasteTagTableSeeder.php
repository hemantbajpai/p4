<?php

use Illuminate\Database\Seeder;
use App\Paste;
use App\Tag;

class PasteTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $pastes = [
            'Hello World' => ['classic', 'research', 'comedy', 'universe'],
            'These are sample pastes' => ['classic', 'science', 'comedy', 'spirituality'],
            'Bye' => ['classic', 'technology', 'universe', 'nonfiction']
        ];

        # Now loop through the above array, creating a new pivot for each paste to tag
        foreach ($pastes as $text => $tags) {
            # First get the paste
            $paste = Paste::where('text', 'like', $text)->first();

            # Now loop through each tag for this paste, adding the pivot
            foreach ($tags as $tagName) {
                $tag = Tag::where('name', 'LIKE', $tagName)->first();

                # Connect this tag to this paste
                $paste->tags()->save($tag);
            }
        }
    }
}
