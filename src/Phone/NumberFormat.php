<?php

namespace Phone;

class NumberFormat {

	private $pattern = NULL;

	public function hasPattern() {
		return isset($this->pattern);
	}

	public function getPattern() {
		return $this->pattern;
	}

	public function setPattern($value) {
		$this->pattern = $value;
		return $this;
	}

	private $format = NULL;

	public function hasFormat() {
		return isset($this->format);
	}

	public function getFormat() {
		return $this->format;
	}

	public function setFormat($value) {
		$this->format = $value;
		return $this;
	}

	private $leadingDigitsPattern = array();

	public function leadingDigitPatterns() {
		return $this->leadingDigitsPattern;
	}

	public function leadingDigitsPatternSize() {
		return count($this->leadingDigitsPattern);
	}

	public function getLeadingDigitsPattern($index) {
		return $this->leadingDigitsPattern[$index];
	}

	public function addLeadingDigitsPattern($value) {
		$this->leadingDigitsPattern[] = $value;
		return $this;
	}

	private $nationalPrefixFormattingRule = NULL;

	public function hasNationalPrefixFormattingRule() {
		return isset($this->nationalPrefixFormattingRule);
	}

	public function getNationalPrefixFormattingRule() {
		return $this->nationalPrefixFormattingRule;
	}

	public function setNationalPrefixFormattingRule($value) {
		$this->nationalPrefixFormattingRule = $value;
		return $this;
	}

	public function clearNationalPrefixFormattingRule() {
		$this->nationalPrefixFormattingRule = NULL;
		return $this;
	}

	/*
	  // optional bool national_prefix_optional_when_formatting = 6;
	  private boolean hasNationalPrefixOptionalWhenFormatting;
	  private boolean nationalPrefixOptionalWhenFormatting_ = false;
	  public boolean hasNationalPrefixOptionalWhenFormatting() {
	  return hasNationalPrefixOptionalWhenFormatting; }
	  public boolean isNationalPrefixOptionalWhenFormatting() {
	  return nationalPrefixOptionalWhenFormatting_; }
	  public NumberFormat setNationalPrefixOptionalWhenFormatting(boolean value) {
	  hasNationalPrefixOptionalWhenFormatting = true;
	  nationalPrefixOptionalWhenFormatting_ = value;
	  return this;
	  }
	 */

	private $domesticCarrierCodeFormattingRule = NULL;

	public function hasDomesticCarrierCodeFormattingRule() {
		return isset($this->domesticCarrierCodeFormattingRule);
	}

	public function getDomesticCarrierCodeFormattingRule() {
		return $this->domesticCarrierCodeFormattingRule;
	}

	public function setDomesticCarrierCodeFormattingRule($value) {
		$this->domesticCarrierCodeFormattingRule = $value;
		return $this;
	}

	/**
	 * @param NumberFormat $other
	 * @return NumberFormat
	 */
	public function mergeFrom(NumberFormat $other) {
		if ($other->hasPattern()) {
			$this->setPattern($other->getPattern());
		}
		if ($other->hasFormat()) {
			$this->setFormat($other->getFormat());
		}
		$leadingDigitsPatternSize = $other->leadingDigitsPatternSize();
		for ($i = 0; $i < $leadingDigitsPatternSize; $i++) {
			$this->addLeadingDigitsPattern($other->getLeadingDigitsPattern($i));
		}
		if ($other->hasNationalPrefixFormattingRule()) {
			$this->setNationalPrefixFormattingRule($other->getNationalPrefixFormattingRule());
		}
		if ($other->hasDomesticCarrierCodeFormattingRule()) {
			$this->setDomesticCarrierCodeFormattingRule($other->getDomesticCarrierCodeFormattingRule());
		}
		//  $this->setNationalPrefixOptionalWhenFormatting($other->isNationalPrefixOptionalWhenFormatting());
		return $this;
	}

	public function toArray() {
		$output = array();
		$output['pattern'] = $this->getPattern();
		$output['format'] = $this->getFormat();

		$output['leadingDigitsPatterns'] = $this->leadingDigitPatterns();

		if ($this->hasNationalPrefixFormattingRule()) {
			$output['nationalPrefixFormattingRule'] = $this->getNationalPrefixFormattingRule();
		}

		if ($this->hasDomesticCarrierCodeFormattingRule()) {
			$output['domesticCarrierCodeFormattingRule'] = $this->getDomesticCarrierCodeFormattingRule();
		}

		/*
		  objectOutput.writeBoolean(nationalPrefixOptionalWhenFormatting_);
		 */
		return $output;
	}

	public function fromArray(array $input) {
		$this->setPattern($input['pattern']);
		$this->setFormat($input['format']);
		foreach ($input['leadingDigitsPatterns'] as $leadingDigitsPattern) {
			$this->addLeadingDigitsPattern($leadingDigitsPattern);
		}

		if (isset($input['nationalPrefixFormattingRule'])) {
			$this->setNationalPrefixFormattingRule($input['nationalPrefixFormattingRule']);
		}
		if (isset($input['domesticCarrierCodeFormattingRule'])) {
			$this->setDomesticCarrierCodeFormattingRule($input['domesticCarrierCodeFormattingRule']);
		}
		/*
		  setNationalPrefixOptionalWhenFormatting(objectInput.readBoolean());
		 *
		 */
	}
}
