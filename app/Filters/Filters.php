<?php
/**
 * Created by PhpStorm.
 * User: gordo
 * Date: 02.12.18
 * Time: 18:01
 */

namespace App\Filters;


use Illuminate\Http\Request;

abstract class Filters
{

    /**
     * @var Request
     */
    protected $request;

    protected $builder;

    protected $filters = [];

    /**
     * ThreadFilters constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }
        return $this->builder;
    }

    protected function filters()
    {
        return $this->request->only($this->filters);
    }
}
