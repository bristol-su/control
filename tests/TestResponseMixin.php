<?php

namespace BristolSU\Tests\ControlDB;

use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\Assert as PHPUnit;

/**
 * @mixin TestResponse
 */
class TestResponseMixin
{

    public function assertPaginatedResponse()
    {
        return function () {
            $this->assertJsonStructure([
                'current_page', 'data', 'first_page_url', 'from', 'last_page', 'last_page_url', 'next_page_url', 'path',
                'per_page', 'prev_page_url', 'to', 'total'
            ]);
        };
    }

    public function assertPerPage()
    {
        return function ($perPage) {

            $realPerPage = $this->json('per_page');
            PHPUnit::assertNotNull($realPerPage, 'No per page attribute found');

            PHPUnit::assertEquals($perPage, $realPerPage);
        };
    }

    public function assertPageIs()
    {
        return function ($page) {

            $realPage = $this->json('current_page');
            PHPUnit::assertNotNull($realPage, 'No current page attribute found');

            PHPUnit::assertEquals($page, $realPage);
        };
    }

    public function assertTotalPages()
    {
        return function ($total) {

            $totalPages = $this->json('last_page');
            PHPUnit::assertNotNull($totalPages, 'No last page attribute found');

            PHPUnit::assertEquals($total, $totalPages);
        };
    }

    public function assertTotalRecords()
    {
        return function ($total) {

            $totalRecords = $this->json('total');
            PHPUnit::assertNotNull($totalRecords, 'No total attribute found');

            PHPUnit::assertEquals($total, $totalRecords);
        };
    }

    public function paginatedJson()
    {
        return function () {
            return $this->json('data');
        };
    }

    public function assertPaginatedJsonCount()
    {
        return function($expected) {
            return $this->assertJsonCount($expected, 'data');
        };
    }

}