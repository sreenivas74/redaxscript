<?php
namespace Redaxscript\Model;

/**
 * abstract class to create a model class
 *
 * @since 4.0.0
 *
 * @package Redaxscript
 * @category Model
 * @author Henry Ruhs
 */

abstract class ContentAbstract extends ModelAbstract
{
	/**
	 * get all by order
	 *
	 * @since 4.0.0
	 *
	 * @param string $orderColumn name of the column to order
	 *
	 * @return object|null
	 */

	public function getAllByOrder(string $orderColumn = null) : ?object
	{
		return $this->query()->orderBySetting($orderColumn)->findMany() ? : null;
	}

	/**
	 * get the content by language and order
	 *
	 * @since 4.0.0
	 *
	 * @param string $language
	 * @param string $orderColumn name of the column to order
	 *
	 * @return object|null
	 */

	public function getByLanguageAndOrder(string $language = null, string $orderColumn = null) : ?object
	{
		return $this
			->query()
			->whereLanguageIs($language)
			->where('status', 1)
			->orderBySetting($orderColumn)
			->findMany() ? : null;
	}

	/**
	 * get the content by id and language and order
	 *
	 * @since 4.0.0
	 *
	 * @param int $id
	 * @param string $language
	 * @param string $orderColumn name of the column to order
	 *
	 * @return object|null
	 */

	public function getByIdAndLanguageAndOrder(int $id = null, string $language = null, string $orderColumn = null) : ?object
	{
		return $this
			->query()
			->whereIdIs($id)
			->whereLanguageIs($language)
			->where('status', 1)
			->orderBySetting($orderColumn)
			->findMany() ? : null;
	}

	/**
	 * publish by date
	 *
	 * @since 3.3.0
	 *
	 * @param string $date
	 *
	 * @return int
	 */

	public function publishByDate(string $date = null) : int
	{
		return $this
			->query()
			->whereLt('date', $date)
			->where('status', 2)
			->findMany()
			->set('status', 1)
			->save()
			->count();
	}
}
