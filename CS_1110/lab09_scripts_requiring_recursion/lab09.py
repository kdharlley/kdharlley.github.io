# lab09.py
# YOUR NAME AND NETID HERE
# THE DATE COMPLETED HERE
# Skeleton by various CS1110 profs over the years

"""Recursive Functions. See the associated test file for test cases."""

# STUDENTS in CS1110 2018 Spring: due to the A3 and Spring Break schedule,
# you need only have worked on the first two functions in this file to get
# checked off.
#
# However, we strongly recommend that by the time prelim 2 rolls
# around, you have solved all four exercises.


def numberof(thelist, v):
    """Returns: number of times int v occurs in thelist, a possibly empty list of
    ints.  """

    if len(thelist)==0:
        return 0
    if len(thelist)==1:
        if v==thelist[0]:
            return 1
        else:
            return 0
    first_case = numberof([thelist[0]], v)
    second_case = numberof(thelist[1:], v)
    return first_case+second_case
            
            
        
    pass  # REPLACE WITH RECURSIVE IMPLEMENTATION. TEST CASES IN lab09_test.py


def sum_nested_list(theinput):
    """Returns: Summation of all the numbers in the nested list theinput
[0, [2, 5], 6]
    Example:
    sum_nested_list([0, [2, 5, []], 8, [-10, -1]]) should be  4

    Precondition: theinput is an integer, or a potentially nested
    list of integers. It is possible for component lists to be empty"""
    """if type(theinput)==int:
        return theinput
    if len(theinput)==0:
        return 0
    if len(theinput)==1:
        theinput = theinput[0]
    if type(theinput)==int:
        return theinput
    leftmost= sum_nested_list(theinput[:1])
    rightmost= sum_nested_list(theinput[1:])
    return leftmost+rightmost"""

    count=0
    if type(theinput)==int:
        return theinput
    for i in theinput:
        if type(i)==int:
            count+=i
        else:
            count+=sum_nested_list(i)
    return count
    pass  # REPLACE WITH RECURSIVE IMPLEMENTATION.
          # SEE TEST CASES IN lab09_test.py
    
    
    # Hint: since you want to do something different depending on whether
    # theinput is a list or an int, you'll want to check the result of
    # type(theinput)

    # Note: there are several possible approaches, including using
    # list slicing, using map, or using a for-loop together with recursion.



#### STUDENTS: below are two exercises you should complete on your own time,
#### but need not be completed by the time you go to check in this lab.


def replace(thelist, a, b):
    """Returns: a COPY of thelist but with all occurrences of int a replaced by
    int b.  Does not change thelist.

        Example: replace([1,2,3,1], 1, 4) = [4,2,3,4].

    Precondition: thelist is a possibly empty list of ints."""
    if len(thelist)==0:
        return []
    if len(thelist)==1:
        if thelist[0]==a:
            thelist[0]=b
            return [thelist[0]]
        else:
            return [thelist[0]]
    left_most = replace([thelist[0]], a, b)
    right_most= replace(thelist[1:], a, b)
    print(left_most)
    print(right_most)
    return left_most+right_most
    pass  # REPLACE WITH RECURSIVE IMPLEMENTATION.
          # SEE TEST CASES IN lab09_test.py


def print_nested_list(theinput):
    """Prints out every single string in theinput, one per line, UNLESS
    theinput is a string, in which case it just prints the input.

    Example:
    if theinput is
      [['this'], ['is', ['a', ['very', 'very', 'very'], ['nes ted', 'list']]]]
    then print_nested_list(theinput) should result in the following printout
       this
       is
       a
       very
       very
       very
       nes ted
       list

    Precondition: input is a string, or a potentially nested potentially empty
    list of strings."""
    if type(theinput)==str:
        print(theinput)
    else:
        for i in theinput:
            if type(i)==str:
                print(i)
            elif i==[]:
                pass
            else:
                print_nested_list(i)

    """
    if type(theinput)==str:
        print(theinput)
        return
    if len(theinput)==0:
        pass
        return
    if len(theinput)==1:
        theinput = theinput[0]
    if type(theinput)==str:
        print(theinput)
        return
    leftmost= print_nested_list(theinput[:1])
    rightmost= print_nested_list(theinput[1:])"""
    pass
    pass # REPLACE WITH RECURSIVE IMPLEMENTATION. MORE TEST CASES IN lab09_test.py

    # Hint: since you want to do something different depending on whether
    # theinput is a list or a string, you'll want to check the result of
    # type(theinput)

    # Note: there are several approaches that work, including using list
    # slicing, using a for-loop together with recursion, and using map.

