<?php
namespace Edu\Cnm\Flek;

require_once("autoload.php");

/**
 * Social Login Class for Logging into Flek Account
 *
 * This social login is a way for the profile to have access to our site without having to enter email name. It's a quick alternative to having member privelages to begin using the site.
 *
 * @author Giles Sandoval <gsandoval49@cnm.edu>
 * @version 1.0.0
 **/
class Social Login implements \JsonSerializable {
    /**
     * id for Social Login; this is the primary key
     * @var int $socialLoginId
     **/
    private $socialLoginId;
    /**
     * name for Social Login name;
     * @var string $socialLoginName
     **/
    private $socialLoginName;

    /**
     * constructor for Social Login
     *
     * @param int|null $socialLoginId of this Social Login or null if new Social Login
     * @param string $socialLoginName string containing data
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
     * @throws \TypeError if data types violate type hints
     * @throws \Exception if some other exception occurs
     **/
    public function __construct(int $socialLoginId = null, string $socialLoginName) {
        try {
            $this->setSocialLoginId($newSocialLoginId);
            $this->setSocialLoginName($newSocialLoginName);
        } catch(\InvalidArgumentException $invalidArgument) {
            //rethrow the exception to the caller
            throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
        } catch(\RangeException $range) {
            //rethrow the exception to the caller
            throw(new \RangeException($range->getMessage(), 0, $range));
        } catch(\TypeError $typeError) {
            // rethrow the exception to the caller
            throw(new \TypeError($typeError->getMessage(), 0, $typeError));
        } catch(\Exception $exception) {
            // rethrow the exception to the caller
            throw(new \Exception($exception->getMessage(), 0, $exception));
        }
    }
}
?>