<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Mostrar categorias en el Admin
        $categories = Category::orderBy('id', 'desc')
                        ->simplePaginate(8);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Retornar la vista que nos dirigira al formulario de categorias
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = $request->all();
        //Validar si existe un archivo
        if($request->hasFile('image')){
            $category['image'] = $request->file('image')->store('categories');
        }
        //Guardar informacion
        Category::create($category);

        return redirect()->action([CategoryController::class, 'index'])
            ->with('success-create', 'Categoría creada con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //Retornar la vista
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        //Si el usuario sube una imagen
        if($request->hasFile('image')){
            //Eliminar imagen anterior
            File::delete(public_path('storage/'.$category->image));
            //Asignar nueva imagen
            $category['image'] = $request->file('image')->store('categories');
        }
        //Actualizar datos
        $category->update([
            'name' => $request->name,
            'status' => $request->status,
            'is_featured' => $request->is_featured,
        ]);

        return redirect()->action([CategoryController::class, 'index'],compact('category'))
                        ->with('success-update', 'Categoría modificada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //Eliminar imagen de la categoria
        if($category->image){
            File::delete(public_path('storage/'.$category->image));
        }
        $category->delete();

        return redirect()->action([CategoryController::class, 'index'], compact('category'))
                        ->with('success-delete', 'Categoría eliminada con éxito');
    }

    // Filtrar articulos por categorias
    public function detail(Category $category){
        //Coger todos lo articulos que pertenezcan a la misma categoria y sea publicos
        $articles = Article::where([
            ['categori_id', $category->id],
            ['status', '1'],
        ])
        ->orderBy('id','desc')->simplePaginate(5);

        $navbar = Category::where([['status','1'],['is_featured','1']])->paginate(3);

        return view('suscriber.categories.detail', compact('articles', 'category', 'navbar'));
    }
}

