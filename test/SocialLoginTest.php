<?php
namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\{
    SocialLogin, Tag
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
     * SocialLogin content for the tag.
     * @var string $VALID_SOCIAL_LOGIN_CONTENT
     **/
    protected $VALID_SOCIAL_LOGIN_CONTENT = "This social stuff has to work";
    /**
     * content of the updated hashtag
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
        $this->assertEquals($pdoSocialLogin->getSocialLoginName($this->VALID_SOCIAL_LOGIN_CONTENT, $this->VALID_SOCIAL_LOGIN_CONTENT); //do i need valid social login content twice?
    }

    /**
     * test inserting a SocialLogin that already exists
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