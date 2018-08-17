# timer.py
# Lillian Lee (LJL2) and Walker White (WMW2)
# Feb 2018

""" Timer class for lab05

Students do not need to edit or even examine this file.

"""


class Timer(object):

    """Instances represent a timer with a resolution of minutes.

    Attributes:
        hours [non-negative int]: number of hours
        minutes [int in the range 0..59]: number of minutes

    """

    ## STUDENTS: don't worry about the syntax of this method definition.
    ## Just know that a call of the form Timer(x,y) will set the new Timer's
    ## hours to x and the Timer's minutes to y.
    def __init__(self, h, m):
        """Sets this Timer's hours to h and minutes to m.

        Preconditions: h is a positive int, h is an int in range 0..59"""
        self.hours = h
        self.minutes = m


