<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Transaction;
use App\Models\User;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;
	
    public function testShowMethodReturns404ForNonexistentTransaction()
    {
        // Create a user
        $user = User::factory()->create();

        // Attempt to access a non-existent transaction ID
        $response = $this->actingAs($user, 'api')
            ->get('/api/transactions/999');

        // Assert the response status is 404 (Not Found)
        $response->assertStatus(404);
    }
}
