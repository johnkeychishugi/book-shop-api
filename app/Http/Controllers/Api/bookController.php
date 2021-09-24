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

    public function formattageResponse($books, $from)
    {
         $data = [];

         // Let's Map the results  for formattage of data
         $formatData = $books->map(function ($item) use ($from) {
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
                $data['release_date'] = date('Y-m-d', strtotime($item->released));
 
                return $data;
             });
        
          return $formatData;
    }
}
