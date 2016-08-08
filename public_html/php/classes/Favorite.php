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
}