# positions_test.py
# Lillian Lee (LJL2)
# Apr 11, 2018


"""Some demonstrations of the use of class Positions and related functions
    from positions.py.

    Also tests whether students can use networkx to draw org charts.

    STUDENTS: try running this file on the command line, i.e.,
        python positions_test.py

    if you get an error saying that name networkx is not defined,
    do the following on the command line (not interactive mode):

        pip install networkx

    If you don't get such a message, but running python on this file fails to
    produce a figure with a "web" of positions, do the following on the
    command line:

        pip install --upgrade networkx

    If after you try the relevant option above and you still aren't getting
    a figure produced when running this file, please post on Piazza with
    some details of any error messages or output.

"""

import positions as pfile


# STUDENTS: observe that making a subclass makes it easier to create
# formulaic Positions
class VP(pfile.Position):
    """All Vice Presidents and Provosts are report to the President.
    Assumes `president` is a global variable."""
    def __init__(self, t, h,):
        super().__init__(t, h,  [president], [])


class Dean(pfile.Position):
    """Regular Deans report to the Provost.  Assumes `provost` is a global
    variable."""
    def __init__(self, t, h, search_in_progress=False):
        super().__init__(t, h, [provost], [], search_in_progress)


if __name__ == '__main__':

    # Set up part of the org chart for Cornell
    # Start with the "root"
    trustees = pfile.Position("Board of Trustees", 0, [], [])

    # This netid is made up.
    president = pfile.Position("President", "mep100", [trustees], [])

    # LL note: my reading of the Cornell bylaws
    # (https://trustees.cornell.edu/Shared%20Documents/18-3%20bylaws%20w-TC.pdf)
    # is that the University Counsel is a separate position from the
    # Secretary of the Corporation, despite the President org chart
    # at http://dbp.cornell.edu/university-org-structure/
    counsel = pfile.Position("University Counsel",
                             "mfw68",
                             [trustees, president],
                             [])
    sec_of_corp = pfile.Position("Secretary of the Corporation",
                                 "mfw68",
                                 [president],
                                 [])

    provost = pfile.Position("Provost",
                             "mik7",
                             [president],
                             [])
    evp = VP("Executive Vice President and Chief Financial Officer", "jmd11")
    pma = VP("Provost for Medical Affairs", "amc562")
    vdai = pfile.Position("Vice Dean for Academic Integration",
                          "gak36",
                          [provost, pma],
                          [])
    dean_med = pfile.Position("Dean of the Medical College", "amc562", [pma], [])
    dean_as = Dean('Dean of Arts and Sciences', "gr72", search_in_progress=True)
    dean_bus = Dean('Dean of Business', "ljt3", search_in_progress=True)

    # Test some printouts
    for posn in [trustees, president, counsel, sec_of_corp, provost,
                 evp, pma, vdai, dean_med, dean_as, dean_bus]:
        print(posn.full_string())
        print()

    title = "Fragment starting at Board of Trustees (blue dot).\n"
    title += "(Resize the window if this figure is hard to read.)"

    pfile.draw(trustees, figtitle=title)



