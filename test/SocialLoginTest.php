<?php
namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\{
    SocialLogin
};
use PDOException;

//grab the project test parameters
require_once("SocialLogingTest.php");

// grab the class that's going through the x-ray and under the knife :)
require_once (dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
 * Full PHPUnit test for the SocialLogin class
 *
 * This is a complete test of the SocialLogin  class. It is complete because ALL mySQL/PDO enabled methods are tested for both invalid and valid inputs
 *
 * @see SocialLogin
 * @author Giles Sandoval <gsandoval49@cnm.edu>
 **/
class SocialLoginTest extends FlekTest {
    /**
     * SocialLogin content for the social login content.
     * @var string $VALID_SOCIAL_LOGIN_CONTENT
     **/
    protected $VALID_SOCIAL_LOGIN_CONTENT = "This social stuff has to work";
    /**
     * content of the updated SocialLogin
     * @var string $VALID_SOCIAL_LOGIN_CONTENT2
     **/
    protected $VALID_SOCIAL_LOGIN_CONTENT2 = "This 2nd content of social better work too!";
    /**
     * Test inserting a valid social login and verifying that mySQL data matches
     **/
    public function testInsertValidSocialLogin() {
        // NO DEPENDENT OBJECTS - didn't create dependent objects code aka setUp
        // count the number of rows and save it for later later
        $numRows = $this->getConnection()->getRowCount("socialLogin");

        // create a new SocialLogin and insert into mySQL
        $socialLogin = new SocialLogin(null, $this->VALID_SOCIAL_LOGIN_CONTENT);
        $socialLogin->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match
        $pdoSocialLogin = SocialLogin::getSocialLoginbySocialLoginId($this->getPDO(), $socialLogin->getSocialLoginId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("socialLogin"));
        $this->assertEquals($pdoSocialLogin->getSocialLoginId($this->VALID_SOCIAL_LOGIN_CONTENT);
    }

    /**
     * test inserting a SocialLogin that already  exists
     *
     * @expectedException PDOException
     **/
    public function testInsertInvalidSocialLogin() {
        $socialLogin = new SocialLogin(FlekTest::INVALID_KEY, $this->VALID_SOCIAL_LOGIN_CONTENT);
        $socialLogin->insert($this->getPDO());
    }

    /**
     * test inserting a SocialLogin, editing it, and then updating it
     **/
    public function testUpdateValidSocialLogin() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("socialLogin");

        // create a new SocialLogin and insert into mySQL
        $socialLogin = new SocialLogin(null, $this->VALID_SOCIAL_LOGIN_CONTENT);

        // edit the SocialLogin and update it in mySQL
        $socialLogin->setSocialLoginName($this->VALID_SOCIAL_LOGIN_CONTENT2);
        $socialLogin->update($this->getPDO());

        // grab the data from mySQL and enforce the fields to match our expectations
        $pdoSocialLogin = SocialLogin::getSocialLoginbySocialLoginId($this->getPDO(), $socialLogin->getSocialLoginId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("socialLogin"));
        $this->assertEquals($pdoSocialLogin->getSocialLoginName(), $this->VALID_SOCIAL_LOGIN_CONTENT2);
    }

    /**
     * test updating a SocialLogin and then deleting it
     **/
    public function testDeleteValidSocialLogin() {
        //count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("socialLogin");

        // create a new SocialLogin and insert into mySQL
        $socialLogin = new SocialLogin(null, $this->VALID_SOCIAL_LOGIN_CONTENT);
        $socialLogin->insert($this->getPDO());

        // delete the SocialLogin from mySQL
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("socialLogin"));
        $socialLogin->delete($this->$this->getPDO());

        // grab the data from mySQL and enforce the SocialLogin does not exist
        $pdoSocialLogin = SocialLogin::getSocialLoginbySocialLoginId($this->getPDO(), $socialLogin->getSocialLoginId());
        $this->assertNull($pdoSocialLogin);
        $this->assertEquals($numRows, $this->getConnection()->getRowCount("socialLogin"));
    }

    /**
     * test deleting a SocialLogin that does NOT exist
     *
     * @expectedException PDOException
     **/
    public function testDeleteInvalidSocialLogin() {
        //create a SocialLogin and try to delete it without actually inserting it
        $socialLogin = new SocialLogin(null, $this->VALID_SOCIAL_LOGIN_CONTENT);
        $socialLogin->delete($this->getPDO());
    }

    /**
     * test grabbing a SocialLogin by social login content
     **/
    public function testGetValidSocialLoginBySocialLoginContent() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("socialLogin");

        // create a new SocialLogin and insert to into mySQL
        $socialLogin = new SocialLogin(null, $this->VALID_SOCIAL_LOGIN_CONTENT);
        $socialLogin->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $results = SocialLogin::getSocialLoginbySocialLoginName($this->getPDO(), $socialLogin->getSocialLoginName());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("socialLogin"));
        $this->assertCount(1, $results);

        // grab the result from the array and validate it
        $pdoSocialLogin = $results[0];
        $this->assertEquals($pdoSocialLogin->getSocialLoginName(), $this->VALID_SOCIAL_LOGIN_CONTENT);
    }

    /**
     * test grabbing a SocialLogin Id that does NOT exist
     **/
    public function testGetInvalidSocialLoginBySocialLoginId() {
        // grab a profile id that exceeds the maximum allowable profile id
        $socialLogin = SocialLogin::getSocialLoginbySocialLoginId($this->getPDO(), FlekTest::INVALID_KEY);
        $this->assertNull($socialLogin);
    }

    /**
     * test grabbing a SocialLogin by content that does not exist, apparently Dylan didn't do this :)
     *
     * See if I still need to have this function in if it comes up as an error? this was an example from Gerald.
     **/
    public function testGetInvalidSocialLoginBySocialLoginName() {
        // grab a SocialLogin by content that does NOT exist
        $socialLogin = SocialLogin::getSocialLoginbySocialLoginName($this->getPDO(), "nobody ever made this SOCIALLOGIN NAME. LET'S SEE IF THIS WORKS.");
        $this->assertCount(0, $socialLogin);
    }

    /**
     * test grabbing all SocialLogins
     **/
    public function testGetAllValidSocialLogins() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("socialLogin");

        // create a new SocialLogin and insert into mySQL
        $socialLogin = new SocialLogin(null, $this->VALID_SOCIAL_LOGIN_CONTENT);
        $socialLogin->insert($this->getPDO());

        //grab the data from mySQL and enforce the fields match our expectations
        $results = SocialLogin::getAllSocialLogins($this->getPDO());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("socialLogin"));
        $this->assertCount(1, $results);

        // grab the result from the array and validate it
        $pdoSocialLogin = $results[0];
        $this->assertEquals($pdoSocialLogin->getSocialLoginName(), $this->VALID_SOCIAL_LOGIN_CONTENT);
    }
}

