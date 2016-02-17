<?php
/**
 * Created by PhpStorm.
 * User: w8
 * Date: 09/02/2016
 * Time: 10:33
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ClientRepository;
use CodeProject\Validators\ClientValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Prettus\Validator\Exceptions\ValidatorException;

class ClientService
{



    /**
     * @param ClientRepository $repository
     * @param ClientValidator $validator
     */

    protected $repository;
    protected $validator;
    public function __construct(ClientRepository $repository , ClientValidator $validator){

        $this->repository = $repository;
        $this->validator = $validator;

    }



    public function create(array $data){

        try{

            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);

        }catch (ValidatorException $e){

            return [
                'error'=>true,
                'message'=>$e->getMessageBag()
            ];

        }




    }



    public function update(array $data , $id){

        try{

            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data,$id);

        }catch (ValidatorException $e){

            return [
                'error'=>true,
                'message'=>$e->getMessageBag()
            ];

        }


    }






    public function all(){

        try {

            $data =  $this->repository->all();

            if( count($data) > 0 ){

                return $data;

            }else{

                return[
                    'error'=>true,
                    'message'=>'Nao existe Cliente',
                ];

            }

        }catch (\Exception $e){

            return[
                'error'=>true,
                'message'=>'Ocorreu algum erro'
            ];

        }

    }



    public function find($id){

        try {

            return $this->repository->find($id);


        }catch (ModelNotFoundException $e) {

            return [
                'error'=>true,
                'message'=>'Cliente nao encontrado!'
            ];

        }catch (QueryException $e){

            return[
                'error'=>true,
                'message'=>'Erro'
            ];

        }catch (\Exception $e){

            return[
                'error'=>true,
                'message'=>'Ocorreu algum erro ao buscar este Cliente'
            ];

        }

    }



    public function deleta($id){

        try {



            $this->repository->find($id)->delete();
            return [
                'success'=>true,
                'message'=>'Cliente deletado com sucesso!'
            ];


        } catch (ModelNotFoundException $e) {

            return [
                'error'=>true,
                'message'=>'Cliente não Existe!.'
            ];


        }catch (QueryException $e) {

            return [
                'error'=>true,
                'message'=>'Cliente não pode ser apagado!.'
            ];

        }catch (\Exception $e) {

            return [
                'error'=>true,
                'message'=>'Ocorreu algum erro ao excluir o Cliente.'
            ];

        }
    }






}