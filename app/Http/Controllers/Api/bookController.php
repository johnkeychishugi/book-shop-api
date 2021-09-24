<?php

namespace App\Http\Controllers\Api;

use Response;
use App\Http\Controllers\Controller;
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

        $data = $this->formattageResponse($books);

        return Response::json([
            'success_code' => 200,
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function formattageResponse($books)
    {
         $data = [];

         // Let's Map the results  for formattage of data
         $formatData = $books->map(function ($item) {
                $data['name'] = $item->name;
                $data['isbn'] = $item->isbn;
                $data['authors'] = $item->authors;
                $data['number_of_pages'] = $item->numberOfPages;
                $data['publisher'] = $item->publisher;
                $data['country'] = $item->country;
                $data['release_date'] = date('Y-m-d', strtotime($item->released));
 
                return $data;
             });
        
          return $formatData;
    }
}
