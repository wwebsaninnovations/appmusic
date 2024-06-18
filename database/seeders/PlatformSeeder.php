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
            ['name' => '7digital'],
            ['name' => 'Adaptr'],
            ['name' => 'Amazon'],
            ['name' => 'Amazon Music'],
            ['name' => 'Amazon Prime Music'],
            ['name' => 'Anghami Music'],
            ['name' => 'Apple iTunes'],
            ['name' => 'Apple Music'],
            ['name' => 'AWA Music'],
            ['name' => 'Bandcamp'],
            ['name' => 'Beatport'],
            ['name' => 'Beatsource'],
            ['name' => 'Claro Música'],
            ['name' => 'Deezer'],
            ['name' => 'Facebook'],
            ['name' => 'Instagram'],
            ['name' => 'iTunes Match'],
            ['name' => 'iTunes Radio'],
            ['name' => 'Juno Download'],
            ['name' => 'KuGou'],
            ['name' => 'KuWo'],
            ['name' => 'Pandora'],
            ['name' => 'Peloton'],
            ['name' => 'QQMusic'],
            ['name' => 'Resso'],
            ['name' => 'Shazam'],
            ['name' => 'SoundCloud'],
            ['name' => 'Spotify'],
            ['name' => 'Tidal'],
            ['name' => 'TikTok'],
            ['name' => 'United Media Agency'],
            ['name' => 'Yandex'],
            ['name' => 'YouTube Content ID'],
            ['name' => 'YouTube Music'],
        ];

        DB::table('platforms')->insert($platforms);
    }
}
