<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicinesTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Analgesics',
            'Anesthetics',
            'Anti-anxiety medications',
            'Antiarrhythmics',
            'Anticoagulants',
            'Anticonvulsants',
            'Antiemetics',
            'Antifungal agents',
            'Antimalarial agents',
            'Antineoplastic agents',
            'Antitussives',
            'Bronchodilators',
            'Calcium channel blockers',
            'Cardiac glycosides',
            'Cholinergics',
            'Corticosteroids',
            'Cough and cold preparations',
            'Decongestants',
            'Dermatologicals',
            'Diagnostic agents',
            'Digestive system agents',
            'Diuretics',
            'Emergency contraception',
            'Gastrointestinal agents',
            'Hematopoietic agents',
            'Hormonal contraceptives',
            'Immunomodulators',
            'Laxatives',
            'Muscle relaxants',
            'Narcotic analgesics',
            'Nasal preparations',
            'Neurological agents',
            'Non-narcotic analgesics',
            'Ophthalmic preparations',
            'Osteoporosis agents',
            'Otic preparations',
            'Radiocontrast agents',
            'Respiratory system agents',
            'Skeletal muscle relaxants',
            'Thyroid agents',
            'Topical agents',
            'Urological agents',
        ];

        $medicinesTypes = [
            'Tablets',
            'Capsules',
            'Syrups',
            'Injections',
            'Creams',
            'Gels',
            'Sprays',
            'Patches',
            'Drops',
            'Lozenges',
            'Powders',
            'Suppositories',
            'Other',
        ];
        foreach ($medicinesTypes as $medicineType) {
            DB::table('medicines_types')->insert([
                'name' => $medicineType,
            ]);
        }
    }
}
