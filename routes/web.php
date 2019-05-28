<?php
use App\Olimpico;
use Illuminate\Http\Request;
use App\Comment;
use Carbon\Carbon;
use App\Post;
use App\Like;
use Illuminate\Support\Facades\DB;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Auth::routes();

Route::group(
    [
        'middleware' => ['auth']
    ],
    function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/home', 'HomeController@index')->name('home');
    }
);

Route::get('/reporte/{reporte}/html', 'ReporteController@html')->name('reportehtml');
Route::get('/reporte/{reporte}/excel', 'ReporteController@excel')->name('reporteexcel');
Route::get('/reporte/{reporte}/pdf', 'ReporteController@pdf')->name('reportepdf');
Route::get('/olimpicostpl', function () {
    echo file_get_contents(base_path('resources/views/olimpicos/view.blade.php'));
})->name('olimpicostpl');
Route::get('/olimpicos', function () {
    return view('olimpicos.list', ['list' => Olimpico::all(), 'user' => Olimpico::first()]);
})->name('olimpicos.list');
Route::get('/olimpicos/{id}', function ($id) {
    $olimpico = Olimpico::find($id);
    $post = Post::first();
    if (!$post) {
        $post = new Post();
        $post->id = 1;
        $post->olimpico()->associate($olimpico);
        $post->updated_at = new Carbon();
        $post->image = 'https://i.ytimg.com/vi/7MCdGs3SXwQ/maxresdefault.jpg';
        $post->text = 'Para vencer a Cronos tambien tuve que vencer a los 12 titanes con la ayuda de los Ciclopes y los Hecatonquiros';
    }

    $comment = $post->comments()->first();
    if (!$comment) {
        $comment = new Comment();
        $comment->id = 1;
        $comment->post()->associate($post);
        $comment->olimpico()->associate($olimpico);
        $comment->updated_at = new Carbon();
        $comment->text = 'Eso no me gusto';
    }

    $amistad = $olimpico->sugerirAmistad();
    $posts = Post::all()->sortBy('updated_at', SORT_REGULAR, true);
    return view('olimpicos.view', ['user' => $olimpico, 'post' => $post, 'comment' => $comment, 'amistad' => $amistad, 'posts' => $posts]);
})->name('olimpicos.view');

// Editar olimpico
Route::get('/olimpicos/{id}/edit', function ($id) {
    $olimpico = Olimpico::find($id);
    return view('olimpicos.edit', ['user' => $olimpico]);
})->name('olimpicos.edit');
Route::post('/olimpicos/{id}/save', function ($id, Request $request) {
    $olimpico = Olimpico::find($id);
    if ($file = $request->file('avatar')) {
        $path = Storage::putFile('public', $request->file('avatar'));
        $realpath = Storage::path($path);
        $image = imagecreatefromstring(file_get_contents($realpath));
        $width = imagesx($image);
        $height = imagesy($image);
        $size = min($width, $height);
        $cropped = cropAlign($image, $size, $size, 'center', 'middle');
        imagejpeg($cropped, $realpath);
        $olimpico->avatar = Storage::url($path);
    }
    $olimpico->name = $request->input('name');
    $olimpico->save();
    return redirect('/olimpicos/' . $olimpico->id);
})->name('olimpicos.edit');

// Crear olimpico
Route::get('/olimpico/crear', function () {
    $olimpico = new Olimpico();
    return view('olimpicos.edit', ['user' => $olimpico]);
})->name('olimpicos.edit');
Route::post('/olimpico/save', function (Request $request) {
    $olimpico = new Olimpico();
    if ($file = $request->file('avatar')) {
        $path = Storage::putFile('public', $request->file('avatar'));
        $realpath = Storage::path($path);
        $image = imagecreatefromstring(file_get_contents($realpath));
        $width = imagesx($image);
        $height = imagesy($image);
        $size = min($width, $height);
        $cropped = cropAlign($image, $size, $size, 'center', 'middle');
        imagejpeg($cropped, $realpath);
        $olimpico->avatar = Storage::url($path);
    }
    $olimpico->name = $request->input('name');
    $olimpico->save();
    return redirect('/olimpicos/' . $olimpico->id);
})->name('olimpicos.edit');

// Escribir un post
Route::get('/olimpicos/{id}/post', function ($id) {
    $olimpico = Olimpico::find($id);
    return view('olimpicos.post', ['user' => $olimpico]);
})->name('olimpicos.edit');
Route::post('/olimpicos/{id}/post', function ($id, Request $request) {
    $olimpico = Olimpico::find($id);
    $post = new Post();
    if ($request->file('image')) {
        $path = Storage::putFile('public', $request->file('image'));
        $post->image = Storage::url($path);
    }
    $post->text = $request->input('text');
    $post->olimpico()->associate($olimpico);
    $post->save();
    return redirect('/olimpicos/' . $olimpico->id);
})->name('olimpicos.post');

// LIKES
Route::get('/olimpicos/{olimpico}/like/post/{post}', function (Olimpico $olimpico, Post $post) {
    return view('olimpicos.likes', ['user' => $olimpico, 'post' => $post]);
})->name('olimpicos.likes');
Route::post('/olimpicos/{olimpico}/like/post/{post}/post', function (Olimpico $olimpico, Post $post, Request $request) {
    $type = $request->input('type');
    Like::where('olimpico_id', $olimpico->id)
    ->where('post_id', $post->id)
    ->delete();
    $like = new Like();
    $like->olimpico()->associate($olimpico);
    $like->post()->associate($post);
    $like->type = $type;
    $like->save();
    return redirect('/olimpicos/' . $olimpico->id . '#post' . $post->id);
})->name('olimpicos.post');

// Escribir un comentario
Route::get('/olimpicos/{olimpico}/comment/post/{post}', function (Olimpico $olimpico, Post $post) {
    return view('olimpicos.comment', ['user' => $olimpico, 'post' => $post]);
})->name('olimpicos.comment');
Route::post('/olimpicos/{olimpico}/comment/post/{post}/post', function (Olimpico $olimpico, Post $post, Request $request) {
    $text = $request->input('text');
    $comment = new Comment();
    $comment->olimpico()->associate($olimpico);
    $comment->post()->associate($post);
    $comment->text = $text;
    $comment->save();
    return redirect('/olimpicos/' . $olimpico->id . '#post' . $post->id);
})->name('olimpicos.postcomment');

// Lista de amistades
Route::get('/olimpicos/{olimpico}/amistades', function (Olimpico $olimpico) {
    return view('olimpicos.amistades', ['user' => $olimpico]);
})->name('olimpicos.comment');
Route::post('/olimpicos/{olimpico}/amistades/post', function (Olimpico $olimpico, Post $post, Request $request) {
    DB::connection('hr')->table('amistades')->where('olimpico_id', $olimpico->id)->delete();
    $ids = $request->input('id');
    $types = $request->input('type');
    foreach ($ids as $index => $id) {
        $type = $types[$index];
        if ($type) {
            $olimpico->amistades()->attach($id, ['type' => $type]);
        }
    }
    return redirect('/olimpicos/' . $olimpico->id . '/amistades');
})->name('olimpicos.postcomment');

// Lista de amistades
Route::get('/olimpicos/{olimpico}/aceptar/{amistad}', function (Olimpico $olimpico, Olimpico $amistad) {
    $relacion = DB::connection('hr')->table('amistades')->where('olimpico_id', $olimpico->id)
    ->where('relacion_id', $amistad->id)->first();
    if (!$relacion) {
        $olimpico->amistades()->attach($amistad->id, ['type' => 'amigo(a)']);
    }
    return redirect('/olimpicos/' . $olimpico->id . '/amistades');
})->name('olimpicos.postcomment');

// Helpers
function uploadImage()
{
}

function cropAlign($image, $cropWidth, $cropHeight, $horizontalAlign = 'center', $verticalAlign = 'middle')
{
    $width = imagesx($image);
    $height = imagesy($image);
    $horizontalAlignPixels = calculatePixelsForAlign($width, $cropWidth, $horizontalAlign);
    $verticalAlignPixels = calculatePixelsForAlign($height, $cropHeight, $verticalAlign);
    return imageCrop($image, [
        'x' => $horizontalAlignPixels[0],
        'y' => $verticalAlignPixels[0],
        'width' => $horizontalAlignPixels[1],
        'height' => $verticalAlignPixels[1]
    ]);
}

function calculatePixelsForAlign($imageSize, $cropSize, $align)
{
    switch ($align) {
      case 'left':
      case 'top':
          return [0, min($cropSize, $imageSize)];
      case 'right':
      case 'bottom':
          return [max(0, $imageSize - $cropSize), min($cropSize, $imageSize)];
      case 'center':
      case 'middle':
          return [
              max(0, floor(($imageSize / 2) - ($cropSize / 2))),
              min($cropSize, $imageSize),
          ];
      default: return [0, $imageSize];
  }
}
