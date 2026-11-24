<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_anyone_can_list_books(): void
    {
        Book::factory(3)->create(['user_id' => User::factory()->create()->id]);

        $this->getJson('/api/books')->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_guest_cannot_create_book(): void
    {
        $this->postJson('/api/books', [])->assertUnauthorized();
    }

    public function test_user_can_create_book_and_validation_works(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum')->postJson('/api/books', [])->assertUnprocessable();

        $this->actingAs($user, 'sanctum')->postJson('/api/books', [
            'title' => 'Clean Code', 'author' => 'Robert Martin', 'isbn' => '9780132350884', 'year' => 2008,
        ])->assertCreated()->assertJsonPath('data.title', 'Clean Code');
    }

    public function test_user_cannot_delete_someone_elses_book(): void
    {
        $book = Book::factory()->create(['user_id' => User::factory()->create()->id]);

        $this->actingAs(User::factory()->create(), 'sanctum')
            ->deleteJson("/api/books/{$book->id}")->assertForbidden();
    }

    public function test_owner_can_update_and_delete(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'sanctum')->patchJson("/api/books/{$book->id}", ['title' => 'New'])
            ->assertOk()->assertJsonPath('data.title', 'New');
        $this->actingAs($user, 'sanctum')->deleteJson("/api/books/{$book->id}")->assertNoContent();
    }
}
