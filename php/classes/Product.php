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

	private productId;

	/** id for the Profile that has the product */

	private productProfileId;

	private productPrice;

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
			$this->setProductId = null;
			return;
		}


	}
}