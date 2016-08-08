<?php
namespace Edu\Cnm\Flek;

require_once("autoload.php");
/*
 * This favorite can be considered a small example of what could be stored when profiles
 *
 * @author Diane Peshlakai <dpeshlakai3@cnm.edu>
 * @version 3.0.0
 */
class Favorite implements \JsonSerializable {
	/*
	 * id for Favorite when profile can favorite the profile and identify the profile
	 *  this is the foreign key
	 * @var int $favoriteeId
	 */
	private $favoriteeId;
	/*
	 * int $favoriterId
	 * id for the favorite the profile can favorite vice versa
	 * this is a foreign key
	 */
	private $favoriterId;

	/*
	 * constructor for favorite
	 *@param int|null $newFavoritee
	 *@param int|null $newFavoriter
	 * @throws \RangeException if data values are out of bounds
	 * @throws \Exception is some other exception occurs
	 */
	public function__construct(int $newFavoriteeId = null, int $newFavoriterId = null) {
		try {
				$this->setFavoriteeId($newFavoriteeId);
				$this->setFavoriterId($newFavoriterId);
}		catch(\InvalidArgumentException $invalidArgumentException)
{
	//rethrow the exception to the caller
	throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
}
		catch(\RangeException $range) {
			//rethrow the exception to the caller
	throw(new \RangeException($range->getMessage(), 0, $range));
}
		catch(\Exception $exception) {
		//rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}


