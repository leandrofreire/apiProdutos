<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Cartao;

class CartaoController extends Controller
{
   protected function validarCartao($request)
   {
     $Validator = Validator::make($request->all(),[
       'numero'   => 'required',
       'data'     => 'required|numeric|min:0',
       'cvv'      => 'required|numeric|min:0',
       'titular'  => 'required',
       'cpf'      => 'required|numeric|min:0',
     ]);
     return $Validator;
   }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cartoes = Cartao::all();
        return response()->json(['cartoes'=>$cartoes],200);
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
        //Valida os dados da request
        $validator = $this->validarCartao($request);
        if($validator->fails()){
          return response()->json(['message'=>'Erro',
          'errors'=>$validator->errors()],400);
        }
        $data = $request->only(['numero', 'data', 'cvv', 'titular', 'cpf']);
        if ($data) {
          $cartao = Cartao::create($data);
          if ($cartao) {
            return response()->json(['data'=>$cartao], 201);
          }else{
            return response()->json(['message'=>'Erro ao criar cartão'], 400);
          }
        }else{
          return response()->json(['message'=>'Dados inválidos'], 400);
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
