<?php

namespace Bootstrap\Test\TestCase\View\Helper;

use Bootstrap\View\Helper\PaginatorHelper;
use Cake\Core\Configure;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use Cake\View\View;

class PaginatorHelperTest extends TestCase {

    /**
     * Instance of PaginatorHelper.
     *
     * @var PaginatorHelper
     */
    public $Paginator;

    /**
     * View associated with the PaginatorHelper.
     *
     * @var View
     */
    public $View;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $request = new ServerRequest([
            'url' => '/',
            'params' => [
                'plugin' => null,
                'controller' => '',
                'action' => 'index',
            ],
        ]);
        $request = $request->withAttribute('paging', [
            'Article' => [
                'page' => 1,
                'current' => 9,
                'count' => 62,
                'prevPage' => false,
                'nextPage' => true,
                'pageCount' => 7,
                'sort' => null,
                'direction' => null,
                'limit' => null,
            ],
        ]);
        $this->View = new View($request);
        $this->View->loadHelper('Html', [
            'className' => 'Bootstrap.Html'
        ]);
        $this->Paginator = new PaginatorHelper($this->View);
        Router::reload();
        Router::connect('/:controller/:action/*');
        Router::connect('/:plugin/:controller/:action/*');
        Router::setRequest($request);
    }

    public function testNumbers()
    {
        $this->View->setRequest($this->View->getRequest()->withAttribute('paging', [
            'Client' => [
                'page' => 8,
                'current' => 3,
                'count' => 30,
                'prevPage' => false,
                'nextPage' => 2,
                'pageCount' => 15,
            ],
        ]));
        $result = $this->Paginator->numbers();
        $expected = [
            ['ul' => ['class' => 'pagination']],
            ['li' => []], ['a' => ['href' => '/index?page=4']], '4', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=5']], '5', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=6']], '6', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=7']], '7', '/a', '/li',
            ['li' => ['class' => 'active']], ['a' => ['href' => '']], '8', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=9']], '9', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=10']], '10', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=11']], '11', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=12']], '12', '/a', '/li',
            '/ul'
        ];
        $this->assertHtml($expected, $result);
        $result = $this->Paginator->numbers(['first' => 'first', 'last' => 'last']);
        $expected = [
            ['ul' => ['class' => 'pagination']],
            ['li' => []], ['a' => ['href' => '/index']], 'first', '/a', '/li',
            ['li' => ['class' => 'ellipsis disabled']], ['a' => []], '&hellip;', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=4']], '4', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=5']], '5', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=6']], '6', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=7']], '7', '/a', '/li',
            ['li' => ['class' => 'active']], ['a' => ['href' => '']], '8', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=9']], '9', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=10']], '10', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=11']], '11', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=12']], '12', '/a', '/li',
            ['li' => ['class' => 'ellipsis disabled']], ['a' => []], '&hellip;', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=15']], 'last', '/a', '/li',
            '/ul'
        ];
        $this->assertHtml($expected, $result);
        $result = $this->Paginator->numbers(['first' => '2', 'last' => '8']);
        $expected = [
            ['ul' => ['class' => 'pagination']],
            ['li' => []], ['a' => ['href' => '/index']], '2', '/a', '/li',
            ['li' => ['class' => 'ellipsis disabled']], ['a' => []], '&hellip;', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=4']], '4', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=5']], '5', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=6']], '6', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=7']], '7', '/a', '/li',
            ['li' => ['class' => 'active']], ['a' => ['href' => '']], '8', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=9']], '9', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=10']], '10', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=11']], '11', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=12']], '12', '/a', '/li',
            ['li' => ['class' => 'ellipsis disabled']], ['a' => []], '&hellip;', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=15']], '8', '/a', '/li',
            '/ul'
        ];
        $this->assertHtml($expected, $result);
        $result = $this->Paginator->numbers(['first' => '8', 'last' => '8']);
        $expected = [
            ['ul' => ['class' => 'pagination']],
            ['li' => []], ['a' => ['href' => '/index']], '8', '/a', '/li',
            ['li' => ['class' => 'ellipsis disabled']], ['a' => []], '&hellip;', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=4']], '4', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=5']], '5', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=6']], '6', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=7']], '7', '/a', '/li',
            ['li' => ['class' => 'active']], ['a' => ['href' => '']], '8', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=9']], '9', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=10']], '10', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=11']], '11', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=12']], '12', '/a', '/li',
            ['li' => ['class' => 'ellipsis disabled']], ['a' => []], '&hellip;', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=15']], '8', '/a', '/li',
            '/ul'
        ];
        $this->assertHtml($expected, $result);
        $this->View->setRequest($this->View->getRequest()->withAttribute('paging', [
            'Client' => [
                'page' => 1,
                'current' => 3,
                'count' => 30,
                'prevPage' => false,
                'nextPage' => 2,
                'pageCount' => 15,
            ]
        ]));
        $result = $this->Paginator->numbers();
        $expected = [
            ['ul' => ['class' => 'pagination']],
            ['li' => ['class' => 'active']], ['a' => ['href' => '']], '1', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=2']], '2', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=3']], '3', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=4']], '4', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=5']], '5', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=6']], '6', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=7']], '7', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=8']], '8', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=9']], '9', '/a', '/li',
            '/ul'
        ];
        $this->assertHtml($expected, $result);
        $this->View->setRequest($this->View->getRequest()->withAttribute('paging', [
            'Client' => [
                'page' => 14,
                'current' => 3,
                'count' => 30,
                'prevPage' => false,
                'nextPage' => 2,
                'pageCount' => 15,
            ]
        ]));
        $result = $this->Paginator->numbers();
        $expected = [
            ['ul' => ['class' => 'pagination']],
            ['li' => []], ['a' => ['href' => '/index?page=7']], '7', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=8']], '8', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=9']], '9', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=10']], '10', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=11']], '11', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=12']], '12', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=13']], '13', '/a', '/li',
            ['li' => ['class' => 'active']], ['a' => ['href' => '']], '14', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=15']], '15', '/a', '/li',
            '/ul'
        ];
        $this->assertHtml($expected, $result);
        $this->View->setRequest($this->View->getRequest()->withAttribute('paging', [
            'Client' => [
                'page' => 2,
                'current' => 3,
                'count' => 27,
                'prevPage' => false,
                'nextPage' => 2,
                'pageCount' => 9,
            ]
        ]));
        $result = $this->Paginator->numbers(['first' => 1]);
        $expected = [
            ['ul' => ['class' => 'pagination']],
            ['li' => []], ['a' => ['href' => '/index']], '1', '/a', '/li',
            ['li' => ['class' => 'active']], ['a' => ['href' => '']], '2', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=3']], '3', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=4']], '4', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=5']], '5', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=6']], '6', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=7']], '7', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=8']], '8', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=9']], '9', '/a', '/li',
            '/ul'
        ];
        $this->assertHtml($expected, $result);
        $result = $this->Paginator->numbers(['last' => 1]);
        $expected = [
            ['ul' => ['class' => 'pagination']],
            ['li' => []], ['a' => ['href' => '/index']], '1', '/a', '/li',
            ['li' => ['class' => 'active']], ['a' => ['href' => '']], '2', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=3']], '3', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=4']], '4', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=5']], '5', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=6']], '6', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=7']], '7', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=8']], '8', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=9']], '9', '/a', '/li',
            '/ul'
        ];
        $this->assertHtml($expected, $result);
        $this->View->setRequest($this->View->getRequest()->withAttribute('paging', [
            'Client' => [
                'page' => 15,
                'current' => 3,
                'count' => 30,
                'prevPage' => false,
                'nextPage' => 2,
                'pageCount' => 15,
            ]
        ]));
        $result = $this->Paginator->numbers(['first' => 1]);
        $expected = [
            ['ul' => ['class' => 'pagination']],
            ['li' => []], ['a' => ['href' => '/index']], '1', '/a', '/li',
            ['li' => ['class' => 'ellipsis disabled']], ['a' => []], '&hellip;', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=7']], '7', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=8']], '8', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=9']], '9', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=10']], '10', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=11']], '11', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=12']], '12', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=13']], '13', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=14']], '14', '/a', '/li',
            ['li' => ['class' => 'active']], ['a' => ['href' => '']], '15', '/a', '/li',
            '/ul'
        ];
        $this->assertHtml($expected, $result);
        $this->View->setRequest($this->View->getRequest()->withAttribute('paging', [
            'Client' => [
                'page' => 10,
                'current' => 3,
                'count' => 30,
                'prevPage' => false,
                'nextPage' => 2,
                'pageCount' => 15,
            ]
        ]));
        $result = $this->Paginator->numbers(['first' => 1, 'last' => 1]);
        $expected = [
            ['ul' => ['class' => 'pagination']],
            ['li' => []], ['a' => ['href' => '/index']], '1', '/a', '/li',
            ['li' => ['class' => 'ellipsis disabled']], ['a' => []], '&hellip;', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=6']], '6', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=7']], '7', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=8']], '8', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=9']], '9', '/a', '/li',
            ['li' => ['class' => 'active']], ['a' => ['href' => '']], '10', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=11']], '11', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=12']], '12', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=13']], '13', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=14']], '14', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=15']], '15', '/a', '/li',
            '/ul'
        ];
        $this->assertHtml($expected, $result);
        $this->View->setRequest($this->View->getRequest()->withAttribute('paging', [
            'Client' => [
                'page' => 6,
                'current' => 15,
                'count' => 623,
                'prevPage' => 1,
                'nextPage' => 1,
                'pageCount' => 42,
            ]
        ]));
        $result = $this->Paginator->numbers(['first' => 1, 'last' => 1]);
        $expected = [
            ['ul' => ['class' => 'pagination']],
            ['li' => []], ['a' => ['href' => '/index']], '1', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=2']], '2', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=3']], '3', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=4']], '4', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=5']], '5', '/a', '/li',
            ['li' => ['class' => 'active']], ['a' => ['href' => '']], '6', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=7']], '7', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=8']], '8', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=9']], '9', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=10']], '10', '/a', '/li',
            ['li' => ['class' => 'ellipsis disabled']], ['a' => []], '&hellip;', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=42']], '42', '/a', '/li',
            '/ul'
        ];
        $this->assertHtml($expected, $result);
        $this->View->setRequest($this->View->getRequest()->withAttribute('paging', [
            'Client' => [
                'page' => 37,
                'current' => 15,
                'count' => 623,
                'prevPage' => 1,
                'nextPage' => 1,
                'pageCount' => 42,
            ]
        ]));
        $result = $this->Paginator->numbers(['first' => 1, 'last' => 1]);
        $expected = [
            ['ul' => ['class' => 'pagination']],
            ['li' => []], ['a' => ['href' => '/index']], '1', '/a', '/li',
            ['li' => ['class' => 'ellipsis disabled']], ['a' => []], '&hellip;', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=33']], '33', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=34']], '34', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=35']], '35', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=36']], '36', '/a', '/li',
            ['li' => ['class' => 'active']], ['a' => ['href' => '']], '37', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=38']], '38', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=39']], '39', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=40']], '40', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=41']], '41', '/a', '/li',
            ['li' => []], ['a' => ['href' => '/index?page=42']], '42', '/a', '/li',
            '/ul'
        ];
        $this->assertHtml($expected, $result);
    }

    public function testPrev() {
        $this->assertHtml([
            ['li' => [
                'class' => 'disabled'
            ]],
            ['a' => true], '&lt;', '/a',
            '/li'
        ], $this->Paginator->prev('<'));
        $this->assertHtml([
            ['li' => [
                'class' => 'disabled'
            ]],
            ['a' => true],
            ['i' => [
                'class' => 'glyphicon glyphicon-chevron-left',
                'aria-hidden' => 'true'
            ]],
            '/i', '/a', '/li'
        ], $this->Paginator->prev('i:chevron-left'));
    }

    public function testNext() {
        $this->assertHtml([
            ['li' => true],
            ['a' => [
                'href' => '/index?page=2'
            ]], '&gt;', '/a',
            '/li'
        ], $this->Paginator->next('>'));
        $this->assertHtml([
            ['li' => true],
            ['a' => [
                'href' => '/index?page=2'
            ]],
            ['i' => [
                'class' => 'glyphicon glyphicon-chevron-right',
                'aria-hidden' => 'true'
            ]],
            '/i', '/a', '/li'
        ], $this->Paginator->next('i:chevron-right'));
    }

};
