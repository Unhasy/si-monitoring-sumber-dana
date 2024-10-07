<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\MasterSumberDana;
use App\Models\MasterNomenklatur;
use App\Models\MasterDasarHukum;
use File;






class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::truncate();
        User::factory()->create([
            'name' => 'Mas Admin',
            'email' => 'admin@example.com',
            'role' => 'ADMIN',
            'password' => 'password123'
        ]);

        // dasar hukum
        MasterDasarHukum::truncate();
        $json = File::get("database/seeders/dasar_hukum.json");
        $hukums = json_decode($json);
        foreach ($hukums as $key => $value) {
            MasterDasarHukum::create([
                "peraturan"=>  $value->peraturan,
                "user_pembuat"=>1,
            ]);
        }
        // end dasar hukum

        // sumber dana
        MasterSumberDana::truncate();
        $json = File::get("database/seeders/sumber_dana.json");
        $danas = json_decode($json);
        foreach ($danas as $key => $value) {
            MasterSumberDana::create([
                "kode_rekening" => $value->kode_dana,
                "keterangan" => $value->sumber_dana,
                "user_pembuat" => 1
            ]);
        }
        // end sumber dana

        // nomenklatur
        MasterNomenklatur::truncate();
        $json = File::get("database/seeders/nomenklatur.json");
        $nomenklaturs = json_decode($json);
        foreach ($nomenklaturs as $key => $value) {
            MasterNomenklatur::create([
                "master_dasar_hukum_id"=>1,
                "kategori"=>  $value->kategori,
                "kode_rekening"=>  $value->kode_rekening,
                "nomenklatur"=>  $value->nomenklatur,
                "user_pembuat"=>1,
            ]);
        }
        // end nomenklatur
    }
}
