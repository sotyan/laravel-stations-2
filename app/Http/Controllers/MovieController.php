<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\CreateScheduleRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Schedule;
use App\Models\Sheet;
//use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\DB;
//use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Validated;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class MovieController extends Controller
{
    // Eloquentモデルで記述している
    // データベーステーブルをモデルで呼び出しているのが特徴
    // 現在はコントローラーの記述量が多いため、モデルも使えると良い
    // public function index(){
    //     $movies = Movie::all();
    //     $is_showing = 2;
    //     $keyword = '';
    //     return view('index',['movies' => $movies], compact('is_showing', 'keyword'));
    // }

    public function adminIndex(){
        $movies = Movie::all();
        $genres = Genre::all();
        // $movies = Movie::with('genre')->get();
        // $genres = Genre::all();
        return view('adminIndex',compact('movies','genres'));
    }

    public function adminCreate(){
        return view('adminCreate');
    }

    public function adminStore(CreateMovieRequest $request){
    try {
        DB::beginTransaction();
        // $inputs = $request->all();
        // Movie::create($inputs);
        //$is_showing = $request->has('is_showing') && $request->is_showing ? true : false;
        $genreName = $request->input('genre'); // ジャンル名の入力
        // 入力されたジャンル名が既に存在していれば既存のレコードの取得、存在していなければ新規のGenreレコードを作成
        // だから同じジャンル名を入力すると、同じgenre_idになる
        $genre = Genre::firstOrCreate(['name' => $genreName]);
        $movie = Movie::create([
            'title' => $request->title,
            'image_url' => $request->image_url,
            'published_year' => $request->published_year,
            'is_showing' => $request->is_showing,
            'description' => $request->description,
            'genre_id' => $genre->id, // ジャンル名のIDを入力
        ]);
        DB::commit();
        }catch(\Throwable $e){
            DB::rollback();
            abort(500);
            // DB::rollback();
            // Log::error('Failed to create movie: ' . $e->getMessage(), ['exception' => $e]);
            // return response()->json(['error' => $e->getMessage()], 500);
        }
        Session::flash('err_msg',' 登録しました');
        return redirect('/admin/movies');
    }

    public function adminEdit($id){
        // ここではmovie_idで取得しているため、genre_idを一意に特定する必要がない
        $movie = Movie::find($id);
        $genre = Genre::find($movie->genre_id);
        return view('adminEdit',compact('movie','genre'));
    }

    public function adminUpdate(UpdateMovieRequest $request,$id){
        try{
            DB::beginTransaction();
            $movie = Movie::find($id);
            $genre = Genre::find($movie->genre_id); 
            // 上２行と下の光っているやつがおかしい、この辺の改善が必要
            $genreName = $request->input('genre'); 
            $genre = Genre::firstOrCreate(['name' => $genreName]);
            // $movie = Movie::find($id); // 登録済みデータの取得
            // $movie-> update($inputs); // 登録済みのデータのみ編集
            //dd($movie,$genre);
            //$is_showing = $request->has('is_showing') && $request->is_showing ? true : false;
            //$genreName = $request->input('genre'); // ジャンル名の入力
            //$genre = Genre::firstOrCreate(['name' => $genreName]); // genreNameがなかったら、新しく作る
            $movie -> update([
                'title' => $request->title,
                'image_url' => $request->image_url,
                'published_year' => $request->published_year,
                'is_showing' => $request->is_showing,
                'description' => $request->description,
                'genre_id' => $genre->id, // ジャンル名のIDを入力
            ]);
            $genre -> update([
                'name' => $request->input('genre'),
            ]);
        DB::commit();
        }catch(\Throwable $e){
            DB::rollback();
            abort(500);
            // DB::rollback();
            // Log::error('Failed to create movie: ' . $e->getMessage(), ['exception' => $e]);
            // return response()->json(['error' => $e->getMessage()], 500);
        }
        Session::flash('err_msg',' 編集しました');
        return redirect('/admin/movies');
    }

    public function adminDestroy($id){
        $movie = Movie::find($id); // 削除するデータの取得
        if(!$movie) return response()->json(['error' => 'Not Found'], 404); // 削除したいデータが取得できないとき
        DB::beginTransaction();
        try{
             // ここでカラムを削除
            $movie->delete();// 削除
            DB::commit();
        }catch(\Throwable $e){
            DB::rollback();
            Log::error('Failed to create movie: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
        Session::flash('err_msg','削除しました');
        return redirect('/admin/movies');
    }

    public function adminSchedules(){
        //$movies = Movie::all();
        //$schedules = Schedule::all();
        //$movies = Movie::with('schedules')->get();
        //昇順に並べ替え
        $movies = Movie::with(['schedules' => function ($query) {
            $query->orderBy('start_time', 'asc');
        }])->get();
        //dd($movies);
        return view('adminSchedules',compact('movies'));
    }

    public function adminSchedulesShow($id){
        $movie = Movie::find($id);
        // orderby句で昇順にソート
        $schedules = Schedule::where('movie_id', $id)->orderBy('start_time')->get();
        //dd($movie,$schedules);
        return view('adminSchedulesShow', compact('movie','schedules'));
    }

    public function adminDetail($id) {
        $movie = Movie::find($id);
        // orderby句で昇順にソート
        $schedules = Schedule::where('movie_id', $id)->orderBy('start_time')->get();
        //dd($movie,$schedules);
        return view('adminDetail', compact('movie','schedules'));
    }

    public function adminSchedulesCreate($id) {
        $movie = Movie::find($id);
        $schedules = Schedule::find($id);
        return view('adminSchedulesCreate',compact('movie','schedules'));
    }

    public function adminSchedulesEdit($id) {
        $schedules = Schedule::find($id);
        return view('adminSchedulesEdit',compact('schedules'));
    }

    public function adminUpdateSchedules(UpdateScheduleRequest $request,$id) {
        // date型にするため、結合
        $start_time = $request->start_time_date . ' ' . $request->start_time_time;
        $end_time = $request->end_time_date . ' ' . $request->end_time_time;
        try{
            DB::beginTransaction();
            $schedules = Schedule::find($id);
            $schedules -> update([
                'start_time' => $start_time,
                'end_time' => $end_time,

            ]);
            DB::commit();
        }catch(\Throwable $e){
            DB::rollback();
            abort(500);
            // DB::rollback();
            // Log::error('Failed to create movie: ' . $e->getMessage(), ['exception' => $e]);
            // return response()->json(['error' => $e->getMessage()], 500);
        }
        Session::flash('err_msg',' 編集しました');
        return redirect('/admin/schedules');
    }

    public function adminStoreSchedules(CreateScheduleRequest $request){
        // date型にするため、結合
        //dd($request);
        $start_time = $request->start_time_date . ' ' . $request->start_time_time;
        $end_time = $request->end_time_date . ' ' . $request->end_time_time;
        try{
            DB::beginTransaction();
            $schedule = Schedule::create([
                'movie_id' => $request->movie_id,
                'start_time' => $start_time,
                'end_time' => $end_time,
            ]);
            DB::commit();
        }catch(\Throwable $e){
            DB::rollback();
            abort(500);
            // DB::rollback();
            // Log::error('Failed to create movie: ' . $e->getMessage(), ['exception' => $e]);
            // return response()->json(['error' => $e->getMessage()], 500);
        }
        Session::flash('err_msg',' 登録しました');
        return redirect('/admin/schedules');
    }

    public function adminDestroySchedules($id) {
        //dd($id);
        $schedule = Schedule::find($id);
        if (!$schedule) return response()->json(['error' => 'Not Found'], 404);
        DB::beginTransaction();
        try{
            $schedule->delete();
            DB::commit();
        }catch(\Throwable $e){
            DB::rollback();
            Log::error('Failed to create movie: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
        Session::flash('err_msg','削除しました');
        return redirect('/admin/schedules');
    }



    public function index(Request $request){
        $keyword = $request->input('keyword');
        $is_showing = $request->input('is_showing');
        // チェックボックス未入力
        if($is_showing == null) $is_showing = 2;
        // 公開中のラジオボックス
   
        // データベースクエリを構築（複数の条件を持たせるため）
        // $queryに条件を持たせるイメージ
        $query = Movie::query();

        // is_showing の条件を追加
        if ($is_showing != 2) {
            $query->where('is_showing', $is_showing);
        }
        // keywordの条件を追加
        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                // $qに複数の条件をまとめる
                $q->where('title', 'like', '%' . $keyword . '%')
                  ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }

        // クエリ（条件）を実行して映画を取得
        $movies = $query->paginate(20);

        return view('index', compact('movies'),compact('is_showing','keyword'));
        // is_showing はラジオボックスのチェックを保持させる目的
    }

    public function detail($id) {
        $movie = Movie::find($id);
        // orderby句で昇順にソート
        $schedules = Schedule::where('movie_id', $id)->orderBy('start_time')->get();
        //dd($movie,$schedules);
        return view('detail', compact('movie','schedules'));
    }

    public function movieSheet(Request $request, $movie_id, $schedule_id){
        //dd($movie_id, $schedule_id);
        $movie = Movie::find($movie_id);
        $schedule = Schedule::find($schedule_id);
        $sheets = Sheet::all();
        $date = $request->date;
        // dd($date);
        // 通常引数の数はweb.phpのルートの中の引数と同じにする必要がある。
        // そのためurlに直接つけることで、ルートの中の引数を同じにしながら、$requestでdateを取得する
        return view('movieSheet',compact('movie','schedule','sheets','date'));
    }

    public function sheetReserve(Request $request, $movie_id, $schedule_id){
        $movie = Movie::find($movie_id);
        $schedule = Schedule::find($schedule_id);
        $sheet = $request->sheet_id;
        $date = $request->date;
        //dd($request);
        //dd($sheet,$date);
        return view('sheetReserve',compact('movie','schedule','sheet', 'date'));
    }

    public function reservationCreate(){}

    public function sheets() {
        $sheets = Sheet::all();
        //dd($seets);
        return view('sheets',compact('sheets'));
    }

} 