# cardstufftest.py
# Lillian Lee (LJL2) and Steve Marschner (SRM2)
# Mar 5, 2018

"""Module for testing some functions in cardstuff"""

import cornellasserts
import card_lab06  # need to create Cards for test cases
import cardstuff
import sys




def test_draw():
    """Quick diagnostic test of whether cardstuff.draw seems to be working.
    May depend on equality being correct for cards"""
    print("Testing test_draw")
    orig_clist = [card_lab06.Card(1,11)]
    clist = orig_clist[:]
    orig_hand = [card_lab06.Card(2,3)]
    hand = orig_hand[:]
    # Have a hand containing the 3 of hearts, drawing from a 'deck'
    # containing just the Jack of Diamonds

    c = cardstuff.draw(clist)
    hand.append(c)

    try:
        cornellasserts.assert_not_equals(c,None)
    except:
        print("Error: draw is returning None")
        sys.exit()

    try:
        cornellasserts.assert_equals(0,len(clist))
    except:
        print("Error: the drawn card is not being removed from the list")
        print("Consider adding print statements to debug")
        sys.exit()

    # Now trying to draw from a full deck, checking that we don't seem to
    # be drawing from the same position each time
    orig_deck = card_lab06.full_deck()
    clist = card_lab06.full_deck()
    c1 = cardstuff.draw(clist)
    i1 = orig_deck.index(c1)
    orig_deck.pop(i1)
    c2 = cardstuff.draw(clist)
    i2 = orig_deck.index(c2)
    orig_deck.pop(i2)
    c3 = cardstuff.draw(clist)
    i3 = orig_deck.index(c3)

    if i1 == i2 and i2 == i3:
        print("***Suspicious output***: seems like the drawn card is not randomly picked")
        print("\tbut is always drawn from the same position.")
        print("Consider testing in Python interactive mode")
        sys.exit()

    print("finished test of test_draw()")


def test_less_than():
    """Test cardstuff.less_than"""
    print("Running less_then")

    # We're using a list of lists to compactly encode test cases.
    # We don't guarantee that this is a thorough set of test cases.
    test_cases = [
        [card_lab06.Card(2,10), card_lab06.Card(2,11), True],
        [card_lab06.Card(3,10), card_lab06.Card(2,11), True],
        [card_lab06.Card(2,13), card_lab06.Card(2,11), False],
        [card_lab06.Card(3,10), card_lab06.Card(2,1), False],
        [card_lab06.Card(3,10), card_lab06.Card(3,10), False],
        [card_lab06.Card(3,10), card_lab06.Card(2,10), False],
        [card_lab06.Card(0,10), card_lab06.Card(2,10), True],
        [card_lab06.Card(3,2), card_lab06.Card(2,3), True]
    ]

    # Now we loop through each case in out list of test cases.
    for tcase in test_cases:
        inputs = tcase[:2] # first two items
        answer = tcase[2]

        # the "*" expands a list of arguments into arguments for a function
        try:
            cornellasserts.assert_equals(answer, cardstuff.less_than(*inputs))
        except:
            print("Failed on input " + str(inputs))
            sys.exit()

    print("finished test_less_than")


def test_draw_poker_hand():

    fd = card_lab06.full_deck()
    hand = cardstuff.draw_poker_hand(fd)
    print('Drawing a poker hand to test. It is:', end=' ')
    card_lab06.print_cards_condensed(hand)


    # check that we got five cards
    try:
        cornellasserts.assert_equals(5, len(hand))
    except:
        print("\tError: the hand that was drawn doesn't have 5 cards.")
        sys.exit()

    # check that 5 cards were removed from the deck
    try:
        cornellasserts.assert_equals(52-5, len(fd))
        # check that none of the cards in the hand are in the deck
        for c in hand:
            cornellasserts.assert_true(not c in fd)
    except:
        print("\tError: cards in the hand weren't removed from the deck,")
        print("\t or there is some other problem with the deck.")
        print("\tHere is what the deck is: ")
        card_lab06.print_cards_condensed(fd)
        sys.exit()

    # check that the cards are in reversed sorted order
    try:
        for i in range(5-1):
            cornellasserts.assert_true(hand[i]>hand[i+1])
    except:
        print("\tError: the hand isn't sorted correctly.")
        sys.exit()

    print("\nfinished test of draw_poker_hand:")
    print("\tHas exactly 5 cards, sorted, that are no longer in the deck.")


# STUDENTS: don't edit this function.
def ask_to_quit():
    """Ask if user wishes to keep testing, terminate execution if not."""
    msg = 'Press q to quit, anything else to start testing the next function. '
    response = input(msg)
    if response == "q":
        sys.exit()

if __name__ == '__main__':
    test_draw()
    ask_to_quit()
    test_less_than()
    ask_to_quit()
    test_draw_poker_hand()
    print('All test cases for cardstuff passed')


