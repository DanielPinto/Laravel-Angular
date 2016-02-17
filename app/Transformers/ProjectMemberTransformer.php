<?php
/**
 * Created by PhpStorm.
 * User: w8
 * Date: 15/02/2016
 * Time: 20:36
 */

namespace CodeProject\Transformers;


use CodeProject\Entities\User;
use League\Fractal\TransformerAbstract;

class ProjectMemberTransformer extends TransformerAbstract
{

    public function transform(User $member)
    {

        return [

            'member_id'=>$member->id
        ];

    }

}