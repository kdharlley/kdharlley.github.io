# num_space_runs_test.py
# Lillian Lee (LJL2) and Walker White (WMW2)
# April 2018

import cornellasserts as ca
import inspect
import num_space_runs as labfile
import sys


def test_space_runs():
    # print test procedure name
    print('Running ' + inspect.stack()[0][3]) # print test-procedure name

    for fn in [labfile.num_space_runs1,
               labfile.num_space_runs2,
               labfile.num_space_runs3]:
        print('\t Testing', fn.__name__) # print function name

        test_cases = {
            "a  f   g": 2,
            " a  f   g   ": 4,
            " a  f   g ": 4,
            " a  bc   d": 3,
            " a": 1,
            "ab": 0,
            "abc   a":1,
            "abc    ":1,
            "    ":1
        }
        try:
            for tc in test_cases:
                print('\t\t Testing "', tc + '"')
                result = fn(tc)
                right_answer = test_cases[tc]
                ca.assert_equals(right_answer, result)
            print(fn.__name__, "passed all test cases.  Hurrah!")
        except:
            print("ERROR:  something wrong with", fn.__name__, "for test case ", \
                "'" + tc + "'")
            sys.exit()


if __name__ == '__main__':
    test_space_runs()
    print("All test cases passed.")

