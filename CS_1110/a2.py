# a2.py
# Prof. Lillian Lee (LJL2)
# Feb 27, 2018

""" Code for A2 diagramming exercise."""

from player import Player


def change(p, delta):
    """Adds delta to p's holdings unless doing so would make p's holdings
        negative, in which case nothing is added.
        Returns True if adding delta keeps p's holdings non-negative, False o.w.

    p is a Player.
    delta is an int, possibly negative or zero."""

    if delta < -p.holdings:
        return False
    else:
        p.holdings = p.holdings + delta
        return True


def redistr(p1, contrib1, p2, contrib2, factor):
    """Play a public goods game.

    Players p1 and p2 contribute contrib1 and contrib2 tokens, respectively,
    with the pot multiplied by `factor` before fair division between p1 and p2
    (truncated to an int).

    However, no change is made to if p1's holdings are less than contrib1 or
    p2's holdings are less than contrib2.

    p1 and p2 are Players.
    contrib1 and contrib2 are non-negative ints.
    factor is a positive float between 1 and 2 exclusive.
    """
    if not change(p1, -contrib1):
        return
    elif not change(p2, -contrib2):
        change(p1, contrib1)
        return

    get_back = int((contrib1+contrib2)*factor/2) # float division
    change(p1, get_back)
    change(p2, get_back)


p1 = Player(20)
p2 = Player(30)
p3 = Player(2)
redistr(p1, 4, p2, 6, 1.5)
redistr(p3, 2, p1, 30, 1.7)


