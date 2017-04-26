<?php

/** Profile Class
 * This class is a collection of profile data collected by users from the Very Bad  Site
 *
 * @author Luc Flynn lflynn7@cnm.edu
 *
 * 0.0.0
 **/

class Product {

	/** id for the product */

	private $productId;

	/** id for the Profile that has the product */

	private $productProfileId;

	private $productPrice;


	/** Constructor for PodcutId and productProfileId and product price
	 */

	public function __construct(?int $newProductId, int $newProductProfileId, string $newProductPrice = null) {
		try {
			$this->setProductId($newProductId);
			$this->setProductProfileId($newProductProfileId);
			$this->setProductPrice($newProductPrice);
		}
		//determine what exception type was thrown
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

	public function getProductId(): ?int {
		return ($this->productId);
	}

	/**
	 * mutator method for product id
	 *
	 * @param int|null $newProductId value of new product id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 */

	public function setProductId(?int $newProductId): void {
		if($newProductId === null) {
			$this->productId = null;
			return;
		}

		if($newProductId <=0 ) {
			throw(new\RangeException("Profile Id is not positive"));
		}

		//convert and store the product id
		$this->productId = $newProductId;
	}

	//Start mutator method for productProfileId

	public function getProductProfileId(): ?int {
		return ($this->productProfileId);
	}

	/**
	 * mutator method for productProfileid
	 *
	 * @param int|null $newProductId value of new product id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 */

	public function setProductProfileId(?int $newProductProfileId): void {
		if($newProductProfileId === null) {
			$this->productProfileId = null;
			return;
		}

		if($newProductProfileId <=0 ) {
			throw(new\RangeException("Profile Id is not positive"));
		}

		//convert and store the product id
		$this->productProfileId = $newProductProfileId;
	}


	public function getProductPrice(): string {
		return ($this->productPrice);
	}

	/**
	 * mutator method for productPrice
	 *
	 * @param string $newProductPrice new value of handle
	 *
	 * @throws \InvalidArgumentException if $newProductPrice is not a string or insecure
	 * @throws \RangeException if $newProductPrice is > 32 characters
	 * @throws \TypeError if $newProductPrice is not a string
	 **/

	public function setProductPrice(string $newProductPrice): void {
		// verify the price is secure
		$newProductPrice = trim($newProductPrice);
		$newProductPrice = filter_var($newProductPrice, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProductPrice) === true) {
			throw(new\InvalidArgumentException("Price is empty"));
		}

		// verify the at handle will fit in the database
		if(strlen($newProductPrice) > 32) {
			throw(new \RangeException("Price too large"));
		}

		if($newProductPrice < 0) {
			throw(new\RangeException(("Price cannot be negative")));
		}

		//store the handle
		$this->productPrice = $newProductPrice;
	}

	/**
	 * inserts productId into Mysql
	 *@param \PDO $pdo PDO connection object
	 *@throws /PDOException when mySQL related errors occur
	 *@throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		//enforce the productId is null (i.e., don't insert a productId that already exists
		if($this->productId !== null) {
			throw(new \PDOException("not a new productId"));
		}
		//create query template
		$query = "INSERT INTO product(productId, productProfileId, productPrice) VALUE(:productId, :productProfileId, :productPrice)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["productProfileId" => $this->productProfileId, "productPrice" => $this->productPrice];
		$statement->execute($parameters);
		// update the null productId with what mysql just gave us
		$this->productId = intval($pdo->lastInsertId());
	}
	/**
	 * deletes this product from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throw \PDOException whe mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */

	public function delete(\PDO $pdo) : void {
		// enforce the productId is not null.
		if($this->productId === null) {
			throw(new \PDOException("Unable to delete product that does not exists"));
		}
		// create query
		$query = "DELETE FROM product WHERE productId = :productId";
		$statement = $pdo->prepare($query);
		// bind variables
		$parameters = ["productId" => $this->productId];
		$statement->execute($parameters);
	}

	/**
	 * Updates this product
	 * @param PDO $pdo
	 */

	public function update(\PDO $pdo) : void {
		// enforce the productId is not null.
		if($this->productId === null) {
			throw(new \PDOException("Unable to update product that does not exists"));
		}
		// create query
		$query = "UPDATE product SET productProfileId = :productProfileId, productPrice = :productPrice WHERE productId = :productId";
		$statement = $pdo->prepare($query);
		// bind variables
		$parameters = ["productProfileId" => $this->productProfileId, "productPrice" => $this->productPrice, "productId" => $this->productId];
		$statement->execute($parameters);
	}

	/**
	 * gets a product by productId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $tweetId tweet id to search for
	 * @return Tweet|null Tweet found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProductbyProductId(\PDO $pdo, int $productId) : ?Product {
		// sanitize the tweetId before searching
		if($productId <= 0) {
			throw(new \PDOException("product id is not positive"));
		}
		// create query template
		$query = "SELECT productId, productProfileId, prodcutPrice FROM product WHERE productId = :productId";
		$statement = $pdo->prepare($query);
		// bind the tweet id to the place holder in the template
		$parameters = ["productId" => :$productId];
		$statement->execute($parameters);
		// grab the tweet from mySQL
		try {
			$product = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$product = new Product($row["productId"], $row["productProfileId"], $row["productPrice"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($product);
}
