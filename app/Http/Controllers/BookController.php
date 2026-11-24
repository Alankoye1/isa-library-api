<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    // GET /api/books?search=...&per_page=...
    public function index(Request $request)
    {
        $books = Book::with('user')
            ->when($request->search, fn ($q, $s) => $q->where('title', 'like', "%$s%")
                ->orWhere('author', 'like', "%$s%"))
            ->latest()
            ->paginate($request->integer('per_page', 10));

        return BookResource::collection($books);
    }

    // POST /api/books
    public function store(BookRequest $request)
    {
        $book = $request->user()->books()->create($request->validated());

        return (new BookResource($book->load('user')))
            ->response()->setStatusCode(Response::HTTP_CREATED);
    }

    // GET /api/books/{book}
    public function show(Book $book)
    {
        return new BookResource($book->load('user'));
    }

    // PUT/PATCH /api/books/{book}
    public function update(BookRequest $request, Book $book)
    {
        abort_if($book->user_id !== $request->user()->id, 403, 'Not your book.');
        $book->update($request->validated());

        return new BookResource($book->load('user'));
    }

    // DELETE /api/books/{book}
    public function destroy(Request $request, Book $book)
    {
        abort_if($book->user_id !== $request->user()->id, 403, 'Not your book.');
        $book->delete();

        return response()->noContent();
    }
}
