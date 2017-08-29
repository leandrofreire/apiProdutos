<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Cartao;
use Illuminate\Pagination\Paginator;

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
    public function index(Request $request)
    {
        $qtd = $request['qtd'];
        $page = $request['page'];
        Paginator::currentPageResolver(function () use ($page){
          return $page;
        });
        $cartoes = Cartao::paginate($qtd);

        $cartoes = $cartoes->appends(Request::capture()->except('page'));

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
        if($id < 0){
          return response()->json(['message'=>'Id menor que zero, por favor, informe um ID válido'], 400);
        }
        $cartao = Cartao::find($id);
        if($cartao){
          return response()->json([$cartao], 200);
        }else{
          return response()->json(['message'=>'O veicuo com o '.$id.'não existe'], 404);
        }
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
        $validator = $this->validarCartao($request);
        if($validator->fails()){
          return response()->json
          (['message'=>'Erro','errors'=>$validator->errors()], 400);
        }
        $data = $request->only(['numero', 'data', 'cvv', 'titular', 'cpf']);
        if($data){
          $cartao = Cartao::find($id);
          if($cartao){
            $cartao->update($data);
            return response()->json(['data'=>$cartao], 200);
          }else{
            return response()->json(['message'=>'O cartão com id '.$id.' não existe'], 400);
          }
        }else{
          return response()->json(['message'=>'Dados inválidos'], 400);
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
        if($id < 0){
          return response()->json(['message'=>'Id menor que zero, por favor, informe um ID válido'], 400);
        }
        $cartao = Cartao::find($id);
        if($cartao){
          $cartao->delete();
          return response()->json([], 204);
        }else{
          return response()->json(['message'=>'O cartão com o id '.$id.' não existe'], 404);
        }
    }
}
