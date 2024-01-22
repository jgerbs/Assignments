<?php

require_once 'Book.php';

class BookRepository {

	private string $filename;

	/**
	 * @param string $theFilename
	 */
	public function __construct(string $theFilename) {
		$this->filename = $theFilename;
	}

	/**
	 * @return array of Book objects
	 */
	public function getAllBooks(): array {
		// If the file doesn't exist, we have no books to read!
		if (!file_exists($this->filename)) {
			return [];
		}

		// If we get a falsy value back from file_get_contents, we won't have anything to parse to JSON
		$fileContents = file_get_contents($this->filename);
		if (!$fileContents) {
			return [];
		}

		// The string happens to be in JSON format, so pass it to json_decode
		// The 2nd parameter requests an associative array return value
		$decodedBooks = json_decode($fileContents, true);
		if (json_last_error() !== JSON_ERROR_NONE) {
			return []; // A JSON error occurred in our parsing attempt -- return empty to the caller
		}

		// Create an empty list and fill the Book objects with the JSON
		$books = [];
		foreach ($decodedBooks as $bookData) {
			$books[] = (new Book())->fill($bookData);
		}

		// Return the array of Books back to the caller
		return $books;
	}

	/**
	 * @param Book $book
	 */
	public function saveBook(Book $book): void {
		if ($book->getName() && $book->getInternationalStandardBookNumber() && $book->getAuthor()) {
            $books = $this->getAllBooks();
            $books[] = $book;
            file_put_contents($this->filename, json_encode($books, JSON_PRETTY_PRINT));
        }
	}
	 /**
	  * Retrieves the book with the given ISBN, or null if no book with the specified ISBN is found.
	  * Note: for the purposes of this lab you may return the first occurrence if there are multiple books with the same ISBN in the file.
	  *
	  * @param string $isbn
	  * @return Book|null
	  */
	 public function getBookByISBN(string $isbn): Book|null {
		$books = $this->getAllBooks();
		foreach ($books as $book) {
			if ($book->getInternationalStandardBookNumber() === $isbn) {
				return $book;
			}
		}
		return null;
	 }

	/**
	 * Retrieves the book with the given title, or null if no book of that title is found.
	 * Note: for the purposes of this lab you may return the first occurrence if there are multiple books of the same title.
	 *
	 * @param string $title
	 * @return Book|null
	 */
	public function getBookByTitle(string $title): Book|null {
        $books = $this->getAllBooks();
        foreach ($books as $book) {
            if ($book->getName() === $title) {
                return $book;
            }
        }
        return null;
	}

	/**
	 * Updates the book in the file with the given $isbn (the contents of that book is replaced by $newBook in the file)
	 * Hint: are you seeing the file have indexes added to the JSON? Look into https://www.php.net/manual/en/function.array-values.php
	 * @param string $isbn
	 * @param Book $newBook
	 */
	public function updateBook(string $isbn, Book $newBook): void {
        if ($newBook->getName() && $newBook->getInternationalStandardBookNumber() && $newBook->getAuthor()) {
            $books = $this->getAllBooks();
            foreach ($books as $key => $book) {
                if ($book->getInternationalStandardBookNumber() === $isbn) {
                    $books[$key] = $newBook;
                    file_put_contents($this->filename, json_encode($books, JSON_PRETTY_PRINT));
                    return;
                }
            }
        }
	}

	/**
	 * Deletes the book in the file with the given $isbn.
	 * Seeing indexes be added to the JSON? Look into https://www.php.net/manual/en/function.array-values.php
	 * @param string $isbn
	 */
	public function deleteBookByISBN(string $isbn): void {
        $books = $this->getAllBooks();
        foreach ($books as $key => $book) {
            if ($book->getInternationalStandardBookNumber() === $isbn) {
                unset($books[$key]);
				file_put_contents($this->filename, json_encode($books, JSON_PRETTY_PRINT));
                return;
            }
        }	}

}
