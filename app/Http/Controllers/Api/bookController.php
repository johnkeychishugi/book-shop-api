<?php

namespace App\Http\Controllers\Api;

use Response;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    //Get books from external api
    public function getBooksExternalApi(Request $request)
    {
        $name = $request->input('name');
        $books = Http::get('https://www.anapioficeandfire.com/api/books')->object();
        $books = collect($books);

        //If the parameter name exist
        if ($name) {
           $books = $books->filter(function ($item,$key) use ($name) {
                return $item->name == $name;
           });
        }

        $data = $this->formattageResponse($books,2);

        return Response::json([
            'success_code' => 200,
            'status' => 'success',
            'data' => $data
        ], 200);
    }
    //Create a book in local database
    public function createBook(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'isbn' => 'required',
            'country' => 'required',
            'authors' => 'required',
            'number_of_pages' => 'required|numeric',
            'publisher' => 'required',
            'release_date' => 'required',
        ]);

        $author = Author::whereName($request->authors)->first();

        if(!$author){
            $author = new Author();
            $author->name = $request->authors;
            $author->save();
        }

        $book = new Book();
        $book->name = $request->name;
        $book->isbn = $request->isbn;
        $book->country = $request->country;
        $book->number_of_pages = $request->number_of_pages;
        $book->publisher = $request->publisher;
        $book->release_date = $request->release_date;
        $book->save();
        $book->authors()->attach($author->id);

        $data= Book::whereId($book->id)->with('authors')->get();

        $data = $this->formattageResponse($data,1);

        return Response::json([
            'success_code' => 201,
            'status' => 'success',
            'data' => $data
        ],201);
    }
    //Get all books in database
    public function getBooks()
    {
        $books = Book::with('authors')->get();

        $data = $this->formattageResponse($books,1);

        return Response::json([
            'success_code' => 200,
            'status' => 'success',
            'data' => $data
        ],200);
    }
    //update a book in local database
    public function updateBook(Request $request, $id)
    {

        $this->validate($request,[
            'name' => 'required',
            'isbn' => 'required',
            'country' => 'required',
            'authors' => 'required',
            'number_of_pages' => 'required|numeric',
            'publisher' => 'required',
            'release_date' => 'required',
        ]);

        $book = Book::whereId($id)->with('authors')->first();
        $book->name = $request->name;
        $book->isbn = $request->isbn;
        $book->country = $request->country;
        $book->number_of_pages = $request->number_of_pages;
        $book->publisher = $request->publisher;
        $book->release_date = $request->release_date;
        $book->save();

        $data= Book::whereId($id)->with('authors')->get();

        $data = $this->formattageResponse($data,1);

        return Response::json([
            "status_code" => 200, 
            "status" => "success",
            "message" => $book->name ." was updated successfully",
            "data" => $data->first()
        ],200);

    }
    //Delete a book in local database
    public function deleteBook($id)
    {
        $book = Book::whereId($id)->with('authors')->first();

       if($book){
        $bookName = $book->name;
        $book->delete();
        $status = 200;
        $response = [
            "status_code" => 200, 
            "status" => "success",
            "message" => $bookName ." was deleted successfully",
            "data" => []
        ];
       }else{
        $status = 404;
        $response = [
            "status_code" => 404, 
            "status" => "Not Found",
            "message" => "Book not found in the database",
        ];
       }

        return Response::json($response,$status);

    }
    //Get a single book in local database
    public function getBook($id)
    {
        $book = Book::whereId($id)->with('authors')->get();

        $data = $this->formattageResponse($book,1);

        return Response::json([
            "status_code" => 200, 
            "status" => "success",
            "data" => $data->first()
        ],200);
    }
    //Formattage fo data for the response purpose for both external and local data
    public function formattageResponse($books, $from)
    {
         $data = [];

         // Let's Map the results  for formattage of data
         $formatData = $books->map(function ($item) use ($from) {
                $data['id'] = $item->id;
                $data['name'] = $item->name;
                $data['isbn'] = $item->isbn;
                //if $from is 1 data coming from internal and other if from external
                if($from == 1){
                    $data['authors'] = $item->authors->map(function($value){
                          return $value->name;
                    });
                    $data['number_of_pages'] = $item->number_of_pages;
                }else{
                    $data['authors'] = $item->authors;
                    $data['number_of_pages'] = $item->numberOfPages;
                }
                $data['publisher'] = $item->publisher;
                $data['country'] = $item->country;
                if($from == 1){
                  $data['release_date'] = date('Y-m-d', strtotime($item->release_date));
                }else{
                    $data['release_date'] = date('Y-m-d', strtotime($item->released));
                }
                return $data;
             });
        
          return $formatData;
    }
}
