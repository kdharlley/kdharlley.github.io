# a3test.py
# Kenneth Harlley (Kdh62)
# NONE
# Thursday March 29th, 2018
# Skeleton by Lillian Lee (LJL2) and Victoria Litvinova, Mar 22 2018

""" Test functions for a3.py.

    STUDENTS:
    WARNING: WE HAVE PURPOSELY PLANTED ONE INCORRECT TEST CASES IN
    EACH OF THE FUNCTIONS TESTING THE CODE YOU WRITE. You need to correct them,
    and comment those changes with
    '# ... STUDENT-FIXED ERROR ...'
    so the graders can easily find what you did.
    You do NOT have to check for problems with testers of a3 functions that
    we wrote for you.

    Run this script with "python a3test.py quiet" if you want less
    diagnostic output and no visual file dialogs.

    Assumes the existence of a subdirectory `sources` in the same
    directory that contains the files distributed with CS1110 2018SP. """

import a3
import cornellasserts as ca  # Abbreviation
import sys  # For getting command-line arguments
import os  # For dealing with differences in operating systems (Windows, OSX)
import inspect  # Used to get function names automatically:
                # inspect.stack()[0] is the "highest" frame on the call stack


def add_sources_to_fname(fname):
    """Make the name for a file named fname in the subdirectory sources
    as appropriate for the caller's operating system. ("sources" is a hardcoded
    name.)"""
    return os.path.join('sources', fname)


def test_get_content_lines(verbose):
    """Test a3.get_content_lines()"""

    # A generic line that can be pasted into any function;
    # retrieves the name of current function from its frame on the stack.
    # Each item in the list returned by inspect.stack() is a call frame.
    # You can print out the frame at the top of the stack by:
    #     print(str(inspect.stack()[0])
    tester_name = inspect.stack()[0][3]
    print("Running " + tester_name + "()")

    test_cases = {
        # Different operating systems have different ways of dealing with
        # subdirectories, which is what os.path.join helps us deal with.
        #  See section 14.4 "Filenames and paths" of the text.
        add_sources_to_fname('shortest.txt'):  ["abc abcabc natural language processing\n",
                                                "3 o'clock bc!d\n"],
        add_sources_to_fname('short.txt'):
           ["here is a small piece of text a small piece of text a small piece of text here is a small piece of text at nine o'clock in the morning\n"],
        add_sources_to_fname('shortest_commented.txt'): ["abc abcabc natural language processing\n",
                                                         "bc!d bc!d\n"],
    }

    for test_input in test_cases:
        if verbose:
            print("\tTesting " + str(test_input))
        expected = test_cases[test_input]
        ca.assert_equals(expected, a3.get_content_lines(test_input))

    # For longer files, rough check that we get the right number of lines
    test_cases = {
        add_sources_to_fname('imbeciles.txt'): 33-6,
        add_sources_to_fname('lonely_as_a_cloud.txt'): 29-2,
        add_sources_to_fname('2013_obama.txt'): 184,
    }
    for test_input in test_cases:
        if verbose:
            print("\tTesting " + str(test_input))
        expected = test_cases[test_input]
        ca.assert_equals(expected, len(a3.get_content_lines(test_input)))


def test_convert_lines_to_string(verbose):
    """Test a3.test_convert_lines_to_string() and
       a3.test_convert_lines_to_string2() """

    # A generic line that can be pasted into any function;
    # retrieves the name of current function from its frame on the stack.
    # Each item in the list returned by inspect.stack() is a call frame.
    # You can print out the frame at the top of the stack by:
    #     print(str(inspect.stack()[0])
    tester_name = inspect.stack()[0][3]
    print("Running " + tester_name + "()")



    # Have to store lists as tuples in order to have them be dict. keys.
    test_cases = {
        ("hi\n", "there"): "hi there",# ... STUDENT-FIXED ERROR ...
        ("hi\n", "there\n"):  "hi there",
        ("    hola    ", "   salut \n  howdy  "): "hola salut \n  howdy",
        ("so", "la", "", "do"): "so la do",
        ("so", "\n", "la", "", "", "do"): "so  la do",  # no extra space after la

        # ..... STUDENT-ADDED DICT. CONVERT...STRING TEST CASES BELOW THIS LINE ....
        
        #STUDENT-ADDED DICT.
        # checking if works if linelist empty
        (): "",
        
        #leading and trailing white spaces for all elements 
        ("    hi\n   ", "    there    "): "hi there",
        
        #white spaces located within words
        ("hi   \n", "    the  here    "): "hi the  here",
        
    #leading and trailing new lines(sometimes multiple and right after each other)
        ("\n\nhi\n", "there\n\n\n"): "hi there",
        
        #multiple white spaces located within words
        ("hi   \n", "    th  ere    "): "hi th  ere",
        
        #multiple mixed leading and trailing white spaces and new lines
        #(sometimes right after wach other)
        (" \n    \n  \n    hi    \n    \n  ",
         "  \n  there  \n\n\n     "): "hi there",
        
        #string which is white spaces,
        #I believe this showld be treated as new lines as shown by my output"
        ("so", "  ", "do", "fa"): "so  do fa",
        
        #string which is white space at beginning
        ("  ", "so", "do", "fa"): " so do fa",
        
        #ensures code treats capital letters the same as lower case letters
        ("So", "do", "fa"): "So do fa",
        
        #string which is white space at end
        ("so", "so", "do", " "): "so so do ",
        
        #multiple strings which are white spaces after each other
        ("so", "  ", "  ", "fa"): "so   fa",
        
        #string which is new line in middle"
        ("so", "\n", "do", "fa"): "so  do fa",
        
        #string which is new line at beginning
        ("\n", "so", "do", "fa"): " so do fa",
        
        #string which is new line at end
        ("so", "so", "do", "\n"): "so so do ",
        
        #multiple strings which are new line after each other
        ("so", "\n", "\n", "fa"): "so   fa",
        
        #empty string in middle"
        ("so", "", "do", "fa"): "so do fa",
        
        #empty string at beginning
        ("", "so", "do", "fa"): "so do fa",
        
        #sempty string at end
        ("so", "so", "do", ""): "so so do",
        
        #multiple strings which are new line after each other
        ("so", "\n", "\n", "fa"): "so   fa",
        
        #one word lines and even list
        ("hi", "how", "are", "you"): "hi how are you",
        
        #one lined list
        ("hi",): "hi",
        
        #common case with standard lines(multiple words and standard strings
        #and also checking for odd list
        ("hello my name is Ben\n","I like Buffalo Wings", "I am 12 years old"):
            "hello my name is Ben I like Buffalo Wings I am 12 years old",
        
        #ensures code still works even when \n made /n(slash in wrong direction)
        ("so", "/n", "do", "fa"): "so /n do fa",
        
        #ensures code works for blackslashed characters which aren't new lines
        ("so", "\\N", "do", "fa"): "so \\N do fa",
        
        #ensuring code doesnt strip away ending punctuation
        ("so",  "do!\n", "fa"): "so do! fa",
        
        #ensuring code doesnt strip away ending backslashes
        ("so",  "do!\\\n", "fa"): "so do!\\ fa",
    
    }

    # Yes, functions can be elements of lists, too! Note that the elements
    # are not (values returned by) function calls, but the functions themselves.
    fns_to_test = [a3.convert_lines_to_string, a3.convert_lines_to_string2]
    for ind in range(len(fns_to_test)):  # also OK to wrap "list" around range()
        convertfn = fns_to_test[ind]
        print("testing " + convertfn.__name__)
        for test_input in test_cases:
            if verbose:
                print("\tTesting " + str(test_input))
            expected = test_cases[test_input]
            ca.assert_equals(expected,
                             # Convert tuple back to list
                             convertfn(list(test_input)))


        

        if ind < (len(fns_to_test)-1):  # Not the last fn to test
            # Check whether students are ready to test the next function
            ask_to_quit(verbose, fns_to_test[ind+1].__name__)


def test_convert_lines_to_paragraph(verbose):
    """Test a3.convert_lines_to_paragraphs"""
    tester_name = inspect.stack()[0][3]
    print("Running " + tester_name + "()")

    test_cases = {}  # Start with empty dictionary

    # test_file is the name of a file containing lines to
    # extract and make into a test input (i.e., a list of lines)
    # for convert_lines_to_paragraphs()
    test_file = add_sources_to_fname('short_stanzas.txt')
    expected = []
    stanza = "1st line of 1st stanza"
    stanza += " 2nd line of 1st stanza"# ... STUDENT-FIXED ERROR ...
    expected.append(stanza)
    stanza = "1st line of 2nd stanza"
    expected.append(stanza)
    stanza = "1st line of 3rd stanza"
    stanza += " 2nd line of 3rd stanza"
    stanza += " 3rd line of 3rd stanza"
    expected.append(stanza)
    print(stanza)
    test_cases[test_file] = expected

    # We are using a list because hidden from students at submission time we
    # have multiple implementations.
    fns_to_test = [a3.convert_lines_to_paragraphs]
    for convertfn in fns_to_test:
        print("testing " + convertfn.__name__)
        for test_file in test_cases:
            if verbose:
                print("\tTesting " + str(test_file))
            expected = test_cases[test_file]
            test_input = a3.get_content_lines(test_file)
            ca.assert_equals(expected,
                             convertfn(test_input))

        test_input = []
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals([], convertfn(test_input))

        test_input = ["\n", "\n"]  # all lines blank
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals([], convertfn(test_input))

        # ends with multiple blank lines
        test_input = ["\n", "\n", "just one content line", "\n"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["just one content line"],
                         convertfn(test_input))
        
        # embedded newline
        test_input = ["I'm\ntricky",
                      "and you can be too  \n",
                      "\n",
                      "stay in school"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["I'm\ntricky and you can be too", "stay in school"],
                         convertfn(test_input))

        test_file = add_sources_to_fname('lonely_as_a_cloud.txt')
        if verbose:
            print("\tTesting file " + str(test_file))
        test_input = a3.get_content_lines(test_file)
        result = convertfn(test_input)
        ca.assert_equals(result[0], "i wandered lonely as a cloud that floats on high o'er vales and hills when all at once i saw a crowd a host of golden daffodils beside the lake beneath the trees fluttering and dancing in the breeze")
        ca.assert_equals(result[1], 'continuous as the stars that shine and twinkle on the milky way they stretched in never ending line along the margin of a bay ten thousand saw i at a glance tossing their heads in sprightly dance')
        ca.assert_equals(result[2], 'the waves beside them danced but they out did the sparkling waves in glee a poet could not but be gay in such a jocund company i gazed and gazed but little thought what wealth the show to me had brought')
        ca.assert_equals(result[3], 'for oft when on my couch i lie in vacant or in pensive mood they flash upon that inward eye which is the bliss of solitude and then my heart with pleasure fills and dances with the daffodils')


        # ... STUDENT-ADDED NON-DICT. CONVERT...PARA TEST CASES BELOW THIS LINE ....
        
        #STUDENT-ADDED NON-DICT
        #empty linelist
        test_input = []
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals([], convertfn(test_input))
        
        #non-empty linelist with only empty strings
        test_input = ["", "","","" ]  # all lines blank
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals([], convertfn(test_input))
        
        #begins with blank line
        test_input = ["\n", "just one content line", "how are you"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["just one content line how are you"],
                         convertfn(test_input))
        
        #ends with blank line
        test_input = ["hello my boy", "just one content line", "\n"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hello my boy just one content line"],
                         convertfn(test_input))
        
        #blank line in middle
        test_input = ["hello my boy","hi","\n", "just one content line",
                      "blue"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hello my boy hi","just one content line blue"],
                         convertfn(test_input))
        
        #begins with multiple blank lines
        test_input = ["\n","\n","\n", "just one content line",
                      "how are you"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["just one content line how are you"],
                         convertfn(test_input))
        
        #ends with multiple blank lines
        test_input = ["hello my boy", "just one content line", "\n",
                      "\n", "\n"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hello my boy just one content line"],
                         convertfn(test_input))
        
        #multiple blank lines in middle
        test_input = ["hello my boy","hi","\n","\n","\n",
                      "just one content line", "blue"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hello my boy hi","just one content line blue"],
                         convertfn(test_input))
        
        #one word paragraphs
        test_input = ["hi","\n", "blue"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hi","blue"],
                         convertfn(test_input))
        
        #ensures code treats capital letters the same as lowercase letters
        test_input = ["Hi","\n", "Blue"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["Hi","Blue"],
                         convertfn(test_input))
        
        #one item linelist
        test_input = ["hi"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hi"],
                         convertfn(test_input))
        
        #paragraph begins with embedded blank line
        test_input = ["\njust one", "just one content line", "how are you"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["just one just one content line how are you"],
                         convertfn(test_input))
        
        #paragraph ends with emdedded blank line
        test_input = ["hello my boy\n", "just one content line\n"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hello my boy just one content line"],
                         convertfn(test_input))
        
        #emdedded blank line in middle of paragraph
        test_input = ["hello \n my boy","hi","\n",
                      "just one content\n line", "blue"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hello \n my boy hi","just one content\n line blue"],
                         convertfn(test_input))
        
        #paragraph which is just white space this should become two spaces between lines as shown in convert_lines_to_string
        test_input = ["just one", "    ", "how are you"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["just one  how are you"],
                         convertfn(test_input))
        
        #multiple paragraphs which are just white spaces
        test_input = ["just one", "    ","     ", "how are you"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["just one   how are you"],
                         convertfn(test_input))
        
        #paragraph which is just white at beginning
        test_input = ["     ", "hello","hi", "how are you"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals([" hello hi how are you"],
                         convertfn(test_input))
        
        #paragraph which is just white at end
        test_input = [ "hello","hi", "    "]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hello hi "],
                         convertfn(test_input))
        
        #paragraph begins with trailling white spaces
        test_input = ["   just one", "  just one content line", "how are you"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["just one just one content line how are you"],
                         convertfn(test_input))
        
        #paragraph ends with trailling white spaces
        test_input = ["hello my boy   ", "just one content line    "]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hello my boy just one content line"],
                         convertfn(test_input))
        
        #trailling white spaces in middle of paragraph
        test_input = ["hello     my boy","hi","\n", "just one content    line",
                      "blue"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hello     my boy hi",
                          "just one content    line blue"],
                         convertfn(test_input))
        
        #white spaces and new lines in middle of lines
        test_input = ["hello  \n\n \n   my boy","hi","\n",
                      "just one content  \n  line", "blue"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hello  \n\n \n   my boy hi",
                          "just one content  \n  line blue"],
                         convertfn(test_input))
        
        #  white spaces and new lines at beginning of lines
        test_input = ["\n   just one\n  ", " \n just one content line ",
                      "\n  how are you"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["just one just one content line how are you"],
                         convertfn(test_input))
        
#line in paragraph which is not exactly "\n" (example has white spaces " \n ")
        test_input = ["hello my boy","hi"," \n ", "just one content line",
                      "blue"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hello my boy hi  just one content line blue"],
                         convertfn(test_input))
        
        #multiple paragraphs in list
        test_input=["hello my","hi","\n","just lie","blue","\n","may act",
                    "red","\n", "may thee","purp"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hello my hi", "just lie blue", "may act red",
                          "may thee purp"],
                         convertfn(test_input))
        
        #one line paragraph in beginning and even number of paragraphs
        test_input = ["hello my boy","\n", "just one content line", "blue"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hello my boy","just one content line blue"],
                         convertfn(test_input))
        
        #one line paragraph at end and even number of lines
        test_input = ["hello my boy", "just one content line", "\n", "blue"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hello my boy just one content line","blue"],
                         convertfn(test_input))
        
        #one line paragraph in middle and odd number of paragraphs
        test_input = ["hello my boy", "hi", "\n", "just one content line",
                      "\n", "blue", "hi"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hello my boy hi","just one content line","blue hi"],
                         convertfn(test_input))
        
        #one large paragrpah from multiple lines and odd number of lines
        test_input = ["hello my boy", "hi", "just one content line", "blue",
                      "hi"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hello my boy hi just one content line blue hi"],
                         convertfn(test_input))
        
        #linelist with only blank lines
        test_input = ["\n", "\n","\n","\n" ]  # all lines blank
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals([], convertfn(test_input))
        
#multiple new blank lines in one line(behaves like a paragraph of white spaces)
        test_input = ["hi","\n\n\n", "blue"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hi  blue"],
                         convertfn(test_input))

        #miswritten blank line that is blank line with slash turned-> /n
        test_input = ["hi","/n", "blue"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hi /n blue"],
                         convertfn(test_input))
        
        #ensuring code is case sensitive for blank lines
        test_input = ["hi","\\N", "blue"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["hi \\N blue"],
                         convertfn(test_input))
        
        #ensuring code doesnt strip away ending punctuation
        test_input = ["Hi", "Blue!\n"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["Hi Blue!"],
                         convertfn(test_input))
        
        #ensuring code doesnt strip away ending backslashes
        test_input = ["Hi", "Blue\\\n"]
        if verbose:
                print("\tTesting " + str(test_input))
        ca.assert_equals(["Hi Blue\\"],
                         convertfn(test_input))
        
def test_get_econ_vocab(verbose):
    """ Test a3.get_econ_vocab() """
    # Does just some rough checks

    tester_name = inspect.stack()[0][3]
    print("Running " + tester_name + "()")
    print("...this takes a little while")

    result = a3.get_econ_vocab()
    assert type(result) == list
    ca.assert_equals(type(result), list)
    ca.assert_true(len(result) > 20)

    # spot checks
    ca.assert_equals(672, len(result))
    some_terms = ['agency costs', 'capital gains', 'euro', 'poverty', 'third way']
    some_terms.extend(['tax base', 'volatility', 'yield', 'welfare'])
    for term in some_terms:
        ca.assert_true(term in result)
    ca.assert_false('Tariff' in result)


# helper function for more compact testing code
def round3(x):
    """Returns x rounded to 3 places as a float.  x should be a float or an int."""
    return round(float(x), 3)


def test_track_topic(verbose):
    """ Test a3.track_topic() """
    # This code presumes that a3.get_content_lines(), a3.convert_lines_to_string(),
    # and a3.convert_lines_to_paragraphs() are all implemented correctly.

    tester_name = inspect.stack()[0][3]
    print("Running " + tester_name + "()")

    # Single-document examples from specification
    test_cases = {
        # Need the comma in ("abc",) to convince Python  that "abc" is an item
        # in a one-element tuple, not a sequence to be turned into ('a', 'b', 'c')
        ("abc abcabc a   a", ("abc",)): round3(1/4),
        ("abc abcabc a   a", ("ABC", "a")): round3(2/4),
        ("ab abab a   a", ("ABC", "a", "ab", "v", "abab")): round3(4/4),
        
        #STUDENT-ADDED DICTIONARY TEST CASES
        
        #doc just one non-white space character
        ("a", ("abc",)): round3(0),
        
        #doc just multiple non white space characters
        ("abcc", ("abc",)): round3(0),
        
        #checking if code still right when outlist output is zero
        ("abcc  abccdd  sjjnff", ("abc",)): round3(0),
        
        #checking if code differentiates between case sensitive words
        ("ABC  abccdd  sjjnff", ("abc", "abccdd")): round3(1/3),
        
        #checking if function works if all words in docs_list in vocab_list
        ("abc  abccdd", ("abc", "abccdd")): round3(1),
        
        #common case where outlist value is between 0 and 1
        ("abc  abccdd  bbb ccc", ("abc", "abccdd")): round3(1/2),
        
        #doc in doc_list has leading white spaces
        ("   abc  abccdd  bbb ccc", ("abc", "abccdd")): round3(1/2),
        
        #doc in doc_list has trailing white spaces
        ("abc  abccdd  bbb ccc   ", ("abc", "abccdd")): round3(1/2),
        
        #doc in doc_list has leading and trailing white spaces
        ("    abc  abccdd  bbb ccc   ", ("abc", "abccdd")): round3(1/2),
        
#document has words with internal punctuation also ensuring that 
#full words counted not just portion of words so word abc in vocablist
# should not be found in abcc'dd
        ("abc  abcc'dd  bbb ccc", ("abc", "abcc'dd", "abcc")): round3(1/2),
        
        #doc in doc_list has words containing numbers
        ("ab1c  abcc'dd2  bb11b ccc", ("ab1c", "abcc'dd2",
                                       "abcc")): round3(1/2),
        
        #vocablist just one item list
        ("hey  abccdd  hi", ("hey",)): round3(1/3),
        
        #words in doc in doclist repeated
        ("hey hey abccdd  hi", ("hey",)): round3(2/4),
        
        #words in vocablist repeated
        ("hey hey abccdd  hi", ("hey","hey")): round3(2/4),
        
        #doc in doclist one very long word with no spaces
        ("heyheyabccddhi", ("hey","abcc")): round3(0),
        
        #vocablist containg string which is just space
        ("hey  abccdd  hi", ("hey","  ")): round3(1/3),
        
    #doc in doclist contains multiple spaces of varying lengths between words
        ("hey      ab        cc d  d  hi", ("hey","  ")): round3(1/6),
                
        #target word in vocab_list contains spaces in between string
        ("hey baby abccdd  hi", ("hey ","baby","hey baby")): round3(1/4),
        
        #internal punctuation in vocablist and checking odd vocablist
        ("abc  abcbbc'dd  bbb ccc", ("abc", "abcbbc'dd", "abcc")): round3(1/2),
        
        #vocablist containing words with numbers and checking even vocablist
        ("hey1 hey2 abccdd  hi", ("hey2","hey")): round3(1/4),
        
        #target word in vocab_list contains spaces before string
        ("hey baby abccdd  hi", (" hey","baby","heybaby")): round3(1/4),
        
        #checking Function case sensitive
        ("Hey Baby abccdd  hi", ("Hey","baby","heybaby")): round3(1/4),
        
        #target word in vocab_list contains spaces after string
        ("hey baby abccdd  hi", ("hey","baby ","heybaby")): round3(1/4),
        
        #target word in doc contains tabs right infront of it which are
        #treated as spaces here spaces here
        ("hey baby\t abccdd  hi", ("hey","baby","heybaby")): round3(2/4),
    }
    for test_input in test_cases:
        docs_list = [test_input[0]]
        vocab_list = list(test_input[1])
        if verbose:
                print("\tTesting " + str((docs_list, vocab_list)))
        ca.assert_equals([test_cases[test_input]], a3.track_topic(docs_list, vocab_list))


    # Just one document, vary the vocabulary lists
    linelist = a3.get_content_lines(add_sources_to_fname("shortest.txt"))
    docs_list = [a3.convert_lines_to_string(linelist)]
    vocab_tuples = {
        ("abc",): [round3(1/8)],  # Need the comma to convince Python "abc" is a tuple
                                  # item, not a sequence to be turned into ('a', 'b', 'c')
        ("abcab",): [round3(0)],
        ("abc", "o'clock", "bipedal", "abcabc", "natural"): [round3(4/8)],# ... STUDENT-FIXED ERROR ...
        tuple(a3.convert_lines_to_string(linelist).split(),): [round3(1)]   # All the words
    }
    for key in vocab_tuples:
        vocab_list = list(key)
        if verbose:
                print("\tTesting " + str((docs_list, vocab_list)))
        ca.assert_equals(vocab_tuples[key], a3.track_topic(docs_list, vocab_list))

    # Several documents, each corresponding to a stanza (paragraph)
    linelist = a3.get_content_lines(add_sources_to_fname("imbeciles.txt"))
    docs_list = a3.convert_lines_to_paragraphs(linelist)
    len_list = []  # Stores the lengths of each document checked for length
    for doc in docs_list:
        len_list.append(len(doc.split()))

    vocab_tuples = {
        ("cheese", "continuous"): [round3(1/len_list[0]),
                                   round3(1/len_list[1]),
                                   0.,
                                   0.],
        # Should be case-sensitive, where these docs have been downcased
        ("cheese", "Continuous"): [round3(1/len_list[0]), 0., 0., 0.],
        # Should not pick up commented lines
        ("cheese", "Harry"): [round3(1/len_list[0]), 0., 0., 0.],
        ("cheese", "imbeciles"): [round3(2/len_list[0]),
                                  0.,
                                  0.,
                                  round3(1/len_list[3])],
        ("the",): [round3(3/len_list[0]),
                   round3(3/len_list[1]),
                   round3(3/len_list[2]),
                   round3(2/len_list[3])],
        ("the", "a", "an"): [round3((3 + 3 + 0)/len_list[0]),
                             round3((3 + 2 + 0)/len_list[1]),
                             round3((3 + 2 + 0)/len_list[2]),
                             round3((2 + 0 + 0)/len_list[3])]
    }
    for key in vocab_tuples:
        vocab_list = list(key)
        if verbose:
                print("\tTesting " + str((docs_list, vocab_list)))
        #TODO: NOTICE THE NESTED indices!! Ask the students to do?
        # Check each float in the resulting list
        result = a3.track_topic(docs_list, vocab_list)
        for ind in range(len(docs_list)):
            ca.assert_floats_equal(vocab_tuples[key][ind], result[ind])


    # Leave the following comment line in your submitted code so that the
    # graders can easily locate it and thus your additions.
    # ..... STUDENT-ADDED NON-DICTIONARY TEST CASES BELOW THIS LINE ....


    #STUDENT-ADDED NON-DICTIONARY TEST CASES BELOW
    
    #Empty docs_list
    docs_list = []
    vocab_tuples = {
        #empty docs_list with one item vocab_list
        ("abc",): [],  
   
        #empty docs_list with only spaces in vocab_list
        (" ",): [],
        
        #empty docs_list with multiple item vocab_list
        ("abc", "o'clock", "bipedal", "abcabc", "natural"): [],
    }
    for key in vocab_tuples:
        vocab_list = list(key)
        if verbose:
                print("\tTesting " + str((docs_list, vocab_list)))
        ca.assert_equals(vocab_tuples[key], a3.track_topic(docs_list, vocab_list))
        
    #Docs_list just one item so outlist also one item
    docs_list = ["abc hhhh nnnbhb"]
    vocab_tuples = {
        # docs_list with one item vocab_list
        ("abc",): [round3(1/3)],  
        
        #one item docs_list with multiple item vocab_list
        ("abc", "o'clock", "bipedal", "abcabc", "natural"): [round3(1/3)],
    }
    
    for key in vocab_tuples:
        vocab_list = list(key)
        if verbose:
                print("\tTesting " + str((docs_list, vocab_list)))
        ca.assert_equals(vocab_tuples[key], a3.track_topic(docs_list, vocab_list))
        
    #Odd- lengthed doclist
    docs_list = ["abc hhhh nnnbhb", "bye bye11 bye22", "car is better"]
    vocab_tuples = {
        #docs_list with one item vocab_list
        ("abc",): [round3(1/3), round3(0), round3(0)],  
        
        #docs_list with multiple item vocab_list
        ("abc", "o'clock", "bipedal", "bye11",
         "natural"): [round3(1/3), round3(1/3), round3(0)],
    }
    
    for key in vocab_tuples:
        vocab_list = list(key)
        if verbose:
                print("\tTesting " + str((docs_list, vocab_list)))
        ca.assert_equals(vocab_tuples[key], a3.track_topic(docs_list, vocab_list))

    #Even-lengthed doclist
    docs_list = ["abc hhhh nnnbhb", "bye bye11 bye22"]
    vocab_tuples = {
        #one item vocab_list
        ("abc",): [round3(1/3), round3(0)],  
        
        # multiple item vocab_list
        ("abc", "o'clock", "bipedal",
         "bye11", "natural"): [round3(1/3), round3(1/3)],
    }
    
    for key in vocab_tuples:
        vocab_list = list(key)
        if verbose:
                print("\tTesting " + str((docs_list, vocab_list)))
        ca.assert_equals(vocab_tuples[key], a3.track_topic(docs_list, vocab_list))




def ask_to_quit(verbose, nextfn=None):
    """Ask if user wishes to test the next function nextfn;
       terminate execution if not.
    Does nothing if `verbose` is False.
    If nextfn, the name of the next function, isn't given, Python uses the
      value None"""
    if verbose:
        if nextfn is None:
            nextfn = "the next function"
        msg = 'Press q to quit, anything else to start testing/running '
        msg += nextfn + '(). '
        response = input(msg)
        if response == "q":
            sys.exit()


# See the second half of section 14.9 "Writing modules" of the text for more
# on this __name__ business. Basic idea: the indented code is only run if
# this file is run by `python a3test.py` on the command line
if __name__ == '__main__':

    verbose = True  # Default mode is to give lots of output.
                    # False means give less output

    # Handling arguments from the command line
    if len(sys.argv) > 1:
        # Was called with at least one argument
        if len(sys.argv) == 2 and sys.argv[1] in ["quiet"]:
            # called by "python a3test.py quiet"
            verbose = False
        else:
            print("Invalid argument(s), only possible argument is 'quiet'.")
            sys.exit()

    fns_to_run = [test_get_content_lines,
                  test_convert_lines_to_string,
                  test_convert_lines_to_paragraph,
                  # test_get_econ_vocab,   # commented out to speed up testing
                  test_track_topic
                  ]
    for ind in range(len(fns_to_run)):
        fn = fns_to_run[ind]
        fn(verbose)
        if ind < (len(fns_to_run)-1):  # not the last test
            ask_to_quit(verbose, nextfn=fns_to_run[ind+1].__name__)
