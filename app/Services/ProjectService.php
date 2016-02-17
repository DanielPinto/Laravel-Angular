<?php
/**
 * Created by PhpStorm.
 * User: w8
 * Date: 09/02/2016
 * Time: 10:33
 */

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Prettus\Validator\Exceptions\ValidatorException;

use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Filesystem\Filesystem;

class ProjectService
{


    /**
     * @var ProjectRepository
     *
     */
    protected $repository;

    /**
     * @var ProjectValidator
     */
    protected $validator;
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var Storage
     */
    private $storage;


    /**
     * @param ProjectRepository $repository
     * @param ProjectValidator $validator
     * @param Filesystem $filesystem
     */
    public function __construct(ProjectRepository $repository , ProjectValidator $validator , Filesystem $filesystem , Storage $storage){

        $this->repository = $repository;
        $this->validator = $validator;

        $this->filesystem = $filesystem;
        $this->storage = $storage;
    }



    public function create(array $data){

        try{


            $this->validator->with($data)->passesOrFail();
            $this->repository->create($data);
            return [
                'success'=>true,
                'message'=>'Projeto criado com sucesso!',
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



    public function update(array $data , $id){


        try{


            $this->validator->with($data)->passesOrFail();
            $this->repository->update($data,$id);

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


    public function deleta($id){

        try {



                $this->repository->find($id)->passesOrFail()->delete();
                return [
                    'success'=>true,
                    'message'=>'Projeto deletado com sucesso!'
                ];


        } catch (ModelNotFoundException $e) {

            return [
                'error'=>true,
                'message'=>'Projeto não Existe!.'
            ];


        }catch (QueryException $e) {

            return [
                'error'=>true,
                'message'=>'Projeto não pode ser apagado pois existe um ou mais clientes vinculados a ele.'
            ];

        }catch (\Exception $e) {

            return [
                'error'=>true,
                'message'=>'Ocorreu algum erro ao excluir o projeto.'
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

    public function createFile(array $data)
    {
        $project = $this->repository->skipPresenter()->find($data['project_id']);

        $projectFile = $project->files()->create($data);


        $this->storage->put($projectFile->id.".".$data['extension'] , $this->filesystem->get($data['file']));

    }

}