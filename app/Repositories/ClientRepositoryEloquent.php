<?php
/**
 * Created by PhpStorm.
 * User: w8
 * Date: 06/02/2016
 * Time: 02:21
 */

namespace CodeProject\Repositories;


use CodeProject\Entities\Client;
use Prettus\Repository\Eloquent\BaseRepository;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository
{
    public function model(){

        return Client::class;
    }

}