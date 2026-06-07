<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplimentsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('compliments')->insert([
            [
                'submitted_by_name' => 'Марија Петрова',
                'submitted_by_email' => 'marija@example.com',
                'submitted_by_phone' => '+389 2 123 456',
                'subject' => 'Одличан сервис!',
                'message' => 'Многу благодаран за добриот третман и напор на целиот тим. Вистински ми импонира вашата посветеност.',
                'status' => 'new',
                'assigned_to' => null,
                'created_at' => now()->subDays(2),
            ],
            [
                'submitted_by_name' => 'Јован Стефанов',
                'submitted_by_email' => 'jovan@example.com',
                'submitted_by_phone' => '+389 2 654 321',
                'subject' => 'Пофалба за тимската работа',
                'message' => 'Сакам да ги благодарам сите на останатост и профионалност. Просто браво!',
                'status' => 'seen',
                'assigned_to' => 1,
                'created_at' => now()->subDays(5),
            ],
            [
                'submitted_by_name' => 'Елена Миќовска',
                'submitted_by_email' => 'elena@example.com',
                'submitted_by_phone' => null,
                'subject' => 'Благодаран за вашите напори',
                'message' => 'Голема пофалба за инициативата и проактивниот приод во решавањето на проблемите.',
                'status' => 'closed',
                'assigned_to' => 1,
                'created_at' => now()->subDays(10),
            ],
        ]);
    }
}
