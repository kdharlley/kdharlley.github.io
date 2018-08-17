# num_space_runs.py
# Walker White (wmw2) and Lillian Lee (LJL2)
# April 29, 2018

# STUDENTS: your solutions below MUST use while-loops that make effective
# use of and preserve the given invariants.
#
# You need only do TWO of the three problems below.


def num_space_runs1(s):
    """Returns: The number of runs of spaces in the string s.

    Examples (we've put ^ markers to "underline" spaces):
            num_space_runs('  a  f   g    ') returns 4
                            ^^ ^^ ^^^ ^^^^

            num_space_runs('a  f   g') returns 2
                             ^^ ^^^

            num_space_runs('  a  bc   d') returns 3
                            ^^ ^^  ^^^
    Precondition: s is a nonempty string with letters and spaces"""

    # STUDENTS: The invariant for you to work with is:
    #     s[0..i-1] has n runs of spaces, AND:
    #     in_a_run is a boolean:
    #          True if i-1 is a valid index and s[i-1] is a space
    #          False otherwise
    #
    # In other words, s[i..len(s)-1] still needs to be checked;
    # and in_a_run tells us whether a new space would be part of an old run.


    # REPLACE THE FOLLOWING WITH CORRECT INITIALIZATION CODE:
    i = 0
    n = 0
    in_a_run = False

    # PUT YOUR WHILE LOOP HERE
    # Hint1: only increment n when you find a space and are not currently in a run.
    # Hint2: you need to change in_a_run when:
    #   (a) you have found a space and you are not currently in a run, or
    #   (b) you found a non-space and you currently in a run
    # Hint3: don't forget to increment your loop variable, if you have one!
    while i<len(s):
        if s[i]==" " and in_a_run==False:
            n +=1
            in_a_run=True
        elif s[i] !=" " and in_a_run==True:
            in_a_run= False
        i=i+1
        
    return n












    # post: s[0..len(s)-1] contains n runs of spaces
    # PUT THE RETURN STATEMENT HERE


def num_space_runs2(s):
    """Same spec as above"""

    # invariant: s[0..i] contains n runs of spaces. So if i+1 is a legal index,
    # s[i+1] is the next thing to check, or the unknowns are s[i+1..len(s)-1].


    # WE ARE GIVING YOU THE FOLLOWING INITIALIZATION. DON'T CHANGE IT.
    i = 0
    if s[0] == ' ': # this initialization "peeks" at the data to see
                    # whether s[0] starts a run or not.
        n = 1
    else:
        n = 0

    # PUT YOUR WHILE LOOP HERE.
    # Hint: you only need to increment n when you have a space following a
    # non-space.


    while i<len(s)-1:
        if s[i]!=" " and s[i+1]==" ":
            n+=1
        i=i+1
    
    return n








    # post: s[0..len(s)-1] contains n runs of spaces

    # PUT THE RETURN STATEMENT HERE





def num_space_runs3(s):
    """Same spec as above"""

    # The invariant for you to work with is:
    #     s[0..i] has n runs of spaces
    #
    # In other words, s[i+1..len(s)-1] still needs to be checked.

    # WE ARE GIVING YOU THE FOLLOWING INITIALIZATION. DON'T CHANGE IT.
    i = -1
    n = 0

    # PUT YOUR WHILE LOOP HERE
    # Hint: you only need to increment n when i is a valid index and s[i] is
    # not a space but s[i+1] is a space,
    # OR when i is -1 and the very first character in s is a space

    while i<=len(s)-2:
        if i==-1 and s[0]==" ":
            n+=1
        elif s[i]!=" " and s[i+1]==" ":
            n+=1
        i=i+1
    return n










    # post: s[0..len(s)-1] contains n runs of spaces
    # PUT THE RETURN STATEMENT HERE



