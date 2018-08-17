# positions_cornell.py
# Lillian Lee (LJL2)
# Apr 11, 2018


"""A module creating a non-trivial org chart.

Root is`trustees`
11 Positions total
netids amc562  and mfw68 both hold two separate Positions each
Positions vdai and counsel have more than one supervising Positions
There are 4 positions above vdai

References:
Cornell org charts:
http://irp.dpb.cornell.edu/university-factbook/university-organization
By-Laws:
(https://trustees.cornell.edu/Shared%20Documents/18-3%20bylaws%20w-TC.pdf)

"""

import positions as pfile


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


if __name__ == '__main__':

    title = "Fragment starting at Board of Trustees (blue dot).\n"
    title += "(Resize the window if this figure is hard to read.)"
    pfile.draw(trustees, figtitle=title)



