<?php
/**
 * Created by PhpStorm.
 * User: w8
 * Date: 09/02/2016
 * Time: 11:41
 */

namespace CodeProject\Validators;




use Prettus\Validator\LaravelValidator;

class ProjectNoteValidator extends LaravelValidator
{

    protected $rules = [
        'project_note'=>'required',
        'title'=>'required',
        'note'=>'required',
    ];

}