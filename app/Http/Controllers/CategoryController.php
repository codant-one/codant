<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategoryType;
use Carbon\Carbon;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Category::with('categoryType'); 

            foreach ($request->input('order') as $order) {
                if ($order['column_name'] === 'category_type_name') {
                    $query->join('category_types', 'categories.category_type_id', '=', 'category_types.id')
                        ->orderBy('category_types.name', $order['dir'])
                        ->select('categories.*');
                } else {
                    $query->orderBy($order['column_name'], $order['dir']);
                }
            }

            foreach ($request->input('columns') as $key => $column) {
                if (!$request->filled("columns.$key.search.value")) continue;

                $column_name = $request->input("columns.$key.data");
                $search_value = $request->input("columns.$key.search.value");
                $date_columns = ['created_at'];

                if (!in_array($column_name, $date_columns)) {
                    if ($column_name === 'category_type_name') {
                        $query->whereHas('categoryType', function($q) use ($search_value) {
                            $q->where('name', 'LIKE', "%$search_value%");
                        });
                    } else {
                        $query->where($column_name, 'LIKE', "%$search_value%");
                    }
                } elseif (in_array($column_name, $date_columns)) {
                    $query->whereDate($column_name, Carbon::parse($search_value)->format('Y-m-d'));
                }
            }

            $categories = ($request->length == -1) ? $query->paginate($query->count()) : $query->paginate($request->length);

            $categories->getCollection()->transform(function ($category) {
                return [
                    'id' => $category->id,
                    'category_type_name' => $category->categoryType->name ?? '',
                    'name_es' => $category->name_es,
                    'name_en' => $category->name_en,
                    'created_at' => $category->created_at,
                    'updated_at' => $category->updated_at,
                ];
            });

            return response()->json($categories, 200);
        }

        return view('cruds.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryTypes = CategoryType::all();
        return view('cruds.categories.create', compact('categoryTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_type_id' => 'required|exists:category_types,id',
            'name_es' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        $category = new Category();
        $category->fill($request->all());
        $category->save();

        return redirect()->route('categories.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Categoria creada exitosamente'
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $categoryTypes = CategoryType::all();

        if (!$category)
            return redirect()->route('categories.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la categoría'
                ]
            ]);

        return view('cruds.categories.edit', compact('category', 'categoryTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category)
            return redirect()->route('categories.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la categoría'
                ]
            ]);

        $request->validate([
            'category_type_id' => 'required|exists:category_types,id',
            'name_es' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        $category->fill($request->all());
        $category->save();

        return redirect()->route('categories.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Categoría actualizada exitosamente'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category)
            return redirect()->route('categories.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la categoría'
                ]
            ]);

        $category->delete();

        return redirect()->route('categories.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Categoría eliminada exitosamente'
            ]
        ]);
    }
}
