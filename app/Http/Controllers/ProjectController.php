<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;
use CodeProject\Http\Requests;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectController extends Controller
{
    /**
     * @var ClientRepository
     */
    protected $repository;

    /**
     * @var ClientService
     */
    protected $service;


    public function __construct(ProjectService $service , ProjectRepository $repository){

        $this->repository = $repository;
        $this->service = $service;

    }


    /**
     * @param ClientRepository $repository
     * @return mixed
     */
    public function index()
    {


        return $this->repository->findWhere(['owner_id'=>\Authorizer::getResourceOwnerId()]);
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
      return $this->service->create($request->all());
      //return Client::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if($this->checkProjectPermissions($id)==false){

            return ['error'=>'access forbidden'];
        }

        return $this->service->find($id);
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
     * @param Request $request
     * @param $id
     * @return array
     */

      public function update(Request $request, $id)
    {
        return $this->service->update($request->all(),$id);
    }

    /**
     * @param $id
     *
     */

    public function destroy($id)
    {
        $this->service->deleta($id);
    }


    private function checkProjectOwner($projectId){

        $userId = \Authorizer::getResourceOwnerId();

        return $this->repository->isOwner($projectId , $userId);

    }


    private function checkProjectMember($projectId){

        $userId = \Authorizer::getResourceOwnerId();

        return $this->repository->hasMember($projectId , $userId);

    }


    private function checkProjectPermissions($projectId)
    {
        if($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId))
        {
            return true;
        }

        return false;
    }

}
