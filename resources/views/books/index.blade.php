@extends('layout')

@section('content')
    <div class="container">
        <h1>Books</h1>
        <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>ISBN</th>
                    <th>Publication Year</th>
                    <th>Price</th>
                    <th>Genre</th>
                    <th>Subgenre</th>
                    <th>Stock</th>
                    <th>Writer</th>
                    <th>Publisher</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->ISBN }}</td>
                        <td>{{ $book->publication_year }}</td>
                        <td>{{ $book->price }}</td>
                        <td>{{ $book->genre }}</td>
                        <td>{{ $book->subgenre }}</td>
                        <td>{{ $book->stock_amount }}</td>
                        <td>{{ $book->writer->name }}</td>
                        <td>{{ $book->publisher->name }}</td>
                        <td>
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('books.move', $book) }}" method="POST" style="display: inline">
                                @csrf
                                <input type="number" name="up" placeholder="Up">
                                <input type="number" name="down" placeholder="Down">
                                <button type="submit">Move</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
