<?php

namespace App\Http\Controllers;

use App\Product;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function apiList()
    {
        try {
            $client = new Client();
            $request = $client->get('https://world.openfoodfacts.org/cgi/search.pl?action=process&sort_by=unique_scans _n&page_size=20&json=1​');
            $response = $request->getBody();
            $content = json_decode($response->getContents());
            if ($content === false || !$content || !$content->products) {
                abort(422, '	Unprocessable Entity');
            }

            $products = $content->products;

            return view('products.api-list', compact('products'));

        } catch (RequestException $ex) {
            abort(500, 'Server error');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->get('query');

        $products = [];
        if ($request->isMethod('post') && $request->get('query')) {
            $products = DB::table('products')->where('name', 'LIKE', "\\" . $request->get('query') . "%")->get();
        }

        return view('products.search', compact(['products', 'query']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'category' => 'required'
        ]);

        Product::updateOrCreate(
            [
                'name' => $request->get('name'),
                'image' => $request->get('image'),
                'category' => $request->get('category'),
                'api_id' => $request->get('api_id')
            ]
        );

        return redirect('/products')->with('success', 'Product saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'category' => 'required'
        ]);
        $product = Product::find($id);
        $product->image = $request->get('image');
        $product->name = $request->get('name');
        $product->category = $request->get('category');
        $product->save();

        return redirect('/products')->with('success', 'Product updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect('/products')->with('success', 'Product deleted!');
    }
}
