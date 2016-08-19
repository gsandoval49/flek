<?php
/* find out if this namespace is correct*/
namespace Edu\Cnm\Flek;

require_once("autoload.php");

/**
 * Tag class
 *
 * @author Giles Sandoval <gsandoval49@cnm.edu>
 * @version 1.0.0
 **/
class Tag implements \JsonSerializable {
    /**
     * id of the Tag that is created by the tag that has the image
     * this is the primary key
     * @var int $tagId
     **/
    private $tagId;
    /**
     * name or label of the Tag that is attached to the tag Id
     * @var string $tagName
     **/
    private $tagName;

    /**
     * constructor for this Tag
     *
     * @param int|null $newTagId id of this Tag or null if new Tag
     * @param string $newTagName string containing data
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
     * @throws \TypeError if data types violate type hints
     * @throws \Exception if some other exception occurs
     **/
    public function __construct(int $newTagId = null, string $newTagName) {
        try {
            $this->setTagId($newTagId);
            $this->setTagName($newTagName);
        } catch(\InvalidArgumentException $invalidArgument) {
            // rethrow the exception to the caller
            throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
        } catch(\RangeException $range) {
            // rethrow the exception to the caller
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
     * accessor method for tag id
     *
     * @return int|null value of tag id
     **/
    public function getTagId() {
        return ($this->tagId);
    }

    /**
     * mutator method for tag id
     *
     * @param int $newTagId new value of tag id
     * @throws \RangeException if $newTagId is not positive
     * @throws \TypeError if $newTagId is not an integer
     **/
    public function setTagId(int $newTagId = null) {
        // base case: if the tag id is null, this a new tag without a mySQL assigned id (yet)
        if($newTagId === null) {
            $this->tagId = null;
            return;
        }

        // verify the tag id is positive
        if($newTagId <= 0) {
            throw(new \RangeException("tag id is not positive"));
        }

        // convert and store the tag id
        $this->tagId = $newTagId;
    }

    /**
     * accessor method for tag name
     *
     * @return string value of tag name
     **/
    public function getTagName() {
        return($this->tagName);
    }

    /**
     * mutator method for tag name
     *
     * @param string $newTagName new value of tag name
     * @throws \InvalidArgumentException if $newTagName is not a string or insecure
     * @throws \RangeException if $newTagName is > 32 characters
     * @throws \TypeError if $newTagName is not a string
     **/
    public function setTagName(string $newTagName) {
        // verify the tag string is secure
        $newTagName = trim($newTagName);
        $newTagName = filter_var($newTagName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if(empty($newTagName) === true) {
            throw(new \InvalidArgumentException("tag name is empty or insecure"));
        }

        // verify the tag name will fit in the database
        if(strlen($newTagName) > 32) {
            throw(new \RangeException("tag name is too large"));
        }

        // store the tag name
        $this->tagName = $newTagName;
    }

    /**
     * inserts this Tag into mySQL
     *
     *@param \PDO $pdo PDO connection object
     *@throws \PDOException when mySQL related errors occur
     *@throws \TypeError if $pdo is not a PDO connection object
     **/
    public function insert(\PDO $pdo) {
        // enforce the tagId is null (i.e., don't insert a tag that already exists)
        if($this->tagId !== null) {
            throw(new \PDOException("not a new tag"));
        }

        // create query template
        $query = "INSERT INTO tag(tagName) VALUES(:tagName)";
        $statement = $pdo->prepare($query);

        // bind the member variables to the place holders in the template
        // CHECK TO SEE IF THIS CODE NEEDS TO BE IN HERE. AND ALSO DELETED the $formattedDate
        $parameters = ["tagName" => $this->tagName];
        $statement->execute($parameters);

        // update the null tagId with what mySQL just gave us
        $this->tagId = intval($pdo->lastInsertId());
    }

    /**
     * deletes this Tag from mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function delete(\PDO $pdo) {
        // enforce the tagId is not null (i.e., don't delete a tag that hasn't been inserted)
        if($this->tagId === null) {
            throw(new \PDOException("unable to delete a tag that does not exist"));
        }

        // create query template
        $query = "DELETE FROM tag WHERE tagId = :tagId";
        $statement = $pdo->prepare($query);

        // bind the member variables to the place holder in the template
        $parameters = ["tagId" => $this->tagId];
        $statement->execute($parameters);
    }

    /**
     * updates this Tag in mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function update(\PDO $pdo) {
        // enforce the tagId is not null (i.e., don't update a tag that hasn't been inserted)
        if($this->tagId === null) {
            throw(new \PDOException("unable to update a tag that does not exist"));
        }

        // create query template
        $query = "UPDATE tag SET tagName = :tagName WHERE tagId = :tagId";
        $statement = $pdo->prepare($query);

        // bind the member variables to the place holders in the template
        // deleted the formatted date from the example
        $parameters = ["tagName" => $this->tagName, "tagId" => $this->tagId];
        $statement->execute($parameters);
    }

    /**
     * gets the Tag by name
     *
     * @param \PDO $pdo PDO connection object
     * @param string $tagName tag name to search for
     * @return tag|null tag or null if not found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     **/
    public static function getTagByTagName(\PDO $pdo, string $tagName){
        // sanitize the description before searching
        $tagName = trim($tagName);
        $tagName = filter_var($tagName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if(empty($tagName) === true) {
            throw(new \PDOException("tag name is invalid"));
        }
        // create query template
        $query = "SELECT tagId, tagName FROM tag WHERE tagName LIKE :tagName";
        $statement = $pdo->prepare($query);
        // bind the tag name to the place holder in the template
        // $tagName = "%$tagName%";
        $parameters = array("tagName" => $tagName);
        $statement->execute($parameters);
        // grab the tag from mySQL
        try {
            $tag = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
                $tag = new Tag($row["tagId"], $row["tagName"]);
            }
        } catch(\Exception $exception) {
            // if the row couldn't be converted, rethrow it
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        return($tag);
    }

    /**
     * gets the Tag by tagId
     *
     * @param \PDO $pdo PDO connection object
     * @param int $tagId tag id to search for
     * @return tag|null tag found or null if not found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     **/
    public static function getTagByTagId(\PDO $pdo, int $tagId)
    {
        // sanitize the tagId before searching
        if ($tagId <= 0) {
            throw(new \RangeException("tag id is not positive"));
        }
        // create query template
        $query = "SELECT tagId, tagName FROM tag WHERE tagId = :tagId";
        $statement = $pdo->prepare($query);
        // bind the tag id to the place holder in the template
        $parameters = ["tagId" => $tagId];
        $statement->execute($parameters);
        // get the tag from mySQL
        try {
            $tag = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if ($row !== false) {
                $tag = new Tag($row["tagId"], $row["tagName"]);
            }
        } catch (\Exception $exception) {
            // if the row couldn't be converted, rethrow it
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        return ($tag);
    }

    /**
     * gets all tags
     *
     * @param \PDO $pdo PDO connection object
     * @return \SplFixedArray SplFixedArray of tags found or null if not found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     **/
    public static function getsAllTags(\PDO $pdo) {
        // create query template
        $query = "SELECT tagId, tagName FROM tag";
        $statement = $pdo->prepare($query);
        $statement->execute();
        // build an array of tags
        $tags = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !== false) {
            try {
                $tag = new Tag($row["tagId"], $row["tagName"]);
                $tags[$tags->key()] = $tag;
                $tags->next();
            } catch (\Exception $exception) {
                //if the row couldn't be converted, rethrow it
                throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return ($tags);
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