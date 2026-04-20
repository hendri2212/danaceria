<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TransactionSeeder extends Seeder
{
    /**
     * Seed dummy transactions for local users with ID 1 and 2 only.
     */
    public function run(): void
    {
        $userIds = User::query()
            ->whereIn('id', [1, 2])
            ->pluck('id')
            ->all();

        if ($userIds === []) {
            return;
        }

        Transaction::query()
            ->whereIn('user_id', $userIds)
            ->where('description', 'like', '[Seeder Dummy]%')
            ->delete();

        $inTitles = [
            'Nabung uang jajan',
            'Setoran mingguan',
            'Bonus bantu orang tua',
            'Hadiah tabungan',
            'Uang saku disimpan',
        ];

        $outTitles = [
            'Beli alat tulis',
            'Bayar jajanan',
            'Beli buku cerita',
            'Beli mainan',
            'Tarik tabungan',
        ];

        $records = [];

        for ($index = 0; $index < 100; $index++) {
            $type = fake()->randomElement(['in', 'out']);
            $transactedAt = Carbon::now()
                ->subDays(fake()->numberBetween(0, 90))
                ->setTime(fake()->numberBetween(7, 20), fake()->randomElement([0, 10, 20, 30, 40, 50]));

            $title = $type === 'in'
                ? fake()->randomElement($inTitles)
                : fake()->randomElement($outTitles);

            $records[] = [
                'user_id' => $userIds[$index % count($userIds)],
                'title' => $title,
                'description' => '[Seeder Dummy] ' . fake()->sentence(6),
                'type' => $type,
                'amount' => fake()->randomElement([1000, 2000, 3000, 5000, 7000, 10000, 15000, 20000, 25000, 50000]),
                'transacted_at' => $transactedAt,
                'created_at' => $transactedAt,
                'updated_at' => $transactedAt,
            ];
        }

        Transaction::query()->insert($records);
    }
}
