<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Certs;

class presentationSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userList = [
            ['id' => '1', 'name' => "Rafiq Naqhiuddin", 'username' => 'rafiq991008', 'email' => 'mohdrafiq991008@hotmail.com', 'password' => Hash::make('qweasdrf'), 'operator' => '1',],
            ['id' => '2', 'name' => "Staff 1", 'username' => 'staff1', 'email' => 'staff@one', 'password' => Hash::make('12345678'), 'operator' => '0',],
            ['id' => '3', 'name' => "Operator 1", 'username' => 'oprt1', 'email' => 'oprt@one', 'password' => Hash::make('87654321'), 'operator' => '1',],
            ['id' => '4', 'name' => "CutieMegane", 'username' => 'cutiemegane00', 'email' => 'hell@lo', 'password' => Hash::make('99100810'), 'operator' => '0',],
            ['id' => '5', 'name' => "Staff 2", 'username' => 'staff2', 'email' => '', 'password' => Hash::make('ggwpthispassword'), 'operator' => '0',],
        ];

        //Shove all stock images to public
        Storage::copy('stok/stok1.png', 'public/images/lzDyTv0GzZwkBiJxEWNaLYnlYbpSIVh8UbRVejjx.png');
        Storage::copy('stok/stok2.png', 'public/images/287GNe2XeJ1QP3ezNaYujxkkztPFl5FSRz148Shw.png');
        Storage::copy('stok/stok3.png', 'public/images/IRB9797ftQpxCGG0ciGwU3HjTHfL6OiZT3PD8TyJ.png');
        Storage::copy('stok/stok4.png', 'public/images/cExFM7ORkegNk15FNfBnjsclahVANKlETZzyLnee.png');
        Storage::copy('stok/stok5.png', 'public/images/vAKvwroXc8A4NZpPd4J8NgcwK2Hw9AbD7QFqlJGL.png');

        $certList = [
            ['id' => '2e2e58a0-ff8f-4f09-adbb-a85bd5ff4500', 'name' => 'Mohammad Rafiq Naqhiuddin bin Mohd Ridza', 'details' => 'Valued contribution to an company.', 'created_by' => 'Rafiq Naqhiuddin', 'hash' => 'b80d92c322873ffca4c8132509e815a930216fba0a77b738ca3c8c13090188b6', 'imagepath' => storage_path('app/public/images/lzDyTv0GzZwkBiJxEWNaLYnlYbpSIVh8UbRVejjx.png'), 'stego_mark' => 'uSUBytxH1HgCwFZxqRBVKitCX', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'ea1f8d18-b125-4323-b8d9-3e00f830d5ab', 'name' => 'Mohd Ali bin Mohd Isa', 'details' => 'Valued contribution to an company.', 'created_by' => 'Rafiq Naqhiuddin', 'hash' => 'b0014acd8995ee7ccd12918c8ff7f13f2306c30d38544e94d61994978fc037fe', 'imagepath' => storage_path('app/public/images/287GNe2XeJ1QP3ezNaYujxkkztPFl5FSRz148Shw.png'), 'stego_mark' => 'x75PzWvfZv3ZGSiLhbLVQVMQo', 'created_at' => now(), 'updated_at' => now()],
            ['id' => '03e75a5f-cfd2-46db-99d0-0866a7486a49', 'name' => 'Shahadan bin Saad', 'details' => 'Valued contribution to an company.', 'created_by' => 'Rafiq Naqhiuddin', 'hash' => 'e585be751ce4244a273f7e510d2883e183ec2c8d32098496eb43ef3d70374034', 'imagepath' => storage_path('app/public/images/IRB9797ftQpxCGG0ciGwU3HjTHfL6OiZT3PD8TyJ.png'), 'stego_mark' => 'zuh4Xu3IUOTpc77AWTe9EgxO4', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'b0dd3876-0b70-4234-991b-293ad758fa1a', 'name' => 'Ali Abu Bakar', 'details' => 'An event.', 'created_by' => 'CutieMegane', 'hash' => '924323ce8de924b85cf08aaf6266e767d216c671afff98878e19bbb38420cf4c', 'imagepath' => storage_path('app/public/images/cExFM7ORkegNk15FNfBnjsclahVANKlETZzyLnee.png'), 'stego_mark' => 'Z8ggw28bwLVCVsdJOTDWwVCdq', 'created_at' => now(), 'updated_at' => now()],
            ['id' => '50e93649-33f4-4d52-8410-bb90f16f8e08', 'name' => 'Euphyllia Magenta', 'details' => 'An event.', 'created_by' => 'CutieMegane', 'hash' => '3e7608645f91ce05ead01bf8fc44e2f3e4fbebf77eea72ae1d29935dc9da65ed', 'imagepath' => storage_path('app/public/images/vAKvwroXc8A4NZpPd4J8NgcwK2Hw9AbD7QFqlJGL.png'), 'stego_mark' => 'AMtG68Uom1Hm474n5q49CViME', 'created_at' => now(), 'updated_at' => now()],
        ];
      
        foreach ($userList as $ul) User::firstOrCreate($ul);
        foreach ($certList as $cl) Certs::firstOrCreate($cl);
    }
}
