<?php

namespace Database\Seeders;

use App\Models\RegionalAssociation;
use Illuminate\Database\Seeder;

class RegionalAssociationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RegionalAssociation::create([
            'name' => 'Dansk Speedcubing Forening',
            'address' => 'Odense',
            'wcif_identifier' => 'DSF',
            'chairman_contact_id' => '9e22614e-32e9-41a4-9040-23830d677189',
            'treasurer_contact_id' => '9e22660b-896f-458c-a9f9-fdedd1bf239c',
        ]);
        RegionalAssociation::create([
            'name' => 'Roskilde Speedcubing Forening',
            'address' => 'Roskilde',
            'wcif_identifier' => 'Roskilde',
            'chairman_contact_id' => '9e22614e-2e7e-4df5-8af9-4b6f3f8acad1',
            'treasurer_contact_id' => '9e22614e-3170-4c66-9e83-c5c749377999',
        ]);
        RegionalAssociation::create([
            'name' => 'Furesø Speedcubing Forening',
            'address' => 'Furesø',
            'wcif_identifier' => 'Furesø',
            'chairman_contact_id' => '9e22660b-8de7-430b-86e7-abcf9bc51799',
            'treasurer_contact_id' => '9e22614e-3170-4c66-9e83-c5c749377999',
        ]);
        RegionalAssociation::create([
            'name' => 'Fyns Speedcubing Forening',
            'address' => 'Odense',
            'wcif_identifier' => 'Fyn',
            'chairman_contact_id' => '9e22614e-32e9-41a4-9040-23830d677189',
            'treasurer_contact_id' => '9e22614e-2e7e-4df5-8af9-4b6f3f8acad1',
        ]);
        RegionalAssociation::create([
            'name' => 'Hvidovre Speedcubing Forening',
            'address' => 'Hvidovre',
            'wcif_identifier' => 'Hvidovre',
            'chairman_contact_id' => '9e22614e-35d4-4b57-8475-522daff361ab',
            'treasurer_contact_id' => '9e22614e-3463-4665-9701-4d42756c6cfd',
        ]);
        RegionalAssociation::create([
            'name' => 'Speedcubing Aarhus',
            'address' => 'Aarhus',
            'wcif_identifier' => 'Aarhus',
            'chairman_contact_id' => '9e22614e-37c3-4339-8ac8-d69fbb89d6b2',
            'treasurer_contact_id' => '9e22614e-3a50-42bf-908c-7cb69999d2da',
        ]);
        RegionalAssociation::create([
            'name' => 'Speedcubing Herning',
            'address' => 'Herning',
            'wcif_identifier' => 'Herning',
            'chairman_contact_id' => '9e22660b-8fbf-4268-bb0c-db4b7d46e387',
            'treasurer_contact_id' => '9e22614e-2e7e-4df5-8af9-4b6f3f8acad1',
        ]);
        RegionalAssociation::create([
            'name' => 'Ishøj Speedcubing Forening',
            'address' => 'Ishøj',
            'wcif_identifier' => 'Ishøj',
            'chairman_contact_id' => '9e22614e-3170-4c66-9e83-c5c749377999',
            'treasurer_contact_id' => '9e22660b-92ec-4915-afcc-b01d56894ce0',
        ]);
    }
}
