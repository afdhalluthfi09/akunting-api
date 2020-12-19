<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $transaction = Transaction::orderBy('waktu','DESC')->get();
        $response =[
            'message'=>'Berdasarakan Waktu Pencatatan',
            'data'=>$transaction
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
        //
        $validation = Validator::make($request->all(),[
            'title'=>['required'],
            'amount'=>['required','numeric'],
            'type'=>['required','in:expannse,revenue']
        ]);

        if($validation->fails()){
            return response()->json($validation->errors(),Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            
            $transaction = Transaction::create($request->all());
            $response =[
                'message' => 'Data Berhasil di tambah',
                'data' =>$transaction
            ];

            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            //throw $th;
            return response()->json([
                'message' => 'gagal menambahkan '.$e->errorInfo 
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
        $transaction = Transaction::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'title' => ['required'],
            'amount' =>['required','numeric'],
            'type' =>['required','in:expannse,revenue']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            //code...
            $transaction->update($request->all());
            $response =[
                "message" =>"data sudah di update",
                "data" =>$transaction
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            //throw $th;
            return response()->json([
                "message" => "data tidak berhasil di update ".$e->errorInfo
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
        //
    }
}
