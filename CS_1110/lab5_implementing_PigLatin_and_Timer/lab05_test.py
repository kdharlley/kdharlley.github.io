# lab05_accessories.py
# Lillian Lee (LJL2) and Walker White (WMW2)
# Feb 2018

"""Accessory functions and definitions for students to use in Lab 05.

Students do not need to edit this file.

"""

from timer import Timer
import lab05
import cornellasserts
import sys


##### TEST PROCEDURES


def test_add_time():
    print("Running test_add_timer")
    t1 = Timer(1,59)
    t2 = Timer(1,2)
    msg = '\tTrying '+str(t1.hours)+":"+str(t1.minutes)
    msg = msg + ' and '+str(t2.hours)+":"+str(t2.minutes)
    print(msg)
    sum = lab05.add_timers(t1,t2)
    cornellasserts.assert_equals(3, sum.hours)
    cornellasserts.assert_equals(1, sum.minutes)

    t1 = Timer(1,59)
    t2 = Timer(3,59)
    msg = '\tTrying '+str(t1.hours)+":"+str(t1.minutes)
    msg = msg + ' and '+str(t2.hours)+":"+str(t2.minutes)
    print(msg)
    sum = lab05.add_timers(t1,t2)
    cornellasserts.assert_equals(5, sum.hours)
    cornellasserts.assert_equals(58, sum.minutes)

    t1 = Timer(1,50)
    t2 = Timer(0,2)
    msg = '\tTrying '+str(t1.hours)+":"+str(t1.minutes)
    msg = msg + ' and '+str(t2.hours)+":"+str(t2.minutes)
    print(msg)
    sum = lab05.add_timers(t1,t2)
    cornellasserts.assert_equals(1, sum.hours)
    cornellasserts.assert_equals(52, sum.minutes)




def test_pigify():
    print("Running test_pigify to test lab05.pigify")

    ## STUDENTS:
    ## At this point in the class, you do not know what dictionaries are.
    ## But for the curious: test_cases is a structure that lets you organize
    ## pairs of a so-called "key" (the first item in a pair) and an associated
    ## "value" (the second item in a pair).
    ## In our case, the keys and values are inputs and desired outputs.

    # These test cases come from the lab handout.
    test_cases = {'ask': 'askhay',
                  'use': 'usehay',
                  'quiet': 'ietquay',
                  'quay': 'ayquay',
                  'qu':'quay',
                  'tomato': 'omatotay',
                  'school': 'oolschay',
                  'you': 'ouyay',
                  'pssst': 'pssstay'
                  }

    ## STUDENTS:  "
    ## At this point in the class, you do not know what for-loops/blocks are.
    ## But for the curious: the code below runs assert_equals on each
    ## input/output pair in the test_cases dictionary
    for w in test_cases:
        print('\tTrying "' + w + '"')
        cornellasserts.assert_equals(test_cases[w], lab05.pigify(w))


# STUDENTS: don't edit this function.
def ask_to_quit():
    """Ask if user wishes to keep testing, terminate execution if not."""
    msg = 'Press q to quit, anything else to start testing the next function. '
    response = input(msg)
    if response == "q":
        sys.exit()


# CODE TO EXECUTE

print("Beginning tests of lab05 code")
test_add_time()
ask_to_quit()
test_pigify()
print("All test cases for lab05 passed")
