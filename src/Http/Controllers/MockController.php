<?php

namespace Blok\Mock\Http\Controllers;

use Blok\Mock\Mock;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function index($table, Request $request)
    {
        $folder = public_path(Mock::getPath() . '/' . $table);

        if (is_file(Mock::getPath() . '/' . $table . '.json')) {
            $data = json_decode(file_get_contents(Mock::getPath() . '/' . $table . '.json'), true);
            return response()->json($data);
        }

        if (!is_dir($folder)) {
            \File::makeDirectory($folder, 0775, true);
        }

        $files = \File::allFiles(public_path(Mock::getPath() . '/' . $table));

        $data = [];

        foreach ($files as $file) {
            $item = json_decode(file_get_contents($file->getRealPath()), true);

            if (!isset($item["id"])) {
                $item["id"] = str_replace(".json", "", $file->getBasename());
            }

            $data[] = $item;
        }

        if (config("mock.paginate")) {
            // Get current page form url e.x. &page=1
            $currentPage = LengthAwarePaginator::resolveCurrentPage();

            // Create a new Laravel collection from the array data
            $itemCollection = collect($data);

            // Define how many items we want to be visible in each page
            $perPage = config("mock.per_page");

            // Slice the collection to get the items to display in current page
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->values()->all();

            // Create our paginator and pass it to the view
            $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);

            // set url path for generted links
            $paginatedItems->setPath($request->url());

            return $paginatedItems;
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
