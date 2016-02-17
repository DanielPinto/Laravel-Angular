<?php
/**
 * Created by PhpStorm.
 * User: w8
 * Date: 09/02/2016
 * Time: 10:33
 */

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Validators\ProjectNoteValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectNoteService
{


    /**
     * @var ProjectNoteRepository
     *
     */
    protected $repository;

    /**
     * @var ProjectNoteValidator
     */
    protected $validator;



    public function __construct(ProjectNoteRepository $repository , ProjectNoteValidator $validator){

        $this->repository = $repository;
        $this->validator = $validator;

    }



    public function create(array $data){

        try{


            $this->validator->with($data)->passesOrFail();
            $this->repository->create($data);
            return [
                'success'=>true,
                'message'=>'Nota do Projeto criado com sucesso!',
            ];

        }catch (ValidatorException $e){

            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];
        }catch(QueryException $e){

            return [
                'error' => true,
                'message' => 'Erro ao Inserir os dados na Base!',
            ];

        }catch(\Exception $e){

            return [
                'error' => true,
                'message' => 'Ocorreu algum Erro',
            ];
        }




    }



    public function update(array $data , $id , $noteId){


        try{


            $this->validator->with($data)->passesOrFail();
            $this->repository->update($data,$noteId);

            return [
                'success' => true,
                'message' => 'Os dados foram alterados com sucesso!'
            ];


        }catch (ValidatorException $e){

            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];

        }catch(QueryException $e){

            return [
                'error' => true,
                'message' => 'Erro ao fazer o update dos dados!'
            ];

        }catch(ModelNotFoundException $e){

            return [
                'error' => true,
                'message' => 'Este Projeto nao existe!',
            ];

        }catch(\Exception $e){

            return [
                'error' => true,
                'message' => 'Ocorreu algum erro!',
            ];
        }


    }


    public function destroy($id,$noteId){

        try {

                $this->repository->find($noteId)->delete();
                return [
                    'success'=>true,
                    'message'=>'Nota do Projeto deletado com sucesso!'
                ];


        } catch (ModelNotFoundException $e) {

            return [
                'error'=>true,
                'message'=>'nota do Projeto não Existe!.'
            ];


        }catch (QueryException $e) {

            return [
                'error'=>true,
                'message'=>'Nota do Projeto não pode ser apagado pois existe um ou mais clientes vinculados a ele.'
            ];

        }catch (\Exception $e) {

            return [
                'error'=>true,
                'message'=>'Ocorreu algum erro ao excluir a nota do projeto.'
            ];

        }
    }





    public function find($id){

        try {

            return $this->repository->find($id);


        }catch (ModelNotFoundException $e) {

            return [
                'error'=>true,
                'message'=>'Projeto nao encontrado!'
            ];

        }catch (QueryException $e){

            return[
                'error'=>true,
                'message'=>'Erro'
            ];

        }catch (\Exception $e){

            return[
                'error'=>true,
                'message'=>'Ocorreu algum erro ao buscar este projeto'
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
                    'message'=>'Nao existe Projetos',
                ];

            }

        }catch (\Exception $e){

            return[
                'error'=>true,
                'message'=>'Ocorreu algum erro'
            ];

        }

    }

}