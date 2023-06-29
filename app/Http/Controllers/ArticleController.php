<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Mostrar los articulos en el admin
        //? Trae la informacion del articulo autenticado
        $user = Auth::user();
        $articles = Article::where('user_id', $user->id) // El user_id viene de la clave foranea entre user y articles
                    ->orderBy('id','desc')
                    ->simplePaginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Obtener categorias publicas
        $categories = Category::select(['id','nombre'])
                        ->where('status', '1')
                        ->get();

        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        /*
        Formulario:

        1. Titulo = "Articulo l"
        2: Slug = "articulo-1"
        3: Introduction = "Este es el primer articulo"
        4: Image = "foto.png"
        5: Body = "Primer aticulo del curso"
        6: Status = 3
        7: Category_id = 3
        */

        $request->merge([
            'user_id' => Auth::user()->id,
        ]);

        //? Guardo la solicitud en una variable
        $article = $request->all();

        //? Validar si hay un archivo en el request
        if($request->hasFile('image')){
            $article['image'] = $request->file('image')->store('articles'); // va a guardar en la carpeta 'public/storage/articles'
        }

        Article::create($article);

        return redirect()->action([ArticleController::class, 'index'])
                        ->with('success-create', 'Artículo creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $comments = $article->comments()->simplePaginate(5);

        return view('susbcriber.articles.show', compact('article', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //Obtener categorias publicas
        $categories = Category::select(['id','nombre'])
                        ->where('status', '1')
                        ->get();

        return view('admin.articles.edit', compact('categories', 'article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        //Si el usuario sube una nueva imagen
        if($request->hasFile('image')){
            //Eliminar la imagen anterior
            File::delete(public_path('storage/'.$article->image));
            //Asigna la nueva imagen
            $article['image'] = $request->file('image')->store('articles');
        }

        //Actualizar datos
        $article->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'introduction' => $request->introduction,
            'body' => $request->body,
            'user_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);

        return redirect()->action([ArticleController::class, 'index'])
                        ->with('success-update', 'Artículo modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //Eliminar imagen del articulo
        if($article->image){
            File::delete(public_path('storage/'.$article->image));
        }

        //Eliminar articulo
        $article->delete();

        return redirect()->action([ArticleController::class, 'index'], compact('article'))
                        ->with('success-delete', 'Artículo eliminado con éxito');
    }
}
