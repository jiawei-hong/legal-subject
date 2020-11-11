<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Category;
use App\Question;
use App\Option;
use App\Answer;
use App\Classname;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */


    public function run()
    {
        $dataset = [
            '法律常識測驗' => 'legal.txt'
        ];

       foreach ($dataset as $category => $filename) {
           $category = Category::create(['name' => $category]);
       }
    //        $raw_data = file_get_contents(__DIR__ . "/../data/{$filename}");
    //        $questions = array_filter(preg_split('/\r\n|\r|\n/', $raw_data), function ($d) {
    //            return trim($d) != '';
    //        });
    //        foreach ($questions as $key => $question) {
    //            $splitData = explode(',', $question);

    //            $questionResult = Question::create([
    //                'category_id' => $category->id,
    //                'question' => $splitData[2]
    //            ]);

    //            $options = [];

    //            for ($i = 3; $i < count($splitData); $i++) {
    //                array_push($options, Option::create(['question_id' => $questionResult->id, 'value' => $splitData[$i]]));
    //            }

    //            foreach ($options as $index => $option) {
    //                if (chr(65 + $index) == $splitData[1]) {
    //                    Answer::create([
    //                        'question_id' => $questionResult->id,
    //                        'option_id' => $option->id
    //                    ]);
    //                }
    //            }
    //        }

       Classname::create(['name' => '管理員']);
       Classname::create(['name' => '測試員']);
       
       User::create([
           'username' => '管理員',
           'account' => 'admin',
           'password' => Hash::make('1234'),
           'permission' => '管理員',
           'class_id' => 1,
           'api_token' => Str::random(80)
       ]);

       User::create([
           'username' => '測試員',
           'account' => 'test',
           'password' => Hash::make('1234'),
           'class_id' => 2,
           'api_token' => Str::random(80)
       ]);

       User::create([
           'username' => '測試員2',
           'account' => 'test2',
           'password' => Hash::make('1234'),
           'class_id' => 2,
           'api_token' => Str::random(80)
       ]);

       User::create([
           'username' => '測試員3',
           'account' => 'test3',
           'password' => Hash::make('1234'),
           'class_id' => 2,
           'api_token' => Str::random(80)
       ]);
    }
}
