<?php

namespace App\Http\Controllers;

use App\Http\Resources\API\V1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Jambasangsang\Flash\Facades\LaravelFlash;

class UserProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $view = $request->get('view') ?? 'profile';
        return view('jambasangsang.backend.users.profile', compact('user', 'view'));
    }

    public function bio(Request $request)
    {
        $user = Auth::user();
        return view('jambasangsang.backend.users.bio', compact('user', 'view'));
    }

    public function storePhoto(Request $request)
    {
        $user = $request->wantsJson() ? auth('api')->user() : auth()->user();

        $validator = Validator::make($request->all(), [
            'image' => 'required|image'
        ]);

        if ($validator->fails()) {
            return $this->getValidationResponse($request, $validator);
        }

        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $image = uploadOrUpdateFile($request->file('image'), $user->image, \constPath::UserImage);
                $user->update(['image' => $image]);
            }

            DB::commit();

            $message = 'Profile Photo Updated Successfully';

            return $this->getResponse($request, $user, $message);

        } catch (\Throwable $th) {
            DB::rollback();
            return $this->getErrorResponse($request, $th->getMessage());

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $user = $request->wantsJson() ? auth('api')->user() : auth()->user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|different:current_password|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->getValidationResponse($request, $validator);
        }

        try {
            if (Hash::check($request->get('current_password'), $user->password)) {
                DB::beginTransaction();

                $user->update([
                    'password' => Hash::make($request->get('new_password'))
                ]);

                DB::commit();

                $message = 'Password Updated Successfully';

                return $this->getResponse($request, $user, $message);
            } else {
                return $this->getErrorResponse($request);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->getErrorResponse($request, $th->getMessage());
        }
    }

    private function getValidationResponse($request, $validator)
    {
        if ($request->wantsJson()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            LaravelFlash::withError('OOPS! ' . $validator->errors()->first());
            return redirect()->back();
        }
    }

    private function getResponse($request, $user, $message)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'message' => $message,
                'user' => new UserResource($user),
            ]);
        } else {
            LaravelFlash::withSuccess($message);
            return redirect()->back();
        }
    }

    private function getErrorResponse($request, $message = null)
    {
        if ($request->wantsJson()) {
            return response()->json(['error' => $message], 500);
        } else {
            LaravelFlash::withError($message);
            return back();
        }
    }
}
