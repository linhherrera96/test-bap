<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   

        DB::table('jobs')->insert(
            [
                'title' => 'Tuyển Vuejs 2 năm kinh nghiệm',
                'description' => 'Lương upto 2000$',
                'status_complete' => '0',
                'due_date' => '2023-05-25'
            ]
        );

        DB::table('jobs')->insert(
            [
                'title' => 'Tuyển ReactJS 2 năm kinh nghiệm',
                'description' => 'Lương upto 1500$',
                'status_complete' => '1',
                'due_date' => '2023-06-25'
            ]
        );

        DB::table('jobs')->insert(
            [
                'title' => 'Tuyển Python 3 năm kinh nghiệm, onsite tại Hà Nội',
                'description' => 'Lương cạnh tranh, upto 2000$',
                'status_complete' => '1',
                'due_date' => '2023-06-21'
            ]
        );
        DB::table('jobs')->insert(
            [
                'title' => 'Tuyển Junior Java Spring Boot',
                'description' => 'Lương upto 1200$',
                'status_complete' => '1',
                'due_date' => '2023-06-15'
            ]
        );
        DB::table('jobs')->insert(
            [
                'title' => 'Tuyển QA 1 năm kinh nghiệm',
                'description' => 'Lương upto 1000$',
                'status_complete' => '1',
                'due_date' => '2023-06-22'
            ]
        );
        DB::table('jobs')->insert(
            [
                'title' => 'Tuyển Designer 2 năm kinh nghiệm',
                'description' => 'Lương upto 1000$',
                'status_complete' => '0',
                'due_date' => '2023-05-25'
            ]
        );

        DB::table('jobs')->insert(
            [
                'title' => '[Hybrid] Onsite HCM, NuxtJS 3 năm kinh nghiệm',
                'description' => 'Lương upto 1500$',
                'status_complete' => '0',
                'due_date' => '2023-06-25'
            ]
        );

        DB::table('jobs')->insert(
            [
                'title' => '[Urgent] Tuyển 2 dev Django 3 năm kinh nghiệm, onsite tại Huế',
                'description' => 'Lương upto 2000$',
                'status_complete' =>'1',
                'due_date' => '2023-06-28'
            ]
        );
        DB::table('jobs')->insert(
            [
                'title' => 'Tuyển Senior Java Spring Boot',
                'description' => 'Lương upto 2200$',
                'status_complete' => '1',
                'due_date' => '2023-06-11'
            ]
        );
        DB::table('jobs')->insert(
            [
                'title' => 'Tuyển Frontend 1 năm kinh nghiệm',
                'description' => 'Lương upto 1000$',
                'status_complete' => '1',
                'due_date' => '2023-06-09'
            ]
        );

        DB::table('jobs')->insert(
            [
                'title' => 'Tuyển Frontend 2 năm kinh nghiệm',
                'description' => 'Lương upto 1200$',
                'status_complete' => '1',
                'due_date' => '2023-06-02'
            ]
        );
    }
}
