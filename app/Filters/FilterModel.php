<?php

namespace App\Filters;

use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\Filters\FiltersExact;
use Spatie\QueryBuilder\Filters\FiltersScope;
use Spatie\QueryBuilder\Filters\FiltersPartial;
use App\Filters\FiltersStartsWith;
use App\Filters\FiltersEndsWith;
use App\Filters\FiltersLessThan;
use App\Filters\FiltersGreaterThan;
use App\Filters\Between\FiltersBetweenFacade;
use App\Filters\Exact\FiltersExactFacade;
use App\Filters\FiltersExclude;

class FilterModel
{

    public $filter;
    public $field;
    public $value;
    public $op;
    public $mathSign;
    public $fieldType;

    public function __construct($filterRule)
    {
        $this->filter = $filterRule;
        $this->setField();
        $this->setValue();
        $this->setOp();
        $this->setFieldType();
    }

    public function setField()
    {
        $this->field = array_get($this->filter, "field");
    }

    public function setValue()
    {
        $this->value = array_get($this->filter, "value");
    }

    public function setOp()
    {
        $this->op = array_get($this->filter, "op");
        
        switch ($this->op) {
            case '<':
            case 'less':
                $this->mathSign =  '<';
                break;

            case '>':
            case 'greater':
                $this->mathSign =  '>';
                break;

            case '=':
            case 'equal':
            case 'exact':
                $this->mathSign =  '=';
                break;
            
            default:
                # code...
                break;
        }
    }

    public function setFieldType()
    {
        $this->fieldType = array_get($this->filter, "fieldType");
    }

    public function getField()
    {
        return $this->field;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getOp()
    {
        return $this->op;
    }

    public function getFieldType()
    {
        return $this->fieldType;
    }

    public function assignClass()
    {

        $field = $this->field;

        switch ($this->op) {

            case 'starts_with':
                return Filter::custom($field, FiltersStartsWith::class);
                break;

            case 'ends_with':
                return Filter::custom($field, FiltersEndsWith::class);
                break;

            case '<':
            case 'less':
                return Filter::custom($field, FiltersLessThan::class);
                break;

            case '>':
            case 'greater':
                return Filter::custom($field, FiltersGreaterThan::class);
                break;

            case '=':
            case 'equal':
            case 'exact':
                return FiltersExactFacade::getExactFilter($field, $this->fieldType);
                break;

            case 'between':
                return FiltersBetweenFacade::getBetweenFilter($field, $this->fieldType);
                break;
                
            case 'exclude':
                return Filter::custom($field, FiltersExclude::class);
                break;

            default: // contains
                return Filter::partial($field);
                break;
    }

}

}
