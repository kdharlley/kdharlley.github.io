# timer_script.py
# Lillian Lee (LJL2)
# Feb 2018

from timer import Timer

t = Timer(2,30)
# This is like grouping two students on CMS, so that their deadlines are linked
s = t
t.minutes = 20
print("t.minutes is: " + str(t.minutes))
print("s.minutes is: " + str(s.minutes) + '\n')

# This is like un-grouping the two students on CMS, so their deadlines are
# now no longer linked, even if they have the same values.
s = Timer(t.hours, t.minutes)
print("t.minutes is: " + str(t.minutes))
print("s.minutes is: " + str(s.minutes) + '\n')

t.minutes = 10
print("t.minutes is: " + str(t.minutes))
print("s.minutes is: " + str(s.minutes))