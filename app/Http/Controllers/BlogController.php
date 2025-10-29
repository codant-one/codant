<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Blog::with(['category', 'user']);

            foreach ($request->input('order') as $order) {
                $query->orderBy($order['column_name'], $order['dir']);
            }

            foreach ($request->input('columns') as $key => $column) {
                if (!$request->filled("columns.$key.search.value")) continue;

                $column_name = $request->input("columns.$key.data");
                $search_value = $request->input("columns.$key.search.value");
                $date_columns = ['created_at'];

                if (!in_array($column_name, $date_columns)) {
                    $query->where($column_name, 'LIKE', "%$search_value%");
                } elseif (in_array($column_name, $date_columns)) {
                    $query->whereDate($column_name, Carbon::parse($search_value)->format('Y-m-d'));
                }
            }

            $blogs = ($request->length == -1) ? $query->paginate($query->count()) : $query->paginate($request->length);

            // Transformar los datos para incluir información de relaciones
            $blogs->getCollection()->transform(function ($blog) {
                return [
                    'id' => $blog->id,
                    'title_es' => $blog->title_es,
                    'category_name' => $blog->category->name_es ?? '',
                    'year' => $blog->year,
                    'is_popular' => (bool) $blog->is_popular_blog,
                    'user_name' => $blog->user->name ?? '',
                    'created_at' => $blog->created_at,
                    'updated_at' => $blog->updated_at,
                ];
            });

            return response()->json($blogs, 200);
        }

        return view('cruds.blogs.index');
    }

     /**
     * Show the form for creating a new resource.
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::whereHas('categoryType', function($query) {
            $query->where('name', 'Blog');
        })->get();
        
        $users = User::all();

        return view('cruds.blogs.create', compact('categories', 'users'));
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
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'is_popular_blog' => 'sometimes|boolean',
            'title_es' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_es' => 'required|string',
            'description_en' => 'required|string',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'slug' => 'required|string|max:255|unique:blogs,slug',
        ]);

        $blog = new Blog();
        $blog->fill($request->all());
        
        // Manejar la subida de imagen si existe
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/blogs'), $imageName);
            $blog->image = $imageName;
        }

        $blog->save();

        return redirect()->route('blogs.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Blog creado exitosamente'
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
        $blog = Blog::find($id);
        $categories = Category::whereHas('categoryType', function($query) {
            $query->where('name', 'Blog');
        })->get();
        
        $users = User::all(); 

        if (!$blog)
            return redirect()->route('blogs.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'Blog no encontrado'
                ]
            ]);

        return view('cruds.blogs.edit', compact('blog', 'categories', 'users'));
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
        $blog = Blog::find($id);

        if (!$blog)
            return redirect()->route('blogs.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'Blog no encontrado'
                ]
            ]);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'is_popular_blog' => 'sometimes|boolean',
            'title_es' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_es' => 'required|string',
            'description_en' => 'required|string',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'slug' => 'required|string|max:255|unique:blogs,slug,' . $blog->id,
        ]);

        $blog->fill($request->all());
        
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/blogs'), $imageName);
            $blog->image = $imageName;
        }

        $blog->save();

        return redirect()->route('blogs.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Blog actualizado exitosamente'
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
        $blog = Blog::find($id);

        if (!$blog)
            return redirect()->route('blogs.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'Blog no encontrado'
                ]
            ]);

        $blog->delete();

        return redirect()->route('blogs.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Blog eliminado exitosamente'
            ]
        ]);
    }
}
