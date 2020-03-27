<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;   
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{

    public function index()
    {
    	try{
	        $data["count"] = Barang::count();
	        $sbarangiswa = array();

	        foreach (Barang::all() as $p) {
	            $item = [
	                "id"          => $p->id,
	                "nama_barang"         => $p->nama_barang,
	                "deskripsi"  => $p->deskripsi,
	                "harga"    	  => $p->harga,
	                "created_at"  => $p->created_at,
	                "updated_at"  => $p->updated_at
	            ];

	            array_push($barang, $item);
	        }
	        $data["barang"] = $barang;
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
	        $data["count"] = Barang::count();
	        $barang = array();

	        foreach (Barang::take($limit)->skip($offset)->get() as $p) {
	            $item = [
                    "id"          => $p->id,
	                "nama_barang" => $p->nama_barang,
	                "deskripsi"   => $p->deskripsi,
	                "harga"    	  => $p->harga,
	                "created_at"  => $p->created_at,
	                "updated_at"  => $p->updated_at
	            ];

	            array_push($barang, $item);
	        }
	        $data["barang"] = $barang;
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
    			'nama_barang'      => 'required|string|max:255',
				'deskripsi'			  => 'required|string|max:255',
				'harga'			  => 'required|string|max:255',
    		]);

    		if($validator->fails()){
    			return response()->json([
    				'status'	=> 0,
    				'message'	=> $validator->errors()
    			]);
    		}

    		$data = new Barang();
	        $data->nama_barang = $request->input('nama_barang');
	        $data->deskripsi = $request->input('deskripsi');
	        $data->harga = $request->input('harga');
	        $data->save();

    		return response()->json([
    			'status'	=> '1',
    			'message'	=> 'Barang berhasil ditambahkan!'
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
			'nama_barang'      => 'required|string|max:255',
			'deskripsi'			  => 'required|string|max:255',
			'harga'			  => 'required|string|max:255',
		]);

      	if($validator->fails()){
      		return response()->json([
      			'status'	=> '0',
      			'message'	=> $validator->errors()
      		]);
      	}

      	//proses update data
      	$data = Barang::where('id', $id)->first();
        $data->nama_barang = $request->input('nama_barang');
        $data->deskripsi = $request->input('deskripsi');
        $data->harga = $request->input('harga');
        $data->save();

      	return response()->json([
      		'status'	=> '1',
      		'message'	=> 'Barang berhasil diubah'
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

            $delete = Barang::where("id", $id)->delete();

            if($delete){
              return response([
              	"status"	=> 1,
                  "message"   => "Barang berhasil dihapus."
              ]);
            } else {
              return response([
                "status"  => 0,
                  "message"   => "Barang gagal dihapus."
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
