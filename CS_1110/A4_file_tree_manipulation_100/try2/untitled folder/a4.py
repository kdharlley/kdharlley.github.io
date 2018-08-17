# a4.py
# STUDENTS: update the next three lines and then delete this one
# PUT YOUR NAME(S) AND NETID(S) HERE
# Sources/people consulted:  STUDENTS: FILL IN OR WRITE "NONE"
# PUT DATE YOU COMPLETED THIS HERE
# Skeleton by Lillian Lee (LJL2)
# Apr 12 2018

# STUDENTS:
# Instructions: implement the bodies of the predefined function headers below
# according to their specifications.
#
# Rule 1: no direct or indirect calls to positions._collect_reachable_positions()
# in any code you submit.
# (Using positions.draw() to debug is OK, but delete such calls before
# submission.)
#
# Rule 2: No strategies that essentially "flatten" an org chart into a
# non-nested list (of strings,  Positions, whatever) and then operate on that.
#
# Rule 3: implementations must make effective use of recursion. It's OK to
# include for-loops or anything else, too.

import positions


def posns_above(root):
    """Returns: list of Positions that supervise Position `root`, or supervise
    `root`'s supervisors, ... and so on up.

    No repeats in the returned list. (OK if different Positions have the same title)
    """
    sups_list = []
    
    for sup in root.sups:
        
        if sup not in sup_list:
            sup_list.append(sup)
            
        sups_list_redundant = posns_above(sup)
    
        for sup in sups_list_redundant:
            if sup not in sups_list:
                sups_list.append(sup)
    return sups_list
    

def map_people_to_positions(root):
    """Returns: dictionary of netids of people who hold the `root` Position or
    any Position subordinate to `root`, or subordinate to a subordinate of `root`,
    and so on, all the way down.
    The value for a given netid: list of Positions held by that netid, no repeats
    """
    sub_dict = {}
    
    if root.holder != 0:
        sub_dict={root.holder: [root]}#if zero dont add it
        
    for sub in root.subs:
        
        if sub.holder not in sub_dict:
            sub_dict[sub.holder]=[sub]
        else:
            sub_dict[sub.holder].append(sub)
            
        subs_list_redundant = map_people_to_positions(sub)
    
        for netID in subs_list_redundant:
            if netID not in sups_list:
                sups_list.append(sup)
    return sups_list
    sub_dict ={}
    subs_list= posns_below(root) + [root]
    for sub in subs_list:
        if sub.holder not in sub_dict:
            sub_dict[sub.holder] = [sub]
        else:
            sub_dict[sub.holder].append(sub)
        """    
        list_map = positions.titles_from_list(sub.holder, [sub]).split(", ")
        #print list_map
        sub_dict[list_map[0]]= list_map[1:]"""
    print(sub_dict)
    return sub_dict
    """subs_list =[]
    if root.subs ==[]:
        subs_list = root
        return subs_list
    else:
        for sub in root.subs:
            sups_list_redundant = sups_list + [sup] + posns_above(sup)
        sups_list = []
        for sup in sups_list_redundant:
            if sup in sups_list:
                pass
            else:
                sups_list.append(sup)"""
    #return sups_list
    pass
