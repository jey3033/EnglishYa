<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Term;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::insert([
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Admin',
                'email'     => 'Admin@englishya.com',
                'password'  => Hash::make('Admin2026'),
                'role'      => 'admin',
                'is_active' => true,
                'parent_id' => 0
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Ms. Yun',
                'email'     => 'msyun@englishya.com',
                'password'  => Hash::make('msyun2026'),
                'role'      => 'teacher',
                'is_active' => true,
                'parent_id' => 0
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Papa',
                'email'     => 'papa@yopmail.com',
                'password'  => Hash::make('Papa2026'),
                'role'      => 'parent',
                'is_active' => true,
                'parent_id' => 0
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Anak',
                'email'     => 'Anak@yopmail.com',
                'password'  => Hash::make('Anak2026'),
                'role'      => 'student',
                'is_active' => true,
                'parent_id' => 3
            ],
        ]);

        Course::insert([
            [ 'uuid' => Str::uuid(), 'name' => 'IGCSE', 'description' => "Master IGCSE with expert tutors, structured lessons, personalized support, and proven exam strategies to achieve academic excellence." ],
            [ 'uuid' => Str::uuid(), 'name' => 'General English', 'description' => "Develop confidence in speaking, listening, reading, and writing through interactive lessons tailored to every proficiency level." ],
            [ 'uuid' => Str::uuid(), 'name' => 'Model United Nations (MUN)', 'description' => "Master diplomacy, public speaking, negotiation, and global issues through immersive Model United Nations simulations." ],
            [ 'uuid' => Str::uuid(), 'name' => "World Scholar's Cup (WSC)", 'description' => "Prepare for World Scholar's Cup with expert coaching in debate, writing, quiz challenges, and collaborative learning." ],
            [ 'uuid' => Str::uuid(), 'name' => "IELTS", 'description' => "Achieve your target IELTS score with expert coaching, practical exercises, and focused preparation for every test section." ],
        ]);

        Term::insert([
            [ 'uuid' => Str::uuid(), 'name' => 'Hourly', 'meeting_number' => 1 ],
            [ 'uuid' => Str::uuid(), 'name' => '6 Hours Package', 'meeting_number' => 6 ],
            [ 'uuid' => Str::uuid(), 'name' => '10 Hours Package', 'meeting_number' => 10 ],
            [ 'uuid' => Str::uuid(), 'name' => 'Intensive', 'meeting_number' => 20 ],
        ]);
    }
}
