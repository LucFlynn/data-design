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

}
