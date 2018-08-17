# onioncard.py
# PUT YOUR NAME AND NETID HERE
# PUT DATE OF COMPLETION HERE
# Skeleton by Lillian Lee (LJL2), Apr 16, 2018

"""Module providing a class for Cripple Mr. Onion cards, i.e.,
    with eight suits: spades, hearts, diamonds, clubs plus swords, cups, coins,
    and staves."""

import card_lab12 as cfile


class OnionCard(cfile.Card):
    """Represents a Cripple Mr. Onion (CMO) card.

   Class variables:
        SUIT_NAMES: list of valid suit names:
            ['Clubs', 'Diamonds', 'Hearts', 'Spades',
             'Staves', 'Coins', 'Cups', 'Swords']
        NUM_SUITS (int): number of valid suits: 8
        RANK_NAMES: translation table of ranks to names:
            RANK_NAME[1] is 'Ace',
            RANK_NAME[2] is '2',
            ...
            RANK_NAME[13] is 'King',
        NUM_RANKS (int): number of valid ranks: 13


    Instance Attributes:
        suit: The suit of this particular card.
              The name of this suit is given by OnionCard.SUIT_NAMES[suit].
              [int, in 0..OnionCard.NUM_SUITS-1]
        rank: The rank of this particular card.
              The name of this rank is given by OnionCard.RANK_NAMES[rank].
              [int, in 1..OnionCard.NUM_RANKS]

    For example, if we execute c = OnionCard(4, 12),
    OnionCard.SUIT_NAMES[c.suit] is 'Staves'
    OnionCard.RANK_NAMES[c.rank] is '12',
    so this card is the Queen of Staves.
    """
    # Class variable definitions

    SUIT_NAMES = cfile.Card.SUIT_NAMES + ['Staves', 'Coins', 'Cups', 'Swords']
    NUM_SUITS = len(SUIT_NAMES)
    # RANK-related variables are inherited from the superclass.

    def __init__(self, s, r):
        """Initializer: A new OnionCard with suit encoding s and rank encoding r.

        Preconditions:
           s in 0..self.NUM_SUITS-1 (inclusive)
           r in 1..self.NUM_RANKS (inclusive)"""
        cfile.Card.__init__(self, s,r)

        print(OnionCard.water)
        pass  # STUDENTS: replace with a correct call to the
              # __init__ of the superclass

if __name__ == '__main__':
    """Here is the test suggested in the handout to see if creating an OnionCard
    raises an error."""

    print(OnionCard(6, 10))