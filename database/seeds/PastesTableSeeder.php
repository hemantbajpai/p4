<?php

use Illuminate\Database\Seeder;
use App\Paste;

class PastesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $pastes = [
            ['2020-01-05', 'Hello World'],
            ['2020-02-06', 'These are sample pastes'],
            ['2020-03-07', 'Bye']
        ];

        $count = count($pastes);

        foreach ($pastes as $key => $pasteData) {
            $paste = new Paste();

            $paste->created_at = Carbon\Carbon::now()->subDays($count)->toDateTimeString();
            $paste->updated_at = Carbon\Carbon::now()->subDays($count)->toDateTimeString();
            $paste->date = $pasteData[0];
            $paste->text = $pasteData[1];
            $paste->user_id = 1;
            $paste->save();
            $count--;
        }
    }
}
