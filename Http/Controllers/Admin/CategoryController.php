<?php

namespace Modules\ECommerce\Http\Controllers\Admin;

use Neev;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\ECommerce\Models\Category;
use Ssntpl\Neev\Http\Controllers\Controller;

class CategoryController extends Controller
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
        return view('neev::admin.catalogue.category.index')
            ->with('categories', Category::where('organisation_id', Neev::organisation()->getKey()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = DB::table('languages')->pluck('language_code', 'description');
        return view('neev::admin.catalogue.category.create')->with('languages', $languages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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

        $category = Category::create([
            'organisation_id' => Neev::organisation()->getKey(),
            'parent_id' => null,
            'name' => $arrName,
            'description' => $arrDescription,
            'meta_description' => $arrMetaDesc,
            'meta_keyword' => $arrMetaKeyword,
            'slug' => $arrSlug,
            'tag' => $arrTag,
            'sort_order' => $request->sort_order,
            'visible' => $request->visible,
            'active' => $request->active
        ]);

        return redirect(route('admin.category.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $category->languages = DB::table('languages')->pluck('language_code', 'description');
        return view('neev::admin.catalogue.category.edit')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
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

        $category->parent_id = $request->parent_id;

        $category->setTranslations('name', $name_translations);
        $category->setTranslations('description', $description_translations);
        $category->setTranslations('meta_description', $meta_description_translations);
        $category->setTranslations('meta_keyword', $meta_keyword_translations);
        $category->setTranslations('slug', $slug_translations);
        $category->setTranslations('tag', $tag_translations);

        $category->sort_order = $request->sort_order;
        $category->visible = $request->visible;
        $category->active = $request->active;
        $category->save();

        return redirect(route('admin.category.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect(route('admin.category.index'));
    }
}
