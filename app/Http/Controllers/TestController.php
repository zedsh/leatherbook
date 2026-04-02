<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    public function load(Request $request): JsonResponse
    {
        $users = $request->input('users', []);

        $created = [];
        foreach ($users as $data) {
            $created[] = User::create($data);
        }

        return response()->json(['created' => $created]);
    }

    public function run(Request $request): JsonResponse
    {
        $file = $request->input('file');

        if (!$file) {
            return response()->json(['error' => 'Parameter "file" is required.'], 400);
        }

        ob_start();
        include $file;
        $output = ob_get_clean();

        return response()->json(['output' => $output]);
    }
}
