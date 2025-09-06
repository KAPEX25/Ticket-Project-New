<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketsTableSeeder extends Seeder
{
    public function run(): void
    {
        // 200 ticket üret
        Ticket::factory()->count(200)->create();

        // 20 tanesini resolved yap
        Ticket::inRandomOrder()->limit(20)->update([
            'status' => 'resolved',
            'resolved_at' => now(),
        ]);

        // 30 tanesi overdue
        Ticket::inRandomOrder()->limit(30)->update([
            'sla_due_date' => now()->subDays(rand(1, 5)),
        ]);

        // 50 tanesine tags eklemek istersen (opsiyonel)
        /*
        Ticket::inRandomOrder()->limit(50)->each(function ($ticket) {
            $ticket->tags = ['vpn', 'ssl', 'firewall']; // JSON field varsayımı
            $ticket->save();
        });
        */
    }
}
