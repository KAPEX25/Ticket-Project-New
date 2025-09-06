<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;


 
class TicketFactory extends Factory
{
    
    protected $model = Ticket::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(['open', 'in_progress', 'resolved']);
        $resolvedAt = $status === 'resolved' ? $this->faker->dateTimeBetween('-30 days', 'now') : null;

        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'priority' => $this->faker->randomElement(['Critical', 'High', 'Medium', 'Low']),
            'category' => $this->faker->randomElement([
                'Computer (Laptop / Desktop)',
                'Printer / Scanner',
                'Network Devices',
                'Operating System',
                'Email',
                'Security',
            ]),
            'impact' => $this->faker->randomElement(['High', 'Medium', 'Low']),
            'source' => $this->faker->randomElement(['Web', 'Email', 'Phone', 'Chat']),
            'status' => $status,
            'created_by_user_id' =>  $this->faker->numberBetween(1, 5), // user id’lerden biri
            'assigned_user_id' => $this->faker->optional()->numberBetween(2, 4), // agent id
            'resolved_at' => $resolvedAt,
            'sla_due_date' => $this->faker->dateTimeBetween('now', '+10 days'),
            'attachments' => [],
        ];
    }
}
