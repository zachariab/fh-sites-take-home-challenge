<?php
namespace PokerHand;

use PHPUnit\Framework\TestCase;

class PokerHandTest extends TestCase
{
    /**
     * @test
     */
    public function itCanRankARoyalFlush()
    {
        $hand = new PokerHand('As Ks Qs Js 10s');
        $this->assertEquals('Royal Flush', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankAPair()
    {
        $hand = new PokerHand('Ah As 10c 7d 6s');
        $this->assertEquals('One Pair', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankTwoPair()
    {
        $hand = new PokerHand('Kh Kc 3s 3h 2d');
        $this->assertEquals('Two Pair', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankAFlush()
    {
        $hand = new PokerHand('Kh Qh 6h 2h 9h');
        $this->assertEquals('Flush', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankAStraightFlush()
    {
        $hand = new PokerHand('3h 4h 5h 6h 7h');
        $this->assertEquals('Straight Flush', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankAStraight()
    {
        $hand = new PokerHand('7h 4s 5h 6d 3s');
        $this->assertEquals('Straight', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankThreeOfAKind()
    {
        $hand = new PokerHand('Kh Kc Ks 3h 2d');
        $this->assertEquals('Three of a Kind', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankFourOfAKind()
    {
        $hand = new PokerHand('3h 3c 3s 3d 2d');
        $this->assertEquals('Four of a Kind', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankAFullHouse()
    {
        $hand = new PokerHand('3h 3c 3s 2c 2d');
        $this->assertEquals('Full House', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankAHighCard()
    {
        $hand = new PokerHand('3h Ac Js 2c 8d');
        $this->assertEquals('High Card', $hand->getRank());
    }
     
    /**
     * @test
     * Validation test
     */
    public function itWillThrowOnDuplicateCards() 
    {
        $this->expectException(\InvalidArgumentException::class);
        $hand = new PokerHand('Kh 4h 4h 9s 10s');
    }

    /**
     * @test
     * Validation test
     */
    public function itWillThrowOnWrongNumberOfCards() 
    {
        $this->expectException(\InvalidArgumentException::class);
        $hand = new PokerHand('Kh 4h 4d 9s 10s 8s 10d');
    }

    /**
     * @test
     * Validation test
     */
    public function itWillThrowOnInvalidCardString() 
    {
        $this->expectException(\InvalidArgumentException::class);
        $hand = new PokerHand('9s 10s 8s 10d 99m');
    }
    
}