<?php
namespace Edu\Cnm\Flek;

require_once("autoload.php");

/**
 * Social Login Class for Logging into Flek Account
 *
 * This social login is a way for the profile to have access to our site without having to enter email name. It's a quick alternative to having member privileges to begin using the site.
 *
 * @author Giles Sandoval <gsandoval49@cnm.edu>
 * @version 1.0.0
 **/
class SocialLogin implements \JsonSerializable {
    // use ValidateDate;
    // ValidateDate took out because we are not using in our classes. That will be phase 2 :)

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
    public function __construct(int $newSocialLoginId = null, string $newSocialLoginName) {
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

    /**
     * accessor method for Social Login id
     *
     * @return int|null value of socialLogin id
     **/
    public function getSocialLoginId() {
        return($this->socialLoginId);
    }

    /**
     * mutator method for Social Login id
     *
     * @param int|null $newSocialLoginId new value of socialLoginId
     * @throws \RangeException if $newSocialLoginId is not positive
     * @throws \TypeError if $newSocialLoginId is not an integer
     **/

    public function setSocialLoginId(int $newSocialLoginId = null) {
        // base case: if the socialLogin id is null, this a new socialLogin without a mySQL assigned id (yet)
        if ($newSocialLoginId === null) {
            $this->socialLoginId = null;
            return;
        }

        // verify the socialLogin id is positive
        if ($newSocialLoginId <=0) {
            throw(new \RangeException("social login id is not positive"));
        }

        // convert and store the social login id
        $this->socialLoginId = $newSocialLoginId;
    }

    /**
     * accessor method for Social Login name
     *
     * @return string value of Social Login name
     **/

    public function getSocialLoginName() {
        return($this->socialLoginName);
    }

    /**
     * mutator method for Social Login name
     *
     * @param string $newSocialLoginName new value of social login name
     * @throws \InvalidArgumentException if $newSocialLoginName is not a string or insecure
     * @throws \RangeException if $newSocialLoginName is > 32 characters
     * @throws \TypeError if $newSocialLoginName is not a string
     **/
    public function setSocialLoginName(string $newSocialLoginName) {
        // verify the social login name string is secure
        $newSocialLoginName = trim($newSocialLoginName);
        $newSocialLoginName = filter_var($newSocialLoginName, FILTER_SANITIZE_STRING);
        if(empty($newSocialLoginName) === true) {
            throw(new \InvalidArgumentException("social login name is empty or insecure"));
        }

        // verify the social login name will fit in the database
        if(strlen($newSocialLoginName) > 32) {
            throw(new \RangeException("social login name is too large"));
        }

        // store the social login name
        $this->socialLoginName = $newSocialLoginName;
    }

    /**
     * inserts this Social Login ID into mySQL
     *
     *@param \PDO $pdo PDO connection object
     *@throws \PDOException when mySQL related errors occur
     *@throws \TypeError if $pdo is not a PDO connection object
     **/
    public function insert(\PDO $pdo) {
        // enforce the socialLoginId is null (i.e., don't insert a Social Login id that already exists.)
        if ($this->socialLoginId !== null) {
            throw(new \PDOException("not a new social login ID"));
        }

        // create query template
        $query = "INSERT INTO socialLogin(socialLoginId, socialLoginName) VALUES(:socialLoginId, :socialLoginName)";
        // in example, socialLoginId was omitted but no errors were brought up. keeping for now.
        $statement = $pdo->prepare($query);

        // bind the member variables to the place holders in the template
        // CHECK TO SEE IF THIS CODE NEEDS TO BE IN HERE. AND ALSO DELETED the $formattedDate
        $parameters = ["socialLoginId" => $this->socialLoginId, "socialLoginName" => $this->socialLoginName];
        $statement->execute($parameters);

        // update the null socialLoginId with what mySQL just gave us
        $this->socialLoginId = intval($pdo->lastInsertId());
    }

    /**
     * deletes this Social Login from mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function delete(\PDO $pdo) {
        // enforce the socialLoginId is not null (i.e., don't delete a socialLoginId that hasn't been inserted)
        if($this->socialLoginId === null) {
            throw(new \PDOException("unable to delete a socialLoginId that does not exist"));
        }

        // create query template
        $query = "DELETE FROM socialLogin WHERE socialLoginId = :socialLoginId";
        $statement = $pdo->prepare($query);

        // bind the member variables to the place holder in the template
        $parameters = ["socialLoginId" => $this->socialLoginId];
        $statement->execute($parameters);
    }

    /**
     * updates this Social Login ID in mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function update(\PDO $pdo) {
        // enforce the socialLoginId is not null (i.e., don't update a socialLogin that hasn't been inserted yet
        if($this->socialLoginId === null) {
            throw(new \PDOException("unable to update the social login data that does not exist"));
        }

        // create query template
        $query = "UPDATE socialLogin SET socialLoginName = :socialLoginName WHERE socialLoginId = :socialLoginId";
        $statement = $pdo->prepare($query);

        // bind the member variables to the place holders in the template
        // deleted the formatted date from the example
        $parameters = ["socialLoginName" => $this->socialLoginName, "socialLoginId" => $this->socialLoginId];
        $statement->execute($parameters);
    }

    /**
     * gets the Social Login by name
     *
     * @param \PDO $pdo PDO connection object
     * @param string $socialLoginName social login name to search for
     * @return \SplFixedArray SplFixedArray of Social login name found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     **/

    public static function getSocialLoginBySocialLoginName(\PDO $pdo, string $socialLoginName) {
        // sanitize the description before searching
        $socialLoginName = trim($socialLoginName);
        $socialLoginName = filter_var($socialLoginName, FILTER_SANITIZE_STRING);
        if (empty($socialLoginName) === true) {
            throw(new \PDOException("social login name is invalid"));
        }

        // create query template
        $query = "SELECT socialLoginId, socialLoginName FROM socialLogin WHERE socialLoginName LIKE :socialLoginName";
        $statement = $pdo->prepare($query);

        // bind the social login name to the place holder in the template
        $socialLoginName = "%$socialLoginName%";
        $parameters = array("socialLoginName" => $socialLoginName);
        $statement->execute($parameters);

        // build an array of social login names
        // make plural using entity name. calling array socialLogins
        $socialLogins = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !== false) {
            try {
                $socialLogin = new SocialLogin($row["socialLoginId"], $row["socialLoginName"]);
                $socialLogins[$socialLogins->key()] = $socialLogin;
                $socialLogins->next();
            } catch (\Exception $exception) {
                //if the row couldn't be converted, rethrow it
                throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return ($socialLogins);
    }

    /**
     * gets the SocialLogin by socialLoginId
     *
     * @param \PDO $pdo PDO connection object
     * @param int $socialLoginId social login id to search for
     * @return SocialLogin|null SocialLogin found or null if not found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     **/
    public static function getSocialLoginBySocialLoginId(\PDO $pdo, int $socialLoginId) {
        // sanitize the $socialLoginId before searching
        if($socialLoginId <= 0) {
            throw(new \PDOException("social login id is not positive"));
        }

        // create query template
        $query = "SELECT socialLoginId, socialLoginName FROM socialLogin WHERE socialLoginId = :socialLoginId";
        $statement = $pdo->prepare($query);

        // bind the socialLogin id to the place holder in the template
        $parameters = array("socialLoginId" => $socialLoginId);
        $statement->execute($parameters);

        // grab the socialLogin from mySQL
        try {
            $socialLogin = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
                $socialLogin = new SocialLogin($row["socialLoginId"], $row["socialLoginName"]);
            }
        } catch(\Exception $exception) {
            // if the row couldn't be converted, rethrow it
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        return($socialLogin);
    }

    /**
     * gets all SocialLogins
     *
     * @param \PDO $pdo PDO connection object
     * @return \SplFixedArray SplFixedArray of SocialLogins found or null if not found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     **/
    public static function getAllSocialLogins(\PDO $pdo) {
        // create query template
        $query = "SELECT socialLoginId, socialLoginName FROM socialLogin";
        $statement = $pdo->prepare($query);
        $statement->execute();

        // build an array of SocialLogins
        $socialLogins = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !== false) {
            try {
                $socialLogin = new SocialLogin($row["socialLoginId"], $row["socialLoginName"]);
                $socialLogins[$socialLogins->key()] = $socialLogin;
                $socialLogins->next();
            } catch(\Exception $exception) {
                //if the row couldn't be converted, rethrow it
                throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return ($socialLogins);
    }

    /**
     * Specify data which should be serialized to JSON serialization
     *
     * @return array resulting state variable to serialize
     **/
    public function jsonSerialize() {
        $fields = get_object_vars($this);
        return($fields);
    }
}
?>