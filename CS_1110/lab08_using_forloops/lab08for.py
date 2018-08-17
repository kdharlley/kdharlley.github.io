# lab08for.py
# Lillian Lee (LJL2) and Walker White(wmw2)
# Mar 2018
"""Functions for Lab 8"""


def lesser_than(thelist, value):
    """Returns: number of items in thelist that are strictly less than `value`.
    Does not change thelist itself.
    Preconditions: thelist is a (possibly empty) list of ints.
                   `value` is an int.

    Example:  lesser_than([5, 9, 1, 7], 9) -> 3

    Other test cases are given in lab08for_test.py
    """
    counter=0
    for index in list(range(len(thelist))):
        if thelist[index]<value:
            counter= counter+1
    return counter
    pass  # STUDENTS: replace with an implementation that makes effective use
          # of a for-loop.




# STUDENTS: the use of a local function is more advanced Python than you need
# to know for this class, but you might find it interesting to see a use of
# `filter` instead of an explicit loop.
def lesser_than3(thelist, value):
    """Alternate version of less_then"""

    # Yes, you can define functions within functions!
    def ltv(x):
        """Returns True/False depending on whether x is less than value."""
        return x < value

    return len(list(filter(ltv, thelist)))


# STUDENTS: the use of a "temporary" function (a lambda expression) is more
# advanced Python than you need to know for this class,
# but you might find it interesting to see an another way to use `filter`
# instead of an explicit loop.
def lesser_than4(thelist, value):
    """Alternate version of less_then"""
    # The "lambda" expression:
    # lambda x: x < value
    # evaluates to a function that returns True/False depending on whether
    # its argument is less than `value` or not.
    #
    return len(list(filter(lambda x: x < value, thelist)))


def clamp(thelist, vmin, vmax):
    """Modifies the list so that every element is between vmin and vmax.
    Does not return anything.

    Any number in the list less than vmin is replaced with vmin.  Any number
    in the list greater than vmax is replaced with vmax. Any number between
    vmin and vmax is left unchanged.

    Example: if thelist is [-1, 1, 3, 5], then clamp(thelist, 0, 4) changes
    thelist to have [0,1,3,4] as its contents.

    Preconditions:
        thelist: possibly empty list of numbers (float or int)
        vmin, vmax: numbers, with vmin <= vmax"""
    for index in list(range(len(thelist))):
        if thelist[index]<vmin:
            thelist[index]=vmin
        elif thelist[index]>vmax:
            thelist[index]=vmax
    pass  # STUDENTS: replace with an implementation that makes effective use
          # of a for-loop.


def perfects(exam):
    """Returns: the number of perfect subquestions answered on this `exam`.

    A graded exam consists of a non-empty list of questions.
    Each question is a non-empty list of 2-tuples of the form
         (got, poss)
    where `got` is the int score that the student received, and `poss` is the
    int max score achievable on that problem, 0 <= got <= poss.
    """
    counter=0
    for index in list(range(len(exam))):
        question= exam[index]
        for subsect in list(range(len(question))):
            answerval = list(question[subsect])
            if answerval[0]==answerval[1]:
                counter=counter+1
                
    return counter
    pass  # STUDENTS: First, don't forget to complete the diagram in section 3.1
          # of the lab handout.
          #
          # Then, provide an implementation that makes effective use
          # of nested for-loops. (You may not make use of any list flattening,
          # even if you happen to know what that is.)






# STUDENTS:  this exercise is optional!
def uniques(thelist):
    """Returns: The number of unique elements in thelist.
    Does not modify thelist.

    Examples: unique([5, 9, 5, 7]) -> 3
              unique([5, 5, 1, 'a', 5, 'a']) -> 3

    Precondition: thelist is a (possibly empty) list."""
    # You *must* implement this with a for-loop.
    # Hint1: You need to keep track of all the items you've already seen.
    #        One strategy is to start with a new empty list called new_items,
    #        and gradually append to new_items any previously unseen item.
    #
    #        An alternate strategy is to look to see if the current item
    #        existed in any of the prior part of thelist.
    # Hint2: You can check whether `item` is in new_items
    #           item in new_items  # This is a boolean expression
    #        Similarly, you can do
    #           item not in new_items
    #        or
    #           not item in new_items
    newlist=[]
    for key in list(range(len(thelist))):
        if thelist[key] not in newlist:
            newlist.append(thelist[key])
    return len(newlist)    
    pass  # STUDENTS:  This question is optional!  Only try it if you have time.
          # replace with your code, which must make effective use of
          # of a for-loop



