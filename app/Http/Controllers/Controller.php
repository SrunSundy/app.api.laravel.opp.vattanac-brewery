<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Traits\ResponseTrait;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ResponseTrait;

    protected $params = [];
     /**
     * Get parameter for filter
     */
    public function getParams()
    {
        $this->params['page'] = request()->get('page', 1) ?? 1;
        $this->params['limit'] = request()->get('limit', 10) ?? 10;
        $this->params['search'] = request()->get('search');
        $this->params['order'] = request()->get('order', 'created_at') ?? 'created_at';
        $this->params['sort'] = request()->get('sort', 'desc') ?? 'desc';
    }
}
