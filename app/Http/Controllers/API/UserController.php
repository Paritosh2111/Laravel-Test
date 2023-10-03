<?php

namespace App\Http\Controllers\API;

use App\Models\Company;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Hobby;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('hobbies','experiences')->get();
        $edus = Education::all(); //we need all data of education,company and hobby not relational that's why here 3 different queries i have taken.
        $comps = Company::all();
        $hobbies = Hobby::all();
        return response()->json(['success'=>true,'data'=>$users]);
    }

    public function edit($id)
    {
        $data = User::with('education','company','hobbies')->findorfail($id);
        return response()->json(['success'=>true,'data'=>$data]);
    }

    // Save User Data
    public function save(Request $request)
    {
        // dd($request->all());
        $rules = [
            'name' => 'required|regex:/^[A-Za-z\s]+$/',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:10',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->hasFile('image')) {
            $randomFileName = '/user_' . rand(1000, 9999) . '_' . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $path = $request->file('image')->storeAs('public/images', $randomFileName);
            $url = asset('storage/images/' . $randomFileName);
        }

        $data = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'education_id' => $request->input('education'),
            'company_id' => $request->input('company'),
            'image_path' => $randomFileName,
            'message' => $request->input('message'),
            'gender' => $request->input('gender')
        ]);

        if($request->experience != null){
            foreach($request->experience as $exp){
                $save = Experience::create([
                    'name' => $exp,
                    'user_id' => $data->id
                ]);
            }
        }

        if($request->hobby != null){
            $data_id = User::findorfail($data->id);
            $hobbies = $request->hobby;
            $data_id->hobbies()->attach($hobbies);
        }
        return response(['success' => true, 'data' => $data]);
    }

    public function update(Request $request){

        // dd($request->all());
        $rules = [
            'name' => 'required|regex:/^[A-Za-z\s]+$/',
            'phone' => 'required|numeric|digits:10',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = User::findOrFail($request->id);

        if ($request->hasFile('image')) {
            // Remove the old image if it exists
            if ($data->image_path) {
                Storage::delete('public/images/' . $data->image_path);
            }

            $randomFileName = '/user_' . rand(1000, 9999) . '_' . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $path = $request->file('image')->storeAs('public/images', $randomFileName);
            $url = asset('storage/images/' . $randomFileName);

            $data->update([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'education_id' => $request->input('education'),
                'company_id' => $request->input('company'),
                'image_path' => $randomFileName,
                'message' => $request->input('message'),
                'gender' => $request->input('gender')
            ]);
        } else {
            $data->update([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'education_id' => $request->input('education'),
                'company_id' => $request->input('company'),
                'message' => $request->input('message'),
                'gender' => $request->input('gender')
            ]);
        }

        if ($request->hobby != null) {
            $hobbies = $request->hobby;
            $data->hobbies()->detach();
            $data->hobbies()->attach($hobbies);
        }

        return response()->json(['success' => true,'data' => $data,'message' => "Record Updated Successfully !"]);
    }

    public function delete($id){

        $data = User::findorfail($id);
        $data->delete();
        if($data){
            return response()->json(['success'=>true,'data' => $data,'message' => "Record Deleted Successfully !"]);
        }else{
            return response()->json(['success'=>false]);
        }
    }

    public function search(Request $request) {

        $searchQuery = $request->query('data'); // Get the search input from the query parameter
        $users = User::with('hobbies','education','company')->where(function($query) use ($searchQuery) {
            $query->where('name', 'like', '%' . $searchQuery . '%')
                  ->orWhere('email', 'like', '%' . $searchQuery . '%');
        })->get();

        $edus = Education::all();
        $hobbies = Hobby::all();
        $comps = Company::all();

        // Render the Blade view with the search results
        // $view = view('tableData', ['users' => $users,'edus'=>$edus,'hobbies'=>$hobbies,'comps'=>$comps])->render();

        if (!empty($searchQuery)) {
            return response()->json(['success' => true, 'data' => $users,'message' => "Record Fetched Successfully !"]);
        } else {
            return response()->json(['success' => false]);
        }
    }



}
