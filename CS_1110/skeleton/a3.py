# a3.py
# Kenneth Harlley (Kdh62)
# NONE
# Thursday March 29th, 2018
# Skeleton by Lillian Lee (LJL2) and Victoria Litvinova (VL242), Mar 22 2018

from tkinter import filedialog  # Get visual request for file selection
import urllib.request  # Get vocabulary from a webpage
import string  # Get some useful string built-in values
import os
import sys

from sources import econ_terms# BEGIN REMOVE
ECON_DATA_FNAME = os.path.join('econ_terms_scratch', 'econ_vocab_data.txt')
ECON_VOCAB = econ_terms.ECON_VOCAB


def get_content_lines(fname=None):
    """Given filename fname, return a list of normalized lines in the file,
    except that lines that are 'commented out', in the sense of the first
    non-whitespace character being a '#', are not included.

    EXCEPTION: if no argument is given, the "fname=None" in the function header
    sets fname to None (the actual value, NOT the string "None"), which,
    in the code below, causes the filename to be retrieved from the user via a
    visual file-open dialog.

    The normalization is almost exactly as described in Section 13.3 "Word histogram" in the
    text, and in particular the function process_line: hyphens are replaced
    with spaces (so "highly-flammable programs" would become three words);
    punctuation at the beginning and ends of words is removed (so that "Really?",
    "Really!" and "Really" are all treated as the same word), and all words are
    lower-cased (so that "CS1110" and "cs1110" are treated as the same word.)
    Leading or trailing whitespace is removed, and all line-internal whitespace
    is replaced by a single space.
    However, a "\n" is added to the end of every line.

    Precondition: fname is the name of a plain-text file, OR it is not given by
    the caller (in which case Python will set parameter fname to None).
    """
    output = []  # Initialize our accumulator

    # This is how to check if something is None (Pythonistas don't use == here.)
    if fname is None:
        # Fill in fname using a visual dialog window
        fname = filedialog.askopenfilename(filetypes=[("Text Files", "*.txt")],
                                           title="Choose an input file")

    # About open(), see section 9.1 "Reading word lists" of the text.
    # "with" makes sure file opening and closing is cleanly done.
    # The 'r' means can only read the file, not change it
    with open(fname, mode='r', encoding='utf-8') as fp:

        # See Section 13.3 "Word histogram" on looping through a file's lines
        for line in fp:
            left_justified_line = line.lstrip()  # Remove leading whitespace
            if len(left_justified_line) == 0 or left_justified_line[0] != '#':
                # Either line was empty or it wasn't a comment.
                line = line.replace('-', ' ')
                words_in_line = line.split()
                for ind in range(len(words_in_line)):
                    word = words_in_line[ind].strip()
                    word = word.strip(string.punctuation + string.whitespace)
                    word = word.lower()
                    words_in_line[ind] = word  # Replace with normalized version
                output.append(' '.join(words_in_line) + '\n')
    return output


def convert_lines_to_string(linelist):
    """ Returns: a single string that is the concatenation of every non-empty
    line in linelist except each such line has been stripped of leading and
    trailing whitespace (including newlines), and there is a single space
    between what used to be adjacent lines (ignoring lines that were originally
    empty strings before the stripping of whitespace).

    Example input and output:
        ["hi\n", "there"] -> "hi there"
        ["    hola    ", "   salut \n  howdy  "] -> "hola salut \n  howdy"
        ["so", "la", "", "do"] -> "so la do"
        ["so", "\n", "la", "", "", "do"] -> "so  la do"
           ** note the two spaces between "so" and "la"

    Precondition: linelist is a (possibly empty) list of strings.
    """
    single_string = ""
    beginning_space_stripped =0
    for line in linelist:
        if line == "":
            pass
        else :
            line = line.strip(" \n")
            if single_string == "":
                beginning_space_stripped +=1
                if beginning_space_stripped==1:   
                    single_string =  single_string + line
                else:
                    single_string =  single_string + " " + line
            else:
                single_string =  single_string + " " + line
    return single_string


def convert_lines_to_string2(linelist):
    """Same specification as convert_lines_to_string()"""

    single_string = ""
    beginning_space_stripped =0
    for ind in list(range(len(linelist))):
        if linelist[ind] == "":
            continue
        else:
            linelist[ind] = linelist[ind].strip(" \n")
            if single_string == "":
                beginning_space_stripped +=1
                if beginning_space_stripped==1:   
                    single_string =  single_string + linelist[ind]
                else:
                    single_string =  single_string + " " + linelist[ind]
            else:
                single_string =  single_string + " " + linelist[ind]
    return single_string



def convert_lines_to_paragraphs(linelist):
    """ Returns: a list of the paragraph-strings corresponding to
    the paragraphs in linelist.

    Each paragraph in linelist is a maximal contiguous subsequence of lines
    in linelist such that the sequence does not contain a blank line.
    A blank line is exactly the string "\n".

    A paragraph-string is the result of running convert_lines_to_string()
    or convert_lines_to_string2 on a paragraph.

    If linelist is empty, or if all the lines in linelist are empty,
    returns the empty list.

    See the test cases in a3test.test_convert_lines_to_paragraph() for examples.

    Precondition: linelist is a (possibly empty) list of strings.
    """

    paragraphlist = []
    curr_paragraph =[]
    paragraph_num = 0
    new_line_found = False
    if linelist==[]:
        return linelist
    for line_ in linelist:
        if line_=="":
            continue
        elif line_=="\n":
            new_line_found=True
        elif new_line_found:
            if curr_paragraph ==[]: 
                curr_paragraph.append(line_)
                new_line_found= False
            else:
                paragraphlist.append(convert_lines_to_string(curr_paragraph))
                curr_paragraph=[]
                curr_paragraph.append(line_)
                new_line_found= False
        else:
            curr_paragraph.append(line_)
            
    if len(curr_paragraph)>=1:
        paragraphlist.append(convert_lines_to_string(curr_paragraph))
    return paragraphlist







def download_econ_vocab_data(fname):
    """(over)write into file fname the concatenation of text regarding
    economics-related terminology text from
        https://www.economist.com/economics-a-to-z/a
        https://www.economist.com/economics-a-to-z/b
        ...
        https://www.economist.com/economics-a-to-z/z

    Preconditions: directory econ_dict exists in the same directory as this file.
    """
    with open(fname, mode='a+', encoding='utf-8') as fp:

        # Isn't it handy to be able to loop through strings?
        for letter in string.ascii_lowercase:
            # You can check that this is like what we did in A1, file
            # get_status_from_webpage.py
            data_name = 'https://www.economist.com/economics-a-to-z/'
            try:
                data_source = urllib.request.urlopen(data_name + letter)
                fp.write(data_source.read().decode('utf-8'))
                fp.write('\n\n')  # have a separator between webpages
            except ValueError:
                print("Something is wrong with the web address or webpage.")
                sys.exit()


def get_econ_vocab_helper(vlist_to_add_to, work_text):
    """Extends vlist_to_add_to with the list of the vocabulary items,
    lower-cased, in work_text, assumed to be well-formatted html"""

    # Add each <h2>...</h2> term or phrase to vlist_to_add_to, separating out
    # comma-separated phrases.

    i_start = work_text.find('<h2>')
    if i_start == -1:
        # No more <h2> tags, all done
        return
    else:
        work_text = work_text[i_start + len('<h2>'):]
        try:
            i_end = work_text.index('</h2>')  # If no matching </h2>,
                                              # quit because the data is corrupt
        except:
            print('ˆData has a <h2> without matching </h2>.')
            sys.exit()
        # Deal with "G7, G8, G20"
        term_list = work_text[:i_end].split(',')
        for term in term_list:
            vlist_to_add_to.append(term.lower().strip())
        work_text = work_text[i_end + len('</h2>') + 1:]

        # Recursive call!
        get_econ_vocab_helper(vlist_to_add_to, work_text)


def get_econ_vocab(fname):
    """Returns a list of the vocabulary items in fname, lower-cased."""
    with open(fname, mode='r', encoding='utf-8') as fp:
        outlist = []
        get_econ_vocab_helper(outlist, fp.read())
        return outlist

def track_topic(docs_list, vocab_list):
    """
    Returns: a list of the fraction of words in each document in docs_list that
    are in vocab_list.

    In more detail...

    Preconditions:

    * docs_list: a (possibly empty) list of nonempty strings, each of which
    contains at least one non-white-space character. We consider each item of
    docs_list to be a "document" where the "words" of the document are all the
    spans of characters that don't contain spaces. No "words" contain beginning
    or ending punctuation, although internal punctuation is OK.
    So, this document
        hey howdy          how's the weather
    has five words.
    This document
        xxx y z3!42
    has three words.
    This is NOT a legal document:
        hey howdy,     how's the weather???

    * vocab_list is a non-empty list of non-empty strings that may contain
    spaces. We consider each item of vocab_list to be a target "word". No
    target word can have beginning or ending punctuation, although internal
    punctuation is OK.

    This function returns a new list outlist such that:
        * len(outlist) == len(docs_list), and
        * for each valid index `ind` of docs_list, outlist[i] is the fraction
          of words in document docs_list[i] that are found in vocab_list.
          The fraction should be a float rounded to three digits past the
          decimal point via the round() built-in function.

    Examples:
    if doclist[0] is "abc abcabc a   a" and vocab_list is ["abc"],
        then outlist[0] should be .25 (i.e, 1/4).
    If doclist[1] is "abc abcabc a   a" and vocab_list is ["ABC", "a"],
        then outlist[1] should be .5 (i.e., 2/4)
    If doclist[2] is "ab abab a   a" and vocab_list is ["ABC", "a", "ab", "v", "abab"],
        then outlist[2] should be 1.0 (i.e., 4/4).

    The reason we disallow punctuation is to avoid having to decide whether
    a document "are you okay?" contains a word in the list ["okay"].
    """

    outlist= []
    if docs_list==[]:
        return outlist
    for item in list(range(len(docs_list))):
        shared_words=0
        doclist_items = docs_list[item].split()
        for subitem in doclist_items:
            shared_words_test = False
            for vocab_item in vocab_list:
                if subitem == vocab_item:
                    shared_words_test = True 
            if shared_words_test:
                shared_words += 1
            
        fractionfound = round(shared_words/len(doclist_items), 3)
        outlist.append(fractionfound)
    return outlist

if __name__ == '__main__':
    # econ_vocab= get_econ_vocab()
    # print(econ_vocab)

    # https://www.exaptive.com/blog/topic-modeling-the-state-of-the-union
    red_topic = ['make sure', 'company', 'college', 'republican', 'parent',
                 'medicare', 'bipartisan', 'kid', 'small business', 'global']
    purple_topic = ['afghanistan', 'america', 'terror',  'troop', 'border',
                    'terrorist', 'violence', 'enemy', 'fighting', 'rule']

    sotus = []  # State of the Union addresses, 2005-2016
    for year in range(2001, 2009):
        fname = os.path.join('sources', str(year)+'_bush.txt')
        sotus.append(convert_lines_to_string(get_content_lines(fname)))
    for year in range(2009, 2017):
        fname = os.path.join('sources', str(year)+'_obama.txt')
        sotus.append(convert_lines_to_string(get_content_lines(fname)))
    for year in range(2017, 2019):
        fname = os.path.join('sources', str(year)+'_trump.txt')
        sotus.append(convert_lines_to_string(get_content_lines(fname)))

    print("Demonstration of tracing a topic through a single speech: ")
    print("How the red topic trends through Obama's 2013 SOTU. Topics typically exhibit such `bursty' behavior.")
    fname = os.path.join('sources', '2013_obama.txt')
    obama13 = convert_lines_to_paragraphs(get_content_lines(fname))
    print(track_topic(obama13, red_topic))



    red_trend = track_topic(sotus, red_topic)
    purple_trend = track_topic(sotus, purple_topic)

    import matplotlib.pyplot as plt
    plt.title("Topic trends in recent US State of the Union addresses")
    plt.ylabel("fraction of speech tokens on the topic")
    x = list(range(2001, 2019))
    plt.plot(x, track_topic(sotus, ECON_VOCAB),
             'b', marker='o', label="The Economist's economic terms")
    plt.plot(x, track_topic(sotus, red_topic),
             'r', marker='o',
             label="Evans' red topic (selections: 'college', 'parent', ...)")
    plt.plot(x, track_topic(sotus, purple_topic),
             'purple', marker='o',
             label="Evans' purple topic (selections: 'terrorist', 'enemy', ...)")
    labels = ["2001: Bush", "2005: Bush",
              "2009: Obama", "2013: Obama",
              "2017: Trump"]
    plt.xticks(range(2001, 2019, 4), labels, rotation=45, fontsize=6)
    plt.legend()
    plt.show()
    plt.close('all')


