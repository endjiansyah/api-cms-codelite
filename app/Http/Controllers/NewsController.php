<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    function index()
    {
        $news = News::query()->get();

        return response()->json([
            "status" => true,
            "message" => "list news",
            "data" => $news
        ]);
    }

    function show($id)
    {
        $news = News::query()
            ->where("id", $id)
            ->first();

        if (!isset($news)) {
            return response()->json([
                "status" => false,
                "message" => "data kosong",
                "data" => null
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "nyoh",
            "data" => $news
        ]);
    }

    function store(Request $request)
    {
        $payload = $request->all();
        if (!isset($payload['title'])) {
            return response()->json([
                "status" => false,
                "message" => "data tidak ditemukan",
                "data" => null
            ]);
        }

        //-----
        $file = $request->file("banner");
        $filename = $file->hashName();
        $file->move("foto", $filename);
        $path = $request->getSchemeAndHttpHost() . "/foto/" . $filename;
        $payload['banner'] =  $path;
         //----

        $news = News::query()->create($payload);
        return response()->json([
            "status" => true,
            "message" => "data tersimpan",
            "data" => $news
        ]);
    }

    function update(Request $request, $id)
    {
        $news = News::query()->where("id", $id)->first();
        if (!isset($news)) {
            return response()->json([
                "status" => false,
                "message" => "luru nopo mas?",
                "data" => null
            ]);
        }

        $payload = $request->all();

        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $filename = $file->hashName();
            $file->move('foto', $filename);
            $path = $request->getSchemeAndHttpHost() . '/foto/' . $filename;
            $payload['banner'] = $path;

            $lokasibanner = str_replace($request->getSchemeAndHttpHost(), '', $news->banner);
            $banner = public_path($lokasibanner);
            unlink($banner);
        }

        $news->fill($payload);
        $news->save();

        return response()->json([
            "status" => true,
            "message" => "perubahan data tersimpan",
            "data" => $news
        ]);
    }

    function destroy(Request $request,$id)
    {
        $news = News::query()->where("id", $id)->first();
        if (!isset($news)) {
            return response()->json([
                "status" => false,
                "message" => "data kosong",
                "data" => null
            ]);
        }
        if($news->banner != ''){
            $lokasibanner = str_replace($request->getSchemeAndHttpHost(), '', $news->banner);
                $banner = public_path($lokasibanner);
                unlink($banner);
        }

        $news->delete();

        return response()->json([
            "status" => true,
            "message" => "Data Terhapus",
            "data" => $news
        ]);
    }

}
