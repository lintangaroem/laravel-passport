<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get data from table barang
        $barang = Barang::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Barang',
            'data'    => $barang  
        ], 200);

    }
    
     /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        //find barang by ID
        $barang = Barang::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Barang',
            'data'    => $barang
        ], 200);

    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama'   => 'required',
            'harga' => 'required',
            'stok' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $barang = Barang::create([
            'nama'     => $request->nama,
            'harga'   => $request->harga,
            'stok'   => $request->stok,
        ]);

        //success save to database
        if($barang) {

            return response()->json([
                'success' => true,
                'message' => 'Barang Created',
                'data'    => $barang  
            ], 201);

        } 

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Barang Failed to Save',
        ], 409);

    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $barang
     * @return void
     */
    public function update(Request $request, Barang $barang)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama'   => 'required',
            'harga' => 'required',
            'stok' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find barang by ID
        $barang = Barang::findOrFail($barang->id);

        if($barang) {

            //update barang
            $barang->update([
                'nama'     => $request->nama,
                'harga'   => $request->harga,
                'stok'   => $request->stok,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Barang Updated',
                'data'    => $barang  
            ], 200);

        }

        //data barang not found
        return response()->json([
            'success' => false,
            'message' => 'Barang Not Found',
        ], 404);

    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //find barang by ID
        $barang = Barang::findOrfail($id);

        if($barang) {

            //delete barang
            $barang->delete();

            return response()->json([
                'success' => true,
                'message' => 'Barang Deleted',
            ], 200);

        }

        //data barang not found
        return response()->json([
            'success' => false,
            'message' => 'Barang Not Found',
        ], 404);
    }
}
