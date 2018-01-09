<?php
/**
 * The intention of the Paginated class is to manage the iteration of records
 * based on a specified page number usually addressed by a get parameter in the query string
 * and to use a layout interface to produce number pages based on the amount of elements
 */

class Paginator {

	private $pageSize;                      //number of records to display
	private $pageNumber;                    //the page to be displayed
	private $numRows;
	private $offset;
	private $pgArr;

	function __construct($resultSize, $displayRows = 10, $pageNum = 1) {
		$this->setPageSize($displayRows);
		$this->setNumRows($resultSize);		
		$this->assignPageNumber($pageNum);	
		$this->setPageArray();
	}

	//implement getters and setters
	public function getPageSize() {
		return $this->pageSize;
	}

	public function setPageSize($pages) {
		$this->pageSize = $pages;
	}
	public function getNumRows(){
		return $this->numRows;
	}
	public function setNumRows($rows){
		$this->numRows=$rows;
	}
	//offset, i.e. where to start searching in database	
	public function getOffset(){
		return $this->offset;
	}

	//accessor and mutator for page numbers
	public function getPageNumber() {
		return $this->pageNumber;
	}

	public function setPageNumber($number) {
		$this->pageNumber = $number;
	}

	public function fetchNumberPages() {
		if (!$this->getNumRows()) {
			return false;
		}
		
		$pages = ceil($this->getNumRows() / (float)$this->getPageSize());
		return $pages;
	}

	//sets the current page being viewed to the value of the parameter
	public function assignPageNumber($page) {
		if(!isset($page) || ($page == "") || ($page <= 0) || ($page > $this->fetchNumberPages())) {			
			$this->setPageNumber(1);
		}
		else {
			$this->setPageNumber($page);
		}
		//upon assigning the current page, move the cursor in the result set to (page number minus one) multiply by the page size
		//example  (2 - 1) * 10
		$this->offset=($this->getPageNumber()-1)*$this->getPageSize();
	}

	public function isFirstPage() {
		return ($this->getPageNumber() <= 1);
	}

	public function isLastPage() {
		return ($this->getPageNumber() >= $this->fetchNumberPages());
	}
	public function getPrevious() {
		if(($this->getPageNumber())>1) return $this->getPageNumber()-1;
		else return false;
	}
	public function getNext() {
		if(($this->getPageNumber())<$this->fetchNumberPages()) return $this->getPageNumber()+1;
		else return false;
	}
	private function setPageArray(){
		$currentPage=$this->getPageNumber();
		$numPages=$this->fetchNumberPages();
		if($numPages-$currentPage>=1000) $stepSizeF=1000;
		else if($numPages-$currentPage>=100) $stepSizeF=100;
		else if($numPages-$currentPage>=10) $stepSizeF=10;
		else $stepSizeF=1;
		
		if($currentPage>=1000) $stepSizeB=1000;
		else if($currentPage>=100) $stepSizeB=100;
		else if($currentPage>=10) $stepSizeB=10;
		else $stepSizeB=1;
		
		$b=floor(($currentPage-5)/(float)$stepSizeB)*$stepSizeB;
		$x=$b/$stepSizeB;
		$i=$x-5;
		if($i<1) $i=1;
		for($i=1; $i<=$x; ++$i)
			$this->pgArr[]=$i*$stepSizeB;		

		$x=$currentPage-5;
		if($x<1) $x=1;
		$max=$x+10;
		if($max>$numPages) $max=$numPages;
		for(;$x<=$max;++$x)
			$this->pgArr[]=$x;
		
		$f=ceil(($currentPage+5)/(float)$stepSizeF)*$stepSizeF;
		$max=$f+$stepSizeF*5;
		if($max>$numPages) $max=$numPages;
		$x=1;
		for(;$f<=$max; ++$x, $f=$x*$stepSizeF)
			$this->pgArr[]=$f;
	}
	public function getPageArray(){
		if(!isset($this->pgArr)||count($this->pgArr)<=1) return false;
		else return $this->pgArr;			
	}

	//returns a string with the base navigation for the page
	//if queryVars are to be added then the first parameter should be preceeded by a ampersand
	//public function fetchPagedNavigation($queryVars = "") {
		//return $this->getLayout()->fetchPagedLinks($this, $queryVars);
	//}//end writeNavigation
}//end Paginated
?>
