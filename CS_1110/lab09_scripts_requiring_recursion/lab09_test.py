# test_lab09.py
# Lillian Lee (LJL2) and Walker White (wmw2)
# Mar 26, 2018

"""Test cases for lab09.py. Omitting specs on the test procedures because
their descriptions are totally obvious from the procedure names."""

import cornellasserts as ca
import lab09
import lab09_optional
import inspect  # For automatically getting function name
import sys  # For testing printouts
import io  # For testing printouts


def test_numberof(verbose):
    print("Running " + inspect.stack()[0][3])

    # dictionaries can't have lists as keys, so using tuples
    test_cases = {
        ((5, 3, 3455, 74, 74, 74, 3), 74): 3,
        ((5, 3, 3455, 74, 74, 74, 3), 3): 2,
        ((5, 3, 3455, 74, 74, 74, 3), 4): 0,
        ((4,), 4): 1,
        ((4, 4), 4): 2,
        ((), 3): 0
    }

    for test_input in test_cases:
        if verbose:
            print('\ttrying ' + str(test_input))
        output = lab09.numberof(list(test_input[0]), test_input[1])
        ca.assert_equals(test_cases[test_input], output)


def test_sum_nested_list(verbose):
    print("Running " + inspect.stack()[0][3])
    # dictionaries can't have lists as keys, so using list instead of dict.
    test_cases = [
        [0, 0],
        [4, 4],
        [[0, [2, 5], [8, [-10, -1]]],    4],
        [[0, [2, 5, []], [8, [-10, -1]]],     4],
        [[], 0]
    ]

    # We have several different implementations, and so use a list of functions
    # to test them all.
    fns_to_test = [lab09.sum_nested_list]
    for fn in fns_to_test:
        print("\tTesting " + fn.__name__)
        for item in test_cases:
            test_input = item[0]
            if verbose:
                print('\ttrying ' + str(test_input))
            correct = item[1]
            ca.assert_equals(correct, lab09.sum_nested_list(test_input))


def test_replace(verbose):
    print("Running " + inspect.stack()[0][3])

    # dictionaries can't have lists as keys, so using tuples
    test_cases = {
        ((5, 6), 5, 4): [4, 6],
        ((5, 6), 6, 4): [5, 4],
        ((5, 5), 5, -4): [-4, -4],
        ((), 1, 2): [],
        ((5, 3, 3455, 74, 74, 74, 3), 3, 20): [5, 20, 3455, 74, 74, 74, 20],
        ((5, 3, 3455, 74, 74, 74, 3), 1, 20): [5, 3, 3455, 74, 74, 74, 3],
    }

    for test_input in test_cases:
        if verbose:
            print('\ttrying ' + str(test_input))
        test_list = list(test_input[0])
        output = lab09.replace(test_list, test_input[1], test_input[2])
        ca.assert_equals(test_cases[test_input], output)
        # see if new list is a different list, even if no values are different
        ca.assert_false(output is test_list)


def test_print_nested_list(verbose):
    print("Running " + inspect.stack()[0][3])

    test_cases = [
        ["cs1110", "cs1110\n"],
        [['this', ['is', 'a'], 'list', ['list', 'list']],
         "this\nis\na\nlist\nlist\nlist\n"],
        [[[['cs1110', 'opython'], 'nested'], 'recursion', 'test'],
         "cs1110\nopython\nnested\nrecursion\ntest\n"],
        [[['this'], ['is', ['a', ['very', 'very', 'very'], ['nes ted', 'list']]]],
         "this\nis\na\nvery\nvery\nvery\nnes ted\nlist\n"]
    ]

    fns_to_test = [lab09.print_nested_list]
    for fn in fns_to_test:
        print("\tTesting " + fn.__name__)
        for tc in test_cases:
            inlist = tc[0]
            answer = tc[1]
            if verbose:
                print('\ttrying ' + str(inlist))

            # magic to be able to store print output somewhere
            old_stdout = sys.stdout
            capturer = io.StringIO()
            sys.stdout = capturer
            lab09.print_nested_list(inlist)
            sys.stdout = old_stdout
            output = capturer.getvalue()
            try:
                ca.assert_equals(answer, output)
            except:
                print()
                print('What SHOULD have been printed:')
                print(answer)
                print()
                print("The code's output")
                print(output)
                exit()


def test_remove_dups(verbose):
    print("Running " + inspect.stack()[0][3])

    # dictionaries can't have lists as keys, so using tuples
    test_cases = {
        (): [],
        (1, 2, 2, 3, 3, 3, 4, 5, 1, 1, 1): [1, 2, 3, 4, 5, 1],
        (3, 3): [3],
        (4,): [4],
        (4, 3, 4): [4, 3, 4],
    }

    for test_input in test_cases:
        if verbose:
            print('\ttrying ' + str(test_input))
        test_list = list(test_input)
        output = lab09_optional.remove_dups(test_list)
        ca.assert_equals(test_cases[test_input], output)
        # see if new list is a different list
        ca.assert_false(output is test_list)


def test_remove_first(verbose):
    print("Running " + inspect.stack()[0][3])

    # Using a list because converting everything to tuples for a dictionary
    # seems too painful.
    # Format: each item is (input1, input2, answer)
    test_cases = [
        ([], 3, []),
        ([3], 3, []),
        ([3], 4, [3]),
        ([3, 4, 4, 4, 5], 4, [3, 4, 4, 5]),
        ([3, 4, 5, 4, 4, 4], 4, [3, 5, 4, 4, 4])
    ]

    for item in test_cases:
        inputlist = item[0]
        inputval = item[1]
        if verbose:
            print('\ttrying ' + str(inputlist) + ' and ' + str(inputval))
        expected = item[2]
        ca.assert_equals(expected, lab09_optional.remove_first(inputlist,
                                                               inputval))


def test_number_not(verbose):
    print("Running " + inspect.stack()[0][3])
    mylist_as_tuple = (5, 3, 3455, 74, 74, 74, 3)

    test_cases = {
        (mylist_as_tuple, 74): 4,
        (mylist_as_tuple, 3): 5,
        (mylist_as_tuple, 4): 7,
        ((3,), 4): 1,  # Need comma to make Python realize we want a tuple
        ((), 4): 0
    }
    for tc in test_cases:
        inputlist = list(tc[0])
        inputval = tc[1]
        if verbose:
            print('\ttrying ' + str(inputlist) + ' and ' + str(inputval))
        ca.assert_equals(test_cases[tc],
                         lab09_optional.number_not(inputlist, inputval))


def test_reverses(verbose):
    print("Running " + inspect.stack()[0][3])

    test_cases = {
        (): [],
        (3,): [3],
        (3, 2, 1): [1, 2, 3]

    }
    fns_to_test = [lab09_optional.reverse1, lab09_optional.reverse2]
    for ind in range(len(fns_to_test)):
        reverse_fn = fns_to_test[ind]
        print("\ttesting " + reverse_fn.__name__)
        for tc in test_cases:
            inputlist = list(tc)
            if verbose:
                print('\ttrying ' + str(inputlist))
            ca.assert_equals(test_cases[tc], reverse_fn(inputlist))

        mylist = [3]
        ca.assert_equals(False, mylist is reverse_fn(mylist))
        if ind < len(fns_to_test) - 1:
            # Still another function to test
            ask_to_quit(verbose)


def test_sum_list(verbose):
    print("Running " + inspect.stack()[0][3])

    test_cases = {
        (): 0,
        (34,): 34,
        (7, 34, 1, 2, 2): 46
    }
    for tc in test_cases:
        inputlist = list(tc)
        if verbose:
            print('\ttrying ' + str(inputlist))
        ca.assert_equals(test_cases[tc], lab09_optional.sum_list(inputlist))


def test_sum_to(verbose):
    print("Running " + inspect.stack()[0][3])

    test_cases = {
        1: 1,
        3: 6,
        5: 15
    }

    for tc in test_cases:
        if verbose:
            print('\ttrying ' + str(tc))
        ca.assert_equals(test_cases[tc], lab09_optional.sum_to(tc))


def test_num_digits(verbose):
    print("Running " + inspect.stack()[0][3])

    test_cases = {
        0: 1,
        3: 1,
        34: 2,
        1345: 4
    }

    for tc in test_cases:
        if verbose:
            print('\ttrying ' + str(tc))
        ca.assert_equals(test_cases[tc], lab09_optional.num_digits(tc))


def test_sum_digits(verbose):
    print("Running " + inspect.stack()[0][3])

    test_cases = {
        0: 0,
        3: 3,
        34: 7,
        345: 12
    }
    for tc in test_cases:
        if verbose:
            print('\ttrying ' + str(tc))
        ca.assert_equals(test_cases[tc], lab09_optional.sum_digits(tc))


def test_number2(verbose):
    print("Running " + inspect.stack()[0][3])
    test_cases = {
        0: 0,
        2: 1,
        234252: 3,
        345: 0
    }
    for tc in test_cases:
        if verbose:
            print('\ttrying ' + str(tc))
        ca.assert_equals(test_cases[tc], lab09_optional.number2(tc))


def test_into(verbose):
    print("Running " + inspect.stack()[0][3])

    test_cases = {
        (5, 3): 0,
        (6, 3): 1,
        (3*3*3*3*7, 3): 4
    }
    for tc in test_cases:
        if verbose:
            print('\ttrying ' + str(tc))
        ca.assert_equals(test_cases[tc], lab09_optional.into(tc[0], tc[1]))


def test_exp(verbose):
    print("Running " + inspect.stack()[0][3])

    test_cases = {
        (3, 0): 1,
        (3, 2): 9,
        (2, 5): 32
    }
    for tc in test_cases:
        if verbose:
            print('\ttrying ' + str(tc))
        ca.assert_equals(test_cases[tc], lab09_optional.exp(tc[0], tc[1]))



def test_embed(verbose):
    print("Running " + inspect.stack()[0][3])
    ca.assert_equals(0, lab09_optional.embed('cs1110'))
    ca.assert_equals(1, lab09_optional.embed(['cs1110']))
    ca.assert_equals(1, lab09_optional.embed(['cs1110', 'opython', 'typoon']))
    ca.assert_equals(3,
                     lab09_optional.embed(['cs1110',
                                           ['opython', ['recursion'], 'typoon']]))


def test_flatten_nested_list(verbose):
    print("Running " + inspect.stack()[0][3])
    fns_to_test = [lab09_optional.flatten_nested_list]
    for flatten_fn in fns_to_test:
        print("\ttesting " + flatten_fn.__name__)
        ca.assert_equals(['cs1110'],
                         flatten_fn(['cs1110']))
        ca.assert_equals(['this', 'is', 'a', 'list', 'list', 'list'],
                         flatten_fn(['this',
                                    ['is', 'a'],
                                    'list',
                                    ['list', 'list']]))
        ca.assert_equals(['cs1110', 'opython', 'nested', 'recursion', 'test'],
                         flatten_fn([[['cs1110', 'opython'], 'nested'], 'recursion', 'test']))

        mylist = ['cs1110']
        ca.assert_equals(False,
                         mylist is flatten_fn(mylist))


def test_max_nested_list(verbose):
    print("Running " + inspect.stack()[0][3])
    ca.assert_equals(0, lab09_optional.max_nested_list(0))
    ca.assert_equals(8, lab09_optional.max_nested_list([0, [2, 5], 8, [-10, -1]]))
    ca.assert_equals(1, lab09_optional.max_nested_list([[[[1]]]]))
    ca.assert_equals(1110,
                     lab09_optional.max_nested_list([[[[1, 1110],2],3],4]))


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
    test_numberof(is_verbose)
    ask_to_quit(is_verbose)
    test_sum_nested_list(is_verbose)
    ask_to_quit(is_verbose)

    # Tests of optional functions
    test_replace(is_verbose)
    ask_to_quit(is_verbose)
    test_print_nested_list(is_verbose)
    ask_to_quit(is_verbose)
    test_number_not(is_verbose)
    ask_to_quit(is_verbose)
    test_remove_dups(is_verbose)
    ask_to_quit(is_verbose)
    test_remove_first(is_verbose)
    ask_to_quit(is_verbose)
    test_reverses(is_verbose)
    ask_to_quit(is_verbose)
    test_sum_list(is_verbose)
    ask_to_quit(is_verbose)
    test_sum_to(is_verbose)
    ask_to_quit(is_verbose)
    test_num_digits(is_verbose)
    ask_to_quit(is_verbose)
    test_sum_digits(is_verbose)
    ask_to_quit(is_verbose)
    test_number2(is_verbose)
    ask_to_quit(is_verbose)
    test_into(is_verbose)
    ask_to_quit(is_verbose)
    test_exp(is_verbose)
    ask_to_quit(is_verbose)
    test_embed(is_verbose)
    ask_to_quit(is_verbose)
    test_max_nested_list(is_verbose)
    ask_to_quit(is_verbose)
    test_flatten_nested_list(is_verbose)

    print("All tests passed")