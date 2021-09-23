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

        // The array we're going to return
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

        
        //If the parameter name exist
        if ($name) {
            $data = collect($formatData);

            $formatData = $data->filter(function ($item){
                  return $item->name == $name;
            });
        }

        return Response::json([
            'success_code' => 200,
            'status' => 'success',
            'data' => $formatData
        ], 200);
    }
}
