<?php

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class EzPaginateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMacro();
    }


    public function registerMacro()
    {
        Builder::macro('ezPaginate', function ($options = []) {

            $maxSize = $options['maxSize'] ?? 100;
            $defaultSize = $options['defaultSize'] ?? 20;
            $defaultPage = $options['defaultPage'] ?? 1;
            $pageParameter = 'page';
            $sizeParameter = 'rows';

            $page = (int) request()->input($pageParameter, $defaultPage);
            $size = (int) request()->input($sizeParameter, $defaultSize);

            $size = $size > $maxSize ? $maxSize : $size;

            $paginator = $this
                ->paginate($size, ['*'], 'page.'.$pageParameter, $page)
                ->setPageName('page['.$pageParameter.']')
                ->appends(Arr::except(request()->input(), 'page.'.$pageParameter));

            $result = $paginator->toArray();

            $result['rows'] = $result['data'];
            unset($result['data']);

            $result['total'] = $paginator->total();
            return $result;
        });
    }
}
