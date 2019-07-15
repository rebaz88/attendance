<?php

namespace App\Filters;

use App\Filters\FilterModel;
use Illuminate\Http\Request;

class ProcessFilterRule
{

    protected $filterRules; // The rules passed from users
    protected $filterModels; // The models from rules
    protected $filters; // The filters that need to be returned to the builder
    protected $allowedFilters;
    protected $excludedFilters;
    protected $request;

    public function __construct(Request $request)
    {
        $this->filterModels = collect([]);
        $this->excludedFilters = collect([]);
        // Extract filter rules from the request
        $this->request = &$request;
        $this->setFilterRules();
    }

    public function setFilterRules()
    {
        $filterRules = $this->request->query('filterRules');

        if ($filterRules) {

            $filterRules = json_decode($filterRules, true);

            if (is_array($filterRules)) {

                $this->filterModels = collect($filterRules)
                    ->map(function ($filterRule) {
                        return new FilterModel($filterRule);
                    });

            }
        }
    }

    public function getFilterModels($filters = [])
    {
        $filters = collect(is_array($filters)
            ? $filters : explode(",", $filters));

        if($filters->count() > 0) {
            return $this->filterModels->filter(function($filterModel) use ($filters){
                return $filters->contains($filterModel->field);
            });
        };

        return $this->filterModels;
    }

    /**
     * Merge with the request in order to comply
     * with the orginal request format
     * filter[name]=value
     */
    public function mergeFilterRules()
    {
        $filters = $this->request->query('filter');
        $excludedFilters = $this->excludedFilters;

        $this->filterModels->each(function ($filterModel)
             use (&$filters, $excludedFilters) {

                if (!$excludedFilters->contains($filterModel->getField())) {
                    $filters[$filterModel->getField()]
                    = $filterModel->getValue();
                }

            });
        $this->request->merge(['filter' => $filters]);
    }

    public function setAllowedFilters($filters)
    {
        $this->allowedFilters = collect(is_array($filters)
            ? $filters : explode(",", $filters));
        return $this;
    }

    public function getAllowedFilters()
    {
        return isset($this->allowedFilters)
        ? $this->allowedFilters
        : $this->filterModels->map(function ($filterModel) {
            return $filterModel->getField();
        });

    }

    public function exclude($filters)
    {
        $this->excludedFilters = collect(is_array($filters)
            ? $filters : explode(",", $filters));
        return $this;
    }

    public function get()
    {
        $allowedFilters = $this->getAllowedFilters();
        $excludedFilters = $this->excludedFilters;
        $this->mergeFilterRules();

        return $this->filterModels
            ->map(function ($filterModel) use ($allowedFilters, $excludedFilters) {
                
                $field = $filterModel->getField();
                if ($excludedFilters->contains($field)) {
                    $filterModel->op = 'exclude';
                }

                if ($allowedFilters->contains($field)) {
                    return $filterModel->assignClass();
                }

            })
            ->filter(function ($filter) {
                return !is_null($filter);
            })->toArray();
    }

    // Return specific user filter param
    public function getFilterInput($filter)
    {
        return $this->filterModels->firstWhere('field', $filter);
    }

}
