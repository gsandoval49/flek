<?php
namespace Edu\Cnm\Gsandoval49\Flek;

require_once("autoload.php");

/**
 * Hashtag class
 *
 * @author Giles Sandoval <gsandoval49@cnm.edu>
 * @version 3.0.0
**/
class Hashtag implements \JsonSerializable {
    /**
     * id of the Hashtag that is created by the tag that has the image
     * this is the primary key
     * @var int $hashtagId
     **/
    private hashtagId;
    /**
     * name or label of the Hashtag that is attached to the hashtag Id
     * @var string $hashtagName
     **/
    private hashtagName;

    /**
     * constructor for this Hashtag
     *
     * @param int|null $hashtagId id of this Hashtag or null if new Hashtag
     * @param string $hashtagName string containing data
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative intergers)
     * @throws \TypeError if data types violate type hints
     * @htrows \Exception if some other exception occurs
    **/
    public function __construct(int $hashtagId = null, string $hashtagName) {
        try {
            $this->setHashtagId($newHashtagId);
            $this->setHashtagName($newHashtagName);
        } catch(\InvalidArgumentException $invalidArgument) {
            // rethrow the exception to the caller
            throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument))

        }
    }
    {
    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}
}