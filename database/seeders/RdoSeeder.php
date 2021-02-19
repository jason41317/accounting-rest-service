<?php

namespace Database\Seeders;

use App\Models\Rdo;
use Illuminate\Database\Seeder;

class RdoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rdos = [
            ['name' => "001"],
            ['name' => "002"],
            ['name' => "003"],
            ['name' => "004"],
            ['name' => "005"],
            ['name' => "006"],
            ['name' => "007"],
            ['name' => "008"],
            ['name' => "009"],
            ['name' => "010"],
            ['name' => "011"],
            ['name' => "012"],
            ['name' => "013"],
            ['name' => "014"],
            ['name' => "015"],
            ['name' => "016"],
            ['name' => "17A"],
            ['name' => "17B"],
            ['name' => "018"],
            ['name' => "019"],
            ['name' => "020"],
            ['name' => "21A"],
            ['name' => "21B"],
            ['name' => "21C"],
            ['name' => "022"],
            ['name' => "23A"],
            ['name' => "23B"],
            ['name' => "024"],
            ['name' => "25A"],
            ['name' => "25B"],
            ['name' => "026"],
            ['name' => "027"],
            ['name' => "028"],
            ['name' => "029"],
            ['name' => "030"],
            ['name' => "031"],
            ['name' => "032"],
            ['name' => "033"],
            ['name' => "034"],
            ['name' => "035"],
            ['name' => "036"],
            ['name' => "037"],
            ['name' => "038"],
            ['name' => "039"],
            ['name' => "040"],
            ['name' => "041"],
            ['name' => "042"],
            ['name' => "043"],
            ['name' => "044"],
            ['name' => "045"],
            ['name' => "046"],
            ['name' => "047"],
            ['name' => "048"],
            ['name' => "049"],
            ['name' => "050"],
            ['name' => "051"],
            ['name' => "052"],
            ['name' => "53A"],
            ['name' => "53B"],
            ['name' => "54A"],
            ['name' => "54B"],
            ['name' => "055"],
            ['name' => "056"],
            ['name' => "057"],
            ['name' => "058"],
            ['name' => "059"],
            ['name' => "060"],
            ['name' => "061"],
            ['name' => "062"],
            ['name' => "063"],
            ['name' => "064"],
            ['name' => "065"],
            ['name' => "066"],
            ['name' => "067"],
            ['name' => "068"],
            ['name' => "069"],
            ['name' => "070"],
            ['name' => "071"],
            ['name' => "072"],
            ['name' => "073"],
            ['name' => "074"],
            ['name' => "075"],
            ['name' => "076"],
            ['name' => "077"],
            ['name' => "078"],
            ['name' => "079"],
            ['name' => "080"],
            ['name' => "081"],
            ['name' => "082"],
            ['name' => "083"],
            ['name' => "084"],
            ['name' => "085"],
            ['name' => "086"],
            ['name' => "087"],
            ['name' => "088"],
            ['name' => "089"],
            ['name' => "090"],
            ['name' => "091"],
            ['name' => "092"],
            ['name' => "093A"],
            ['name' => "093B"],
            ['name' => "094"],
            ['name' => "095"],
            ['name' => "096"],
            ['name' => "097"],
            ['name' => "098"],
            ['name' => "099"],
            ['name' => "100"],
            ['name' => "101"],
            ['name' => "102"],
            ['name' => "103"],
            ['name' => "104"],
            ['name' => "105"],
            ['name' => "106"],
            ['name' => "107"],
            ['name' => "108"],
            ['name' => "109"],
            ['name' => "110"],
            ['name' => "111"],
            ['name' => "112"],
            ['name' => "113A"],
            ['name' => "113B"],
            ['name' => "114"],
            ['name' => "115"],
        ];

        foreach ($rdos as $rdo) {
            Rdo::create($rdo);
        }
    }
}
