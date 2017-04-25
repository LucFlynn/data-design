<?php

/** Profile Class
 * This class is a collection of profile data collected by users from the Very Bad  Site
 *
 * @author Luc Flynn lflynn7@cnm.edu
 *
 * 0.0.0
 **/

class Favorite {

	/** id for the product */

private $faveProductId;

	/** id for the Profile that has the product */

private $faveProductProfileId;

	/**
	 * constructor for this Tweet
	 *
	 * @param int|null $newTweetId id of this Tweet or null if a new Tweet
	 * @param int $newTweetProfileId id of the Profile that sent this Tweet
	 * @param string $newTweetContent string containing actual tweet data
	 * @param \DateTime|string|null $newTweetDate date and time Tweet was sent or null if set to current date and time
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

public function __construct(?int $newFaveProudctId, int $newFaveProductProfileId) {
	try {
		$this->setFaveProductId($newFaveProductProfileId);
		$this->setFaveProductProfileId($newFaveProductProfileId);
	}
		//determine excpetion type thrown
	catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
}

	/**
	 * accesor method for product id
	 *
	 * @return int value of product id (or null if new Product)
	 *
	 **/


	public function getFaveProductId(): ?int {
		return ($this->FaveProductId());
	}

	/**
	 * mutator method for product id
	 *
	 * @param int|null $newProductId value of new product id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 */

	public function setFaveProductId(?int $newFaveProductId): void {
		if($newFaveProductId === null) {
			$this->setFaveProductId = null;
			return;
		}

		if($newFaveProductId <=0 ) {
			throw(new\RangeException("Profile Id is not positive"));
		}

		//convert and store the product id
		$this->FaveProductId = $newFaveProductId;
	}

	//Start mutator method for faveProductProfileId

	public function getFaveProductProfileId(): ?int {
		return ($this->faveProductProfileId);
	}

	/**
	 * mutator method for faveProductProfileid
	 *
	 * @param int|null $newProductId value of new product id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 */

	public function setFaveProductProfileId(?int $newFaveProductProfileId): void {
		if($newFaveProductProfileId === null) {
			$this->productProfileId = null;
			return;
		}

		if($newFaveProductProfileId <=0 ) {
			throw(new\RangeException("Profile Id is not positive"));
		}

		//convert and store the product id
		$this->faveProductProfileId = $newFaveProductProfileId;
	}

	/**
	 * inserts this Tweet into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		// enforce the tweetId is null (i.e., don't insert a tweet that already exists)
		if($this->faveProductId !== null) {
			throw(new \PDOException("not a new tweet"));
		}
		// create query template
		$query = "INSERT INTO tweet(tweetProfileId, tweetContent, tweetDate) VALUES(:tweetProfileId, :tweetContent, :tweetDate)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->tweetDate->format("Y-m-d H:i:s");
		$parameters = ["tweetProfileId" => $this->tweetProfileId, "tweetContent" => $this->tweetContent, "tweetDate" => $formattedDate];
		$statement->execute($parameters);
		// update the null tweetId with what mySQL just gave us
		$this->tweetId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this Tweet from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// enforce the tweetId is not null (i.e., don't delete a tweet that hasn't been inserted)
		if($this->tweetId === null) {
			throw(new \PDOException("unable to delete a tweet that does not exist"));
		}
		// create query template
		$query = "DELETE FROM tweet WHERE tweetId = :tweetId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["tweetId" => $this->tweetId];
		$statement->execute($parameters);
	}

	/**
	 * updates this Tweet in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// enforce the tweetId is not null (i.e., don't update a tweet that hasn't been inserted)
		if($this->tweetId === null) {
			throw(new \PDOException("unable to update a tweet that does not exist"));
		}
		// create query template
		$query = "UPDATE tweet SET tweetProfileId = :tweetProfileId, tweetContent = :tweetContent, tweetDate = :tweetDate WHERE tweetId = :tweetId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->tweetDate->format("Y-m-d H:i:s");
		$parameters = ["tweetProfileId" => $this->tweetProfileId, "tweetContent" => $this->tweetContent, "tweetDate" => $formattedDate, "tweetId" => $this->tweetId];
		$statement->execute($parameters);
	}

	/**
	 * gets a Tweet by tweetId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $tweetId tweet id to search for
	 * @return Tweet|null Tweet found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getTweetByTweetId(\PDO $pdo, int $tweetId) : ?Tweet {
		// sanitize the tweetId before searching
		if($tweetId <= 0) {
			throw(new \PDOException("tweet id is not positive"));
		}
		// create query template
		$query = "SELECT tweetId, tweetProfileId, tweetContent, tweetDate FROM tweet WHERE tweetId = :tweetId";
		$statement = $pdo->prepare($query);
		// bind the tweet id to the place holder in the template
		$parameters = ["tweetId" => $tweetId];
		$statement->execute($parameters);
		// grab the tweet from mySQL
		try {
			$tweet = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$tweet = new Tweet($row["tweetId"], $row["tweetProfileId"], $row["tweetContent"], $row["tweetDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($tweet);
	}

}