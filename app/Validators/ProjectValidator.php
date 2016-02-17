<?php
/**
 * Created by PhpStorm.
 * User: w8
 * Date: 09/02/2016
 * Time: 11:41
 */

namespace CodeProject\Validators;




use Prettus\Validator\LaravelValidator;

class ProjectValidator extends LaravelValidator
{

    protected $rules = [
        'owner_id'=> 'required',
        'client_id'=>'required',
        'name'=>'required',
        'description' => 'required',
        'progress'=> 'required',
        'status'=> 'required',
        'due_date'=> 'required',
    ];

}