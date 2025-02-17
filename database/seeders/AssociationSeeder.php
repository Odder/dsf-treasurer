<?php

namespace Database\Seeders;

use App\Enums\AssociationRole;
use App\Models\RegionalAssociation;
use Illuminate\Database\Seeder;

class AssociationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RegionalAssociation::where('wcif_identifier', 'DSF')->first()->members()->sync([
            '9e22614e-32e9-41a4-9040-23830d677189' => ['role' => AssociationRole::CHAIRMAN],
            '9e22660b-896f-458c-a9f9-fdedd1bf239c' => ['role' => AssociationRole::TREASURER],
        ]);
        RegionalAssociation::where('wcif_identifier', 'Roskilde')->first()->members()->sync([
            '9e22614e-2e7e-4df5-8af9-4b6f3f8acad1' => ['role' => AssociationRole::CHAIRMAN],
            '9e22614e-3170-4c66-9e83-c5c749377999' => ['role' => AssociationRole::TREASURER],
        ]);
        RegionalAssociation::where('wcif_identifier', 'Furesø')->first()->members()->sync([
            '9e22660b-8de7-430b-86e7-abcf9bc51799' => ['role' => AssociationRole::CHAIRMAN],
            '9e22614e-3170-4c66-9e83-c5c749377999' => ['role' => AssociationRole::TREASURER],
        ]);
        RegionalAssociation::where('wcif_identifier', 'Furesø')->first()->members()->sync([
            '9e22660b-8de7-430b-86e7-abcf9bc51799' => ['role' => AssociationRole::CHAIRMAN],
            '9e22614e-3170-4c66-9e83-c5c749377999' => ['role' => AssociationRole::TREASURER],
        ]);
        RegionalAssociation::where('wcif_identifier', 'Fyn')->first()->members()->sync([
            '9e22614e-32e9-41a4-9040-23830d677189' => ['role' => AssociationRole::CHAIRMAN],
            '9e22614e-2e7e-4df5-8af9-4b6f3f8acad1' => ['role' => AssociationRole::TREASURER],
        ]);
        RegionalAssociation::where('wcif_identifier', 'Hvidovre')->first()->members()->sync([
            '9e22614e-35d4-4b57-8475-522daff361ab' => ['role' => AssociationRole::CHAIRMAN],
            '9e22614e-3463-4665-9701-4d42756c6cfd' => ['role' => AssociationRole::TREASURER],
        ]);
        RegionalAssociation::where('wcif_identifier', 'Aarhus')->first()->members()->sync([
            '9e22614e-37c3-4339-8ac8-d69fbb89d6b2' => ['role' => AssociationRole::CHAIRMAN],
            '9e22614e-3a50-42bf-908c-7cb69999d2da' => ['role' => AssociationRole::TREASURER],
        ]);
        RegionalAssociation::where('wcif_identifier', 'Herning')->first()->members()->sync([
            '9e22660b-8fbf-4268-bb0c-db4b7d46e387' => ['role' => AssociationRole::CHAIRMAN],
            '9e22614e-2e7e-4df5-8af9-4b6f3f8acad1' => ['role' => AssociationRole::TREASURER],
        ]);
        RegionalAssociation::where('wcif_identifier', 'Ishøj')->first()->members()->sync([
            '9e22614e-3170-4c66-9e83-c5c749377999' => ['role' => AssociationRole::CHAIRMAN],
            '9e22660b-92ec-4915-afcc-b01d56894ce0' => ['role' => AssociationRole::TREASURER],
        ]);
    }
}
