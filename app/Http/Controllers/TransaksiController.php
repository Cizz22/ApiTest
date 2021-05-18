<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use GuzzleHttp\Psr7\Message;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksi = Transaksi::orderBy('created_at','DESC')->get();
        $response = [
            'message' => 'Data Transaksi',
            'data' => $transaksi
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => ['required'],
            'amount' => ['required', 'numeric']
        ]);

        if($data->fails()){
            return response()->json($data->errors() , Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $transaksi = Transaksi::create($request->all());
            $response = [
                'message' => 'Data Transaksi Tersimpan',
                'data' => $transaksi
            ];
            return response()->json($response, Response::HTTP_CREATED);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed '. $e->errorInfo
            ]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $response = [
            'message' => 'Informasi Data Transaksi',
            'data' => $transaksi
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $transaksi = Transaksi::findOrFail($id);


        $data = Validator::make($request->all(), [
            'name' => ['required'],
            'amount' => ['required', 'numeric']
        ]);

        if($data->fails()){
            return response()->json($data->errors() , Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $transaksi->update($request->all());

            $response = [
                'message' => 'Data Transaksi Diubah',
                'data' => $transaksi
            ];
            return response()->json($response, Response::HTTP_OK);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed '. $e->errorInfo
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        try {
            $transaksi->delete();
            $response = [
                'message' => 'Data Dihapus',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed '.$e->errorInfo
            ]);
        }


    }
}
