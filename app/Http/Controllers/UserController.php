<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $user = User::paginate(100)->all();

        $response = ['success' => true, 'data' => $user];
        return response($response, 200);
    }

    /**
     * @param $id
     * @return Response
     */
    public function show($id): Response
    {
        $user = User::find($id);

        $response = ['success' => true, 'data' => $user];
        return response($response, 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update(UpdateUserRequest $request, $id): Response
    {
        $user = User::find($id);

        if (!$user) {
            $response = ['success' => false, 'message' => 'The user was not found.'];
            return response($response, 404);
        }

        $user->update($request->all());
        $response = ['success' => true, 'message' => 'The user have been successfully updated.'];
        return response($response, 200);
    }

    /**
     * @param $id
     * @return Response
     */
    public function destroy($id): Response
    {
        $user = User::find($id);

        if (!$user) {
            $response = ['success' => false, 'message' => 'The user was not found.'];
            return response($response, 404);
        }

        $user->delete();

        $response = ['success' => true, 'message' => 'The car have been successfully removed.'];
        return response($response, 200);
    }
}
