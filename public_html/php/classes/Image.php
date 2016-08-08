<?php
namespace Edu\Cnm\flek;

require_once("autoload.php");
/**
 *
 * This image can be a small example when the images are stored in the Profile of the user.
 * @author Diane Peshlakai <dpeshlakai3@cnm.edu>
 * @version 3.0.
 */
class Image implements \JsonSerializable {
	/*
	id for Image: this is the primary key
	* @var int $imageId
	 */
	private $imageId;
	/*
	 * id of the profile that sent this Image;
	 * @var int $imageProfileId
	 */
	private $imageProfileId;
	/*
	 * textual description of the Image
	 * @var string $imageDescription
	 */
	private $imageDescription;
	/*
	 * url sent when image is uploaded
	 * @var string $imageSecureUrl
	 */
	private $imageSecureUrl;
	/*
	 * id sent to identify the image uploaded
	 * @var string $imagePublicId
	 */
	private $imagePublicId;
	/*
	 * id to identify the genre the image is assigned to
	 * @var string $imageGenreId
	 */
	private $imageGenreId;


	/*
	 * constructor for the Image
	 * @param int|null $newImageId of this Image or null
	 * @param int|null $newImageProfileId of the profile that sent this Image
	 * @param string $newImageDescription string containing acutal profile data
	 * @param string $newImageSecureUrl string containing url of the image uploaded
	 * @param string $newImagePublicId string containing id of the image uploaded
	 * @param string int|null $newImageGenreId of the image genre or null
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of range
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct(int $newImageId = null, int $newImageProfileId, string $newImageDescription, string $newImageSecureURL,
										 string $newImagePublicId, int $newImageGenreId = null) {
		try {
			$this->setImageId($newImageId);
			$this->setImageProfileId($newImageProfileId);
			$this->setImageDescription($newImageDescription);
			$this->setImageSecureUrl($newImageSecureURL);
			$this->setImagePublicId($newImagePublicId);
			$this->setImageGenreId($newImageGenreId);
		} catch(\InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
			throw(new \InvalidArgumentException(
				$invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			//rethrow the exception to the caller
			throw(new\RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			//rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(Exception $exception) {
			//rethrow the exception to the caller
			throw(new\Exception($exception->getMessage(), 0, $exception));
		}
	}
}