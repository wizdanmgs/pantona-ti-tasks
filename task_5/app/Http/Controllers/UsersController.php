<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = User::query();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="View" class="me-1 btn btn-info btn-sm showUser">View</a>';
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editUser">Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('users.index');
    }

    public function store(UserStoreRequest $request): JsonResponse
    {

        $filled = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $filled['image'] = 'storage/'.$imagePath;
        }

        User::updateOrCreate(['id' => $request->id], $filled);

        return response()->json(['success' => 'User saved successfully.']);
    }

    public function show($id): JsonResponse
    {
        $user = User::find($id);

        return response()->json($user);
    }

    public function edit($id): JsonResponse
    {
        $user = User::find($id);

        return response()->json($user);
    }

    public function update(UserUpdateRequest $request): JsonResponse
    {

        $user = User::find($request->user);

        if ($request->name) {
            $user->name = $request->name;
        }

        if ($request->email) {
            $user->email = $request->email;
        }

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $user->image = 'storage/'.$imagePath;
        }

        $user->save();

        return response()->json(['success' => 'User updated successfully.']);
    }

    public function destroy($id): JsonResponse
    {
        User::find($id)->delete();

        return response()->json(['success' => 'User deleted successfully.']);
    }
}
