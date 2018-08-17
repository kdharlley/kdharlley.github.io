# lab08for_test.py
# Lillian Lee (LJL2) and Walker White (wmw2)
# March 2018

"""Test code for lab."""

import lab08for
import cornellasserts as ca
import sys
import inspect  # Used to get function names automatically:
                # inspect.stack()[0] is the "highest" frame on the call stack
import random


def test_lesser_than(verbose):
    """Test lesser_than and lesser_than2.
    If verbose is True, then each test input is printed out, as well."""

    # A generic line that can be pasted into any function;
    # retrieves the name of current function from its frame on the stack.
    # Each item in the list returned by inspect.stack() is a call frame.
    # You can print out the frame at the top of the stack by:
    #     print(str(inspect.stack()[0])
    fn_name = inspect.stack()[0][3]
    print("Running " + fn_name)


    # We turn to dictionaries and for-loops to make writing test cases less
    # tedious.
    # The keys are tuples representing the two inputs to lesser_than.
    # The values are the expected answers for those two inputs.
    # We have to use tuples because dictionaries don't allow the keys to be
    # "hashable".

    # Format:
    #      (input1, input2): expected_value
    # where input1 is a tuple version of an input list.
    # STUDENTS: beware!  One test case is incorrect on purpose!
    test_cases = {((5, 9, 1, 7), -1): 0,
                  ((5, 9, 1, 7), 1): 0,
                  ((5, 9, 1, 7), 5): 1,  # etc.
                  ((5, 9, 1, 7), 7): 2,
                  ((5, 9, 1, 7), 6): 2,
                  ((5, 9, 1, 7), 9): 3,
                  ((5, 9, 1, 7), 10): 4,
                  ((), -2): 0,  # testing empty list
                  ((), 2): 0,
                  ((4, 5, 6), 1): 0,
                  ((4, 5, 6), 7): 3,
                  ((4, 4, 4), 7): 3  # testing list with duplicates
                  }

    for test_input in test_cases:
        if verbose:
            print("\tTesting input " + str(test_input))
        input_list = list(test_input[0])  # Convert from tuple to list
        orig = input_list[:]  # Create a copy to check that nothing is changed
                              # by the function being tested
        input_value = test_input[1]

        # Test that output is correct
        ca.assert_equals(test_cases[test_input],
                         lab08for.lesser_than(input_list, input_value))

        # Test that the input list was not changed
        ca.assert_equals(orig, input_list)


def test_clamp(verbose):
    """Test clamp.
    If verbose is True, then each test input is printed out, as well."""
    fn_name = inspect.stack()[0][3]
    print("Running " + fn_name)

    # Format: each key is a tuple.
    # The item at index 0 of the key is a tuple version of the input list.
    # The item at index 1 of the key is the min value allowed.
    # The item at index 2 of the key is the max value allowed
    # The value is the list that the input list should match once the function
    #   is applied.
    test_cases = {
        ((-1, 1, 3, 5), 0, 4): [0, 1, 3, 4],
        ((4, -1, 1, 6, 3), 0, 5): [4, 0, 1, 5, 3],
        ((17, -1, 2, 27, 14), 2, 3): [3, 2, 2, 3, 3],
        ((17, -1, 2, 27, 14), 2, 2): [2, 2, 2, 2, 2],
        ((5.3, 0, 2, 8.5, 4), 0, 8): [5.3, 0, 2, 8, 4],
        ((5.3, 0, 2, 8.5, 4), 1.3, 7.2): [5.3, 1.3, 2, 7.2, 4],
        ((), 2, 3): [],
    }

    for test_input in test_cases:
        if verbose:
            print("\tTesting input " + str(test_input))

        input_list = list(test_input[0])  # Need to convert tuple to list
        input_min = test_input[1]
        input_max = test_input[2]

        lab08for.clamp(input_list, input_min, input_max)
        ca.assert_equals(test_cases[test_input], input_list)


def test_perfects(verbose):
    """Test perfects.
    If verbose is True, then each test input is printed out, as well."""
    fn_name = inspect.stack()[0][3]
    print("Running " + fn_name)

    # Construct questions and their number of perfect subquestions.
    test_cases = {
        ((0, 2), (3, 4)): 0,
        ((0, 2), (4, 4)): 1,
        ((3, 3), (7, 7), (5, 5)): 3,
        ((1, 1), (6, 7), (5, 5), (2, 2), (0, 2)): 3
    }

    complex_exam = []
    complex_answer = 0
    for test_input in test_cases:
        complex_exam.append(list(test_input))
        complex_answer = complex_answer + test_cases[test_input]

    if verbose:
        print("\tTesting input " + str(complex_exam))
    ca.assert_equals(complex_answer, lab08for.perfects(complex_exam))

    random.shuffle(complex_exam)  # make sure order doesn't matter
    if verbose:
        print("\tTesting input " + str(complex_exam))
    ca.assert_equals(complex_answer, lab08for.perfects(complex_exam))

    # make a random change to the list
    target = random.choice(list(test_cases.keys()))
    complex_answer -= test_cases[target]
    complex_exam.remove(list(target))
    if verbose:
        print("\tTesting input " + str(complex_exam))
    ca.assert_equals(complex_answer, lab08for.perfects(complex_exam))




def test_uniques(verbose):
    """Test uniques.
    If verbose is True, then each test input is printed out, as well."""

    # A generic line that can be pasted into any function;
    # retrieves the name of current function from its frame on the stack.
    # Each item in the list returned by inspect.stack() is a call frame.
    # You can print out the frame at the top of the stack by:
    #     print(str(inspect.stack()[0])
    fn_name = inspect.stack()[0][3]
    print("Running " + fn_name)

    # Format: each key is a tuple version of an input to function uniques.
    # We can't use lists because dictionaries don't allow them for keys.
    test_cases = {
        (5, 9, 5, 7): 3,  # 5 is duplicated once
        (1, 3, 5, 7): 4,  # All unique
        (5, 1, 3, 5, 3, 5, 5, 5): 3,  # 1, 3, and 5
        (13, "hola", 'b', 7, 'hola', True, False, 2): 7,  # Mixed types
        (5, 5, 1, 'a', 5, 'a'): 3,
        (-1, -1, -1, -1): 1,  # All duplicates
        (): 0,  # empty input
    }

    for test_input in test_cases:
        if verbose:
            print("\tTesting input " + str(test_input))

        input_list = list(test_input)
        orig = input_list[:]  # Create a copy to check that nothing is changed
                              # by the function being tested

        # Test that output is correct
        ca.assert_equals(test_cases[test_input], lab08for.uniques(input_list))

        # Test that the input list was not changed
        ca.assert_equals(orig, input_list)


# STUDENTS: don't edit this function.
def ask_to_quit(verbose):
    """Ask if user wishes to keep testing, terminate execution if not.
    Does nothing if `verbose` is False"""
    if verbose:
        msg = 'Press q to quit, anything else to start testing the next function. '
        response = input(msg)
        if response == "q":
            sys.exit()

# STUDENTS: the next line of code ensures that the indented lines are only
# executed if this script is run at the command line (i.e., they are NOT run
# if this file is imported as a module)
if __name__ == '__main__':
    prompt = "Hit return if you want minimal outout; "
    prompt += "anything else will generate more verbose output: "
    is_verbose = bool(input(prompt))

    fns_to_run = [test_lesser_than, test_clamp, test_perfects]

    # STUDENTS: uncomment this line if you want to test test_uniques, which
    # you should only do if you tried the optional exercise.
    fns_to_run.append(test_uniques)

    for ind in range(len(fns_to_run)):
        fn = fns_to_run[ind]
        fn(is_verbose)
        if ind < len(fns_to_run)-1:  # not the last test
            ask_to_quit(is_verbose)

print("All tests passed")


