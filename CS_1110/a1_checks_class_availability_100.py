# a1.py
# Kenneth Dela Harlley kdh62
# Sources/people consulted: NONE
# Sunday February 25,2018
# Skeleton by Prof. Lee (cs1110-prof@cornell.edu), Feb 14 2018

"""
Functions for finding whether a class is open or closed on a roster.

We use "backwards single quotes" --- like this: `hi there` --- in the
docstrings below to visually set off variable names.
"""



def before_first_double_quote(text):
    """Returns: the part of string `text` right up to but not including
    the first double-quote.

    Precondition: string `text` contains at least one double-quote.

    Example: before_first_double_quote('abd"def') returns the string
        abd
    """
    end_text= text.find('"')
    text_output = text[:end_text]
    return text_output




def after(tag, text):
    """Returns: all of string `text` that occurs just after the first
    occurrence of string `tag` in `text`.

    Preconditions:
        `text` [str] contains an instance of `tag`
        `tag` [str] has length > 0

    Example: if `tag` is the string
        <a id="c111">
    and `s` is the string
        start <a id="c111">xthis that the other
    then this functions returns the string
         xthis that the other
    """
    index_after= text.find(tag) + len(tag)
    after_tag = text[index_after:]
    return after_tag


def open_status(class_num, data):
    """Returns the open-ness status of class `class_num` according to `data`.

    `class_num`: string version of a class number, e.g., "10776" at Cornell.

    `data`: a string whose preconditions are easiest explained by example.
        Suppose `class_num` is "10775".
        Then, `data` must contain somewhere within it a single occurrence of
           <a id="c10775">
        and this is followed by text where the first occurrence of the string
            open-status-
        (the ending hyphen is important) is one of
            open-status-open"
        or
            open-status-closed"
        or any string of the form
            open-status-???"
        (the ending double-quote is important to notice)
        where the ??? stands for a sequence of characters not containing quotes
        that represents the open-ness status of the course. (For example, maybe
        there is such a thing as open-status-waitlist")

    This function returns whatever ??? is.

    Example: if `class_num` is "10775", and `data` is the string
        <a id="c10775"> fa-circle open-status-open"></i></span>
    then this function returns the string
        open

    Example: if `class_num` is "10775", and `data` is the string
        dum dee dum <a id="c10775"> open-stat open-status-CLOSED" tral la la
    then this function returns the string
        CLOSED

    Example: if `class_num` is "432" and `data` is the string
        <a id="c4321"> ha open-status-open" <a id="c432"> open-status-never!""
    then this function returns the string
        never!
    (The exclamation point must be included.)

    Example: if `class_num` is "432" and `data` is the string
        <a  id="c432"> ho open-status-open" <a id="c432"> open-status-nope."
    then this function returns the string
        nope.
    (The number of spaces matters between the `a` and the `id` matters.)



    """
    class_full_num= '<a id="c'+class_num+'">'
    needed_data = after(class_full_num,data)
    target_string= 'open-status-'
    status_name = before_first_double_quote(after(target_string, needed_data))
    return status_name




def label(class_num, data):
    """Returns, as a single string,  the common name, component and component
    number for class `class_num` according to `data`.

    `class_num`: string version of a class number, e.g., "10776" at Cornell.

    `data`: a string whose preconditions are easiest explained by example.
        Suppose `class_num` is "10782".
        Then, `data` matches the pattern
             ... <a id="c10782"> ... class="course-repeater">CS 1110&nbsp;...
            data-ssr-component="DIS" data-section="208"
        And the function should return the string
            CS 1110 DIS 208
        with no beginning or trailing whitespace.

        That is, `data` must contain somewhere within it a single occurrence of
            <a id="c10782">
        and this is followed by text where the first occurrence of the string
            class="course-repeater">
        (the ending quote and angle-bracket is important) is followed by the
        common name of the course, and then the string
            &nbsp;
        and the first occurrence of the string
            data-ssr-component="
        is followed by the component, followed by a double-quote,
        and the first occurrence of the string
            data-section="
        is followed by the component number followed by a double-quote.

        The function returns the string formed by concatenating the common
        name, then a space, then the component, then a space, then the
        component number.

    """
    class_full_num= '<a id="c'+class_num+'">'
    class_data=after('class="course-repeater">', after(class_full_num, data))
    coursename_end = class_data.find('&nbsp')
    course_name= class_data[:coursename_end]
    component_data = after('data-ssr-component="', class_data)
    component_name = before_first_double_quote(component_data)
    sec_num =before_first_double_quote(after('data-section="', component_data))
    
    
    return course_name.strip()+' '+component_name.strip()+' '+sec_num.strip()




