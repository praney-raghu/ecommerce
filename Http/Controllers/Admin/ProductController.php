<?php

namespace Modules\ECommerce\Http\Controllers\Admin;

use Neev;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\ECommerce\Models\Product;
use Ssntpl\Neev\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return get_class(Neev::organisation());
        return view('neev::admin.catalogue.product.index')
            ->with('products', Product::where('organisation_id', Neev::organisation()->getKey()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product;
        $productType = $product->productType();

        $languages = DB::table('languages')->pluck('language_code', 'description');

        return view('neev::admin.catalogue.product.create')->with(['productType' => $productType, 'languages' => $languages]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $languages = DB::table('languages')->pluck('language_code', 'description');

        foreach ($languages as $description => $code) {
            $keys[] = $code;
            $name_values[] = $request['name_' . $code];
            $desc_values[] = $request['description_' . $code];
            $meta_desc_values[] = $request['meta_description_' . $code];
            $meta_keyword_values[] = $request['meta_keyword_' . $code];
            $slug_values[] = $request['slug_' . $code];
            $tag_values[] = $request['tag_' . $code];
        }

        // Translations for translatable columns
        $arrName = array_combine($keys, $name_values);
        $arrDescription = array_combine($keys, $desc_values);
        $arrMetaDesc = array_combine($keys, $meta_desc_values);
        $arrMetaKeyword = array_combine($keys, $meta_keyword_values);
        $arrSlug = array_combine($keys, $slug_values);
        $arrTag = array_combine($keys, $tag_values);

        $product = Product::create([
            'organisation_id' => Neev::organisation()->getKey(),
            'hsn' => $request->hsn,
            'type' => $request->type,
            'module' => $request->module,
            'name' => $arrName,
            'description' => $arrDescription,
            'meta_description' => $arrMetaDesc,
            'meta_keyword' => $arrMetaKeyword,
            'slug' => $arrSlug,
            'tag' => $arrTag,
            'cost' => $request->cost,
            'qty' => $request->qty,
            'unit' => $request->unit
        ]);

        return redirect(route('product.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product->languages = DB::table('languages')->pluck('language_code', 'description');
        return view('neev::admin.catalogue.product.edit')->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $languages = DB::table('languages')->pluck('language_code', 'description');

        foreach ($languages as $description => $code) {
            $keys[] = $code;
            $name_values[] = $request['name_' . $code];
            $desc_values[] = $request['description_' . $code];
            $meta_desc_values[] = $request['meta_description_' . $code];
            $meta_keyword_values[] = $request['meta_keyword_' . $code];
            $slug_values[] = $request['slug_' . $code];
            $tag_values[] = $request['tag_' . $code];
        }

        // Translations for translatable columns
        $name_translations = array_combine($keys, $name_values);
        $description_translations = array_combine($keys, $desc_values);
        $meta_description_translations = array_combine($keys, $meta_desc_values);
        $meta_keyword_translations = array_combine($keys, $meta_keyword_values);
        $slug_translations = array_combine($keys, $slug_values);
        $tag_translations = array_combine($keys, $tag_values);

        $product->hsn = $request->hsn;
        $product->type = $request->type;
        $product->module = $request->module;

        $product->setTranslations('name', $name_translations);
        $product->setTranslations('description', $description_translations);
        $product->setTranslations('meta_description', $meta_description_translations);
        $product->setTranslations('meta_keyword', $meta_keyword_translations);
        $product->setTranslations('slug', $slug_translations);
        $product->setTranslations('tag', $tag_translations);

        $product->cost = $request->cost;
        $product->qty = $request->qty;
        $product->unit = $request->unit;
        $product->visible = $request->visible;
        $product->active = $request->active;
        $product->save();

        //setTranslation('module','en',$request->module);
        return redirect(route('product.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect(route('product.index'));
    }
}
