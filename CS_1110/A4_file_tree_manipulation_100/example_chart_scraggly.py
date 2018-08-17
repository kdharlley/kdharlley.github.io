# positions_scraggly.py
# Lillian Lee (LJL2)
# Apr 11, 2018

"""A module creating an org chart with two long branches.

   Root is `topdog`.
   13 Positions total.
   6 positions above plist[5].
"""

import positions as pfile


# Create some Positions and keep them in plist
plist = []
branch_length = 6
for letter in 'ab':
    for i in range(branch_length):
        title = "Level" + str(i)
        holder = 3*letter + str(i)
        if i == 0:
            suplist = []
        else:
            suplist = [plist[-1]]
        new = pfile.Position(title, holder, suplist, [])
        if i > 0:
            suplist[0].subs.append(new)
        plist.append(new)
plist[3].search_in_progress = True
plist[3 + branch_length].search_in_progress = True
topdog = pfile.Position("Top Dog",
                        "ccc111",
                        [],
                        [plist[0], plist[branch_length]])

if __name__ == '__main__':
    title = "Scraggly example with Top Dog (blue dot) as supreme boss.\n"
    title += "(Resize the window if this figure is hard to read.)"
    pfile.draw(topdog, figtitle=title)


