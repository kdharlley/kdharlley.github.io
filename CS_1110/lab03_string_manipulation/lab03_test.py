# lab03_test.py
# PUT YOUR NAME AND NETID HERE
# PUT THE DATE YOU LAST CHANGED THIS FILE HERE
# Skeleton by Walker M. White (wmw2), Lillian Lee (LJL2), Feb 2018


"""(Skeleton of) tests for lab03.py"""

import cornellasserts  # For assert_equals and assert_true
import lab03  # This is what we are testing


def test_replace_first():
    """Testing function for lab03.replace_first"""

    print("Testing lab03.replace_first")

    print("first test case")
    result = lab03.replace_first('methos', 's', 'd')
    cornellasserts.assert_equals('method', result)
    
    print("second test case")
    result = lab03.replace_first('Misissippi', 's', 'ss')
    cornellasserts.assert_equals('Mississippi', result)
    
    print("third test case")
    result = lab03.replace_first('decrepif', 'f', 't')
    cornellasserts.assert_equals('decrepit', result)
    
    print("fourth test case")
    result = lab03.replace_first('aggreived', 'ei', 'ie')
    cornellasserts.assert_equals('aggrieved', result)
    
    print("fifth test case")
    result = lab03.replace_first('em', 'em', 'umm')
    cornellasserts.assert_equals('umm', result)
    
    print("sixth test case")
    result = lab03.replace_first('judgement', 'e', '')
    cornellasserts.assert_equals('judgment', result)

###########
# Calls to testing functions go here

test_replace_first()

print('Module lab03: all tests passed')
