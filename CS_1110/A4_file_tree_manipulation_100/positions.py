# positions.py
# Lillian Lee (LJL2), with helpful feedback from Austen Joa
# Apr 12, 2018

"""Module providing a class for positions in an org chart."""



# For rough drawings of org charts, without needing to install too much
# Documentation: https://networkx.github.io/documentation/stable/index.html
import matplotlib.pyplot as plt
import networkx as nx


class Position():
    """An instance is a position in an org chart.

    Instance attributes:
        title (non-empty string): the title of this Position
        holder (lowercase string representing a netid, or int 0, or special
            value None): the netid of the person holding this Position, or
            int 0 if the position isn't vacant but a netid for the position
            holder is unspecified, or None if the position is vacant.
        sups (list of Positions, possibly empty): The list of Positions that
            are direct supervisors of this Position. There are no repeats in it.
        subs (list of Positions, possibly empty): The list of Positions that
            this Position directly supervises, i.e., its direct subordinates.
            There are no repeats in it.
        search_in_progress: bool, True if and only if there is a current search
            for that position

    Class invariant
    (i.e., must be true before and after every function/method call):
        Among any connected set of Positions, there are no supervisory cycles,

        Among any connected set of Positions, there is one and only one Position
            whose `sups` attribute is [].

        If Position pos1 has Position pos2 in its `sups` list, then pos2 has
            pos1 in its `subs` list.

        If Position pos1 has Position pos2 in its `subs` list, then pos2 has
            pos1 in in its `sups` list."""

    def __init__(self, t, h, in_sups, in_subs, search_in_progress=False):
        """A new Position with title t, holder h, sups set to (a shallow copy)
        of in_sups and subs set to (a shallow copy) of in_subs, any repeats
        excluded.

        The supervisors of any Positions in in_subs are updated to include this
        Position, and the subordinates of any Positions in in_sups are updated
        to include this Position.

        Preconditions:
            No supervisory cycles are introduced by this Position.
            All arguments are valid values for the respective parameters they
                will be assigned to.
        """
        # Check some preconditions
        self._validate_init_inputs(t, h, in_sups, in_subs)

        self.title = t
        self.holder = h
        self.sups = []
        for sup in in_sups:
            self.become_sub_of(sup)

        self.subs = []
        for sub in in_subs:
            sub.become_sub_of(self)
        self.search_in_progress = search_in_progress

    def _validate_init_inputs(self, t, h, in_sups, in_subs):
        """Raises AssertionError if some checks on preconditions of inputs
        to __init__ fail.
        Otherwise, does nothing."""
        assert isinstance(h, str) or \
            (isinstance(h, int) and h == 0) or \
            h is None, \
            'bad h: ' + repr(h)
        assert isinstance(in_sups, list), \
            'in_sups has wrong type, ' + str(type(in_sups))
        assert isinstance(in_subs, list), \
            'in_subs has wrong type, ' + str(type(in_subs))
        for sup in in_sups:
            assert isinstance(sup, Position), \
                   'in_sups contains non-Position item ' + repr(sup)
        for sub in in_subs:
            assert isinstance(sub, Position), \
                   'in_subs contains non-Position item ' + repr(sub)

    def __str__(self):
        """Abbreviated/adapted for use with networkx visualization.
        Example return strings (each group of lines is one string),
        except that extra newlines are omitted:

        Board of Trustees
        Holder: not specified

        President
        Holder: mep100

        University Counsel
        Holder: mfw68

        Under-secretary of the Corporation
        Holder: -vacant-

        Vice Dean for Academic Integration
        Holder: gak36

        Dean of Arts and Sciences
        Holder: gr72
        (search in progress)
       """
        outstring = self.title + '\n'
        outstring += 'Holder: '
        if isinstance(self.holder, str):
            outstring += self.holder
        elif self.holder == 0:
            outstring += 'not specified'
        else:
            outstring += '-vacant-'
        if self.search_in_progress:
            outstring += ('\n' + '(search in progress)')
        return outstring + 4*'\n'  # Spacing makes figure labels more legible

    def full_string(self):
        """
        Example return strings (each group of 4 lines is one string):

        Title: "Board of Trustees"
        Holder: not specified
        Supervisors: There are none
        Subordinates: President, University Counsel

        Title: "President"
        Holder: mep100
        Supervisors: Board of Trustees
        Subordinates: University Counsel, Secretary of the Corporation


        Title: "University Counsel"
        Holder: mfw68
        Supervisors: Board of Trustees, President
        Subordinates: There are none
        """
        outstring = str(self).strip() + '\n'
        outstring += titles_from_list('Supervisors: ', self.sups) + '\n'
        outstring += titles_from_list('Subordinates: ', self.subs)
        return outstring

    def __repr__(self):
        """Example returned string:

        <Position: President; Holder: mep100; Supervisors: Board of Trustees; Subordinates: University Counsel, Secretary of the Corporation, Provost, Executive Vice President and Chief Financial Officer, Provost for Medical Affairs>

        """
        return '<Position: ' + self.full_string().replace('\n', '; ') + '>'

    def become_sub_of(self, sup):
        """Make self a direct subordinate of Position sup, if not already.
        """
        assert isinstance(sup, Position), 'bad value for sup: ' + repr(sup)

        if self not in sup.subs:
            sup.subs.append(self)
            self.sups.append(sup)


def titles_from_list(header, inlist):
    """Returns string of titles of Positions in inlist, prefaced by header,
    using 'There are none' for the string of titles if inlist is empty.

    Preconditions:
        inlist is a (possibly empty) list of Positions.
        `header` is a nonempty string
    """
    _validate_titles_inputs(header, inlist)

    if inlist == []:
        return header + 'There are none'
    else:
        title_list = []  # We will run join on this later
        for item in inlist:
            title_list.append(item.title)
        return header + ', '.join(title_list)


def _validate_titles_inputs(header, inlist):
    """Raises AssertionError if some checks on preconditions of inputs
        to titles_from_list fail.
    Otherwise, does nothing. """
    assert isinstance(header, str) and len(header) > 1, \
        "bad header " + repr(header)
    assert isinstance(inlist, list), "bad inlist " + repr(inlist)
    for item in inlist:
        assert isinstance(item, Position), 'bad item in inlist: ' + repr(item)


def _collect_reachable_positions(start_posn, collected):
    """
    Add to `collected` all Positions that are subordinate to Position start_posn,
    or subordinate to its subordinates, ..., and so on all the way down.
    But do not include repeats.

    Preconditions:
        `start_posn` is a Position
        `collected` is a list of Positions, possibly empty
    """
    # Note the recursive implementation
    for sub in start_posn.subs:
        if sub not in collected:
            collected.append(sub)
            _collect_reachable_positions(sub, collected)


def draw(root, figtitle=None):
    """Use networkx package to draw the subordinate structures of the Positions
    reachable from `root` following subordinate links.

    Note: the layout is nondeterministic (you can get different picture for the
    same org chart.)

    The title of the figure will be `figtitle`, or the empty string if
    `figtitle` is None.

    Precondition: `root` is a Position.
    """
    # Students, you do not need to understand what is going on with the DiGraph
    # g or how the creation of the figure works.

    all_posns = [root]
    _collect_reachable_positions(root, all_posns)

    # Add nodes corresponding to positions in all_posns to a graph g
    g = nx.DiGraph()
    g.add_nodes_from(all_posns)

    # Add the edges to g
    for posn in all_posns:
        for sub in posn.subs:
            g.add_edge(posn, sub)

    # Display the graph. The root will be blue, the others red.
    node_colors = ['r']*len(all_posns)
    node_colors[0] = 'b'
    fig, ax = plt.subplots()
    if figtitle is None:
        figtitle = ""
    nx.draw_networkx(g,
                     node_color=node_colors,
                     node_size=200,
                     node_shape='.',
                     linewidths=0,  # https://stackoverflow.com/questions/22716161/how-can-one-modify-the-outline-color-of-a-node-in-networkx?rq=1
                     font_size=10)
    plt.title(figtitle)
    plt.axis('off')
    plt.show()


