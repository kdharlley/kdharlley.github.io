# a4.py
# Kenneth Harlley, kdh62
# Sources/people consulted:  NONE
# 15 April,2018
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




def posns_above(root):
    """Returns: list of Positions that supervise Position `root`, or supervise
    `root`'s supervisors, ... and so on up.

    No repeats in the returned list. (OK if different Positions have the same title)
    """
    sups_list=[]
    if root.sups==[]:
        return []
    for sup in root.sups:
        if sup not in sups_list:
            sups_list = sups_list + [sup]
        recursive_sups = posns_above(sup)
        for recsub in recursive_sups:
            if recsub not in sups_list:
                sups_list.append(recsub)
        
    return sups_list


def map_people_to_positions(root):
    """Returns: dictionary of netids of people who hold the `root` Position or
    any Position subordinate to `root`, or subordinate to a subordinate of `root`,
    and so on, all the way down.
    The value for a given netid: list of Positions held by that netid, no repeats
    """
    if root.holder==0 or root.holder==None:
        sub_dict={}
    else:
        sub_dict={root.holder:[root]}
    if root.subs=={}:
        return sub_dict
    for sub in root.subs:
        if sub.holder==0 or sub.holder==None:
            pass
        elif sub.holder not in sub_dict:
            sub_dict[sub.holder]=[sub]
        else:
            sub_dict[sub.holder].append(sub)

            
        recursive_subs = map_people_to_positions(sub)
        
        for key in recursive_subs:
            if key==0 or key==None:
                pass
            elif key not in sub_dict:
                sub_dict[key]=recursive_subs[key]
            else:
                sub_dict[key]= sub_dict[key] + recursive_subs[key]

              
    for key in sub_dict:
        final_positions = []
        for positions in sub_dict[key]:
            if positions not in final_positions:
                final_positions.append(positions)
        sub_dict[key]= final_positions
    return sub_dict
