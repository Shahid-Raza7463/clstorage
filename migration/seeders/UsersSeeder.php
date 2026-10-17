<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 485,
                'teammember_id' => 447,
                'role_id' => 11,
                'fcm' => null,
                'email' => 'sukhbahadur1993@gmail.com',
                'passwordResetToken' => 'ZBas04OcYkpZH9F7bUz1q8mB2IKgehXsCwzeaM5wJdC2UMmnVzoUMiQakbvT',
                'passwordResetExpiresAt' => '2026-09-06 17:10:42',
                'email_verified_at' => null,
                'password' => '$2y$10$VTaurA1sg6lHkcgcLhu2WuqZeZmJwZLMeSdHnKv8a2CxK/0GG5AHu',
                'status' => 1,
                'remember_token' => 'L7hQ6WZo588farNslJUD5dhxpGYKk1SEZnPuYsCoQVp0WHvNHagcA6KuFpSM',
                'two_factor_code' => 786051,
                'otp' => 126785,
                'two_factor_expires_at' => '2026-10-09 11:16:50',
                'created_at' => '2021-05-21 04:56:59',
                'updated_at' => '2026-09-06 05:10:42'
            ],
            [
                'id' => 785,
                'teammember_id' => 936,
                'role_id' => 14,
                'fcm' => null,
                'email' => 'Poojakumari@capitall.io',
                'passwordResetToken' => '',
                'passwordResetExpiresAt' => '2025-06-27 11:54:01',
                'email_verified_at' => null,
                'password' => '$2y$10$xp1Dys/pJ9gg4luscksqs.JlnCo30nLPCSojIvS1glwbbTpI0Alle',
                'status' => 1,
                'remember_token' => null,
                'two_factor_code' => 503376,
                'otp' => null,
                'two_factor_expires_at' => '2026-10-07 16:52:32',
                'created_at' => '2024-04-24 19:49:52',
                'updated_at' => '2025-06-26 13:00:00'
            ],
            [
                'id' => 805,
                'teammember_id' => 951,
                'role_id' => 13,
                'fcm' => null,
                'email' => 'shahidraza@capitall.io',
                'passwordResetToken' => 'UNLBjmqdQkBwn7JHtB3zF9Ao6h8QJwsMz8kQUc8lhOx2IzZWLbE9go0XXppg',
                'passwordResetExpiresAt' => '2025-11-27 12:31:34',
                'email_verified_at' => null,
                'password' => '$2y$10$46NXyFR9K5PDugna4zza.uASs0cP2WzK7W5rIuWPD2NFsqzu1fqbu',
                'status' => 1,
                'remember_token' => null,
                'two_factor_code' => 196462,
                'otp' => null,
                'two_factor_expires_at' => '2026-10-07 16:49:13',
                'created_at' => '2025-04-22 01:35:01',
                'updated_at' => '2025-11-27 00:31:34'
            ],
        ]);
    }
}
