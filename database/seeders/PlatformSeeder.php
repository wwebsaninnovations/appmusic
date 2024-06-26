<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = [
            ['name' => '7digital', 'user_id' => 1],
            ['name' => 'Adaptr', 'user_id' => 1],
            ['name' => 'Amazon', 'user_id' => 1],
            ['name' => 'Amazon Music', 'user_id' => 1],
            ['name' => 'Amazon Prime Music', 'user_id' => 1],
            ['name' => 'Anghami Music', 'user_id' => 1],
            ['name' => 'Apple iTunes', 'user_id' => 1],
            ['name' => 'Apple Music', 'user_id' => 1],
            ['name' => 'AWA Music', 'user_id' => 1],
            ['name' => 'Bandcamp', 'user_id' => 1],
            ['name' => 'Beatport', 'user_id' => 1],
            ['name' => 'Beatsource', 'user_id' => 1],
            ['name' => 'Claro Música', 'user_id' => 1],
            ['name' => 'Deezer', 'user_id' => 1],
            ['name' => 'Facebook', 'user_id' => 1],
            ['name' => 'Instagram', 'user_id' => 1],
            ['name' => 'iTunes Match', 'user_id' => 1],
            ['name' => 'iTunes Radio', 'user_id' => 1],
            ['name' => 'Juno Download', 'user_id' => 1],
            ['name' => 'KuGou', 'user_id' => 1],
            ['name' => 'KuWo', 'user_id' => 1],
            ['name' => 'Pandora', 'user_id' => 1],
            ['name' => 'Peloton', 'user_id' => 1],
            ['name' => 'QQMusic', 'user_id' => 1],
            ['name' => 'Resso', 'user_id' => 1],
            ['name' => 'Shazam', 'user_id' => 1],
            ['name' => 'SoundCloud', 'user_id' => 1],
            ['name' => 'Spotify', 'user_id' => 1],
            ['name' => 'Tidal', 'user_id' => 1],
            ['name' => 'TikTok', 'user_id' => 1],
            ['name' => 'United Media Agency', 'user_id' => 1],
            ['name' => 'Yandex', 'user_id' => 1],
            ['name' => 'YouTube Content ID', 'user_id' => 1],
            ['name' => 'YouTube Music', 'user_id' => 1],
        ];

        DB::table('platforms')->insert($platforms);
    }
}
