<?php

namespace Blok\Mock\Http\Controllers;

use Blok\Mock\Mock;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

/**
 * Data mock controller into json (for testing an mocking)
 */
class MockController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index($table)
    {
        $folder = public_path(Mock::getPath() . '/' . $table);

        if (is_file(Mock::getPath() . '/' . $table . '.json')) {
            $data = json_decode(file_get_contents(Mock::getPath() . '/' . $table . '.json'), true);
            return response()->json($data);
        }

        if (!is_dir($folder)) {
            \File::makeDirectory($folder, 775, true);
        }

        $files = \File::allFiles(public_path(Mock::getPath() . '/' . $table));

        $data = [];

        foreach ($files as $file) {
            $item = json_decode(file_get_contents($file->getRealPath()), true);
            $data[] = $item;
        }

        return $data;
    }

    public function store($table, Request $request)
    {
        $folder = public_path(Mock::getPath() . '/' . $table);

        if (!is_dir($folder)) {
            \File::makeDirectory($folder, 493, true);
        }

        $data = $request->all();
        $data['id'] = uniqid();

        file_put_contents($folder . '/' . $data['id'] . '.json', json_encode($data));

        return $data;
    }

    public function update($table, $id, Request $request)
    {
        $folder = public_path(Mock::getPath() . $table . '/' . $id);

        if (!is_dir($folder)) {
            \File::makeDirectory($folder, 493, true);
        }

        $data = $request->all();

        file_put_contents($folder . '/' . $data['id'] . '.json', json_encode($data));

        return $data;
    }

    public function view($table, $id)
    {
        $folder = public_path(Mock::getPath() . '/' . $table);

        $data = json_decode(file_get_contents($folder . '/' . $id . '.json'), true);

        return $data;
    }
}
