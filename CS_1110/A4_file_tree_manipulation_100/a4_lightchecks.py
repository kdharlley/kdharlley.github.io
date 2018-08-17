# a4_lightchecks.py
# Lillian Lee (LJL2)
# Apr 12, 2018

"""Some example ways to check CS1110 spring 2018 a4.py code. """

# STUDENTS: Do not submit this, or any other testing file; it's up to you to
# decide how to verify the correctness of your a4.py.
#
# Correct a4's will pass all the checks supplied in this file, but we will apply
# additional tests in grading your a4.


import positions as pfile
import example_chart_cornell as cu
import example_chart_scraggly as scraggly
import a4
import inspect  # Used to get function names automatically:
                # inspect.stack()[0] is the "highest" frame on the call stack


def assert_equal_contents(list1, list2):
    """Quit with error if there's something in one input list but
    not the other.
    Precondition: no repeats in either list, lists contain Positions.
    """
    # Provided to get more informative error messages
    assert len(list1) == len(list2)
    list2copy = list2[:]
    for item in list1:
        assert item in list2copy, item.title + ' not in list2'
        list2copy.remove(item)
    # Should be nothing left in list2copy if list2 only had list1 items
    assert len(list2copy) == 0, list2copy[0].title + ' not in list1'


def test_above():
    """Test a4.posns_above. """
    tester_name = inspect.stack()[0][3]
    print("Running " + tester_name + "()")

    # A quick check: just nicely print the output
    """for i in range(12):
        print(pfile.titles_from_list('above the: '+scraggly.plist[i].title+ " "+ scraggly.plist[i].holder + " ", a4.posns_above(scraggly.plist[i])))
    """
    print(pfile.titles_from_list('above the counsellor: ', a4.posns_above(cu.vdai)))
    """print(pfile.titles_from_list('above the trust: ', a4.posns_above(cu.trustees)))
    print(pfile.titles_from_list('above the prez: ', a4.posns_above(cu.president)))
    print(pfile.titles_from_list('above the sec cor: ', a4.posns_above(cu.sec_of_corp)))
    print(pfile.titles_from_list('above the prov: ', a4.posns_above(cu.provost)))
    print(pfile.titles_from_list('above the XVPCFO: ', a4.posns_above(cu.evp)))
    print(pfile.titles_from_list('above the dpmedaff: ', a4.posns_above(cu.pma)))
    print(pfile.titles_from_list('above the dmed: ', a4.posns_above(cu.dean_med)))
    print(pfile.titles_from_list('above the das: ', a4.posns_above(cu.dean_as)))
    print(pfile.titles_from_list('above the dbus: ', a4.posns_above(cu.dean_bus)))"""
    # Two spot checks for inspiration
    assert_equal_contents(a4.posns_above(cu.vdai),
                          [cu.pma, cu.provost, cu.president, cu.trustees])
    assert_equal_contents(a4.posns_above(scraggly.plist[5]),
                          scraggly.plist[:5] + [scraggly.topdog])


def _print_our_map_output():
    print("\n\t..........\n\tHere's our version")
    print("\tmep100: President")
    print("\tmfw68: University Counsel, Secretary of the Corporation")
    print("\tmik7: Provost")
    print("\tgak36: Vice Dean for Academic Integration")
    print("\tgr72: Dean of Arts and Sciences")
    print("\tljt3: Dean of Business")
    print("\tjmd11: Executive Vice President and Chief Financial Officer")
    print("\tamc562: Provost for Medical Affairs, Dean of the Medical College")


def test_map():
    """test a4.map_people_to_positions"""
    tester_name = inspect.stack()[0][3]
    print("Running " + tester_name + "()")

    # A quick check: just nicely print the output
    posns_of = a4.map_people_to_positions(cu.trustees)
    print('\tPrinting position titles from your function with input cu.trustees')
    for netid in posns_of:
        print('\t' + pfile.titles_from_list(netid + ': ', posns_of[netid]))
    _print_our_map_output()
    posns_of = a4.map_people_to_positions(cu.counsel)
    print('\tPrinting position titles from your function with input cu.trustees')
    for netid in posns_of:
        print('\t' + pfile.titles_from_list(netid + ': ', posns_of[netid]))
    posns_of = a4.map_people_to_positions(cu.counsel)
    print('\tPrinting position titles from your function with input cu.trustees')
    for netid in posns_of:
        print('\t' + pfile.titles_from_list(netid + ': ', posns_of[netid]))
    """for i in range(12):
        posns_of = a4.map_people_to_positions(scraggly.plist[i])
        print('\tPrinting position titles from your function with input cu.trustees')
        for netid in posns_of:
            print('\t' + pfile.titles_from_list(netid + ': ', posns_of[netid]))
        #_print_our_map_output()
    posns_of = a4.map_people_to_positions(scraggly.plist[0].sups[0])
    print('\tPrinting position titles from your function with input cu.trustees')
    for netid in posns_of:
        print('\t' + pfile.titles_from_list(netid + ': ', posns_of[netid]))
    print(scraggly.plist[0].sups[0])"""

if __name__ == '__main__':
    testers = [test_above, test_map]

    for test_fn in testers:
        test_fn()

    print('Done. Maybe things are OK!')


