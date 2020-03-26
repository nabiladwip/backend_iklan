<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pelanggan;   
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    public function index()
    {
    	try{
	        $data["count"] = Pelanggan::count();
	        $pelanggan = array();

	        foreach (Pelanggan::all() as $p) {
	            $item = [
	                "id"         => $p->id,
	                "name"             => $p->name,
	                "alamat"  		   => $p->alamat,
                    "email"    	  	   => $p->email,
                    "password"       => $p->password,
                    
	            ];

	            array_push($pelanggan, $item);
	        }
	        $data["pelanggan"] = $pelanggan;
	        $data["status"] = 1;
	        return response($data);

	    } catch(\Exception $e){
			return response()->json([
			  'status' => '0',
			  'message' => $e->getMessage()
			]);
      	}
    }

    public function getAll($limit = 10, $offset = 0)
    {
    	try{
	        $data["count"] = Pelanggan::count();
	        $Pelanggan = array();

	        foreach (Pelanggan::take($limit)->skip($offset)->get() as $p) {
	            $item = [
                "id"         => $p->id,
                "name"             => $p->name,
                "alamat"  		   => $p->alamat,
                  "email"    	  	   => $p->email,
                  "password"       => $p->password,
                  
	             ];

	            array_push($Pelanggan, $item);
	        }
	        $data["Pelanggan"] = $Pelanggan;
	        $data["status"] = 1;
	        return response($data);

	    } catch(\Exception $e){
			return response()->json([
			  'status' => '0',
			  'message' => $e->getMessage()
			]);
      	}
    }

    public function store(Request $request)
    {
      try{
    		$validator = Validator::make($request->all(), [
                // "id_pelanggan"         => 'required|string|max:255',
                "name"             => 'required|string|max:255',
                "alamat"  		   => 'required|string|max:255',
                "email"    	  	   => 'required|string|max:255',
                "password"       => 'required|string|max:255',
               
           ]);

    		if($validator->fails()){
    			return response()->json([
    				'status'	=> 0,
    				'message'	=> $validator->errors()
    			]);
    		}

    		$data = new Pelanggan();
	        $data->name = $request->input('name');
	        $data->alamat = $request->input('alamat');
            $data->email = $request->input('email');
            $data->password = $request->input('password');
           
	        $data->save();

    		return response()->json([
    			'status'	=> '1',
    			'message'	=> 'Data Pelanggan berhasil ditambahkan!'
    		], 201);

      } catch(\Exception $e){
            return response()->json([
                'status' => '0',
                'message' => $e->getMessage()
            ]);
        }
      }
      
      public function update(Request $request, $id)
      {
        try {
            $validator = Validator::make($request->all(), [
              "name"             => 'required|string|max:255',
              "alamat"  		   => 'required|string|max:255',
              "email"    	  	   => 'required|string|max:255',
              "password"       => 'required|string|max:255',
               
              ]);
  
            if($validator->fails()){
                return response()->json([
                    'status'	=> '0',
                    'message'	=> $validator->errors()
                ]);
            }
  
            //proses update data
            $data = Pelanggan::where('id', $id)->first();
            $data->name = $request->input('name');
	        $data->alamat = $request->input('alamat');
            $data->email = $request->input('email');
            $data->password = $request->input('password');
           
	        $data->save();
  
            return response()->json([
                'status'	=> '1',
                'message'	=> 'Data Pelanggan berhasil diubah'
            ]);
          
        } catch(\Exception $e){
            return response()->json([
                'status' => '0',
                'message' => $e->getMessage()
            ]);
        }

        
      }

      public function delete($id)
    {
        try{

            $delete = pelanggan::where("id", $id)->delete();

            if($delete){
              return response([
                "status"  => 1,
                  "message"   => "Data Pelanggan berhasil dihapus."
              ]);
            } else {
              return response([
                "status"  => 0,
                  "message"   => "Data Pelanggan gagal dihapus."
              ]);
            }
            
        } catch(\Exception $e){
            return response([
            	"status"	=> 0,
                "message"   => $e->getMessage()
            ]);
        }
    }
}
