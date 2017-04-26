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

private $favoriteProductId;

	/** id for the Profile that has the product */

private $favoriteProductProfileId;

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

public function __construct( int $newFaveProductId, int $newFaveProductProfileId) {
	try {
		$this->setFavoriteProductId($newFaveProductProfileId);
		$this->setFavoriteProductProfileId($newFaveProductProfileId);
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


	public function getFavoriteProductId(): ?int {
		return ($this->favoriteProductId());
	}

	/**
	 * mutator method for product id
	 *
	 * @param int|null $newProductId value of new product id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 */

	public function setFavoriteProductId( int $newFavoriteProductId): void {
		if($newFavoriteProductId === null) {
			$this->setFavoriteProductId() = null;
			return;
		}

		if($newFavoriteProductId <=0 ) {
			throw(new\RangeException("Profile Id is not positive"));
		}

		//convert and store the product id
		$this->favoriteProductId = $newFavoriteProductId;
	}

	//Start mutator method for faveProductProfileId

	public function getFavoriteProductProfileId(): int {
		return ($this->favoriteProductProfileId);
	}

	/**
	 * mutator method for faveProductProfileid
	 *
	 * @param int|null $newProductId value of new product id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 */

	public function setFavoriteProductProfileId( int $newFavoriteProductProfileId): void {
		if($newFavoriteProductProfileId === null) {
			$this->favoriteProductProfileId = null;
			return;
		}

		if($newFavoriteProductProfileId <=0 ) {
			throw(new\RangeException("Profile Id is not positive"));
		}

		//convert and store the product id
		$this->favoriteProductProfileId = $newFavoriteProductProfileId;
	}

	/**
	 * inserts this favorite into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		// enforce the faveProductId is null (i.e., don't insert a favorite that already exists)
		if($this->favoriteProductId !== null) {
			throw(new \PDOException("not a new favorite"));
		}
		// create query template
		$query = "INSERT INTO favorite(favoriteProductId, favoriteProductProfileId) VALUES(:favoriteProfileId, :favoriteProductProfileId)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["favoriteProductId" => $this->favoriteProductId, "favoriteProductProfileId" => $this->favoriteProductProfileId];
		$statement->execute($parameters);
		// update the null faveProductId with what mySQL just gave us
		$this->favoriteProductId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this Fave from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// enforce the faveProductId is not null (i.e., don't delete a fave that hasn't been inserted)
		if($this->favoriteProductId === null) {
			throw(new \PDOException("unable to delete a fave that does not exist"));
		}
		// create query template
		$query = "DELETE FROM favorite WHERE favoriteProductId = :favoriteProductId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["favoriteProductId" => $this->favoriteProductId];
		$statement->execute($parameters);
	}

	/**
	 * updates this fave in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// enforce the tweetId is not null (i.e., don't update a tweet that hasn't been inserted)
		if($this->favoriteProductId === null) {
			throw(new \PDOException("unable to update a tweet that does not exist"));
		}
		// create query template
		$query = "DELETE FROM fave WHERE favoriteProductId = :faveProductId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["favoriteProductProfileId" => $this->favoriteProductProfileId, "favoriteProductId" => $this->favoriteProductId];
		$statement->execute($parameters);
	}

	/**
	 * gets a fave by faveProductId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $tweetId tweet id to search for
	 * @return Favorite|null fave found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getfavoritesByfavoriteId(\PDO $pdo, int $favoriteProductId) : Favorite {
		// sanitize the tweetId before searching
		if($favoriteProductId <= 0) {
			throw(new \PDOException("favorite id is not positive"));
		}
		// create query template
		$query = "SELECT favoriteProductId, favoriteProductProfileId FROM favorite WHERE favoriteProductId = :favoriteProductId";
		$statement = $pdo->prepare($query);
		// bind the tweet id to the place holder in the template
		$parameters = ["favoriteProductId" => $favoriteProductId];
		$statement->execute($parameters);
		// grab the fave from mySQL
		try {
			$favorite = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$favorite = new Favorite($row["favoriteProductId"], $row["favoriteProductProfileId"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($favorite);
	}

}