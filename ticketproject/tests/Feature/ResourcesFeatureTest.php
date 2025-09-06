<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TicketApiTest extends TestCase
{
    use RefreshDatabase;

    
    public function admin_can_list_tickets()
    {
        // Rolleri oluştur
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'agent']);
        Role::create(['name' => 'user']);

        // Admin kullanıcı
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Ticket üret
        $ticket = Ticket::create([
            'title' => 'Test Ticket',
            'description' => 'Testing resolved status',
            'priority' => 'Low',
            'category' => 'hardware',
            'impact' => 'Medium',
            'source' => 'Phone',
            'status' => 'open',
            'created_by_user_id' => $agent->id,
        ]);

        // İstek at
        $response = $this->actingAs($admin, 'web')
            ->getJson('/api/tickets');

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }
}
