<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TicketModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function ticket_is_resolved_sets_resolved_at_and_assigned_user()
    {
        // Rolleri oluştur
        Role::create(['name' => 'agent']);

        // Ticket oluşturacak kullanıcı
        $creator = User::factory()->create();

        // Agent kullanıcı
        $agent = User::factory()->create();
        $agent->assignRole('agent');

        // Test ortamında auth simüle et
        $this->actingAs($agent);

        // Ticket oluştur
        $ticket = Ticket::factory()->create([
            'status' => 'open',
            'resolved_at' => null,
            'assigned_user_id' => null,
            'created_by_user_id' => $creator->id, // foreign key hatası kalktı
        ]);

        // Agent ticket'ı çözüyor
        $ticket->status = 'resolved'; 
        $ticket->assigned_user_id = $agent->id;
        $ticket->save();

        // DB'den güncel değerleri çek
        $ticket->refresh();

        // Kontroller
        $this->assertNotNull($ticket->resolved_at);
        $this->assertEquals($agent->id, $ticket->assigned_user_id);
    }
}
