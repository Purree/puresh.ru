<?php

namespace App\Traits\Controller;

use Illuminate\Http\Exceptions\HttpResponseException;

trait CheckIsPaginatorPageExists
{
    public string $pageNumber = '1';

    private function updatePageNumber($pageNumber = null): void
    {
        $this->pageNumber = $pageNumber ?? $_GET['page'] ?? '1';
    }

    private function validatePageNumber($paginator, $routeName, $pageNumber = null) {
        if($paginator->lastPage() < ($pageNumber ?? $this->pageNumber)) {
            /* Livewire logic has a different from the standard redirect logic, for this reason we return Redirect class if
               component is livewire extender */
            if(parent::class === 'Livewire\Component'){
                return \Redirect::route($routeName, ['page' => $paginator->lastPage()]);
            }

            $this->forcedRedirect($routeName, ['page' => $paginator->lastPage()]);
        }
    }

    private function forcedRedirect($route, $params) {
        throw new HttpResponseException(\Redirect::route($route, $params)->with('status', 'Page doesn`t exist.'));
    }
}
