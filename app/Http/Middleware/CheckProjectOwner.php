<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Repositories\ProjectRepository;

class CheckProjectOwner
{


    /**
     * @var
     */
    protected $repository;

    public function __construct(ProjectRepository $repository){

        $this->repository = $repository;

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $userId = \Authorizer::getResourceOwnerId();
        $projectId = $request->project;

        if($this->repository->isOwner($projectId , $userId)==false){

            return ['error'=>'access forbidden'];
        }


        return $next($request);
    }
}
