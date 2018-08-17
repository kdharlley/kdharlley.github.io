# card_lab06.py
# Lillian Lee (LJL2), Steve Marschner (SRM2), and Walker White
# Mar 5, 2018

""" Non-standalone module for standard playing cards (no jokers).

Defines the class Card and provides a few Card-related functions.

Implementation adapted from chapter 18 of the course text, _Think Python_,
by Allen B. Downey.

Students will need to correctly implement a function in cardstuff for Card
comparison (specifically, the _lt_ method in class Card) for this
code to work correctly.

"""

from functools import total_ordering  # for implementing comparisons in Python3
import cardstuff


# decorator "fills" missing comparisons, at the cost of speed
@total_ordering
class Card():
    """An instance is a standard playing card (no jokers).

    Class variables:
        SUIT_NAMES: list of valid suit names:
            ['Clubs', 'Diamonds', 'Hearts', 'Spades']
        NUM_SUITS (int): number of valid suits
        RANK_NAMES: list representing translations of valid int ranks to names.
            0 is not a valid rank; do not reference RANK_NAME[0]
            RANK_NAME[1] is 'Ace',
            RANK_NAME[2] is '2',
            ...
            RANK_NAME[10] is '10',
            RANK_NAME[11] is 'Jack',
            RANK_NAME[12] is 'Queen',
            RANK_NAME[13] is 'King'
        NUM_RANKS (int): number of valid ranks

    Instance Attributes:
        suit (int in 0..Card.NUM_SUITS-1): The suit encoding of this card.
            The *name* of this suit is given by `Card.SUIT_NAMES[suit]`.

        rank (int in 1..Card.NUM_RANKS): The rank encoding of this card.
            The *name* of this rank is given by `Card.RANK_NAMES[rank]`.

    For example, if we execute c = Card(0, 12), Card.SUIT_NAMES[c.suit] is
    'Clubs' and Card.RANK_NAMES[c.rank] is 'Queen', meaning c is the Queen of
    Clubs.
    """
    SUIT_NAMES = ['Clubs', 'Diamonds', 'Hearts', 'Spades']
    NUM_SUITS = len(SUIT_NAMES)

    # Starts at None so that we can treat RANK_NAMES as a translation table:
    RANK_NAMES = [None, 'Ace', '2', '3', '4', '5', '6', '7',
                  '8', '9', '10', 'Jack', 'Queen', 'King']
    NUM_RANKS = len(RANK_NAMES)-1  # ignore invalid rank encoding 0

    def __init__(self, s, r):
        """Initializer: A new Card with suit encoding s and rank encoding r.

        Example: if we execute c = Card(0, 12), then this card is the Queen of
        Clubs, since Card.SUIT_NAMES[c.suit] is 'Clubs' and
        Card.RANK_NAMES[c.rank] is 'Queen'.

        Preconditions: s is an int in 0..self.NUM_SUITS-1
                       r is an int in 1..self.NUM_RANKS
        """
        self.suit = s
        self.rank = r

    def __str__(self):
        """Returns: Readable string representation of this card.
        Example: '2 of Hearts'"""
        return self.RANK_NAMES[self.rank] + ' of ' + self.SUIT_NAMES[self.suit]

    def __repr__(self):
        """Returns: Unambiguous string representation of this card.
        Example: 'Card(3,2): 2 of Spades'"""
        partial_result = 'Card('+ str(self.suit) + ',' + str(self.rank) + "): "
        return partial_result +str(self)

    # We've included __eq__ so that we can do testing of equality of cards and
    # lists of cards.
    def __eq__(self, other):
        """Returns: True if `other` is a Card that has the same suit and rank as
        this Card;
        False if `other` is a Card that doesn't have the same suit and rank as
        this Card.
        and NotImplemented if `other` is not a Card."""
        if not isinstance(other,Card):
            return NotImplemented
        else:
            return (self.suit, self.rank) == (other.suit, other.rank)

    def __ne__(self, other):
        """Returns: True if `other` is a Card and does not have the same suit
        and rank as this Card, False otherwise."""
        return not self == other

    def __lt__(self, other):
        """Returns:
        True if `other` is a Card and either:
            * the rank of this Card is less than the rank of `other`, or
            * this Card has the same rank as `other` but a suit that is less
                than the suit of `other`;
        False if `other` is a Card and neither *'d condition above holds;
        NotImplemented if `other` is not a Card"""
        if not isinstance(other,Card):
            return NotImplemented
        else:
            return cardstuff.less_than(self, other)  # Students will implement this


def full_deck():
    """Returns: list of the standard 52 Cards.
        The list is in ascending suit then rank order:
        Ace of Clubs first, King of Spades last."""
    output = []  # list of cards so far to be returned
    for suit in range(Card.NUM_SUITS):
        # range(n) creates the list [0,1,2,...,n-1]
        for rank in range(1,Card.NUM_RANKS+1):
            # range(1,n) creates the list [1,2,...,n-1]
            # skip the None value
            output.append(Card(suit,rank))
    return output


def print_cards(clist):
    """Print cards in clist as a human-readable sequence of lines.

    Precondition: clist is a (possibly empty) list of Cards."""
    for c in clist:
        print(c)


def print_cards2(clist):
    """Altered implementation of print_cards just for lab purposes"""
    for c in clist:
        print("c")


def print_cards_condensed (clist):
    """Print cards in clist as a human-readable single line.

    Precondition: clist is a (possibly empty) list of Cards.."""
    for c in clist:
        print(c, end='; ')  # This replaces the usual terminating newline with
                            # a semicolon and a space, so the printout only
                            # takes up one line.
    print()  # Add newline

