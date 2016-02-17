<?php
/**
 * Created by PhpStorm.
 * User: w8
 * Date: 09/02/2016
 * Time: 11:41
 */

namespace CodeProject\Validators;




use Prettus\Validator\LaravelValidator;

class ClientValidator extends LaravelValidator
{

    protected $rules = [
        'name'=> 'required |max:255',
        'responsible'=>'required|max:255',
        'email'=>'required|email',
        'phone' => 'required',
        'address'=> 'required'
    ];

}