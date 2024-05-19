<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelModel;

class LevelController extends Controller
{
    public function index()
    {
        $data = LevelModel::all();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $level = LevelModel::create($request->all());
        return response()->json($level, 201);
    }

    public function show(LevelModel $level)
    {
        return response()->json($level, 200);
    }

    public function update(Request $request, LevelModel $level)
    {
        $level->update($request->all());
        return response()->json($level, 200);
    }

    public function destroy(LevelModel $level)
    {
        $level->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data terhapus'
        ], 200);
    }
}
