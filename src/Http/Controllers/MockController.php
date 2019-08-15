<?php

namespace Blok\Mock\Http\Controllers;

use Blok\Mock\Mock;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\HeaderBag;

/**
 * Data mock controller into json (for testing an mocking)
 */
class MockController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $table
     * @param $method
     * @param $request Request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function _handleValidation($table, $method, $request){

        $validation = config("mock.entrypoints.".$table.".".$method."_validation");

        if (config("mock.force_json") || config("mock.entrypoints.".$table.".".$method."_force_json")) {
            $request->server->set('HTTP_ACCEPT', 'application/json');
            $request->headers = new HeaderBag($request->server->getHeaders());
        }

        if ($validation) {
            if (is_array($validation)) {
                $this->validate($request, $validation);
            } else {

                $formRequest = new $validation($request->query->all(), $request->request->all(), $request->attributes->all(), $request->cookies->all(), $request->files->all(), $request->server->all(), $request->getContent());

                $this->validate($formRequest, $formRequest->rules());
            }
        }
    }

    /**
     * @param $table
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse|LengthAwarePaginator|Collection|mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index($table, Request $request)
    {
        $this->_handleValidation($table, "index", $request);

        $entity = config("mock.entrypoints.".$table);

        if ($entity) {

            /**
             * @var $data Collection
             */
            $data = factory($entity["class"], $entity["number"])->states($entity["states"])->make($entity["override"]);

            $data = $data->map(function ($item, $key) {

                if (!$item["id"]) {
                    $item['id'] = $key + 1;
                }

                return $item;
            });

        } else {

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

    /**
     * @param $table
     * @param Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store($table, Request $request)
    {
        $this->_handleValidation($table, "store", $request);

        $folder = public_path(Mock::getPath() . '/' . $table);

        if (!is_dir($folder)) {
            \File::makeDirectory($folder, 493, true);
        }

        $data = $request->all();
        $data['id'] = uniqid();

        \File::put($folder . '/' . $data['id'] . '.json', json_encode($data));

        return $data;
    }

    /**
     * @param $table
     * @param $id
     * @param Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($table, $id, Request $request)
    {
        $this->_handleValidation($table, "update", $request);

        $folder = public_path(Mock::getPath() ."/". $table);

        if (!is_dir($folder)) {
            \File::makeDirectory($folder, 493, true);
        }

        $data = $request->all();

        if (!isset($data["id"])) {
            $data["id"] = $id;
        }

        \File::put($folder . '/' . $data['id'] . '.json', json_encode($data));

        return $data;
    }

    /**
     * @param $table
     * @param $id
     * @param Request $request
     * @return Collection|mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function view($table, $id, Request $request)
    {
        $this->_handleValidation($table, "view", $request);

        $entity = config("mock.entrypoints.".$table);

        if ($entity) {

            /**
             * @var $data Collection
             */
            $data = factory($entity["class"])->states($entity["states"])->make($entity["override"]);

            if (!$data->id) {
                $data->id = $id;
            }

        } else {

            $folder = public_path(Mock::getPath() . '/' . $table);

            $data = json_decode(file_get_contents($folder . '/' . $id . '.json'), true);
        }

        return $data;
    }
}
