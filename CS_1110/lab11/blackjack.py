# blackjack.py
# STUDENTS: PLACE YOUR NAME AND NETID HERE
# skeleton by:
#   L. Lee (LJL2), S. Marschner (SRM2), W. White (WMW2), A. Parkhurst (ANP56)
# April 8, 2018

"""Module for a simplified version of the game Blackjack"""
import card_lab11
import random


class Blackjack():
    """An instance is a game of Blackjack between a single player and a dealer.

    Instance Attributes:
        playerHand [list of Cards, may be empty]: the player's cards
        dealerHand [list of Cards, may be empty]: the dealer's cards
        deck [list of Cards]: list of the remaining Cards to draw from.
            The deck is assumed to hold enough Cards that it will not run out
            of cards for the player or dealer to draw from.
    """

    def __init__(self, d):
        """Initializer: a new Blackjack game with the player and dealer hands
        initialized from card list d.

        The player's hand is the first two cards in d.
        The dealer's hand is be the third card in d.
        These three cards are removed from d, and then this instance's deck
        will be resultant d (with those three cards removed) --- not a copy
        of d.

        We choose d to be a parameter to allow the caller, such as a casino,
        to "stack the deck" (choose the arrangement of the cards, insert
        extra cards, etc.) to its advantage!

        Precondition: d is a list of at least three Cards (and nothing other
        than Cards). More than 3 cards is preferable.
        """
        self.playerHand = []
        self.dealerHand = []
        self.playerHand.append(d.pop(0))
        self.playerHand.append(d.pop(0))
        self.dealerHand.append(d.pop(0))
        self.deck =d
        pass  # STUDENTS: REPLACE WITH YOUR IMPLEMENTATION

    def __str__(self):
        """Returns: string describing <player's score> and <dealer's score>

        Format of returned string: "player: <ps>; dealer: <ds>", where
        <ps> and <ds> are the scores of the player's hand and the dealer's
        hand, respectively.

        Here, we are assuming that all that matters is the score, which is true
        if aces are always 11.
        """
        string_scores = "player: " + str(self.playerScore()) + "; dealer: "+ str(self.dealerScore())
        return string_scores
        pass  # STUDENTS: REPLACE WITH YOUR IMPLEMENTATION.
              # But you will need to have implemented other methods first;
              # see the lab handout for instructions.
              # The returned string must have punctuation and spacing exactly
              # as exemplified in the spec.

    def dealerScore(self):
        """Returns: score for the dealer.
        Uses the scoring rules described in the lab handout.
        """
        return _score(self.playerHand)
        pass  # STUDENTS: REPLACE WITH YOUR IMPLEMENTATION

    def playerScore(self):
        """Returns: score for the player.
        Uses the scoring rules described in the lab handout.
        """
        return _score(self.dealerHand)
        pass  # STUDENTS: REPLACE WITH YOUR IMPLEMENTATION

    def dealerBust(self):
        """Returns: True if dealer has gone bust (score is over 21),
        False otherwise.
        Uses the scoring rules described in the lab handout.
        """
        if dealerScore(self)>21:
            return True
        else:
            return False
        pass  # STUDENTS: REPLACE WITH YOUR IMPLEMENTATION

    def playerBust(self):
        """Returns: True if player has gone bust (score is over 21),
        False otherwise.
        Uses the scoring rules described in the lab handout.
        """
        if playerScore(self)>21:
            return True
        else:
            return False
        pass  # STUDENTS: REPLACE WITH YOUR IMPLEMENTATION

# STUDENTS: THIS FUNCTION EXISTS FOR YOU TO USE, BUT DON'T MODIFY IT.
def _score(clist):
    """Returns: simplified-blackjack score for card list clist.

    In our version of blackjack, aces always count as 11 points and face cards
    count as 10 points.

    Example: the score for a hand of the 2 of Hearts and the Ace of spades: 13
    Example: the score for a hand of the King of Diamonds & 4 of Clubs 14

    Precondition: clist is a list of Cards.
    """
    s = 0  # score to return
    for c in clist:
        if c.rank >= 11:  # c is a face card
            s += 10
        elif c.rank == 1:  # c is an ace
            s += 11
        else:
            s += c.rank
    return s


#######################################################################
# DO NOT MODIFY BELOW THIS LINE

def play_a_game():
    """Create and play a single new blackjack game.

    This function provides a text-based interface for blackjack.
    It will continue to run until the end of the game."""

    # Create a new shuffled full deck
    deck = card_lab11.full_deck()
    random.shuffle(deck)

    # Start a new game.
    game = Blackjack(deck)

    # Tell player the scoring rules
    print('Welcome to CS 1110 Blackjack.')
    print('Rules: Face cards are 10 points. Aces are 11 points.')
    print('       All other cards have face value.')
    print()

    # Show initial deal
    print('Your hand: ' +  card_lab11.cardlist_str(game.playerHand))
    print('Dealer\'s hand: ' +  card_lab11.cardlist_str(game.dealerHand))
    print()

    # While player has not busted out, ask if player wants to draw
    player_halted = False  # True if player asked to halt, False otherwise
    while not game.playerBust() and not player_halted:
        # ri: input received from player
        ri = _prompt_player('Type h for new card, s to stop: ', ['h', 's'])

        player_halted = (ri == 's')
        if (not player_halted):
            game.playerHand.append(game.deck.pop(0))
            print("You drew the " + str(game.playerHand[-1]))
            print()

    if game.playerBust():
        print("You went bust, dealer wins.")
    else:
        print()
        _dealer_turn(game)
        print()
        print_winner_after_dealer(game)

    print("The final scores were " + str(game))


def _prompt_player(prompt, valid_responses):
    """Returns: the choice of a player for a given prompt.

    Prompts the user with `prompt` and checks if the response is valid against
    a list of acceptable answers.  If it is not valid, it asks the question
    again. Otherwise, returns the player's answer.

    Preconditions:
       prompt is a string.
       valid_responses is a list of strings representing the valid responses.
    """
    # Ask the question for the first time.
    # ri: input received from player
    ri = input(prompt)

    # Continue to ask while the response is not valid.
    while not (ri in valid_responses):
        print('Sorry, your response is invalid. It must be one of ' +
              str(valid_responses))
        print()
        ri = input(prompt)

    return ri


def _dealer_turn(game):
    """Performs the dealer's turn(s), printing out the result.

    The function uses standard BlackJack rules: the dealer stands above 17,
    but hits otherwise.
    """
    while game.dealerScore() < 17 and not game.dealerBust():
        game.dealerHand.append(game.deck.pop(0))
        print("Dealer drew the " + str(game.dealerHand[-1]))

def print_winner_after_dealer(game):
    """Prints who won, assuming Player did not go bust. """
    if (game.dealerBust()):
        print("Dealer went bust, you win!")
    elif (game.dealerScore() > game.playerScore()):
        print("Dealer outscored you, dealer wins.")
    elif (game.dealerScore() < game.playerScore()):
        print("You outscored dealer, you win!")
    else:
        print("The game was a tie.")



# Script code
if __name__ == '__main__':
    play_a_game()


