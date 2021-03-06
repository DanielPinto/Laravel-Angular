<?php
/**
 * Created by PhpStorm.
 * User: w8
 * Date: 15/02/2016
 * Time: 20:36
 */

namespace CodeProject\Transformers;


use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;
use CodeProject\Transformers\ProjectMemberTransformer;

class ProjectTransformer extends TransformerAbstract
{


    protected $defaultIncludes = ['members'];


    public function transform(Project $project)
    {

        return [

            'project_id'=>$project->id,
            'client_id'=>$project->client_id,
            'owner_id'=>$project->owner_id,
            'project'=>$project->name,
            'description'=>$project->description,
            'progress'=>$project->pprogress,
            'status'=>$project->status,
            'due_date'=>$project->due_date,
        ];

    }

    public function includeMembers(Project $project)
    {

        return $this->collection($project->members , new ProjectMemberTransformer());
    }

}