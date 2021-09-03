<?php 

/**
 * Sort list of data
 *
 * @param  $data
 * @return Illuminate\Database\Eloquent\Builder
 */
function sortList($data, $params)
{
    if (filled($params['order'])) {
        return $data->orderBy($params['order'], $params['sort']);
    }

    return $data->orderBy('created_at', 'desc');
}

/**
 * Count total data in a list
 *
 * @param  $data
 * @return Illuminate\Database\Eloquent\Builder
 */
function countList($data)
{
    return $data
        ->count();
}

/**
 * set offset & limit for list of data
 *
 * @param  $data
 * @param $params
 * @return Illuminate\Database\Eloquent\Collection
 */
function offsetLimit($data, $params)
{
    return $data
        ->offset($params['offset'])
        ->limit($params['limit'])
        ->get();
}

/**
 * Get All data
 *
 * @param $data
 * @return mixed
 */
function getAll($data)
{
    return $data->get();
}

/**
 * set offset & limit for list of data
 *
 * @param  $list
 * @param $params
 * @return array
 */
function listLimit($list, $params)
{
    $list = sortList($list, $params);

    $total = countList($list);

    $list = offsetLimit($list, $params);

    return compact('list', 'total');
}

/**
 * sort for list of all data
 *
 * @param $list
 * @param $params
 * @return array
 */
function listAll($list, $params)
{
    $list = sortList($list, $params);

    $total = countList($list);

    $list = getAll($list);

    return compact('list', 'total');
}
