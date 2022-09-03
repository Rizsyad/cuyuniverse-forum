<?php

namespace App\Http\Controllers\New;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Posts, SavedPosts, User};
use Illuminate\Support\Facades\{RateLimiter, Auth, Hash, Config, Storage};
use App\Http\Requests\New\StoreShowcaseRequest;
use App\Http\Resources\New\ShowcaseCollection;
use App\Models\New\Showcase;

class ShowcaseController extends Controller
{
  public function indexShowcase()
  {
    return Inertia::render('Posts', [
      'title' => "POSTS",
      'root' => "HOME",
      'description' => "Selamat Datang Di Cuy Universe Portal",
      'posts' => new ShowcaseCollection(Showcase::orderByDesc('created_at')->paginate(20)),
    ]);
  }
  public function createShowcase()
  {
    return Inertia::render('Posts', [
      'title' => "POSTS",
      'root' => "HOME",
      'description' => "Selamat Datang Di Cuy Universe Portal",
      'posts' => new ShowcaseCollection(Showcase::orderByDesc('created_at')->paginate(20)),
    ]);
  }

  private function checkRateLimiter(string $showcaseType, $perMinute = 5): \Illuminate\Http\RedirectResponse|null
  {
    $key = "showcase-store-{$showcaseType}-" . Auth::id();
    if (RateLimiter::tooManyAttempts($key, $perMinute)) {
      return redirect()->back()->with('message', 'Too many attempts');
    }

    RateLimiter::hit($key);
    return null;
  }

  public function storeShowcase(StoreShowcaseRequest $request)
  {
    if ($redirect = $this->checkRateLimiter("showcase", Config::get('rate-limit.post'))) {
      return $redirect;
    }
    $request->validated();

    $posts = new Showcase();

    if ($request->hasFile('image')) {
      $fileName = Auth::user()->username . Str::random(60) . '.' . $request->image->getClientOriginalExtension();
      $request->file('image')->storeAs('images/showcase', $fileName);
      $posts->image = $fileName;
    }
    $posts->title = $request->title;
    $posts->title = Str::slug($request->title);
    $posts->description = $request->description;
    $posts->user_id = auth()->user()->id;
    $posts->save();
    return to_route('posts.main')->with('message', 'Showcase Berhasil');
  }

  public function showShowcaseDetail($slug)
  {

    // belum diselesaikan route
    return Inertia::render('Dashboard/MyPosts', [
      'data' => Showcase::query()->where('slug', $slug)->firstOrFail(),
      // 'page' => 'POSTINGAN SAYA',
      // 'next' => 'BUAT POSTINGAN',
      // 'nextRoute' => 'dash.main'
    ]);
  }

  public function deleteShowcase()
  {
    Showcase::where('id', request()->id)->where('user_id', auth()->user()->id)->delete();
    return to_route('posts.main');
  }

  // get data showcase user (get per id)
  public function showShowcaseUser()
  {

    // belum diselesaikan route
    return Inertia::render('Dashboard/MyPosts', [
      'data' => Showcase::orderByDesc('created_at')->where('user_id', auth()->user()->id)->get(),
      // 'page' => 'POSTINGAN SAYA',
      // 'next' => 'BUAT POSTINGAN',
      // 'nextRoute' => 'dash.main'
    ]);
  }
}
