<?php

namespace PokerHand;

class PokerHand
{

    public $hand;
    private $cardRanks = ['2','3','4','5','6','7','8','9','T','J','Q','K','A'];
    private $cardSuits = ['s', 'c', 'd', 'h'];
    private $maxRankValue = 12;

    // Accept a string of cards, validate and then store as an array in $this->hand
    public function __construct($hand)
    {
        // Convert '10' to 'T' so card ranks are uniformly 1 character
        $this->hand = str_replace("10", "T", $hand);
        $this->hand = explode(" ", $this->hand);
        // Cards should be unique
        $this->hand = array_unique($this->hand);
        // 5 unique cards are required
        if (count($this->hand) != 5) {
            throw new \InvalidArgumentException('PokerHand requires 5 unique cards in input string. Hand contained '. count($this->hand) . 'cards');
        }
        // Validate card strings
        foreach ($this->hand as &$card) {
            if (preg_match("/[2-9TJQKA][hcsd]/", $card) === 0)
                throw new \InvalidArgumentException('Invalid card: ' . $card);
        }
    }

    // Main public function of class, optimized for readabilty over speed
    public function getRank()
    {
        $rankFrequncies = $this->getRankFrequencies();

        if ($this->hasFlush() && $this->hasStraight() && $this->getHandHighRankValue() == $this->maxRankValue)
            return 'Royal Flush';
        if ($this->hasFlush() && $this->hasStraight())
            return 'Straight Flush';
        if (in_array(4, $rankFrequncies))
            return 'Four of a Kind';
        if ($rankFrequncies == [2,3])
            return 'Full House';
        if ($this->hasFlush())
            return 'Flush';
        if ($this->hasStraight())
            return 'Straight';
        if ($rankFrequncies == [1,1,3])
            return 'Three of a Kind';
        if ($rankFrequncies == [1,2,2])
            return 'Two Pair';
        if ($rankFrequncies == [1,1,1,2]) 
            return 'One Pair';

        return "High Card";
    }
    
    // Return an array of suit => number of cards in the suit
    private function getSuitFrequencies() {
        $suits = array_fill_keys($this->cardSuits, 0);
        foreach ($this->hand as &$card) { 
            $suits[str_split($card)[1]]++;   
        }
        return $suits;
    }

    // Get the highest numerical rank in the hand
    private function getHandHighRankValue() {
        $highCard = -1;
        foreach ($this->hand as &$card) { 
            $rank = array_search(str_split($card)[0], $this->cardRanks);
            if ($rank > $highCard) {
                $highCard = $rank;
            }       
        }
        return $highCard;
    }

    // Return true if hand contains 5 of the same suit
    private function hasFlush() {
        foreach($this->getSuitFrequencies() as $suit => $suitCount) {
            if ($suitCount == 5)
                return true;
        }
        return false;
    }
    
    // Return true if hand contains 5 ranks in sequence
    private function hasStraight() {
        $rankTotals = array_fill_keys($this->cardRanks, 0);
        foreach ($this->hand as &$card) { 
            $rankTotals[str_split($card)[0]]++;   
        }
        $hasStraight = strpos(implode($rankTotals), '11111') !== false;
        return $hasStraight;
    }

    // Return a sorted array of the distinct rank counts in a hand
    // E.g. A hand with 1 A, 2 Ks, and 2 Qs returns [1,2,2]
    private function getRankFrequencies() {
        $rankTotals = array_fill_keys($this->cardRanks, 0);
        foreach ($this->hand as &$card) { 
            $rankTotals[str_split($card)[0]]++;   
        }
        $rankTotals = array_values(array_filter($rankTotals));
        return $rankTotals;
    }

}