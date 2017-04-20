<?php
namespace home\lflynn7\DataDesign\php\classes;

/** Profile Class
 * This class is a collection of profile data collected by users from the Very Bad  Site
 *
 * @author Luc Flynn lflynn7@cnm.edu
 *
 * 0.0.0
 **/

class Profile{

	/**
	 * id for this Profile; this is the primary key
	 * @var int $profileId
	 **/

	private $profileId;

	/**
	 * at handle for this Profile; this is a unique index
	 * @var string $profileHandle
	 **/

	private $profileHandle;

	/**
	 * token handed out to verify that the profile is valid and not malicious
	 * @var $profileActivationToke
	 **/

	private $profileActivationToke;

	/**
	 * email for this Profile; this is a unique index
	 * @var string $profileEmail
	 **/

	private $profileEmail;

	/**
	 * hash for profile password
	 * @var $profileHash
	 **/

	private $profileHash;

	/**
	 * phone number for this Prolife
	 * @var string $profileSalt
	 */

	private $profileSalt;

	/**
	 * constructor for this profile
	 * @param int|null $newProfileId id of this Profile or null if new Profile
	 * @param string $newProfileActivationToke activation token to safe guard agasint malicious accounts.
	 * @param string $newProfileActivationToke activation token to safe guard agasint malicious accounts.
	 * @param string $newProfileActivationToke activation token to safe guard agasint malicious accounts.
	 * @param string $newProfileActivationToke activation token to safe guard agasint malicious accounts.
	 * @param string $newProfileActivationToke activation token to safe guard agasint malicious accounts.
	 * @param string $newProfileActivationToke activation token to safe guard agasint malicious accounts.
	 */

	/**
	 * accesor method for profile id
	 *
	 * @return int value of profile id (or null if new Profile)
	 *
	 **/

	public function getProfileId(): ?int {
		return ($this->profileId);
	}

	/**
	 * mutator method for profile id
	 *
	 * @param int|null $newProfileId value of new profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 */

	public function setProfileId(?int $newProfileId): void {
		if($newProfileId === null) {
			$this->profileId = null;
			return;
		}

		if($newProfileId <= 0) {
			throw(new \RangeException("Profile Id is not positive"));
		}

		// convert and store the profile id
		$this->profileId = $newProfileId;
	}

	/**
	 * @return string value of activation token
	 */

	public function getProfileActivationToke(): string {
		return ($this->profileActivationToke);
	}

	/**
	 * mutator method for account activation token
	 *
	 * @param string $newProfileActivationToke
	 * @throws \invalidArgumentException if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 */

	public function setProfileActivationToke(?string $newProfileActivationToke): void {
		if($newProfileActivationToke === null) {
			$this->profileActivationToke = null;
			return;
		}

		$newProfileActivationToke = strtolower(trim($newProfileActivationToke));
		if(ctype_xdigit($newProfileActivationToke) === false) {
			throw(new\RangeException("activation not valid"));
		}

		//make sure activation toke is 32 chars
		if(strlen($newProfileActivationToke) !== 32) {
			throw(new\RangeException("Activation toke must be 32 chars"));
		}
		$this->profileActivationToke = $newProfileActivationToke;
	}

	/**
	 * accessor method for at handle
	 *
	 * @return string value of at handle
	 */

	public function getProfileHandle(): string {
		return ($this->profileHandle);
	}

	/**
	 * mutator method for at handle
	 *
	 * @param string $newProfileHandle new value of handle
	 *
	 * @throws \InvalidArgumentException if $newAtHandle is not a string or insecure
	 * @throws \RangeException if $newAtHandle is > 32 characters
	 * @throws \TypeError if $newAtHandle is not a string
	 **/

	public function setProfileHandle(string $newProfileHandle): void {
		// verify the at handle is secure
		$newProfileHandle = trim($newProfileHandle);
		$newProfileHandle = filter_var($newProfileHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileHandle) === true) {
			throw(new\InvalidArgumentException("profile at handle is empty or insecure"));
		}

		// verify the at handle will fit in the database
		if(strlen($newProfileHandle) > 32) {
			throw(new \RangeException("profile handle is too large"));
		}

		//store the handle
		$this->profileHandle = $newProfileHandle;
	}

	/**
	 * accesor method for email
	 *
	 * @return string value of email
	 */
	public function getProfileEmail(): string {
		return $this->profileEmail;
	}

	/**
	 * mutator method for email
	 *
	 * @param string $newProfileEmail new value of email
	 * @throws \InvalidArgumentException if $newEmail is invalid or insecure
	 * @throws \RangeException if $ newEmail is > 128 characters
	 * @throws \TypeError if $newEmail is not a string
	 *
	 */
	public function setProfileEmail(string $newProfileEmail): void {
		//verify email is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("profile email is empty or insecure"));
		}

		//verify the email will fit in database
		if(strlen($newProfileEmail) > 128) {
			throw(new\RangeException("Email too large"));
		}

		//store email
		$this->profileEmail = $newProfileEmail;
	}

	/**
	 * mutator method for profile hash password
	 *
	 * @param string $newProfileHash
	 * @throws \InvalidArgumentException if hash is not secure
	 * @throws \RangeException if hash is not 128
	 * @throws \TypeError if hash is not a string
	 */
	public function setProfileHash(string $newProfileHash): void {
		//enforce that the hash is properly formatted
		$newProfileHash = trim($newProfileHash);
		$newProfileHash = strtolower($newProfileHash);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("Profile password hash empty or insecure"));
		}

		//enforce that the hash is a string representation of a hexadecimal
		if(!ctype_xdigit($newProfileHash)) {
			throw(new \InvalidArgumentException("Profile password hash empty or insecure"));
		}

		//enforce that the hash is exactly 128 characters
		if(strlen($newProfileHash) !== 128) {
			throw(new \RangeException("Profile hash must be 128 characters"));
		}

		//store the hash
		$this->profileHash = $newProfileHash;
	}

	/**
	 * accessor method for salt
	 *
	 * @return string representation of the salt hexadecimal
	 */
	public function getProfileSalt(): string {
		return $this->profileSalt;
	}

	/**
	 * mutator method for profile salt
	 *
	 * @param string $newProfileSalt
	 * @throws \InvalidArgumentException if the salt is not secure
	 * @throws \RangeException if the salt is not 64 characters
	 * @throws \TypeError if profile salt is not a string
	 */

	public function setProfileSalt(string $newProfileSalt): void {
		//enforce that the salt is properly formatted
		$newProfileSalt = trim($newProfileSalt);
		$newProfileSalt = strtolower($newProfileSalt);

		//enforce that the salt is a string representation of a hexadecimal
		if(!ctype_xdigit($newProfileSalt)) {
			throw(new \InvalidArgumentException("Profile password hash is empty or insecure"));
		}

		//enforce salt is 64 characters
		if(strlen($newProfileSalt) !== 64) {
			throw(new \RangeException("profile salt must be 128 characters"));
		}

		//store the hash
		$this->profileSalt = $newProfileSalt;
	}

	/**
	 * inserts this Profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 *
	 */

//	public function insert(\PDO $PDO): void {
//		// enforce the profileId is null (i.e., don't insert a profile that already exists)
//		if($this->profileId !== null) {
//			throw(new \PDOException("not a new profile"));
//		}
//

}