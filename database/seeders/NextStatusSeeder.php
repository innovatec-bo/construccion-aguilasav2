<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NextStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            //design
            ['parent_status_id' => 'project_has_been_created', 'next_status_id' => 'stakes'],
            ['parent_status_id' => 'stakes', 'next_status_id' => 'digitization'],
            ['parent_status_id' => 'stakes', 'next_status_id' => 'drawing'],
            ['parent_status_id' => 'stakes', 'next_status_id' => 'returned'],
            ['parent_status_id' => 'digitization', 'next_status_id' => 'drawing'],
            ['parent_status_id' => 'digitization', 'next_status_id' => 'schedule'],
            ['parent_status_id' => 'schedule', 'next_status_id' => 'already_sent'],
            ['parent_status_id' => 'drawing', 'next_status_id' => 'schedule'],
            ['parent_status_id' => 'drawing', 'next_status_id' => 'digitization'],
            ['parent_status_id' => 'returned', 'next_status_id' => 'canceled'],

            //Rectify design
            ['parent_status_id' => 'rectify_design', 'next_status_id' => 'rd_stakes'],
            ['parent_status_id' => 'rd_stakes', 'next_status_id' => 'rd_digitization'],
            ['parent_status_id' => 'rd_stakes', 'next_status_id' => 'rd_drawing'],
            ['parent_status_id' => 'rd_stakes', 'next_status_id' => 'returned'],
            ['parent_status_id' => 'rd_digitization', 'next_status_id' => 'rd_drawing'],
            ['parent_status_id' => 'rd_digitization', 'next_status_id' => 'already_sent'],
            ['parent_status_id' => 'rd_drawing', 'next_status_id' => 'rd_digitization'],
            ['parent_status_id' => 'rd_drawing', 'next_status_id' => 'already_sent'],
            
            //Rectify illustration
            ['parent_status_id' => 'rectify_illustration', 'next_status_id' => 'ri_digitization'],
            ['parent_status_id' => 'rectify_illustration', 'next_status_id' => 'ri_drawing'],
            ['parent_status_id' => 'ri_digitization', 'next_status_id' => 'ri_drawing'],
            ['parent_status_id' => 'ri_digitization', 'next_status_id' => 'already_sent'],
            ['parent_status_id' => 'ri_drawing', 'next_status_id' => 'ri_digitization'],
            ['parent_status_id' => 'ri_drawing', 'next_status_id' => 'already_sent'],

            //Approvement
            ['parent_status_id' => 'already_sent', 'next_status_id' => 'approved'],
            ['parent_status_id' => 'already_sent', 'next_status_id' => 'canceled'],
            ['parent_status_id' => 'already_sent', 'next_status_id' => 'rectify_design'],
            ['parent_status_id' => 'already_sent', 'next_status_id' => 'rectify_illustration'],
            ['parent_status_id' => 'approved', 'next_status_id' => 'canceled'],
            ['parent_status_id' => 'approved', 'next_status_id' => 'assign_to'],
            
            //Building
            ['parent_status_id' => 'assign_to', 'next_status_id' => 'in_progress'],
            ['parent_status_id' => 'in_progress', 'next_status_id' => 'paused'],
            ['parent_status_id' => 'paused', 'next_status_id' => 'completed'],
            ['parent_status_id' => 'completed', 'next_status_id' => 'project_energized'],
            ['parent_status_id' => 'project_energized', 'next_status_id' => 'as_built'],
            ['parent_status_id' => 'as_built', 'next_status_id' => 'conciliation_reception'],
            ['parent_status_id' => 'conciliation_reception', 'next_status_id' => 'conciliation_shipment'],
            ['parent_status_id' => 'conciliation_shipment', 'next_status_id' => 'cre_return_order'],
            ['parent_status_id' => 'as_built', 'next_status_id' => 'project_energized'],
            ['parent_status_id' => 'project_energized', 'next_status_id' => 'conciliation_reception'],
            ['parent_status_id' => 'cre_return_order', 'next_status_id' => 'project_return_materials'],
            ['parent_status_id' => 'stopped', 'next_status_id' => 'as_built'],
            ['parent_status_id' => 'completed', 'next_status_id' => 'as_built'],
            ['parent_status_id' => 'cre_return_order', 'next_status_id' => 'project_return_materials'],
            ['parent_status_id' => 'paused', 'next_status_id' => 'stopped'],
            ['parent_status_id' => 'in_progress', 'next_status_id' => 'completed'],
        ];
    }
}
