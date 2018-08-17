# cardstuff.py
# YOUR NAME AND NETID HERE;
# PUT THE DATE HERE
# skeleton by Lillian Lee (LJL2), Steve Marschner (SRM2),
#   and Walker White,  Mar 5, 2018


""" Functions dealing with Cards as defined by module card_lab06
"""
import random


# helper for draw_poker_hand
def draw(deck):
    """Returns: a single card that is randomly drawn (and removed) from `deck`.

    Precondition: deck is a list of cards containing at least one card."""
    i = random.randrange(len(deck))  # random int in 0..len(deck)-1
    card_drawn = deck.pop(i)
    return card_drawn
    # TODO: add a line or two that uses list method `pop` to remove the card at
    #       index i from `deck`, and returns the card that was removed.


# helper for the class Card and thus, indirectly, for sorting in draw_poker_hand
def less_than(c1, c2):
        """Returns: True if either:
            * the rank of card c1 is less than the rank of c2, or
            * c1 has the same rank as c2 but a suit that is less than c2's suit
            Returns False otherwise.

        Precondition: c1 and c2 are Cards."""
        if c1.rank < c2.rank:
            return True
        elif c1.rank == c2.rank and c1.suit < c2.suit:
            return True
        else:
            return False
        pass  # TODO: implement this function according to its specification.


def draw_poker_hand(deck):
    """Returns: list of five cards drawn from `deck`, in reverse sorted order.

    The drawn cards are removed from `deck`.  We use reverse sorted order
    because it's typical to sort cards with highest value to the left.

    Precondition: `deck` is a list of Cards containing at least five Cards."""
    output = []     # An empty list for you to add cards to when you draw them
    for y in list(range(5)):
        output.append(draw(deck))
    output.sort()
    output.reverse()


    # TODO: put in lines so that variable `output` eventually holds what we
    #       want to return.
    #
    # Syntax hint: since we're inside the file cardstuff.py, you say draw(deck)
    # instead of cardstuff.draw(deck).  You will want to call function draw
    # five times (or, you could use a for-loop, but we will not assume you
    # are able to write your own for-loops yet.)
    #
    # Non-obvious fact: If clist is a list of Cards, then clist.sort() will sort
    # clist by your less_than() function.
    # (We constructed things in this non-obvious way so that you wouldn't
    # need to know about certain details of class definitions.)
    #
    # REMEMBER: you need to use the *reverse* direction of what less_than does;
    # are there built-in list methods that help with this?



    return output



