import re
import sys

#extrating names, bats and hits from string
line_regex= re.compile(r"^[A-Z](\w*\s)*(?=batted)")
bat_regex= re.compile(r"(?<=batted\s)\d")
hit_regex= re.compile(r"\d(?=\s(hits))")

#class for player
class Player:
    #constructor:
    def __init__(self, name, bats, hits):
        self.name= name
        self.bats= float (bats)
        self.hits= float (hits)
        self.average= 0.000 

#adding scores to player already in the set
def inSet (player, my_objects):
    for obj in my_objects:
        if(player.name == obj.name):
            obj.bats= obj.bats + player.bats
            obj.hits= obj.hits + player.hits
            return True;
    return False;

#set of players
my_objects= set() 

#check arguments and ask for input if necessary
if (len(sys.argv) <= 1):
    print("No argument for file name/path")
    input_file= raw_input("Enter the input file name/path: ")
else:
    input_file= str(sys.argv[1]) 

f= open(input_file)

#reading line by line from file
for line in f:
    match= line_regex.search(line.rstrip())
    hit_match= hit_regex.search(line.rstrip())
    bat_match= bat_regex.search(line.rstrip())

    #choosing the correct line
    if (match is not None) & (bat_match is not None) & (hit_match is not None):
        player= Player(match.group(), bat_match.group(), hit_match.group())
        #adding new player to the set 
        if(not inSet(player,my_objects)):
            my_objects.add(player)

#calcuate average
for obj in my_objects:
    obj.average= obj.hits/obj.bats

#sorting with average scores
newlist= sorted(my_objects, key=lambda x: x.average, reverse= True)

#writing results to output file
with open ("average_score.txt", "w") as f:
    for obj in newlist:
        f.write (obj.name+": %.3f\n" % obj.average)

#closing file
f.close()
