# lab09_optional.py
# Skeleton by various CS1110 profs over the years

"""Optional additional recursion exercises.

    You should write your own testcases --- we have to shortcut your writing
    testcases in lab because of time constraints, but writing test cases
    BEFORE YOU IMPLEMENT is a VITAL part of programming"""


def remove_dups(thelist):
    """Returns: a COPY of thelist with adjacent duplicates removed.

        Example: for thelist = [1,2,2,3,3,3,4,5,1,1,1],
        the answer is [1,2,3,4,5,1]

    Precondition: thelist is a list of ints"""
    if len(thelist)<=1:
        return thelist
 
    if thelist[0]==thelist[1]:
        print("in in if")
        del thelist[0]
        return remove_dups(thelist)
    else:
        return [thelist[0]]+ remove_dups(thelist[1:])
    """left=remove_dups(thelist[:2])
    right=remove_dups(thelist[:])
    return left[:1]+right
    pass # REPLACE WITH YOUR IMPLEMENTATION. MORE TEST CASES IN lab09_test.py"""


def number_not(thelist, v):
    """Returns: number of elements in thelist that are NOT v.

    Precondition: thelist is a list of ints
                  v is an int"""
    if thelist==[]:
        return 0
    if len(thelist)==1:
        if thelist[0]==v:
            return 0
        else:
            return 1
    left= number_not(thelist[:1], v)
    right = number_not(thelist[1:], v)
    return left+right
    pass  # REPLACE WITH YOUR IMPLEMENTATION


def remove_first(thelist, v):
    """Returns: a COPY of thelist but with the FIRST occurrence of v
    removed (if present).

    Note: This can be done easily using index. Don't do that.
    Do it recursively.

    Precondition: thelist is a list of ints
                  v is an int"""
    pass  # REPLACE WITH YOUR IMPLEMENTATION


def reverse1(thelist):
    """Returns: a COPY of thelist that is the reverse of the list.

        Example: the reverse of [1,2,3] is [3,2,1]

    Do not use the method reverse().  That alters the list thelist.
    Instead, implement this function with the following idea:
    The reverse of thelist with at least one element is the
    reverse of thelist[1:] catenated with (a list with the element)
    thelist[0].

    Precondition: thelist is a list of ints"""
    pass  # REPLACE WITH YOUR IMPLEMENTATION


def reverse2(thelist):
    """Returns: a COPY of thelist that is the reverse of the list.

        Example: the reverse of [1,2,3] is [3,2,1]

    Do not use the method reverse().  That alters the list thelist.
    Instead, implement this method with the following idea:
    To reverse a list thelist with at least two elements, switch
    the first and last ones and reverse the middle.

    Precondition: thelist is a list of ints"""
    pass  # REPLACE WITH YOUR IMPLEMENTATION


def sum_list(thelist):
    """Returns: the sum of the integers in list l.

        Example: sum_list([34]) is 34
        Example: sum_list([7,34,1,2,2]) is 46

    Precondition: thelist is a list of ints"""
    pass  # REPLACE WITH YOUR IMPLEMENTATION


def sum_to(n):
    """Returns: sum of numbers 1 to n.

        Example: sum_to(3) = 1+2+3 = 6,
        Example: sum_to(5) = 1+2+3+4+5 = 15

    Precondition: n >= 1 is an int."""
    pass  # REPLACE WITH YOUR IMPLEMENTATION


def num_digits(n):
    """Yields: number of the digits in the decimal representation of n.

        Example: num_digits(0) = 1
        Example: num_digits(3) = 1
        Example: num_digits(34) = 2
        Example: num_digits(1356) = 4

    Precondition: n >= 0 is an int"""
    pass  # REPLACE WITH YOUR IMPLEMENTATION


def sum_digits(n):
    """Returns: sum of the digits in the decimal representation of n.

        Example: sum_digits(0) = 0
        Example: sum_digits(3) = 3
        Example: sum_digits(34) = 7
        Example: sum_digits(345) = 12

    Precondition: n >= 0 is an int."""
    pass  # REPLACE WITH YOUR IMPLEMENTATION


def number2(n):
    """Returns: the number of 2's in the decimal representation of n.

        Example: number2(0) = 0
        Example: number2(2) = 1
        Example: number2(234252) = 3

    Precondition: n >= 0 is an int."""
    pass  # REPLACE WITH YOUR IMPLEMENTATION


def into(n, c):
    """Returns: The number of times that c divides n,

        Example: into(5,3) = 0 because 3 does not divide 5.
        Example: into(3*3*3*3*7,3) = 4.

    Precondition: n >= 1 and c > 1 are ints."""
    pass  # REPLACE WITH YOUR IMPLEMENTATION


def exp(b, c):
    """Returns: b ** c, i.e. b multiplied by itself c times.

    Also called b "to the power" c.
    Hints: b ** 0 = 1.
    if c is even, b**c == (b*b) ** (c/2)
    if c > 0, b**c =  b * (b ** (c-1)).

    Precondition: c >= 0 is an int"""
    pass  # REPLACE WITH YOUR IMPLEMENTATION


def embed(theinput):
    """Returns: depth of embedding, or nesting, in theinput.

    Examples:
        "the dog that barked" -> 0
        ["the", "dog", "that", "barked" ] -> 1
        ["the" ["dog", "that", "barked"]] -> 2
        ["the" ["dog", ["that", "barked"]] -> 3
        ["the" ["dog", ["that", ["barked"]] -> 4
        [[[["the"], "dog"], "that"], "barked"] -> 4

    Precondition: theinput is a string, or a potentially nested
    list of strings. No component list can be empty"""
    pass  # Very compact solution given at
    # http://www.cs.cornell.edu/courses/cs1110/2014sp/lectures/lecture12/presentation-12.pdf


def max_nested_list(theinput):
    """Returns: The item with the largest value in  theinput

    Example:
    sum_nested_list([0, [2, 5], 8, [-10, -1]]) should be  8

    Precondition: theinput is an integer, or a potentially nested
    non-empty list of integers. No component list can be empty"""
    pass  # REPLACE WITH YOUR IMPLEMENTATION


def flatten_nested_list(theinput):
    """Returns: a COPY of theinput that is flattened.

    This function flattens every item in the theinput into a list with depth 1

    Example:
    flatten_nested_list(['this', ['is', 'a'], 'list', ['list', 'list' ]])
    should be ['this', 'is', 'a', 'list', 'list', 'list']

    Precondition: theinput a potentially nested non-empty list of strings.
    No component list can be empty"""
    pass  # REPLACE WITH YOUR IMPLEMENTATION
