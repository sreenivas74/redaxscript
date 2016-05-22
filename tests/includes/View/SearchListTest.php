<?php
namespace Redaxscript\Tests\View;

use Redaxscript\Controller;
use Redaxscript\Db;
use Redaxscript\Language;
use Redaxscript\Registry;
use Redaxscript\Tests\TestCase;
use Redaxscript\View;

/**
 * SearchListTest
 *
 * @since 3.0.0
 *
 * @package Redaxscript
 * @category Tests
 * @author Henry Ruhs
 * @author Balázs Szilágyi
 */

class SearchListTest extends TestCase
{
	/**
	 * instance of the registry class
	 *
	 * @var object
	 */

	protected $_registry;

	/**
	 * instance of the language class
	 *
	 * @var object
	 */

	protected $_language;

	/**
	 * setUp
	 *
	 * @since 3.0.0
	 */

	public function setUp()
	{
		$this->_registry = Registry::getInstance();
		$this->_language = Language::getInstance();
		Db::forTablePrefix('articles')
			->create()
			->set(array(
				'title' => 'test',
				'alias' => 'test-one',
				'author' => 'test',
				'text' => 'test',
				'category' => 1,
				'date' => '2017-01-01 00:00:00'
			))
			->save();
		Db::forTablePrefix('articles')
			->create()
			->set(array(
				'title' => 'test',
				'alias' => 'test-two',
				'author' => 'test',
				'text' => 'test',
				'category' => 1,
				'date' => '2016-01-01 00:00:00'
			))
			->save();
		Db::forTablePrefix('comments')
			->create()
			->set(array(
				'id' => 1,
				'author' => 'test',
				'email' => 'test@test.com',
				'text' => 'test',
				'article' => 1,
				'date' => '2016-01-01 00:00:00'
			))
			->save();
	}

	/**
	 * tearDownAfterClass
	 *
	 * @since 3.0.0
	 */

	public function tearDown()
	{
		Db::forTablePrefix('articles')->where('alias', 'test-one')->deleteMany();
		Db::forTablePrefix('articles')->where('alias', 'test-two')->deleteMany();
		Db::forTablePrefix('comments')->where('author', 'test')->deleteMany();
	}

	/**
	 * providerRender
	 *
	 * @since 3.0.0
	 *
	 * @return array
	 */

	public function providerRender()
	{
		return $this->getProvider('tests/provider/View/search_list_render.json');
	}

	/**
	 * testRender
	 *
	 * @since 3.0.0
	 *
	 * @param array $searchArray
	 * @param array $expect
	 *
	 * @dataProvider providerRender
	 */

	public function testRender($searchArray = array(), $expect = array())
	{
		/* setup */

		$searchList = new View\SearchList($this->_registry, $this->_language);
		$controllerSearch = new Controller\Search($this->_registry, $this->_language);
		$resultArray = $this->callMethod($controllerSearch, '_search', array(
			$searchArray
		));

		/* actual */

		$actual = $searchList->render($resultArray);

		/* compare */

		$this->assertEquals($expect, $actual);
	}
}
