<?php

namespace App\Http\Controllers;

use App\Ad;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    public function index()
    {
        return Ad::all();
    }

    public function show($id)
    {
        try {
            return Ad::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'error' => [
                        'message' => 'Ad not found'
                    ]
                ],
                404
            );
        }
    }

    public function store(Request $request)
    {
//        try {
            $ad = Ad::create($request->all());
//        } catch (\Exception $exception) {
//            dd(get_class($exception));
//        }
        return response()->json(
            ['created' => true],
            201,
            [
                'Location' => route('ads.show', ['id' => $ad->id])
            ]
        );
    }

    public function update(Request $request, $id)
    {
        try {
            $ad = Ad::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'error' => [
                        'message' => 'Ad not found'
                    ]
                ],
                404
            );
        }

        $ad->fill($request->all());
        $ad->save();

        return $ad;
    }

    public function destroy($id)
    {
        try {
            $ad = Ad::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'error' => [
                        'message' => 'Ad not found'
                    ]
                ],
                404
            );
        }

        $ad->delete();

        return response(null, 204);
    }
}
