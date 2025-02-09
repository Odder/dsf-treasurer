<?php

namespace Database\Seeders;

use App\Models\ContactInfo;
use App\Models\RegionalAssociation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactInfo::create([
            'id' => '9e22614e-2e7e-4df5-8af9-4b6f3f8acad1',
            'name' => 'Thor Asmund',
            'address' => '--',
            'email' => 'thorasmund@gmail.com',
            'wca_id' => '2017ASMU01',
        ]);
        ContactInfo::create([
            'id' => '9e22614e-3170-4c66-9e83-c5c749377999',
            'name' => 'Callum Goodyear',
            'address' => '--',
            'email' => 'cgoodyear@worldcubeassociation.org',
            'wca_id' => '2012GOOD02',
        ]);
        ContactInfo::create([
            'id' => '9e22614e-32e9-41a4-9040-23830d677189',
            'name' => 'Henrik Aagaard',
            'address' => '--',
            'email' => 'henrikthedane@gmail.com',
            'wca_id' => '2006BUUS01',
        ]);
        ContactInfo::create([
            'id' => '9e22614e-3463-4665-9701-4d42756c6cfd',
            'name' => 'Fredrik Trondhjem',
            'address' => '--',
            'email' => 'trondhat@live.com',
            'wca_id' => '2011TRON01',
        ]);
        ContactInfo::create([
            'id' => '9e22614e-35d4-4b57-8475-522daff361ab',
            'name' => 'Daniel Egdal',
            'address' => '--',
            'email' => 'daniel.v.egdal@gmail.com',
            'wca_id' => '2013EGDA01',
        ]);
        ContactInfo::create([
            'id' => '9e22614e-37c3-4339-8ac8-d69fbb89d6b2',
            'name' => 'Christian Smedegaard',
            'address' => '--',
            'email' => 'cbsmedegaard@gmail.com',
            'wca_id' => '2015SMED01',
        ]);
        ContactInfo::create([
            'id' => '9e22614e-3a50-42bf-908c-7cb69999d2da',
            'name' => 'Daniel Hermansen',
            'address' => '--',
            'email' => 'dhermansen@worldcubeassociation.org',
            'wca_id' => '2017HERM01',
        ]);
        ContactInfo::create([
            'id' => '9e22660b-896f-458c-a9f9-fdedd1bf239c',
            'name' => 'Oscar Andersen',
            'address' => '--',
            'email' => 'oscarrothandersen@gmail.com',
            'wca_id' => '2008ANDE02',
        ]);
        ContactInfo::create([
            'id' => '9e22660b-8de7-430b-86e7-abcf9bc51799',
            'name' => 'Victor Glyrskov',
            'address' => '--',
            'email' => 'vglyrskov@gmail.com',
            'wca_id' => '2014GLYR01',
        ]);
        ContactInfo::create([
            'id' => '9e22660b-8fbf-4268-bb0c-db4b7d46e387',
            'name' => 'Maica Birch',
            'address' => '--',
            'email' => '---',
            'wca_id' => '2021SJOS01',
        ]);
        ContactInfo::create([
            'id' => '9e22660b-92ec-4915-afcc-b01d56894ce0',
            'name' => 'Daniel Myjak',
            'address' => '--',
            'email' => '---',
            'wca_id' => '9999XXXX99',
        ]);
    }
}
